<!--{include header.tpl}-->
<!--{if $loginInfo['uid'] > 0}-->
<div id="contain" style="margin:10px auto;">
    <a href="./?m=user&w=notification" class="settingPannel">
      <strong><!--{$notificationNumber}--></strong> 提醒
    </a>
    <a href="./?m=user&w=whisper" class="settingPannel">
      <strong><!--{$whisperNumber}--></strong> 私信
    </a>
    <a href="./?m=user&type=balance" class="settingPannel">
      <strong><!--{$balanceNumber}--></strong> 金币
    </a>
    <a href="./#post-newtopic" class="settingPannel">
      <img src="<!--{TPL}-->/mobile/images/new.png">发表
    </a> 
</div>
<!--{/if}-->
<div class="main container">
<!--{loop $topicList $t}-->
<div class="item">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody><tr>
            <td class="avatar">
                <a href="index.php?m=user&id=<!--{$t['uid']}-->">
                    <img alt="<!--{$t['nickname']}-->" title="<!--{$t['nickname']}-->" src="<!--{$t['avatar']}-->"  rel="nofollow">
                </a>
            </td>
            <td class="title">
                <a class="title" id="topicContent" href="say-<!--{$t['tid']}-->.html">
                    <!--{if $t['istop'] > 0 }--><span class="notice black">[置顶]</span><!--{/if}--> 
                    <!--{if $t['pictures'] != '' }--><img src="<!--{TPL}-->/mobile/images/picture.png" class="qqlogo"><!--{/if}-->
                    <!--{$t['message']}-->
                </a>
            </td>
            <td class="comments-count" width="30">
                <a class="title" href="say-<!--{$t['tid']}-->.html"><!--{$t['comments']}--></a>
            </td>
        </tr>
    </tbody></table>
</div>
<!--{/loop}-->
<div class="pages" ><!--{$page}--></div>

<div id="post-newtopic">
  <form id="talk-add" class="form-post">
    <select name="cid" id="cid" class="form-control">
        <option value="">选择分类</option>
        <!--{loop $clubList $c}-->
        <option value="<!--{$c['cid']}-->"><!--{$c['clubname']}--></option>
        <!--{/loop}-->
    </select>
    <textarea id="subject" name="subject" class="form-control" rows="4"></textarea>
    <input type="text" name="tempTid" id="tempTid" value="" style="display:none;"/>
    <input type="text" name="pictureString" id="pictureString" value="" style="display:none;"/>
    <input type="button" id="create" onclick="javascript:postNewTopic();" rel="nofollow" value="创建新微文"/>
  </form>
</div>

<input type="button" id="selectFile" value="选择图片"/>
<span class="upload-el" style="display:none;"><input type="file" title="" class="uploader" id="uploader_0" accept="image/gif, image/jpeg, image/png"></span>
<div id="queue" class="upload-queue"></div>
<div class="preview"></div>
<input type="button" onclick="javascript:$('#selectFile').uploader('start');" value="开始上传" id="start_upload_bt" hidden/>

<script type="text/javascript">
$(function() {
    var tmpArr = new Array();
    var i = 0;
    var previewHTML = '';
    $('#selectFile').uploader({
        action: './?m=upload',
        name: "Filedata",
        formData: {
            "setting": "pictures"
        },
        multiple: false,
        auto: false,
        showQueue: '#queue',
        fileSizeLimit: '2M',
        fileTypeDesc: '选择图片',
        fileTypeExts: 'jpg,gif,png',
        onSelected: function(filelist) {
            if(i>=4){ $('#selectFile').attr("value", "列表一次最多只能上传4张图片");return false; }
            $('#selectFile').attr("value", "准备上传...");
            $('#start_upload_bt').show();
        },
        onProgress: function(e) {
            $('#selectFile').attr("value", '上传中,速度：' + e.speed);
        },
        onError: function(e) {
            $('#selectFile').attr("value", "ERROR");
        },
        onSuccess: function(e) {
            $('#selectFile').attr("value", "选择图片");
            // $('#start_upload_bt').hidden();
            data = eval("(" + e.data + ")");
            // alertMessage(data.message);
            $(".preview").append("<div class=\"uploadSuccess\" id=\"tmp-"+parseInt(i)+"\"><span class=\"del-tmp-pic\" title=\"删除该图片\" onClick=\"javascript:delTmpPicture('"+data.message+"','tmp-" + parseInt(i) + "');\"><img src=\""+data.message+"\"/><span></div>");
            tmpArr[parseInt(i)] = data.message; i++;
            $("#pictureString").val(JSON.stringify(tmpArr));
        }
    })
});
</script>

</div>
<!--{include footer.tpl}-->
