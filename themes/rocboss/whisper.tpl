<!--{include header.tpl}-->
<div id="contain">
    <div class="rightC">
      <ul class="topicUl">
        <!--{loop $whisperList $t}-->
        <li class="topic" id="whisper-<!--{$t['wid']}-->">
          <div class="name">
            <a href="index.php?m=user&id=<!--{$t['uid']}-->" class="avatar">
              <img src="<!--{$t['avatar']}-->" title="<!--{$t['nickname']}-->" alt="<!--{$t['nickname']}-->">
            </a>
          </div>
          <div class="post">
            <div class="container">
              <span class="org_box_cor"></span>
              <span class="org_box_cor_s"></span>
                <h4><!--{$t['message']}--></h4>
                <div class="post-info">
                  <span><a href="index.php?m=user&id=<!--{$t['uid']}-->"><!--{$t['nickname']}--></a></span>
                  <span>•</span>
                  <small><!--{$t['posttime']}--></small>
                  <!--{if $t['atnickname'] != $loginInfo['nickname']}--> 
                  <span>•</span>
                  发给 
                  <span>
                    <img src="<!--{$t['atavatar']}-->" class="talk-avatar-tiny">
                    <a href="?m=user&id=<!--{$t['atuid']}-->"><!--{$t['atnickname']}--></a>
                  </span>
                  <span>•</span>
                  <!--{if $t['isread'] == 1}-->[ 已读 ]<!--{else}--><b>[ 未读 ]</b><!--{/if}--> 
                  <!--{/if}--> 
                </div>
            </div>
          </div>
        </li>
        <!--{/loop}-->
    </ul>
    <div id="pager">
      <!--{if $whisperList == array() }--> 
        暂无数据 
      <!--{else}--> 
        <!--{$page}--> 
      <!--{/if}-->
    </div>
  </div>
  <div class="leftC">
      <div class="box">
        <h3 class="boxhead"><img src="<!--{TPL}-->/rocboss/images/whisper.png" class="qqlogo"> 我的私信</h3>
        <ul class="list-topic">
          <li<!--{if $whisperStatus == '0'}--> class="active"<!--{/if}-->>
            <a href="./?m=user&w=whisper&status=0">未读私信</a>
          </li>
          <li<!--{if $whisperStatus == '1'}--> class="active"<!--{/if}-->>
            <a href="./?m=user&w=whisper&status=1">已读私信</a>
          </li>
          <li<!--{if $whisperStatus == '2'}--> class="active"<!--{/if}-->>
            <a href="./?m=user&w=whisper&status=2">已发私信</a>
          </li>
        </ul>
      </div>
    </div>
</div>
<!--{include footer.tpl}-->