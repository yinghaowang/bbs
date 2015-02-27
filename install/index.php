<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="images/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="images/jquery-ui.min.js"></script>
<script type="text/javascript" src="images/main.js"></script>
<link href="images/style.css" type="text/css" rel="stylesheet">
<title>ROCBOSS微社区 V1.1 安装向导</title>
</head>
<body>
<?php
if(is_file('install.lock')) {
  die('重新安装请先重命名install文件夹下的 install.lock 文件为 _install.lock ！');
}
?>
<div id="no1">
  PHP+MySql 架构的轻量级社区程序
</div>
<div id="no2">
  ROCBOSS微社区 V1.1 
</div>
<div id="no3">
  ROCBOSS微社区 V1.1 
</div>
<div id="no4">
</div>
<div id="no5">
  <a href="../">进入网站&nbsp;&gt;&gt;</a>
</div>
<div id="license">
  <p>
    安装前请把cache、uploads、install目录权限设置为 777（WIN主机跳过）。<font color=red>本安装完成后请删除 install 文件夹！</font>
  </p>
  <p>
    安装完成后务必打开根目录下 config.php 文件完成基础配置，<font color=red>网站密钥一定要更换！</font>
  </p>
  <p>
    如需重新安装请先将数据库清空，然后重新上传install文件夹安装
  </p>
  <p>
    最后感谢MILLET为此安装文件作出的贡献
  </p>
  <div id="licenseBtns">
    <input type="button" value="我已明白" class="button" onclick="goStep2()">
    <input id="licenseCancelBtn" type="button" value="我拒绝" class="button">
  </div>
</div>
<div id="step2" onselectstart="return!1" oncontextmenu="return!1">
  <div id="step2Txt">
    Connecting to server...<br>
    <span id="step2cur">_</span>
  </div>
  <div id="cursor" oncontextmenu="return!1">
  </div>
</div>
<div id="guiBgLogo">
</div>
<div id="progressBar">
  <div id="progressBarDiv">
  </div>
</div>
<div id="window">
  <div id="windowTitle">
    ROCBOSS V1.1 安装向导
  </div>
  <div id="windowContent">
    <div id="step3">
      <strong style="font-size:14px">数据库信息</strong><br>
      <br>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableInfo">
      <tr>
        <td>
          MySQL 服务器：
        </td>
        <td>
          <input name="server" type="text" value="localhost" class="textbox">
        </td>
        <td>
          一般为 localhost
        </td>
      </tr>
      <tr>
        <td>
          数据库名：
        </td>
        <td>
          <input name="database" type="text" value="rocboss" class="textbox">
        </td>
        <td>
          数据库若不存在将自动创建
        </td>
      </tr>
      <tr>
        <td>
          用户名：
        </td>
        <td>
          <input name="user" type="text" value="root" class="textbox">
        </td>
        <td>
          MySQL 的登录账户
        </td>
      </tr>
      <tr>
        <td>
          密码：
        </td>
        <td>
          <input name="password" type="text" value="root" class="textbox">
        </td>
        <td>
          MySQL 的登录密码
        </td>
      </tr>
      <tr>
        <td>
          数据表前缀：
        </td>
        <td>
          <input name="tpre" type="text" value="roc_" class="textbox">
        </td>
        <td>
          若已安装过或者此表前缀已被使用，请修改
        </td>
      </tr>
      </table>
    </div>
    <div id="step4" style="display:none">
      <strong style="font-size:14px">一切都已经准备就绪</strong><br>
      <br>
      请点击“开始安装”立即开始安装程序，安装过程请确保网络连接通畅且不要关闭页面。
    </div>
    <div id="step5" style="display:none">
      <strong style="font-size:14px">配置站点基本信息</strong><br>
      <br>
      <div style="height:260px;overflow-y:scroll">
        <strong>站长信息</strong><br>
        <br>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableInfo">
        <tr>
          <td width="100">
            账户：
          </td>
          <td width="250">
            <input name="username" type="text" value="admin" class="textbox">
          </td>
          <td>
            最高权限账户登录名
          </td>
        </tr>
        <tr>
          <td>
            密码：
          </td>
          <td>
            <input name="pwd" type="text" class="textbox">
          </td>
          <td>
            最高权限账户登录密码
          </td>
        </tr>
        <tr>
          <td>
            邮箱：
          </td>
          <td>
            <input name="email" type="text" class="textbox">
          </td>
          <td>
            最高权限账户所使用的邮箱
          </td>
        </tr>
        </table>
      </div>
    </div>
    <div id="step6" style="display:none">
      <strong style="font-size:14px">谢谢</strong><br>
      <br>
      恭喜您已经完成安装<br>
      请您打开根目录下的 config.php 完成一些基本的配置内容。<br>
      <br>
      如有疑请到ROCBOSS微社区官网交流 <a href="https://www.rocboss.com" target="_blank">[点此前往]</a><br>
    </div>
  </div>
  <div id="windowControls">
    <input id="windowControlNextBtn" type="button" class="button" value="下一步">
  </div>
</div>
</body>
</html>