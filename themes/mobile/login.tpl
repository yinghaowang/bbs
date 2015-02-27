<!--{include header.tpl}-->

<!--{if $currentStatus == 'login'}-->
<div id="contain" class="reg-login">
	<a class="topicTl" href="#">登录<!--{SITENAME}--></a>
	<form id="loginform" class="form reg-login">
		<label for="email">昵称或邮箱</label>
		<input type="text" name="email" id="email" class="input" id="email"/>
		<label for="password">密码</label>
		<input type="password" name="password" class="input" id="password"/>
		忘记密码？<a href="./?m=connect&w=resetPassword">立即找回</a> &nbsp;
		<a href="./?m=connect&w=qqlogin" rel="nofollow"><img src="<!--{TPL}-->mobile/images/qq.png">QQ一键登录</a>
		<input type="button" name="submit" value="立即登录" id="login-submit"/>
	</form>
</div>
<!--{/if}-->
<!--{if $currentStatus == 'register'}-->
<div id="contain" class="reg-login">
	<a class="topicTl" href="#">欢迎加入<!--{SITENAME}--></a>
	<form id="joinform" class="form reg-login">
		<label for="email">Email</label>
		<input type="text" name="email" id="email" class="input" />
		<label for="nickname">昵称</label>
		<input type="text" name="nickname" id="nickname" class="input" />
		<label for="password">密码</label>
		<input type="password" name="password" class="input" id="password" />
		<label for="repassword">确认密码</label>
		<input type="password" name="repassword" class="input" id="repassword" />
		<label for="name">验证码</label>
		<input type="text" name="verify" id="verify" class="input" />
		<img src="./" alt="" id="verify_image" title="点击更换">
		<input type="button" name="submit" value="注册" id="reg-submit" />
	</form>
</div>
<!--{/if}-->
<!--{if $currentStatus == 'qqjoin'}-->
<div id="contain" class="reg-login">
	<a class="topicTl" href="#">您已成功使用QQ互联！请先设置昵称 </a>
	<form id="qqjoinform" class="form reg-login">
	<div class="center" id="avatar-layout">
		<img src="<!--{$QQArray['avatar']}-->">
	</div>
	<label for="nickname">昵称</label>
	<input type="text" class="input" id="nickname" name="nickname" autocomplete="off" value="<!--{$QQArray['nickname']}-->">
	<input type="button" id="qqjoin_submit" value="确定昵称">
	</form>
</div>
<!--{/if}-->
<!--{if $currentStatus == 'resetPassword'}-->
<div id="contain" class="reg-login">
	<a class="topicTl" href="#">找回密码-<!--{SITENAME}--></a>
	<form id="resetform" class="form reg-login">
		<label for="email">你的邮箱（请确保设置过）</label>
		<input type="text" name="email" id="email" class="input" id="email"/>
		<label for="verify">验证码</label>
		<input type="text" name="verify" id="verify" class="input" />
		<img src="./" alt="" id="verify_image" title="点击更换">
		<input type="button" name="submit" value="立即找回" id="reset-submit"/>
	</form>
</div>
<!--{/if}-->
<!--{if $currentStatus == 'doReset'}-->
<div id="contain" class="reg-login">
	<a class="topicTl" href="#">重置密码-<!--{SITENAME}--></a>
	<form id="doresetform" class="form reg-login">
		<div class="tit">RESET</div>
		<label for="password">新密码</label>
		<input type="password" name="password" class="input" id="password" />
		<label for="repassword">确认密码</label>
		<input type="password" name="repassword" class="input" id="repassword" />
		<input type="button" name="submit" value="立即重置" id="doreset-submit"/>
	</form>
</div>
<!--{/if}-->

