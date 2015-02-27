<?php require $this->_include('header.tpl',__FILE__); ?>
<script>
$(function ($) {
	$("#whisper").on('click', function () {
		$("body").append("<div id='mask'></div>");
		$("#mask").addClass("mask").fadeIn("slow");
		$("#LoginBox").fadeIn("slow");
		$("textarea[name=content]").focus();
	});
	$("#cancel").on('click', function () {
		$("#LoginBox").fadeOut("fast");
		$("#mask").css({ display: 'none' });
	});
});
</script>
<div id="contain">
    <div class="rightC">
		<ul class="topicUl">
		<?php if ($RequestType == 'topic' || $RequestType == 'reply' || $RequestType == 'favorite') { ?> 
		<?php if(is_array($postList)) foreach($postList as $t) { ?>
		<li class="topic">
			<div class="name">
		    	<a href="index.php?m=user&id=<?php echo $t['uid']; ?>" class="avatar">
		    		<img src="<?php echo $t['avatar']; ?>" title="<?php echo $t['nickname']; ?>" alt="<?php echo $t['nickname']; ?>">
		    	</a>
			</div>
			<div class="post">
				<div class="container">
					<span class="org_box_cor"></span>
					<span class="org_box_cor_s"></span>
					<?php if ($RequestType == 'topic') { ?>
		            <div class="badge"><?php echo $t['comments']; ?></div>
		            <?php } ?>
		            <h5><?php echo $t['message']; ?></h5>
		            <div class="post-info">
		            	<?php if ($t['pictures'] != '' ) { ?><img src="<?php echo TPL; ?>/rocboss/images/picture.png" class="qqlogo"><?php } ?>
		            	<span><a href="index.php?m=user&id=<?php echo $t['uid']; ?>"><?php echo $t['nickname']; ?></a></span>
		            	<span>•</span>
		            	<small><?php echo $t['posttime']; ?></small>
		            	<span>•</span>
		            	<a href="./say-<?php echo $t['tid']; ?>.html<?php if (isset($t['pid']) && $t['pid'] != '' ) { ?>#reply-<?php echo $t['pid']; ?><?php } ?>">查看</a>
		            </div>
		      	</div>
			</div>
		</li>
		<?php } ?>
		</ul>
		<div id="pager">
		  <?php if ($postList == array() ) { ?> 
              暂无数据 
          <?php }else{ ?> 
          <?php echo $page; ?> 
          <?php } ?>
		</div>
		<?php }else{ ?>
		<?php if ($RequestType == 'balance') { ?>
			<?php if(is_array($postList)) foreach($postList as $t) { ?>
			<li class="topic" style="border-bottom: 1px solid #ededed;padding: 10px 0;">
			<div class="container">
		            <div>
		            	<span><b><?php echo $t['type']; ?></b></span>
		            	<span>•</span>
		            	<span><?php if ($t['changed'] < 0) { ?>扣除<?php }else{ ?>收入<?php } ?> <b><?php echo abs($t['changed']); ?></b> 金币</span>
		            	<span>•</span>
		            	<small>余额 <b><?php echo $t['balance']; ?></b></small>
		            	<span>•</span>
		            	<small>时间 <b><?php echo $t['time']; ?></b></small>
		            </div>
		      	</div>
			</li>
			<?php } ?>
			</ul>
			<div id="pager">
				<?php if ($postList == array() ) { ?> 
					暂无账户数据 
				<?php }else{ ?> 
					<?php echo $page; ?> 
				<?php } ?>
			</div>
		<?php }else{ ?>
		<?php if(is_array($followList)) foreach($followList as $t) { ?>
		<li class="topic">
			<div class="name">
				<a href="index.php?m=user&id=<?php echo $t['uid']; ?>" class="avatar">
					<img src="<?php echo $t['avatar']; ?>" title="<?php echo $t['nickname']; ?>" alt="<?php echo $t['nickname']; ?>">
				</a>
			</div>
			<div class="post">
				<div class="container">
					<span class="org_box_cor"></span>
					<span class="org_box_cor_s"></span>
					<h4><a href="index.php?m=user&id=<?php echo $t['uid']; ?>"><?php echo $t['nickname']; ?></a></h4>
					<p> <?php if ($t['signature'] != '') { ?>个性签名：<?php echo $t['signature']; ?>
						<?php }else{ ?>这个家伙太懒了，还没有个性签名~
						<?php } ?>
					</p>
				</div>
			</div>
		</li>
		<?php } ?>
		</ul>
		<div id="pager">
			<?php if ($followList == array() ) { ?> 
			暂无数据 
			<?php }else{ ?> 
			<?php echo $page; ?> 
			<?php } ?>
		</div>
		<?php } ?>
		<?php } ?>
	</div>
	<div class="leftC">
	    <div class="box">
	      <h3 class="boxhead"><img src="<?php echo TPL; ?>/rocboss/images/user.png" class="qqlogo"> 会员中心</h3>
	      <div class="side-user">
	        <a href="./?m=user&id=<?php echo $userInfo['uid']; ?>" title="<?php echo $userInfo['nickname']; ?>">
	          <img src="<?php echo $userInfo['avatar']; ?>" alt="<?php echo $userInfo['nickname']; ?>" title="<?php echo $userInfo['nickname']; ?>" class="avatar">
	          <h4><?php echo $userInfo['nickname']; ?></h4>
	        </a>
	        <small>
	        	<img id="groupIdImg" src="<?php echo TPL; ?>rocboss/images/<?php echo $userInfo['groupid']; ?>.gif">
	        	<span id="groupname"><?php echo $userInfo['groupname']; ?></span>
	        </small>
	        <br>
	        <?php if ($loginInfo['group'] >= 8) { ?><p><strong><?php echo $userInfo['money']; ?></strong> 金币</p><?php } ?>
	        <p><?php echo $userInfo['regtime']; ?> 加入</p>
	        <p><?php echo $userInfo['lasttime']; ?> 最后</p>
	        <p>
	        	<?php if ($userInfo['signature'] != '') { ?>个性签名：<?php echo $userInfo['signature']; ?>
	        	<?php }else{ ?>这个家伙太懒了，还没有个性签名~
	        	<?php } ?>
	        </p>
	      </div>
		<?php if ($userInfo['uid'] != $loginInfo['uid']) { ?>
	      <div class="side-profile">
			<?php if ($userInfo['groupid'] < 8 ) { ?>
				<?php if ($loginInfo['group'] > 7 ) { ?> 
				<a href="javascript:ban(<?php echo $userInfo['uid']; ?>);" class="btn" id="ban">
					<?php if ($userInfo['groupid'] == 0) { ?>解禁<?php }else{ ?>禁言<?php } ?>
				</a>
				<?php } ?>
			<?php } ?>
	        <a href="javascript:follow(<?php echo $userInfo['uid']; ?>);" class="btn" id="follow">
	        	<?php if ($isFollow > 0) { ?>取消关注<?php }else{ ?>关注<?php } ?>
	        </a>
	        <a href="#" class="btn" id="whisper">私信</a>
	      </div>
		<?php } ?>
	    </div>
	    <div class="clear"></div>
	    <div class="box">
	      <ul class="list-topic">
	          <li<?php if ($RequestType == 'topic') { ?> class="active"<?php } ?>>
	          	<a href="./index.php?m=user&id=<?php echo $userInfo['uid']; ?>">
	          		<?php if ($userInfo['uid'] != $loginInfo['uid']) { ?>TA<?php }else{ ?>我<?php } ?>的主题
	          	</a>
	          </li>
	          <li<?php if ($RequestType == 'reply') { ?> class="active"<?php } ?>>
	          	<a href="./index.php?m=user&id=<?php echo $userInfo['uid']; ?>&type=reply">
	          		<?php if ($userInfo['uid'] != $loginInfo['uid']) { ?>TA<?php }else{ ?>我<?php } ?>的回复
	          	</a>
	          </li>
	          <li<?php if ($RequestType == 'follow') { ?> class="active"<?php } ?>>
	          	<a href="./index.php?m=user&id=<?php echo $userInfo['uid']; ?>&type=follow">
	          		<?php if ($userInfo['uid'] != $loginInfo['uid']) { ?>TA<?php }else{ ?>我<?php } ?>的关注
	          	</a>
	          </li>
	          <li<?php if ($RequestType == 'fans') { ?> class="active"<?php } ?>>
	          	<a href="./index.php?m=user&id=<?php echo $userInfo['uid']; ?>&type=fans">
	          		<?php if ($userInfo['uid'] != $loginInfo['uid']) { ?>TA<?php }else{ ?>我<?php } ?>的粉丝
	          	</a>
	          </li>
	          <?php if ($loginInfo['uid'] == $userInfo['uid'] ) { ?> 
	          <li<?php if ($RequestType == 'favorite') { ?> class="active"<?php } ?>>
	          	<a href="./index.php?m=user&id=<?php echo $userInfo['uid']; ?>&type=favorite">
	          		我的收藏
	          	</a>
	          </li>
	          <li<?php if ($RequestType == 'balance') { ?> class="active"<?php } ?>>
	          	<a href="./index.php?m=user&id=<?php echo $userInfo['uid']; ?>&type=balance">
	          		我的账户
	          	</a>
	          </li>
	          <?php } ?>
	      </ul>
	    </div>
  	</div>
</div>

<div id="LoginBox">
    <div class="row1">
        传送私信 (<?php echo abs($GLOBALS['balance_config']['change']['whisper']); ?>金币/条)
    </div>
    <form class="form-post">
        <input type="text" class="form-control" value="发给：<?php echo $userInfo['nickname']; ?>" disabled="">
        <textarea id="content" name="content" class="form-control" rows="5" placeholder="请输入内容"></textarea>
        <input type="hidden" name="touid" id="touid" value="<?php echo $userInfo['uid']; ?>">
        <a class="btn" href="javascript:whisper();">发送</a>
        <a class="btn" id="cancel">取消</a>
	</form>
</div>

<?php require $this->_include('footer.tpl',__FILE__); ?>