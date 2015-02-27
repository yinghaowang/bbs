<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <meta content="True" name="HandheldFriendly">
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; minimum-scale=1.0; user-scalable=no;">
    <title><!--{$title}-->-<!--{SITENAME}--></title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link href="<!--{TPL}-->mobile/css/common.css" rel="stylesheet" type="text/css">
    <link href="<!--{TPL}-->mobile/css/jquery.uploader.css" rel="stylesheet" type="text/css">
    <script src="<!--{TPL}-->mobile/js/jquery.js"></script>
    <script src="<!--{TPL}-->mobile/js/common.js"></script>
    <script src="<!--{TPL}-->mobile/js/jquery.flyout.js"></script>
    <script src="<!--{TPL}-->mobile/js/jquery.uploader.js"></script>
</head>
<body>
    <a id="top" name="top"></a>
    <div class="header">
        <div class="container">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                <tr>
                    <td align="left" width="auto"><a class="logo" href="./"><!--{SITENAME}--></a></td>
                    <td> </td>
                     <td style="padding-top: 2px;" align="right" width="auto">
                     <!--{if $loginInfo['uid'] > 0}-->
                        <a href="./?m=setting"><!--{$loginInfo['nickname']}--></a>
                        <a href="./?m=connect&w=logout" rel="nofollow">退出</a>
                     <!--{else}-->
                        <a href="./?m=connect&w=register" rel="nofollow">注册</a>
                        <a href="./?m=connect&w=login" rel="nofollow">登录/QQ</a>
                     <!--{/if}-->
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>