<script type="text/javascript">
$(document).ready(function(){
	$("#verify_image").attr("src","?m=connect&w=identifyImage&rd="+Math.random()).click(function(){
		$(this).attr("src","?m=connect&w=identifyImage&rd="+Math.random());
	});
		
	$("#reg-submit").click(function() {
		if( $('#joinform #password').val() != $('#joinform #repassword').val() ){
			$("#reg-submit").attr("value", "两次密码不一样");
			$("#joinform #repassword").focus();
			return false;
		}
		$('#reg-submit').attr("disabled", "disabled");
		$.post("?m=connect&w=register", {
				"do": "register",
				"email": $('#joinform #email').val(),
				"nickname": $('#joinform #nickname').val(),
				"password": $('#joinform #password').val(),
				"verify": $('#joinform #verify').val(),
			}, function(data) {
				data = eval("(" + data + ")");
				if (data.result == "success") {
					$("#reg-submit").attr("value", "注册成功！即将转跳到登陆界面...");
					window.setTimeout("window.location='./?m=connect&w=login'",1500); 
				} else {
					$("#reg-submit").attr("value", data.message);
					$('#reg-submit').removeAttr("disabled");
					if( data.position == 1 ){
						$("#joinform #email").focus();
					}
					if( data.position == 2 ){
						$("#joinform #nickname").focus();
					}
					if( data.position == 3 ){
						$("#joinform #password").focus();
					}
					if( data.position == 4 ){
						$("#joinform #verify").focus();
						$("#joinform #verify").val('');
						$("#joinform #verify_image").click();
					}
				}
			});
	});
	
	$("#joinform").keydown(function(){
	   if(event.keyCode == 13){
		 $("#reg-submit").click();
	   }
	});
	
	$("#loginform").keydown(function(){
	   if(event.keyCode == 13){
		 $("#login-submit").click();
	   }
	});
	$("#resetform").keydown(function(){
	   if(event.keyCode == 13){
		 $("#reset-submit").click();
	   }
	});
	$("#login-submit").click(function() {
		var as = ($.trim($("#loginform input[name=email]").val()).length >= 2) ? true : false;
		var ps = ($("#loginform input[name=password]").val().length >= 6) ? true : false;
		
		if( as && ps ){
			$('#login-submit').attr("disabled", "disabled");
			$.post("?m=connect&w=login", {
					"do": "login",
					"email": $('#loginform #email').val(),
					"password": $('#loginform #password').val(),
				}, function(data) {
					data = eval("(" + data + ")");
					if (data.result == "success") {
						$("#login-submit").attr("value","登录成功！即将转跳到首页...");
						window.setTimeout("window.location='./'",1200); 
					} else {
						$("#login-submit").attr("value", data.message);
						$('#login-submit').removeAttr("disabled");
						if( data.position == 1 ){
							$("#email").focus();
						}
						if( data.position == 2 ){
							$("#password").focus();
						}
					}
			});
		}else{
			if(!as){
				$("#login-submit").attr("value","账号未填或无效");
				$("#email").focus();
			} else if(!ps){
				$("#login-submit").attr("value","密码未填或无效");
				$("#password").focus();
			}
		}
		
	});
	$("#reset-submit").click(function() {
		$('#reset-submit').attr("disabled", "disabled");
		$.post("?m=connect&w=resetPassword", {
				"do": "resetPassword",
				"email":  $('#resetform #email').val(),
				"verify": $('#resetform #verify').val(),
			}, function(data) {
				data = eval("(" + data + ")");
				if (data.result == "success") {
					$("#reset-submit").attr("value",data.message);
					window.setTimeout("window.location='./';",1000);
				} else {
					$("#reset-submit").attr("value",data.message);
					$('#reset-submit').removeAttr("disabled");
					if( data.position == 1 ){
						$("#email").focus();
					}
					if( data.position == 2 ){
						$("#verify").focus();
					}
				}
		});		
	});
	$("#doreset-submit").click(function() {
		$('#doreset-submit').attr("disabled", "disabled");
		$.post("?m=connect&w=doReset", {
				"code": getUrlParam('code'),
				"password":  $('#doresetform #password').val(),
				"repassword": $('#doresetform #repassword').val(),
			}, function(data) {
				data = eval("(" + data + ")");
				if (data.result == "success") {
					$("#doreset-submit").attr("value",data.message);
					window.setTimeout("window.location='./?m=connect&w=login';",1000);
				} else {
					$("#doreset-submit").attr("value",data.message);
					$('#doreset-submit').removeAttr("disabled");
					$("#password").focus();
				}
		});		
	});
	$("#qqjoin_submit").click(function (){
		$("#qqjoin_submit").val('正在提交...');
		$("#qqjoin_submit").attr("disabled", "disabled");
		$.post("./?m=connect&w=qqjoin", {
			"nickname": $("#qqjoinform #nickname").val(),
		}, function(data) {
			data = eval("(" + data + ")");
			if (data.result == "success") {
				$("#qqjoin_submit").attr("value",data.message);
				window.setTimeout("window.location='./';",1000); 
			} else {
				$("#qqjoin_submit").attr("value",data.message);
				$("#qqjoinform #nickname").focus();
				$("#qqjoin_submit").val('确定昵称');
				$("#qqjoin_submit").removeAttr("disabled");
			}
		});
	});

});
function getUrlParam(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return unescape(r[2]); return null;
}
</script>
<!--{include footer.tpl}-->
