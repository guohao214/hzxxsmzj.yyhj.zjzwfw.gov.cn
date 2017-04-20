<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE>
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
    <link href="/Public/css/style.css" type="text/css" rel="stylesheet"/>
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
            /*float: left;*/
        }

        .back {
            font-size: 1.8rem;
            cursor: pointer;
            position: relative;
            display: flex;
            /* justify-content: center; */
            align-items: center;
        }

        .title {
            /*margin: 0 20px;*/
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
        }

        .qfgj_nr a {
            text-decoration: none;
        }

        .qfgj_nr {
            margin: 0 1% .8rem 1%;
        }

        .zt14_hong {
            color: #000;
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
    </style>
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

</head>
<body bgcolor="#f3f3f3">

<!-- 导航条-->
<div id="header">
    <div class="back"><span onclick="history.go(-1);"></span></div>
    <div class="title"><?php echo $typeName; ?></div>
    <div class="my"><span></span></div>
</div>
<div style="height:.5rem;clear:both;overflow:hidden;"></div>
<!--导航条-->
<?php if($projectList['code'] == 0) { ?>
<?php foreach($projectList['items'] as $k=>$v){ ?>
<div class="qfgj_nr" style="cursor:hand"><a href="<?php echo U('index/getInfo',['projectId'=>$v['id']]);?>" style="display: block;">
    <div class="qfgj_nr_dh"><?php echo $v['title']; ?></div>
    <?php if($v['canPreCall']!=1){ ?>
    <div class="qfgj_nr_nr_nr"><span class="zt14_hong"></span><span class="yy_no">不可预约</span></div>
</a>
    <?php }else{ ?>
    <div class="qfgj_nr_nr_nr"><span class="zt14_hong"></span><span class="yy_yes">可预约</span></div>
    </a>
    <?php } ?>
</div>
<?php } } ?>
<div id="footer" style="color: #666; text-align: center; margin: 10px; font-size: 12px; width: 100%;position:fixed;bottom: 0px;">本服务由浙江政务服务网提供</div>
</body>
</html>