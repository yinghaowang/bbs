<?php require $this->_include('header.tpl',__FILE__); ?>
<div id="contain">
    <div class="rightC">
    <?php if ($settingType == 'password') { ?>
    <form id="password-form" class="form-post">
      <fieldset>
        <div class="form-group">
          <label class="col-lg-2 control-label" for="password">当前密码：</label>
          <div class="col-lg-4">
            <input type="password" class="form-control" id="password" name="password" placeholder="">
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-2 control-label" for="newPassword">新密码：</label>
          <div class="col-lg-4">
            <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="">
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-2 control-label" for="reNewPassword">确认密码：</label>
          <div class="col-lg-4">
            <input type="password" class="form-control" id="reNewPassword" name="reNewPassword" placeholder="">
          </div>
        </div>
        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-6">
            <input type="button" id="password-setting-button" class="btn btn-primary" onclick="javascrpit:setPassword();" value="保存">
          </div>
        </div>
      </fieldset>
    </form>
    <?php } ?> 
    <?php if ($settingType == 'signature') { ?>
    <form id="signature-form" class="form-post">
      <fieldset>
        <div class="form-group">
          <label class="col-lg-2 control-label" for="signature">个性签名：</label>
          <div class="col-lg-4">
            <input type="text" class="form-control" id="signature" name="signature" value="<?php echo $userInfo['signature']; ?>">
          </div>
        </div>
        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-6">
            <input type="button" id="signature-setting-button" class="btn btn-primary" onclick="javascrpit:setSignature();" value="保存">
          </div>
        </div>
      </fieldset>
    </form>
    <?php } ?> 
    <?php if ($settingType == 'email') { ?>
    <form id="email-form" class="form-post">
      <fieldset>
        <?php if ($userInfo['password'] == "") { ?>
        <div class="form-group">
          <label class="col-lg-2 control-label" for="password">请先设置个人<a href="./?m=setting&type=password">密码</a></label>
        </div>
        <?php }else{ ?>
        <div class="form-group">
          <label class="col-lg-2 control-label" for="email">邮箱地址：</label>
          <div class="col-lg-4">
            <input type="text" class="form-control" id="email" name="email" placeholder="为登录账号，不会公开显示"  value="<?php echo $userInfo['email']; ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-2 control-label" for="password">当前密码：</label>
          <div class="col-lg-4">
            <input type="password" class="form-control" id="password" name="password" placeholder="">
          </div>
        </div>
        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-6">
            <input type="button" id="email-setting-button" class="btn btn-primary" onclick="javascrpit:setEmail();" value="保存">
          </div>
        </div>
        <?php } ?>
      </fieldset>
    </form>
    <?php } ?> 
    <?php if ($settingType == 'avatar') { ?>
    <form id="avatar-form" class="form-post">
      <fieldset>
        <div class="form-group" style="margin-left:60px;">
          <img src="<?php echo $userInfo['avatar']; ?>" class="avatar-now">
          <div class="col-lg-4">
            <a id="file_upload" data-uploader="uploader_0" rel="nofollow">
              <img src="<?php echo TPL; ?>/rocboss/images/camera.png" class="qqlogo">
            </a>
            <span id="file_upload_notice"></span>
            <span class="upload-el">
              <div class="upload-btn-wrap">
                <input type="file" id="uploader_0" class="uploader">
              </div>
            </span>
          </div>
        </div>
      </fieldset>
    </form>
    <?php } ?>
  </div>
  <div class="leftC">
    <div class="box">
      <h3 class="boxhead"><img src="<?php echo TPL; ?>/rocboss/images/settings.png" class="qqlogo">设置中心</h3>
      <ul class="list-topic">
        <li<?php if ($settingType == 'avatar') { ?> class="active"<?php } ?>><a href="./?m=setting&type=avatar">修改头像</a></li>
        <li<?php if ($settingType == 'signature') { ?> class="active"<?php } ?>><a href="./?m=setting&type=signature">个性签名</a></li>
        <li<?php if ($settingType == 'email') { ?> class="active"<?php } ?>><a href="./?m=setting&type=email">邮箱设置</a></li>
        <li<?php if ($settingType == 'password') { ?> class="active"<?php } ?>><a href="./?m=setting&type=password">密码安全</a></li>
      </ul>
    </div>
  </div>
</div>
<script type = "text/javascript" >
  var tmpArr = new Array();
  var i = 0;
  $(function(){
    $('#file_upload').uploader({
        multi: true,
        auto: true,
        showQueue:false,
        fileSizeLimit: '2M',
        fileTypeDesc: '选择图片',
        fileTypeExts: 'jpg,png,gif',
        action:'./?m=upload',
        formData: {"setting": "avatars"},  
        swf:"themes/rocboss/js/uploader.swf?var=" + (new Date()).getTime(),
      onProgress: function(e){
          $('#file_upload_notice').html('正在上传...');
      },
        onSuccess: function(e){
          data = eval("(" + e.data + ")");
          alertMessage(data.message);
          $('#file_upload_notice').html('上传完成');
          $(".avatar-now").attr("src", data.data +"?var="+ (new Date()).getTime());
      }
    });
  });
</script>
<?php require $this->_include('footer.tpl',__FILE__); ?> 
