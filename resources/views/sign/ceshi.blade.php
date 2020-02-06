<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
<script src="{{asset('hadmin/js/jquery.min.js')}}"></script>
</head>
<body>
	<h3>测试号消息</h3>
	<p>appid:<span class="appid">{{$userInfo['appid']}}</span></p>
	<p>appsecret:<span  class="appsecret">{{$userInfo['appsecret']}}</span></p>
	<h3>接口配置信息<a href="javascript:;" class="update">修改</a></h3>
	URL:<span class="btn">http://1904.api.com/user/createToken</span><input type="text" class="input_value" style="display:none" name="url" value="http://1904.api.com/user/createToken"><br>
	Token:<span id="btn" class="btn"></span><input type="text" style="display:none"  class="input_value" name="token"><br>


</body>
</html>
<script type="text/javascript">
	var appid=$('.appid').text();
	var appsecret=$('.appsecret').text();
	$.ajax({
		url:"{{url('user/createToken')}}",
		data:{appid:appid,appsecret:appsecret},
		dataType:"json",
		success:function(res){
			$("[name='token']").val(res.token);
			$("#btn").html(res.token);
		}
	})
	$(document).on("click",".update",function(){
		$('.input_value').show();
		$('.btn').hide();
	})
	$(document).on("blur",".input_value",function(){
		$('.btn').show();
		$('.input_value').hide();
	})
		
	


</script>