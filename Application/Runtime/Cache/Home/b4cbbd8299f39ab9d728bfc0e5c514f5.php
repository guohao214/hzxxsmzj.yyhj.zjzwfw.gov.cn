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
    <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/js/main.js"></script>
    <script type="text/javascript">

        /*默认字号调整*/
        function toPreCall(id) {
            document.getElementById('transeId').value = id;
            document.getElementById('infoFrom').setAttribute('action', '<?php echo U("index/getInfo");?>?projectId=' + id);
            document.getElementById('infoFrom').submit();
        }

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

        function advise(id) {
            document.getElementById('a').value = id;
            document.getElementById('advise').setAttribute('action', '<?php echo U("index/advise");?>');
            $("#advisep").show();
            $("#pingjiap").hide();
        }
        function pingjia(id) {
            document.getElementById('p').value = id;
            document.getElementById('pingjia').setAttribute('action', '<?php echo U("index/pingjia");?>');
            $("#pingjiap").show();
            $("#advisep").hide();
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
            margin-left: 25%
        }

        .qfgj_nr {
            margin: 0 1% .8rem 1%;
        }

        .qfgj_nr_dh {
            line-height: 350%;
            font-weight: bold;
            font-size: .6rem;
            padding-left: .7rem;
            margin-bottom: 0.3%;
            background: #fff;
            color: #333;
        }

        .cd {
            padding: .5rem .7rem;
            margin-bottom: 0.3%;
            background: #fff;
        }

        .ab ul li a {
            text-decoration: none;
            color: #71adee;
        }

        ul {
            margin: 0;
            padding: 0
        }

        .ab ul li {
            float: left;
            width: 33%;
            background: #fff;
            text-align: center;
            line-height: 2rem
        }

        .midline {
            margin: 0 0.5%
        }

        .ab, .ab ul, .cd {
            clear: both;
            overflow: hidden;
        }

        .cc {
            display: none;
            position: absolute;
            top: 20%;
            width: 12rem;
            left: 50%;
            margin-left: -6rem;
            border: .05rem solid #ccc;
            padding: .5rem 0;
            background: #eee
        }

        #tt, .tt {
            margin: 0 .5rem .5rem
        }

        textarea {
            width: 11rem;
            outline: medium;
            border: 0;
            margin: 0 .5rem
        }

        .submit {
            float: right;
            margin: .5rem .5rem 0 0;
        }

        .menu {
            margin-bottom: .5rem
        }

        .menu ul li {
            float: left;
            width: 49%;
            background: #fff;
            text-align: center;
            line-height: 2.5rem
        }

        .first {
            border-bottom: .1rem solid #5b98e6;
            color: #5b98e6
        }

        .second {
            margin-left: .1rem
        }

        .menu ul, .menu {
            clear: both;
            overflow: hidden;
        }

        .menu ul li a {
            color: #333;
            text-decoration: none;
        }
    </style>

</head>

<body bgcolor="#f3f3f3">

<form id="infoFrom" action="" method="post">
    <input type="hidden" name="id" id="transeId">
    <input type="hidden" name="typeId" value="<?php echo $typeid; ?>">
</form>
<!-- 导航条-->
<div id="header">
    <div class="back"><span onclick="history.go(-1);"> < </span></div>
    <div class="title">预约列表</div>
    <div class="my"><span></span></div>
</div>

<div class="menu">
    <ul>
        <li class="first">预约列表</li>
        <li class="second"><a href="<?php echo U('index/followView',['userId'=>$userId]);?>">关注事项</a></li>
    </ul>
</div>
<!--导航条-->
<?php
if(empty($list)){?>
<div style="text-align: center;margin: 30px auto;">
    <img src="/Public/images/list.png" width="50%">
</div>
<?php }?>
<?php foreach($list as $k=>$v){?>
<div class="qfgj_nr">
    <div class="qfgj_nr_dh" onClick="toPreCall('<?php echo $v['projectid']; ?>')" style="cursor:hand"><a
            class="zt20_l"><?php echo $v['title']; ?></a></div>
    <div class="cd">已预约时间：<?php echo $v['odate']." ".$v['otime']; ?></div>
    <div class="ab">
        <ul>
            <li>
                <a href="<?php echo U('index/cancel',['projectId'=>$v['order_id'],'userId'=>$userId]);?>" <?php if($v['is_cancel']==1){?>
                style="color:gray;"<?php } ?>>取消预约</a></li>
            <li class="midline"><a onclick="advise('<?php echo $v['order_id']; ?>');">意见建议</a></li>
            <li><a onclick="pingjia('<?php echo $v['order_id']; ?>')">评价</a></li>
        </ul>
    </div>
</div>
<?php } ?>

<div id="pingjiap" class="cc">
    <form action="" method="post" id="pingjia"><input type="hidden" name="ids" id="p">

        <div id="tt">请输入评价详情！！</div>
        <div class="tt"><label><input name="pingjia" type="radio" value="1"/>非常满意 </label> <label><input name="pingjia"
                                                                                                         type="radio"
                                                                                                         value="2"/>满意
        </label><label><input name="pingjia" type="radio" value="3"/>不满意 </label></div>
        <textarea name="contents" rows="5"></textarea><input type="submit" name="submit" value="提交" class="submit">
    </form>
</div>

<div id="advisep" class="cc">
    <form action="" method="post" id="advise"><input type="hidden" name="id" id="a">

        <div id="tt">请输入建议内容！！</div>
        <textarea name="advises" rows="5"></textarea><input type="submit" name="submit" value="提交" class="submit">
    </form>
</div>
<div id="footer"
     style="color: #666; text-align: center; margin: 10px; font-size: 12px; width: 100%;position:fixed;bottom: 0px;">
    本服务由浙江政务服务网提供
</div>
</body>
</html>