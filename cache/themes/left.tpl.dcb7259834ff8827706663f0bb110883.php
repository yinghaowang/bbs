  <div class="leftC">
    <?php if ($loginInfo['uid'] > 0 ) { ?>
    <div class="box">
      <h3 class="boxhead"><img src="<?php echo TPL; ?>/rocboss/images/user.png" class="qqlogo"> 当前账号</h3>
      <div class="side-user">
        <a href="./?m=user" title="<?php echo $loginInfo['nickname']; ?>">
          <img src="<?php echo $loginInfo['avatar']; ?>" alt="<?php echo $loginInfo['nickname']; ?>" title="<?php echo $loginInfo['nickname']; ?>" class="avatar">
          <h4><?php echo $loginInfo['nickname']; ?></h4>
        </a>
        <small><img id="groupIdImg" src="<?php echo TPL; ?>rocboss/images/<?php echo $loginInfo['group']; ?>.gif"> <?php echo $loginInfo['groupname']; ?></small>
      </div>
      <div class="side-profile">
        <a href="./?m=user&w=notification" class="notify-count">
          <strong><?php echo $notificationNumber; ?></strong> 提醒
        </a>
        <a href="./?m=user&w=whisper" class="favorite-count">
          <strong><?php echo $whisperNumber; ?></strong> 私信
        </a>
        <a href="./?m=user&type=balance" class="balance-count">
          <strong><?php echo $balanceNumber; ?></strong> 活跃度
        </a> 
      </div>
    </div>
    <div class="clear">
    </div>
    <?php } ?>
    <div class="box">
      <h3 class="boxhead"><img src="<?php echo TPL; ?>/rocboss/images/tags.png" class="qqlogo"> 全部分类</h3>
      <ul class="list-topic">
        <li<?php if ($currentCid == 0) { ?> class="active"<?php } ?>><a href="./">全部</a></li>
        <?php if(is_array($clubList)) foreach($clubList as $c) { ?> 
        <li<?php if ($currentCid == $c['cid'] ) { ?> class="active"<?php } ?>>
            <a href="./?cid=<?php echo $c['cid']; ?>">
              <img src="<?php echo TPL; ?>/rocboss/images/tag<?php if ($currentCid == $c['cid'] ) { ?>active<?php } ?>.png" class="qqlogo"> 
              <?php echo $c['clubname']; ?>
            </a>
        </li>
        <?php } ?>
      </ul>
    </div>
    <div class="clear">
    </div>
  </div>