<!--{include header.tpl}-->
<div style="margin:10px auto;width:90%;display:block;">
  <a href="./?m=setting&type=avatar" class="settingPannel<!--{if $settingType == 'avatar'}--> active<!--{/if}-->">头像</a>
  <a href="./?m=setting&type=signature" class="settingPannel<!--{if $settingType == 'signature'}--> active<!--{/if}-->">签名</a>
  <a href="./?m=setting&type=email" class="settingPannel<!--{if $settingType == 'email'}--> active<!--{/if}-->">邮箱</a>
  <a href="./?m=setting&type=password" class="settingPannel<!--{if $settingType == 'password'}--> active<!--{/if}-->">密码</a>
</div>
<div id="contain">
    <!--{if $settingType == 'password'}-->
    <form id="password-form" class="form">
      
        <div class="form-group">
          <label for="password">当前密码：</label>
          <input type="password" class="input" id="password" name="password" placeholder="">
        </div>
        <div class="form-group">
          <label for="newPassword">新密码：</label>
          <input type="password" class="input" id="newPassword" name="newPassword" placeholder="">
        </div>
        <div class="form-group">
          <label for="reNewPassword">确认密码：</label>
          <input type="password" class="input" id="reNewPassword" name="reNewPassword" placeholder="">
        </div>
        <div class="form-group">
          <div>
            <input type="button" id="password-setting-button" class="btn btn-primary" onclick="javascrpit:setPassword();" value="保存">
          </div>
        </div>
      
    </form>
    <!--{/if}--> 
    <!--{if $settingType == 'signature'}-->
    <form id="signature-form" class="form">
      
        <div class="form-group">
          <label for="signature">个性签名：</label>
          <input type="text" class="input" id="signature" name="signature" value="<!--{$userInfo['signature']}-->">
        </div>
        <div class="form-group">
          <div>
            <input type="button" id="signature-setting-button" class="btn btn-primary" onclick="javascrpit:setSignature();" value="保存">
          </div>
        </div>
      
    </form>
    <!--{/if}--> 
    <!--{if $settingType == 'email'}-->
    <form id="email-form" class="form">
      
        <!--{if $userInfo['password'] == ""}-->
        <div class="form-group">
          <label for="password">请先设置个人<a href="./?m=setting&type=password">密码</a></label>
        </div>
        <!--{else}-->
        <div class="form-group">
          <label for="email">邮箱地址：</label>
          <input type="text" class="input" id="email" name="email" placeholder="为登录账号，不会公开显示"  value="<!--{$userInfo['email']}-->">
        </div>
        <div class="form-group">
          <label for="password">当前密码：</label>
          <input type="password" class="input" id="password" name="password" placeholder="">
        </div>
        <div class="form-group">
          <div>
            <input type="button" id="email-setting-button" class="btn btn-primary" onclick="javascrpit:setEmail();" value="保存">
          </div>
        </div>
        <!--{/if}-->
      
    </form>
    <!--{/if}--> 
    <!--{if $settingType == 'avatar'}-->
    <form id="avatar-form" class="form">
      
        <div class="form-group" style="margin:10px auto;width:100px; display:block;">
          <img src="<!--{$userInfo['avatar']}-->" class="avatar-now">

            <a id="file_upload" data-uploader="uploader_0" rel="nofollow" class="settingPannel">选择头像</a>
            <span id="file_upload_notice"></span>
            <span class="upload-el">
              <div class="upload-btn-wrap">
                <input type="file" id="uploader_0" class="uploader">
              </div>
            </span>
        </div>
      
    </form>
    <!--{/if}-->
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
      onProgress: function(e){
          $('#file_upload').html('正在上传...');
      },
        onSuccess: function(e){
          data = eval("(" + e.data + ")");
          $('#file_upload').html('上传完成');
          $(".avatar-now").attr("src", data.data +"?var="+ (new Date()).getTime());
      }
    });
  });
</script>
<!--{include footer.tpl}--> 
