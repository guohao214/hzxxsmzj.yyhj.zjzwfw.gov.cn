<?php if (!defined('THINK_PATH')) exit();?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <title>萧山区市民服务中心</title>
    <link href="/Public/css/style.css" type="text/css" rel="stylesheet"/>
    <style>
        .six a {
            color: white;
        }

        .loadEffect {
            width: 50px;
            height: 50px;
            position: relative;
            margin: 0 auto;
            margin-top: 100px;
        }

        .loadEffect span {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #337ab7;
            position: absolute;
            -webkit-animation: load 1.04s ease infinite;
        }

        @-webkit-keyframes load {
            0% {
                opacity: 1;
            }
            100% {
                opacity: 0.2;
            }
        }

        .loadEffect span:nth-child(1) {
            left: 0;
            top: 50%;
            margin-top: -4px;
            -webkit-animation-delay: 0.13s;
        }

        .loadEffect span:nth-child(2) {
            left: 7px;
            top: 7px;
            -webkit-animation-delay: 0.26s;
        }

        .loadEffect span:nth-child(3) {
            left: 50%;
            top: 0;
            margin-left: -4px;
            -webkit-animation-delay: 0.39s;
        }

        .loadEffect span:nth-child(4) {
            top: 7px;
            right: 7px;
            -webkit-animation-delay: 0.52s;
        }

        .loadEffect span:nth-child(5) {
            right: 0;
            top: 50%;
            margin-top: -4px;
            -webkit-animation-delay: 0.65s;
        }

        .loadEffect span:nth-child(6) {
            right: 7px;
            bottom: 7px;
            -webkit-animation-delay: 0.78s;
        }

        .loadEffect span:nth-child(7) {
            bottom: 0;
            left: 50%;
            margin-left: -4px;
            -webkit-animation-delay: 0.91s;
        }

        .loadEffect span:nth-child(8) {
            bottom: 7px;
            left: 7px;
            -webkit-animation-delay: 1.04s;
        }
    </style>
    <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="http://app.zjzwfw.gov.cn/client/jssdknew/js/index.js"></script>
    <script data-main="http://app.zjzwfw.gov.cn/client/jssdkJS/jmportal_SDK.js"
            src="http://app.zjzwfw.gov.cn/client/jssdkJS/require.js"></script>
    <script type="text/javascript" src="/Public/js/main.js"></script>
</head>
<body bgcolor="#f3f3f3">
<div id="top"></div>
<div id="header">
    <div class="back"><span onclick="showOrHiddenNav();"></span></div>
    <div class="title">市民服务中心</div>
    <div class="my">
		<span>
			<a onclick="my();"> <img src="/Public/images/citizen/my.png" style="width:1.2rem;margin-top:0.8rem"/></a>
		</span>
    </div>
</div>

<div id="immersive_slider">
    <?php foreach($list['topTypeList'] as $k=>$v): ?>
    <div class="Menubox6 top-type-list">
        <li data-id="<?php echo $v['id']; ?>"><a class="a_color"><?php echo $v['name']; ?></a></li>
    </div>
    <?php endforeach; ?>
</div>
<div class="swiper-container"></div>

<div class="loadEffect" style="display: none">
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
</div>
<div id="footer"
     style="color: #666; text-align: center; margin: 10px; font-size: 12px; width: 100%;position:fixed;bottom: 0px;">
    本服务由浙江政务服务网提供
</div>

<script>
    var host = "/index";
    $(document).ready(function () {
        var $container = $('.swiper-container');
        var $loadEffect = $('.loadEffect');

        $('.top-type-list li').on('click', function () {
            $('.top-type-list li.six').removeClass('six');
            var that = $(this),
                $id = that.attr('data-id');
            that.addClass('six');

            $container.html('');
            $loadEffect.show();
            $.get(host + '/getTypeList', {id: $id}, function (data) {
                $loadEffect.hide();
                $container.html(data);
                window.location.href = '#' + $id
            })

        })


        var $hash = window.location.hash.substring(1);
        if ($hash > 0)
            $('.top-type-list').find('li[data-id="' + $hash + '"]').trigger('click');
        else
            $('.top-type-list li:first').trigger('click');
    })
</script>

<script type="text/javascript">
    function my() {
        getUserInfo({
            success: function (data) {
                if (data == '未登录') {
                    loginApp();
                } else {
                    getUser = jQuery.parseJSON(data);
                    var userId = getUser['userid'];
                    location.href = '<?php echo U("index/orderView");?>?userId=' + userId
                }
            },
            fail: function (data) {
                alert(data);
            }
        });
    }

    function back() {
        window.web2ciciClient.webClose();
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
</script>

</body>
</html>