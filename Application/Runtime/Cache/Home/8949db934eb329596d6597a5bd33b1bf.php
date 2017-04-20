<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE >
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-touch-fullscreen" content="yes">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>萧山区市民服务中心</title>
<script type="text/javascript" src="/hzxxsmzj.yyhj.zjzwfw.gov.cn/Public/js/jquery.min.js"></script>
<script type="text/javascript" src="/hzxxsmzj.yyhj.zjzwfw.gov.cn/Public/js/index.js"></script>
<script data-main="http://app.zjzwfw.gov.cn/client/jssdkJS/jmportal_SDK.js" src="http://app.zjzwfw.gov.cn/client/jssdkJS/require.js"></script>
	<script type="text/javascript" src="/hzxxsmzj.yyhj.zjzwfw.gov.cn/Public/js/main.js"></script>
<script type="text/javascript">
$(document).ready(function(){


	getUserInfo({
		success: function (data) {

			if (data == '未登录') {
				loginApp();
			}
		},
		fail: function (data) {
			alert(data);

		}
	});


});

/*默认字号调整*/
function toPreCall(id){

	getUserInfo({
		success: function (data) {

			if (data == '未登录') {
				loginApp();
			} else {
				getUser = jQuery.parseJSON(data);
				var userId = getUser['userid'];

				$.post('<?php echo U("index/orderTo");?>?userId='+userId,{
					projectId : id,
					phone : $('#phone').val(),
					vcode : $('#vcode').val(),
					orderdate : $('#orderdate').val(),
					ordertime : $('#ordertime').val()
				},function(data){
					alert(data);
					$('.success').html(data);
				});

			}
		},
		fail: function (data) {
			alert(data);

		}
	});




	
}

	(function (doc, win) {
		var docEl = doc.documentElement,
				resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
				recalc = function () {
					var clientWidth = docEl.clientWidth;
					if(clientWidth > 1080)
					 {
					 clientWidth=1080;
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

function sendPhone(){
	var phone = $("#phone").val();

	if(phone==''){
		alert("请输入手机号码");
		return false;
	}
	if(phone.length!=11){alert("请输入正确的手机号码");return false;}
	var tel=$("#phone").val();
	var reg = /^0?1[3|4|5|8][0-9]\d{8}$/;
	if (reg.test(tel)){
		$.ajax({url:"<?php echo U('index/vcode');?>?phone="+tel,async:false,success:function(data){document.getElementById('city_id').value=data;}});set(10);}else{alert("号码有误~");}
}
function set(s){
	
	var intv=setInterval(function(){if(s!=0){$(".vcodeb").html(s+"秒后重发");s--;}else{$(".vcodeb").html("重发验证码");clearInterval(intv);}},1000);

}
</script>
<style type="text/css">
body{font-size:.6rem;font-family: "微软雅黑";margin:0;padding: 0px 0px 40px;}.c{border:0}
#header{ background:#1492ff;color:#fff;clear:both;overflow:hidden;line-height:2.5rem;height:2.5rem;}#header div{float:left;}.back{width:20%;font-size:1.8rem;cursor:pointer}.title{width:60%;text-align:center;font-size:.8rem;overflow:hidden;}.my{width:20%;cursor:pointer}.my span{display:inline-block;margin-left:40%;}.back span{display:inline-block;margin-left:25%}

.info{padding:.4rem .5rem}
.ff{background:#fff;}.ff li{list-style:none;height:2rem;padding:0 0 0 .3rem;line-height:2rem;border-bottom:.1rem solid #f3f3f3;}
input{border:1px solid #fff;outline:medium;height:1.5rem}#phone,#vcode{color:#888}.vcodeb{color:#fff;border-radius:.2rem;background:#338ffe;width:3rem;text-align:center;display:inline;font-size:.5rem;height:1.5rem;text-decoration:none;padding:.3rem}
.sxxq_bottom_nr_zj{background:#fff;width:100%;}.sxxq_bottom_nr_zj a{color:#fff;border-radius:.5rem;background:#338ffe;width:13rem;padding:.5rem;margin:.5rem;text-align:center;display:inline-block;font-size:.7rem}
.ff li span{display:inline-block;font-size:.65rem;font-weight:bold;width:3.5rem}
select{border:1px solid #fff;outline:medium;height:1.5rem;font-size:.6rem;padding-right:2rem;line-height:2rem;}
.success{text-align:Center;line-height:1rem;display:none;padding:.5rem 0;}
</style>

</head>

<body bgcolor="#f3f3f3">
<div id="header"><div class="back"><span onclick="history.go(-1);"> < </span></div><div class="title">网上预约</div><div class="my"><span></span></div></div>
<div class="info">预约基本信息</div>
<div class="success"></div>
<div class="ff">
<input id="city_id" name="city_id" type="hidden">
<form id="infoFrom" name="infoFrom" method="post">
<li><span>手机号码</span><input type="text" name="phone" id="phone" value="输入您的手机号码" onclick="this.value='';"><a href="#" onclick="sendPhone()" class="vcodeb">发送验证码</a></li>
<li><span>验证码</span><input type="text" name="vcode" id="vcode" value="输入您收到的验证码" onclick="this.value='';"></li>
<li><span>预约日期</span>
	<select name="orderdate" id="orderdate">
		<?php foreach($date as $k=>$v){ ?>
		<option value="<?php echo $v; ?>">
			<?php echo $v; ?>
		</option>
		<?php } ?>
	</select>
</li>
<li><span>时间段</span><select name="ordertime" id="ordertime"><?php foreach($time as $k=>$v){ ?><option value="<?php echo $v['beginTime']."-".$v['endTime']; ?>"><?php echo $v['beginTime']."-".$v['endTime']; ?></option><?php } ?></select></li>
</form>
<div class="sxxq_bottom_nr_zj" onClick="toPreCall(<?php echo ($projectId); ?>)" style="cursor:hand"><a class="zt24_b_30" >立即预约</a></div>
</div>
<div id="footer" style="color: #666; text-align: center; margin: 10px; font-size: 12px; width: 100%;position:fixed;bottom: 0px;">本服务由浙江政务服务网提供</div>
</body>
</html>