<!--{include header.tpl}-->
<div id="contain" style="margin:10px auto;">
  <a href="./?m=user&w=whisper&status=0" class="settingPannel<!--{if $whisperStatus == '0'}--> active<!--{/if}-->">未读私信</a>
  <a href="./?m=user&w=whisper&status=1" class="settingPannel<!--{if $whisperStatus == '1'}--> active<!--{/if}-->">已读私信</a>
  <a href="./?m=user&w=whisper&status=2" class="settingPannel<!--{if $whisperStatus == '2'}--> active<!--{/if}-->">已发私信</a>
</div>
<div class="main container">
    <!--{loop $whisperList $t}-->
    <div class="reply" style="padding:5px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody><tr>
              <td class="avatar">
                  <a href="index.php?m=user&id=<!--{$t['uid']}-->">
                      <img alt="<!--{$t['nickname']}-->" title="<!--{$t['nickname']}-->" src="<!--{$t['avatar']}-->"  rel="nofollow" class="avatar">
                  </a>
              </td>
              <td class="each">
                <div class="name">
                  <span><a href="index.php?m=user&id=<!--{$t['uid']}-->"><!--{$t['nickname']}--></a></span>
                  <small><!--{$t['posttime']}--></small>
                </div>
                <div class="r">
                <!--{if $t['atnickname'] != $loginInfo['nickname']}--> 
                TO <img src="<!--{$t['atavatar']}-->" class="avatar" style="border-radius:15px;">
                  <a href="?m=user&id=<!--{$t['atuid']}-->"><!--{$t['atnickname']}--></a>
                <!--{if $t['isread'] == 1}-->[已读]<!--{else}-->[未读]<!--{/if}--><br>
                <!--{/if}-->
                <!--{$t['message']}-->
                </div>

              </td>
          </tr>
        </tbody></table>
    </div>
    <!--{/loop}-->
    <div class="pages">
      <!--{if $whisperList == array() }--> 
        暂无数据 
      <!--{else}--> 
        <!--{$page}--> 
      <!--{/if}-->
    </div>
</div>
<!--{include footer.tpl}-->