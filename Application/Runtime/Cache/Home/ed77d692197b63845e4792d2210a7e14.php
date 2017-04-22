<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE >
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>萧山区市民服务中心</title>
    <link href="/Public/css/style.css" type="text/css" rel="stylesheet"/>
    <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/js/index.js"></script>
    <script type="text/javascript" src="/Public/js/function.js"></script>
    <script data-main="http://app.zjzwfw.gov.cn/client/jssdkJS/jmportal_SDK.js"
            src="http://app.zjzwfw.gov.cn/client/jssdkJS/require.js"></script>
    <script type="text/javascript" src="/Public/js/main.js"></script>
    <script type="text/javascript">
        function follow() {
            getUserInfo({
                success: function (data) {
                    if (data == '未登录') {
                        loginApp();
                    } else {
                        getUser = jQuery.parseJSON(data);
                        var userId = getUser['userid'];
                        window.location.href = '<?php echo U("index/follow");?>?userId=' + userId + '&projectId=' + '<?php echo ($projectId); ?>'
                    }
                },
                fail: function (data) {
                    alert(data);
                }
            });

        }
        /*默认字号调整*/
        (function (doc, win) {
            var docEl = doc.documentElement,
                resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
                recalc = function () {
                    var clientWidth = docEl.clientWidth;
                    if (clientWidth > 1080) {
                        clientWidth = 1080;
                        docEl.style.fontSize = 67.5 + 'px';
                    }
                    if (!clientWidth) return;
                    docEl.style.fontSize = 20 * (clientWidth / 320) + 'px';
                };
            recalc();
            if (!doc.addEventListener) return;
            win.addEventListener(resizeEvt, recalc, false);
            doc.addEventListener('DOMContentLoaded', recalc, false);
        })(document, window);

        function getview(count) {

            for (i = 1; i < 5; i++) {
                if (i == count) {
                    $(".v" + i).addClass("viewli");
                    $(".view" + i).addClass("db");
                    $(".view" + i).removeClass("dn");
                } else {
                    $(".v" + i).removeClass("viewli");
                    $(".view" + i).addClass("dn");
                    $(".view" + i).removeClass("db");
                }
            }


        }

        /**
         * 预约
         */
        function toPreCall() {
            getUserInfo({
                success: function (data) {
                    if (data == '未登录') {
                        loginApp();
                    } else {
                        getUser = jQuery.parseJSON(data);
                        var userId = getUser['userid'];
                        var dePid = $("#depid").val();
                        var authlevel = getUser['authlevel'];

                        if (authlevel < 2) {
                            window.location.href = 'http://puser.zjzwfw.gov.cn/sso/mobile.do?action=realname&servicecode=[]&goto=[]'
                        } else {
                            window.location.href = '<?php echo U("index/order");?>?userId=' + userId + '&projectId=' + '<?php echo ($projectId); ?>&depid=' + dePid
                        }
                    }
                },
                fail: function (data) {
                    alert(data);
                }
            });
            //	var str=window.web2ciciClient.getAppUinfo();
            //	var uinfo=eval("("+str+")");
            //
            //	if(uinfo.uid==0){
            //
            //		window.web2ciciClient.login2js("checklogin");
            //
            //	}else{
            //		document.getElementById('infoFrom').setAttribute('action','/api/citizen/order');
            //		document.getElementById('infoFrom').submit();
            //
            //	}
        }
        function checklogin() {
            document.getElementById('infoFrom').setAttribute('action', '/api/citizen/order');
            document.getElementById('infoFrom').submit();

        }
    </script>
    <style type="text/css">
        body {
            font-size: .6rem;
            font-family: "微软雅黑";
            margin: 0;
            padding: 0px 0px 40px;
        }

        #header {
            background: #1492ff;
            color: #fff;
            clear: both;
            overflow: hidden;
            line-height: 2.5rem;
            height: 2.5rem;
        }

        #header div {
            float: left;
        }

        .back {
            width: 20%;
            font-size: 1.8rem;
            cursor: pointer
        }

        .title {
            width: 60%;
            text-align: center;
            font-size: .8rem;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .my {
            width: 20%;
            cursor: pointer
        }

        .my span {
            display: inline-block;
            margin-left: 40%;
        }

        .back span {
            display: inline-block;
            margin-left: 25%;
            color: #fff;
        }

        .my span a {
            color: #fff;
            text-decoration: none;
        }

        .view ul, .view {
            clear: both;
            overflow: hidden;
            margin: 0;
            padding: 0;
            background: #fff;
        }

        .view ul li {
            float: left;
            background: #fff;
            line-height: 350%;
            width: 25%;
            text-align: center;
            height: 2rem;
            color: #666;
        }

        .viewli {
            height: 1.9rem !important;
            background: #2284DD;
            color: #00aaff !important;
            border-bottom: 2px solid #00aaff;
        }

        .dn {
            display: none;
        }

        .db {
            display: block;
        }

        .sxxq_nr_nr_nr {
            line-height: 200%
        }

        .view1, .view2, .view3, .view4 {
            padding: .2rem .5rem;
            background: #fff;
            margin-top: .5rem;
        }

        .zt18_h {
            font-weight: bold;
            display: inline;
        }

        .sxxq_nr_dh_y {
            background: #fff;
            width: 100%
        }

        .zt18_l {
            border: .05rem solid #ddd;
            border-radius: .5rem;
            padding: .5rem;
            margin: .5rem;
            width: 13rem;
            display: inline-block;
            text-align: center;
            color: #666666;
            background: #fbfbfb;
            text-decoration: none;
            font-weight: bold;
        }

        .sxxq_bottom_nr_zj {
            background: #fff;
            width: 100%;
        }

        .sxxq_bottom_nr_zj_a {
            color: #fff;
            border-radius: .5rem;
            background: #3ea3fe;
            width: 13rem;
            padding: .5rem;
            margin: .5rem;
            text-align: center;
            display: inline-block;
            font-size: .7rem
        }

        .sxxq_bottom_nr_zj_b {
            color: #e6e6e6;
            border-radius: .5rem;
            background: #f8f8f8;
            border-color: #dedede;
            width: 13rem;
            padding: .5rem;
            margin: .5rem;
            text-align: center;
            display: inline-block;
            font-size: .7rem
        }
    </style>

</head>

<body bgcolor="#f3f3f3">
<div id="divTxt"></div>
<form id="infoFrom" name="infoFrom" method="post">
    <input type="hidden" name="depid" id="depid" value="<?php echo $projectItems[0]['acceptDept']; ?>">
</form>

<!--导航条-->
<div id="header">
    <div class="back"><span onclick="history.go(-1);"></span></div>
    <div class="title">详情</div>
    <div class="my"><span><a onclick="follow();">关注</a></span></div>
</div>
<div style="height:.5rem;clear:both;overflow:hidden;"></div>

<!--导航条-->
<div class="view">
    <div style="background: #fff; color: #000; text-align: center;font-size: 20px; margin: 20px auto;">
        <?php echo $projectItems[0]['title'] ?>
    </div>
    <ul>
        <li onclick="getview(1);" class="viewli v1">基本信息</li>
        <li onclick="getview(2);" class="v2">受理条件</li>
        <li onclick="getview(3);" class="v3">办理程序</li>
        <li onclick="getview(4);" class="v4">依据标准</li>
    </ul>
</div>

<div class="view1">
    <div class="sxxq_nr_nr_nr"><span class="zt18_h">部门（单位） : &nbsp;</span><?php echo $projectItems[0]['deptName']; ?> </div>
    <div class="sxxq_nr_nr_nr"><span class="zt18_h">事项类别 :&nbsp; </span><?php echo $projectItems[0]['catagaryName']; ?> </div>
    <div class="sxxq_nr_nr_nr"><span class="zt18_h">受理对象 :&nbsp; </span><?php $obj=array("1"=> "单位","2"=>"个人","3"=>"个人及单位");echo $obj[$projectItems[0]['acceptObject']]; ?>
    </div>
    <div class="sxxq_nr_nr_nr"><span class="zt18_h">法定期限 :&nbsp;</span><?php echo $projectItems[0]['setDay']; ?> </div>
    <div class="sxxq_nr_nr_nr"><span class="zt18_h">办理时限 :&nbsp;</span><?php echo $projectItems[0]['acceptDay']; ?></div>
    <div class="sxxq_nr_nr_nr"><span class="zt18_h">办理窗口 :&nbsp;</span><?php echo $projectItems[0]['acceptWindow']; ?></div>
    <div class="sxxq_nr_nr_nr"><span class="zt18_h">办事窗口次数 :&nbsp;</span><?php echo $projectItems[0]['acceptCount']; ?></div>
    <div class="sxxq_nr_nr_nr"><span class="zt18_h">受理地点 :&nbsp; </span><?php echo $projectItems[0]['address']; ?>  </div>
    <div class="sxxq_nr_nr_nr"><span class="zt18_h">所需材料 :&nbsp; </span><?php echo preg_replace('%style="[^>
        ]+"%',"",$projectItems[0]['needMaterial']); ?>
    </div>
</div>

<div class="view2 dn">
    <div class="sxxq_nr_nr_nr"><?php echo preg_replace('%style="[^>]+"%',"",$projectItems[0]['acceptConditions']); ?></div>
</div>

<div class="view3 dn">
    <div class="sxxq_nr_nr_nr"><?php echo preg_replace('%style="[^>]+"%',"",$projectItems[0]['acceptOrder']); ?></div>
</div>

<div class="view4 dn">
    <div class="sxxq_nr_nr_nr"><?php echo preg_replace('%style="[^>]+"%',"",$projectItems[0]['feesStandard']); ?></div>
</div>

<!--tel:<?php echo $items[0]['telphone']; ?>-->
<div class="sxxq_nr_dh_y"><a href="#"
                             class="zt18_l STYLE1"
                             onclick="onCallPhone('<?php echo $projectItems[0]['telphone']; ?>')"><?php echo $projectItems[0]['telphone']; ?></a>
</div>

<div class="sxxq_bottom_nr_zj" style="cursor:hand"><?php if($projectItems[0]['canPreCall']==1){ ?><a
        class="sxxq_bottom_nr_zj_a"
        onClick="toPreCall()">立即预约</a><?php }else{?>
    <a class="sxxq_bottom_nr_zj_b">不可预约</a><?php } ?></div>

<div id="footer"
     style="color: #666; text-align: center; margin: 10px; font-size: 12px; width: 100%;position:fixed;bottom: 0px;">
    本服务由浙江政务服务网提供
</div>
</body>
</html>