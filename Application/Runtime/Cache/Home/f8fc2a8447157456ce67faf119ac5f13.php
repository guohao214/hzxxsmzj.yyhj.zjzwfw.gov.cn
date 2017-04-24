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
    <script type="text/javascript" src="/Public/js/main.js"></script>
    <script type="text/javascript">
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


    </script>
    <style type="text/css">
        body {
            font-size: .6rem;
            font-family: "微软雅黑";
            margin: 0;
            padding: 0px 0px 40px;
        }

        #header {
            background:#1492ff;color:#fff;
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

        .zt14_hong {
            color: #000;
        }

        .qfgj_nr a {
            text-decoration: none;
        }

        .qfgj_nr {
            margin: 0 1% .8rem 1%;
        }

        ul {
            margin: 0;
            padding: 0
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

        .qfgj_nr_nr_nr {
            line-height: 250%;
            background: #fff;
            padding-left: .7rem;
            font-size: .5rem;
            clear: both;
            overflow: hidden
        }

        .yy_no {
            color: #999;
            float: right;
            margin-right: .5rem;
        }

        .yy_yes {
            color: #6badfa;
            float: right;
            margin-right: .5rem;
        }

        .menu {
            margin-bottom: 1rem
        }

        .menu ul li {
            float: left;
            width: 49%;
            background: #fff;
            text-align: center;
            line-height: 2.5rem
        }

        .second {
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
    <div class="back"><span onclick="history.go(-1);"></span></div>
    <div class="title">关注事项</div>
    <div class="my"><span></span></div>
</div>

<div class="menu">
    <ul>
        <li class="first"><a href="<?php echo U('index/orderView',array('userId'=>$userId));?>">预约列表</a></li>
        <li class="second">关注事项</li>
    </ul>
</div>

<!--导航条-->
<?php
if(empty($list)){?>
<div style="text-align: center;margin: 30px auto;">
    <img src="/Public/images/guanzhu.png" width="50%">
</div>
<?php }?>
<?php if(!empty($list)){ ?>
<?php foreach($list as $k=>$v){ ?>
<div class="qfgj_nr" style="cursor:hand">
    <div class="qfgj_nr_dh"><a class="zt20_l"
                               href="<?php echo U('index/getInfo',array('projectId'=>$v['items'][0]['id']));?>" style="display: block;"><?php echo $v['items'][0]['title']; ?>
    </div>
    <?php if($v['items'][0]['canPreCall']!=1){ ?>
    <div class="qfgj_nr_nr_nr"><span class="yy_no">不可预约</span></div>
    </a>
    <?php }else{ ?>
    <div class="qfgj_nr_nr_nr"><span class="yy_yes">可预约</span></div>
    </a>
    <?php } ?>
</div>
<?php } ?>
<?php } ?>

<div id="footer" style="color: #666; text-align: center; margin: 10px; font-size: 12px; width: 100%;position:fixed;bottom: 0px;">本服务由浙江政务服务网提供</div>
</body>
</html>