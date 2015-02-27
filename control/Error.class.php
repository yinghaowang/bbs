<?php
Class Error
{
    public static function debug($Error)
    {
        $bug = debug_backtrace();
        if (!file_exists(ROOT . "/cache/log/")) {
            mkdir(ROOT . "/cache/log/");
        }
?>
<!DOCTYPE>
<html>
<head>
<title>系统发生异常</title>
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<style>
body{
    font-family: 'Microsoft Yahei', Verdana, arial, sans-serif;
    font-size:14px;
}
a{text-decoration:none;color:#174B73;}
a:hover{ text-decoration:none;color:#FF6600;}
h2{
    border-bottom:1px solid #DDD;
    padding:8px 0;
    font-size:25px;
}
.title{
    margin:4px 0;
    color:#F60;
    font-weight:bold;
}
.message,#trace{
    padding:1em;
    border:solid 1px #000;
    margin:10px 0;
    background:#FFD;
    line-height:150%;
}
.message{
    background:#FFD;
    color:#2E2E2E;
        border:1px solid #E0E0E0;
}
#trace{
    background:#E7F7FF;
    border:1px solid #E0E0E0;
    color:#535353;
}
.notice{
    padding:10px;
    margin:5px;
    color:#666;
    background:#FCFCFC;
    border:1px solid #E0E0E0;
}
.red{
    color:red;
    font-weight:bold;
}
</style>
</head>
<body>
<div class="notice">
<h2>糟糕,系统发生异常 </h2>
<div >您可以选择 [ <A HREF="index.php">重试</A> ] [ <A HREF="javascript:history.back()">返回</A> ] 或者 [ <A HREF="index.php">回到首页</A> ]</div>
<p class="title">[ 异常信息 ]</p>
<p>文件:&nbsp;<?php
        echo $bug['1']['file'];
?></p>
<p>行数:&nbsp;<?php
        echo $bug['1']['line'];
?></p>
<p class="message"><?php
        echo $Error;
?></p>
</div>
</body>
</html>
  <?php
        $Kp_ErrorFiles = fopen(ROOT . "/cache/log/error.log", "a+");
        $str           = date("Y-m-d H:i:s") . '=>' . $Error;
        fwrite($Kp_ErrorFiles, $str . "\r\n");
        fclose($Kp_ErrorFiles);
        exit;
    }
}
?>