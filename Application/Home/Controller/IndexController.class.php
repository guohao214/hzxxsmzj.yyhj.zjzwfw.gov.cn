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

    private function generateUrl($url, $apiHost='')
    {
        if (!$apiHost)
            $apiHost = $this->apiHost;

        $sign = (!strpos($url, '?')) ? '?': '&';
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

        $typeList= TypeList::getCacheTypeList();
        $this->typeList = $typeList['typeList'][$id];

        $this->display();
    }

    //通过类别获取项目列表
    function getList()
    {
        $typeId = I('get.typeId',0,'intval');
        $typeName = I('get.typeName','','strip_tags');

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
        $projectId = I('get.projectId',0,'intval');

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


        Curl::curlGet($this->xsUrl . 'index/follow?userId=' . $userId . '&projectId=' . $projectId);

        redirect(U('Index/followView', array('userId' => $userId)));
    }


    //我的关注列表
    function followView()
    {

        $userId = $_GET['userId'];

        $url = $this->xsUrl . 'index/followView?userId=' . $_GET['userId'];

        $list = Curl::curlGet($url);

        $list = json_decode($list, true);

        foreach ($list as $k => $val) {
            $url = $this->apiHost . "remote/project/getInfo.do?projectId=" . $val['project_id'] . "&userId=";
            $data = Curl::curlGet($url);

            $list[$k] = Curl::jsonToArray($data);
        }

        $this->list = $list;

        $this->userId = $userId;

        $this->display();
    }


    /**
     * 获取验证码
     */
    function vcode()
    {
        $phone = $_GET['phone'];
        $url = $this->apiHost . "remote/user/getVerification.do?phone=" . $phone;

        $arr = Curl::curlGet($url);

        $arr = Curl::jsonToArray($arr);

        if ($arr['code'] == 1) {
            $user_url = $this->apiHost . "remote/user/doLogin.do?mobilePhone=" . $phone;

            $userInfo = Curl::curlGet($user_url);

            $userInfo = Curl::jsonToArray($userInfo);

            $_SESSION['city_uid'] = $userInfo['items'][0]['id'];

            $_SESSION['vcode'] = $arr['data']['authCode'];

            echo $_SESSION['city_uid'];
        }
    }

    /**
     * 我的预约列表
     */
    function orderView()
    {
        $userId = $_GET['userId'];

        $list = Curl::curlGet($this->xsUrl . 'index/orderView?userId=' . $userId);
        $this->list = Curl::jsonToArray($list);
        $this->userId = $userId;

        $this->display();
    }

    //预约详情页
    function order()
    {

        $projectId = $_GET['projectId'];

        $depid = $_GET['depid'];

        $url = $this->apiHost . "remote/preCallInfo/getRestDay.do?deptId=" . $depid . "&year=" . date('Y', time());

        $data = Curl::curlGet($url);

        $data = Curl::jsonToArray($data);

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


        $projectId = $_POST['projectId'];


        $curDate = date("Y-m-d", time());

        $userId = $_GET['userId'];

        $phone = $_POST['phone'];

        $vcode = $_POST['vcode'];

        if ($vcode != $_SESSION['vcode']) {
            echo "短信验证失败!";
            die;
        }

        $orderdate = $_POST['orderdate'];

        $ordertime = $_POST['ordertime'];

        $url = $this->apiHost . "/remote/project/getInfo.do?projectId=" . $projectId . "&userId=" . $userId;

        $saveurl = $this->newApiHost . "/remote/preCallInfo/save.do?phone=" . $phone . "&curDate=" . $curDate . "&projectId=" . $projectId . "&needInfo=0&precallDay=" . $orderdate . "&period=" . $ordertime . '&appId=' . $this->appId . '&secret=' . $this->secret;

        $save = Curl::curlGet($saveurl);

        $save = Curl::jsonToArray($save);

        $saveData = $save['data'];

        p($save);
        p($saveData);
        die;
        if ($save['code'] == 0 && !empty($saveData['precallInfoId'])) {

            $arr = Curl::curlGet($url);

            $arr = Curl::jsonToArray($arr);


            $data = array(
                "projectId" => $projectId,
                "phone" => $phone,
                "orderdate" => $orderdate,
                "ordertime" => $ordertime,
                "title" => $arr['items'][0]['title'],
                "precallInfoId" => $saveData['precallInfoId']
            );


            Curl::curlPost($this->xsUrl . 'index/orderTo?userId=' . $userId, $data);
            echo '预约成功!';
            die;
        }

        echo '预约失败';

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


    //取消预约
    function cancel()
    {

        $order_id = $_GET['projectId'];

        $userId = $_GET['userId'];

        $url = $this->newApiHost . "remote/preCallInfo/cancel.do?id=" . $order_id . '&appId=' . $this->appId . '&secret=' . $this->secret;

        $arr = Curl::curlGet($url);

        $arr = Curl::jsonToArray($arr);

        if ($arr['code'] == 0) {

            Curl::curlGet($this->xsUrl . 'index/cancel?projectId=' . $order_id . '&userId=' . $userId);

            $this->success("取消成功!");
        }
    }

    //发送建议
    function pingjia()
    {
        $order_id = $_POST['ids'];
        $pingjia = $_POST['pingjia'];
        $contents = $_POST['contents'];

        $url = $this->newApiHost . "remote/review/save?callId=" . $order_id . "&review=" . $pingjia . "&reviewContent=" . $contents . '&appId=' . $this->appId . '&secret=' . $this->secret;

        $arr = Curl::curlGet($url);

        $arr = Curl::jsonToArray($arr);

        if ($arr['success'] == 'true') {
            $this->success("评价发送成功!");
        } else {
            $this->error("评价发送失败!");
        }
    }

    //发送评价
    function advise()
    {
        $order_id = $_POST['id'];
        $advises = $_POST['advises'];

        $url = $this->newApiHost . "remote/review/save.do?callId=" . $order_id . "&review=1&reviewContent=评价&revision=" . $advises . '&appId=' . $this->appId . '&secret=' . $this->secret;

        $arr = Curl::curlGet($url);

        $arr = Curl::jsonToArray($arr);

        if ($arr['success'] == 'true') {
            $this->success("评价发送成功!");
        } else {
            $this->error("评价发送失败!");
        }
    }


    function test()
    {
        http_put_file("test.txt", $_POST['txt']);
    }

}
