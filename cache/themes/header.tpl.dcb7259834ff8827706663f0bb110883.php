<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<title><?php echo $title; ?>-<?php echo SITENAME; ?></title>
<meta name="keywords" content="">
<meta name="description" content="">
<link rel="stylesheet" type="text/css" href="<?php echo TPL; ?>
rocboss/css/common.css" media="all">
<link rel="stylesheet" type="text/css" href="<?php echo TPL; ?>
rocboss/css/jquery.uploader.css" media="all">
<script src="<?php echo TPL; ?>rocboss/js/jquery.js"></script>
<script src="<?php echo TPL; ?>rocboss/js/common.js"></script>
<script src="<?php echo TPL; ?>rocboss/js/jquery.uploader.js"></script>
<script src="<?php echo TPL; ?>rocboss/js/jquery.flyout.js"></script>
<script src="<?php echo TPL; ?>rocboss/js/hxdialog.min.js" ></script>
<!--[if lt IE 9]>
<script src="<?php echo TPL; ?>rocboss/js/css3.js"></script>
<![endif]-->
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?48042604b3c7a9973810a87540843e34";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
<script type = "text/javascript" >
	$(document).ready(function() {
		$("#searchWord").keyup(function(event){
		   if(event.keyCode == 13){
			 $("#searchWord_submit").trigger("click");
		   }
		});
	});
</script>
</head>
<body>
<div id="header">
	<div class="wauto">
		<a class="logo" href="./"><?php echo SITENAME; ?></a>
		<div class="user-info-show">
			<input id="searchWord" type="text" placeholder="回车以搜索主题" style=" width: 120px; padding: 1px 5px; font-size: 14px; color: #555; background-color: #fff; background-image: none; border: 1px solid #ccc; border-radius: 3px; -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075); box-shadow: inset 0 1px 1px rgba(0,0,0,.075); -webkit-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s; transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;"/>
			<input onclick="javascript:search();" id="searchWord_submit" type="button" value="搜索" style="display:none;"/>
			<?php if ($loginInfo['uid'] > 0) { ?>
			<a href="./?m=user"<?php if ($currentStatus == 'user') { ?> class="active"<?php } ?>>会员中心</a>
			<a href="./?m=user&w=notification"<?php if ($currentStatus == 'notification') { ?> class="active"<?php } ?>>@提醒</a>
			<a href="./?m=user&w=whisper"<?php if ($currentStatus == 'whisper') { ?> class="active"<?php } ?>>@私信</a>
			<a href="./?m=setting"<?php if ($currentStatus == 'setting') { ?> class="active"<?php } ?>>设置</a>
			<?php if ($loginInfo['group'] >= 8) { ?>
			<a href="./?m=admin"<?php if ($currentStatus == 'admin') { ?> class="active"<?php } ?>>管理中心</a>
			<?php } ?>
			<a href="./?m=connect&w=logout" rel="nofollow">退出</a>
			<?php }else{ ?>
			<a href="./?m=connect&w=register" rel="nofollow">注册</a>
			<a href="./?m=connect&w=login" rel="nofollow">登录</a>

			<?php } ?>
		</div>
		<div class="clear">
		</div>
	</div>
</div>
<div id="tip">
</div>