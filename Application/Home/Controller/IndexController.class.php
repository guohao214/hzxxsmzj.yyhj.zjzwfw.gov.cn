<?php

namespace Home\Controller;

use Home\Api\Curl;
use Home\Api\TypeList;
use Think\Controller;

class IndexController extends Controller
{
    private $authKey = "";
    private $uid = 0;
    protected $apiHost;
    protected $newApiHost;
    private $appId;
    private $secret;
    private $xsUrl;

    function __construct()
    {
        session_start();
        parent::__construct();
        $set = D("Set");
        $status = $set->where(array('id' => 1))->getField("status");
        if ($status != 1) {
            echo "<h1>微站功能维护中!</h1>";
            die;
        }

        $this->appId = 64654654;
        $this->secret = 'e8fece4e-fcc5-40b0-9b18-6cb745b4e546';
        $this->authKey = "f4fna96cdnf27i8W9Jd7bV6T152fgh569zsd5asdhy65Ub52oeg0W6ob88v0Q6Vf126";

        //$this->apiHost = 'http://www.xssmzx.gov.cn/cms/';
        $this->apiHost = 'http://115.236.58.38:2599/baseinf/';
        $this->newApiHost = 'http://115.236.58.38:2599/baseinf/';
        $this->xsUrl = 'http://xiaoshansvr.2500city.com/Api/';
        //$this->xsUrl='http://localhost/zjzwtp/api/';
    }

    private function generateUrl($url, $apiHost = '')
    {
        if (!$apiHost)
            $apiHost = $this->apiHost;

        $sign = (!strpos($url, '?')) ? '?' : '&';
        return sprintf("{$apiHost}{$url}{$sign}appId={$this->appId}&secret={$this->secret}");
    }

    //主页
    public function index()
    {
        parse_str(authcode($_REQUEST['authcode'], 'DECODE', $this->authkey), $p);

        if ($p['uid'] != $_SESSION['citizen_uid']) {
            $_SESSION['citizen_uid'] = 0;
        }

        if (!($typeList = TypeList::getCacheTypeList())) {
            $getProjectTypeListUrl = $this->generateUrl("remote/project/getProjectTypeList.do");
            $response = Curl::curlGet($getProjectTypeListUrl);
            $response = Curl::jsonToArray($response);
            $response = $response['items'];
            $typeList = TypeList::setCacheTypeList($response);
        }

//        $default_url = $this->generateUrl("remote/project/getTypeList.do?parentId=" . $pid);
//        $default_arr = Curl::curlGet($default_url);
//        $default_arr = Curl::jsonToArray($default_arr);
//        $arr['data'] = sortData($default_arr, $pid);

        $this->list = $typeList;
        $this->display();
    }

    public function getTypeList()
    {
        // 顶级菜单ID
        $id = $_GET['id'] + 0;

        $typeList = TypeList::getCacheTypeList();
        $this->typeList = $typeList['typeList'][$id];

        $this->display();
    }

    //通过类别获取项目列表
    function getList()
    {
        $typeId = I('get.typeId', 0, 'intval');
        $typeName = I('get.typeName', '', 'strip_tags');

        $projectListUrl = $this->generateUrl("remote/project/projectList.do?type=" . $typeId);
        $response = Curl::curlGet($projectListUrl);
        $response = Curl::jsonToArray($response);

        if ($response['code'] == -9001) {
            echo '<script type="text/javascript">alert("该业务暂时不可用,请稍后再试!");history.go(-1);</script>';
            die;
        }
        $this->projectList = $response;
        $this->authcode = $_REQUEST['authcode'];
        $this->typeId = $typeId;
        $this->typeName = $typeName;

        $this->display();
    }

    //根据项目ID得到项目详情
    function getInfo()
    {
        $projectId = I('get.projectId', 0, 'intval');

        $projectDetail = $this->generateUrl("remote/project/projectDetail?projectId=" . $projectId . "&userId=" . $_SESSION['citizen_uid']);
        $response = Curl::curlGet($projectDetail);
        $response = Curl::jsonToArray($response);

        $this->projectItems = $response['items'];
        $this->authcode = $_REQUEST['authcode'];
        $this->projectId = $projectId;

        $this->display();
    }


    /**
     *关注
     * 关注URL:/api/Citizen/follow?authcode=6257rPIw/OxjfW2t/4UaVEUDvSfhKnfeAZLUb3ylfwv6ov28W7FCuj3vChE&projectid=207
     */
    function follow()
    {
        $userId = $_GET['userId'];
        $projectId = $_GET['projectId'];

        if (empty($userId) || empty($projectId)) {
            $this->error("请登陆后再做收藏!");
        }

        $requestUrl = $this->generateUrl("remote/attention/saveAttention.do?userId=" . $userId . '&projectId=' . $projectId);
        $response = Curl::curlGet($requestUrl);
        $response = Curl::jsonToArray($response);

        if ($response && $response['success'] === true)
            redirect(U('Index/followView', array('userId' => $userId)));
        else
            $this->error("关注失败!");
    }

    /**
     * 关注列表
     */
    function followView()
    {
        $userId = $_GET['userId'];

        $url = $this->generateUrl('remote/project/getMyList.do?userId=' . $userId);
        $response = Curl::curlGet($url);
        $response = Curl::jsonToArray($response);
        $this->list = $response['data'];
        $this->userId = $userId;

        $this->display();
    }

    /**
     * 取消关注
     */
    public function cancelFollow()
    {
        $projectId = I('get.projectId', 0, 'strip_tags');
        $userId = I('get.userId', 0, 'strip_tags');

        $requestUrl = $this->generateUrl("remote/attention/doCancelAttention.do?projectId={$projectId}&userId={$userId}");
        $response = Curl::curlGet($requestUrl);
        $response = Curl::jsonToArray($response);

        if ($response['code'] == 0)
            $this->success("取消成功!");
        else
            $this->success("取消失败!");
    }

