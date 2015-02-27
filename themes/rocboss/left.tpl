  <div class="leftC">
    <!--{if $loginInfo['uid'] > 0 }-->
    <div class="box">
      <h3 class="boxhead"><img src="<!--{TPL}-->/rocboss/images/user.png" class="qqlogo"> 当前账号</h3>
      <div class="side-user">
        <a href="./?m=user" title="<!--{$loginInfo['nickname']}-->">
          <img src="<!--{$loginInfo['avatar']}-->" alt="<!--{$loginInfo['nickname']}-->" title="<!--{$loginInfo['nickname']}-->" class="avatar">
          <h4><!--{$loginInfo['nickname']}--></h4>
        </a>
        <small><img id="groupIdImg" src="<!--{TPL}-->rocboss/images/<!--{$loginInfo['group']}-->.gif"> <!--{$loginInfo['groupname']}--></small>
      </div>
      <div class="side-profile">
        <a href="./?m=user&w=notification" class="notify-count">
          <strong><!--{$notificationNumber}--></strong> 提醒
        </a>
        <a href="./?m=user&w=whisper" class="favorite-count">
          <strong><!--{$whisperNumber}--></strong> 私信
        </a>
        <a href="./?m=user&type=balance" class="balance-count">
          <strong><!--{$balanceNumber}--></strong> 活跃度
        </a> 
      </div>
    </div>
    <div class="clear">
    </div>
    <!--{/if}-->
    <div class="box">
      <h3 class="boxhead"><img src="<!--{TPL}-->/rocboss/images/tags.png" class="qqlogo"> 全部分类</h3>
      <ul class="list-topic">
        <li<!--{if $currentCid == 0}--> class="active"<!--{/if}-->><a href="./">全部</a></li>
        <!--{loop $clubList $c}--> 
        <li<!--{if $currentCid == $c['cid'] }--> class="active"<!--{/if}-->>
            <a href="./?cid=<!--{$c['cid']}-->">
              <img src="<!--{TPL}-->/rocboss/images/tag<!--{if $currentCid == $c['cid'] }-->active<!--{/if}-->.png" class="qqlogo"> 
              <!--{$c['clubname']}-->
            </a>
        </li>
        <!--{/loop}-->
      </ul>
    </div>
    <div class="clear">
    </div>
  </div>