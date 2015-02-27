<!--{include header.tpl}-->
<div class="topic container">
    <div class="info">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody><tr>
                <td class="avatar">
                    <a href="index.php?m=user&id=<!--{$topicInfo['uid']}-->" title="<!--{$topicInfo['nickname']}-->" class="avatar" rel="nofollow">
                        <img class="useravatar" src="<!--{$topicInfo['avatar']}-->">
                    </a>
                </td>
                <td class="text">
                    <a href="index.php?m=user&id=<!--{$topicInfo['uid']}-->" rel="nofollow">
                        <!--{$topicInfo['nickname']}-->
                        <!--{if $topicInfo['client'] != ''}-->
                          <img src="<!--{TPL}-->mobile/images/phone.png">
                        <!--{/if}-->
                    </a>
                    <!--{$topicInfo['posttime']}-->
                </td>
            </tr>
        </tbody></table>
    </div>

    <div class="article">
        <div class="title">
            <h1>
                <!--{$topicInfo['message']}-->
            </h1>
        </div>
        <!--{if $topicInfo['pictures'] != '' }--> 
            <!--{loop $topicInfo['pictures'] $p}--> 
                <span class="category">
                    <a href="<!--{$p}-->" class="zoom"><img src="<!--{Image::getSmallImg($p)}-->" alt="" title=""></a> 
                </span> 
            <!--{/loop}--> 
        <!--{/if}-->
        <!--{if $loginInfo['uid'] > 0 }-->
        <div class="right-admin">
            <!--{if $loginInfo['group'] >= 8 }-->
                <a class="settingPannel" id="trash" title="删除" href="javascript:trash(<!--{$topicInfo['tid']}-->,1);">删除</a>
            <!--{else}-->
                <!--{if $topicInfo['uid'] == $loginInfo['uid'] }-->
                <a class="settingPannel" id="trash" title="删除" href="javascript:trash(<!--{$topicInfo['tid']}-->,1);">删除</a>
                <!--{/if}-->
            <!--{/if}-->
            <a class="settingPannel" id="favorite" href="javascript:favorite(<!--{$topicInfo['tid']}-->);"><!--{if $isFavorite > 0 }-->取消收藏<!--{else}-->收藏<!--{/if}--></a>
            <a class="settingPannel" id="commend" href="javascript:commend(<!--{$topicInfo['tid']}-->);"><!--{if $isCommend > 0 }-->取消赞<!--{else}-->赞一个<!--{/if}--></a>
            <!--{if $topicInfo['uid'] != $loginInfo['uid'] }--> 
                <a class="settingPannel" id="AtReply" href="javascript:AtReply('<!--{$topicInfo['nickname']}-->');">回复</a> 
            <!--{/if}--> 
        </div>
        <!--{/if}-->
        <!--{if $commendTotal > 0 }-->
            <p>
            <!--{loop $commendList $c}--> 
                <a href="index.php?m=user&id=<!--{$c['uid']}-->" rel="nofollow">
                    <img src="<!--{$c['avatar']}-->" title="<!--{$c['nickname']}-->" alt="<!--{$c['nickname']}-->" class="commonpers">
                </a> 
            <!--{/loop}--> 
            <small class="timeago"><!--{if $commendTotal >15 }-->...等<!--{$commendTotal}-->人<!--{/if}-->觉得很赞</small> 
            </p>
        <!--{/if}--> 
    </div>

     
<!--{loop $replyList $k $r}-->
        <div class="reply" id="reply-<!--{$r['pid']}-->">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody>
            <tr>
                <td class="avatar">
                    <a href="index.php?m=user&id=<!--{$r['uid']}-->" title="<!--{$r['nickname']}-->" class="avatar" rel="nofollow">
                        <img class="replyavatar" src="<!--{$r['avatar']}-->" alt="<!--{$r['nickname']}-->">
                    </a>
                </td>

                <td class="each">
                    <div class="name">
                        <a href="index.php?m=user&id=<!--{$r['uid']}-->" rel="nofollow"><!--{$r['nickname']}--></a>
                        <!--{if $r['client'] != ''}-->
                            <img src="<!--{TPL}-->/mobile/images/phone.png">
                        <!--{/if}-->
                        <!--{$r['posttime']}-->
                       <!--{if $loginInfo['uid'] > 0 }-->
                            <!--{if $r['uid'] != $loginInfo['uid'] }--> 
                                <a href="javascript:AtReply('<!--{$r['nickname']}-->');" class="settingPannel">回复TA</a>
                            <!--{/if}-->
                            <!--{if $loginInfo['group'] >= 8 }--> 
                                <a href="javascript:alertConfirm('delReply(<!--{$r['pid']}-->)');" class="settingPannel">删除</a>
                            <!--{/if}-->
                        <!--{/if}-->
                   </div>
                    <div class="r">
                        <!--{$r['message']}-->
                    </div>
                    <!--{if $r['pictures'] != '' }--> 
                        <!--{loop $r['pictures'] $p}--> 
                            <span class="category">
                                <a href="<!--{$p}-->" class="zoom"><img src="<!--{Image::getSmallImg($p)}-->" alt="" title=""></a>
                            </span> 
                        <!--{/loop}--> 
                    <!--{/if}-->
                </td>

            </tr>
        </tbody>
        </table>
        </div>
<!--{/loop}-->
        
     
    <div class="reply_box">
        <form id="reply-add" class="form-post">
            <input type="text" name="pictureString" id="pictureString" value="" style="display:none;"/>
            <input type="text" name="tid" id="tid" value="<!--{$topicInfo['tid']}-->" hidden/>
            <textarea id="subject" name="subject" class="form-control" rows="4"></textarea>
            <input type="button" id="create" onclick="javascript:postReplyTopic();" value="回复"/>
        </form>
    </div>
    
<input type="button" id="selectFile" value="选择图片"/>
<span class="upload-el" style="display:none;"><input type="file" title="" class="uploader" id="uploader_0" accept="image/jpeg,image/gif,image/png"></span>
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