    /**
     * 获取验证码
     */
    function orderVcode()
    {
        $phone = $_GET['phone'];
        $url = $this->generateUrl("remote/user/getVerification.do?phone=" . $phone);
        $arr = Curl::curlGet($url);
        $arr = Curl::jsonToArray($arr);

        if ($arr['code'] != 1) {
            echo $user_url = $this->generateUrl("remote/user/doLogin.do?mobilePhone=" . $phone);

            $userInfo = Curl::curlGet($user_url);
            $userInfo = Curl::jsonToArray($userInfo);
            $_SESSION['city_uid'] = $userInfo['items'][0]['id'];
            $_SESSION['orderVcode'] = $arr['data']['authCode'];
            echo $_SESSION['city_uid'];
        }
    }

    /**
     * 预约列表
     */
    function orderView()
    {
        $userId = $_GET['userId'];
        $requestUrl = $this->generateUrl('remote/preCallInfo/getPreCallInfoList.do?userId=' . $userId);
        $list = Curl::curlGet($requestUrl);
        $this->list = Curl::jsonToArray($list);
        $this->userId = $userId;

        $this->display();
    }

    //预约详情页
    function order()
    {

        $projectId = $_GET['projectId'];
        //$url = $this->apiHost . "remote/preCallInfo/getRestDay.do?deptId=" .
        //       $depid . "&year=" . date('Y', time());

        $url = $this->generateUrl("remote/preCallInfo/getPreCallInfoById.do?projectId=" . $projectId);
        $data = Curl::curlGet($url);
        $data = Curl::jsonToArray($data);

        if ($data['code'] != 1)
            exit();

        $workdays = $data['items'][0]['workDays'];
        $date = $this->getDateArr($workdays);

        $this->projectId = $projectId;

        $this->date = $date;

        $this->time = $this->gettime($projectId, $date[0], true);

        $this->display();
    }

    /**
     * 预约保存
     */
    function orderTo()
    {
        if ($_POST['vcode'] != $_SESSION['orderVcode']) {
            echo "短信验证失败!";
            die;
        }

        $data['projectId'] = $_POST['projectId'];
        $data['phone'] = $_POST['phone'];
        $data['userId'] = $_GET['userId'];
        $data['precalDay'] = $_POST['orderdate'];
        $data['period'] = $_POST['ordertime'];

        $queryParams = http_build_query($data);

        $requestUrl = $this->generateUrl("remote/preCallInfo/save.do" . $queryParams);
        $response = Curl::curlGet($requestUrl);
        $save = Curl::jsonToArray($response);
        $saveData = $save['data'];

        if ($save['code'] == 1) {
            echo '预约成功!';
            die;
        } else {
            echo '预约失败';
        }
    }

    /**
     * 取消预约
     */
    public function cancelOrder()
    {
        $order_id = $_GET['id'];

        $requestUrl = $this->generateUrl("remote/preCallInfo/cancel.do?id=" . $order_id);
        $response = Curl::curlGet($requestUrl);

        echo $response;
    }


    /**
     * 解析可预约的日期字符串
     * $str='010111111011111101111110111111011111101111110111111011111101111110111111011111101111110111111011111101111110111111011111101111110111111011111101111110111111011111101111110111111011111101111110111111011111101111110111111011111101111110111111011111101111110111111011111101111110011111011111101111110111111011111101111110111111011111101111110111111011111101111110111111';
     * print_r(getDateArr($str);
     * @param $str
     * @return array
     */
    private function getDateArr($str)
    {
        $len = strlen($str);
        $arr = array();

        for ($i = 0; $i < $len; $i++) {

            $firstDay = date("Y-01-01", time());

            $date = date("Y-m-d", strtotime("$firstDay + $i day"));

            $arr[$date] = substr($str, $i, 1);

        }
        $newDay = date("Y-m-d", time());

        $newArr = array();
        while (count($newArr) < 5) {

            $newDay = date("Y-m-d", strtotime("$newDay + 1 day"));

            if ($arr[$newDay] == 1) {
                $newArr[] = $newDay;
            } else {
                $newDay = date("Y-m-d", strtotime("$newDay + 1 day"));
            }

        }

        return $newArr;
    }

    /**
     * 根据时间获得时间段
     * @param $projectId
     * @param $date
     * @return mixed
     */
    private function getTime($projectId, $date)
    {
        $url = $this->apiHost . "remote/preCallInfo/getInfoProjectTime.do?projectId=" . $projectId . "&date=" . $date;

        $data = Curl::curlGet($url);

        $arr = Curl::jsonToArray($data);

        return $arr['items'];
    }

    function gettimeinfo()
    {
        $date = $this->input->post('date');
        $projectid = $this->input->post('projectid');
        $url = $this->api_host . "remote/preCallInfo/getInfoProjectTime.do?projectId=" . $projectid . "&date=" . $date;
        $arr = $this->curl($url);
        echo json_encode($arr['items']);
    }

    /**
     * 评价
     */
    function pingjia()
    {
        $orderId = $_POST['ids'];
        $review = $_POST['pingjia'];
        $reviewContent = $_POST['contents'];

        $url = $this->generateUrl("remote/review/save.do?callId={$orderId}&reviewContent={$reviewContent}&review={$review}");
        $arr = Curl::curlGet($url);

        echo $arr;
    }

    /**
     * 意见
     */
    function advise()
    {
        $order_id = $_POST['id'];
        $revision = $_POST['advises'];

        $url = $this->generateUrl("remote/review/save.do?callId=" . $order_id . "&revision=" . $revision);
        $arr = Curl::curlGet($url);

        echo $arr;
    }
}
