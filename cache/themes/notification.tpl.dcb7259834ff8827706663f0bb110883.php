<?php require $this->_include('header.tpl',__FILE__); ?>
<div id="contain">
    <div class="rightC">
    	<?php if ($notifyStatus == '0') { ?>
          <ul class="topicUl">
            <?php if(is_array($notificationList)) foreach($notificationList as $t) { ?>
            <li class="topic" id="notification-<?php echo $t['nid']; ?>">
            	<div class="name">
	            	<a href="index.php?m=user&id=<?php echo $t['uid']; ?>" class="avatar">
	            		<img src="<?php echo $t['avatar']; ?>" title="<?php echo $t['nickname']; ?>" alt="<?php echo $t['nickname']; ?>">
	            	</a>
            	</div>
				<div class="post">
					<div class="container">
						<span class="org_box_cor"></span>
						<span class="org_box_cor_s"></span>
		                <h4><?php echo $t['message']; ?></h4>
		                <div class="post-info">
		                	<span><a href="index.php?m=user&id=<?php echo $t['uid']; ?>"><?php echo $t['nickname']; ?></a></span>
		                	<span>•</span>
		                	<small><?php echo $t['posttime']; ?></small>
		                	<span>•</span>
		                	<a href="./say-<?php echo $t['tid']; ?>.html<?php if ($t['pid'] != '' ) { ?>#reply-<?php echo $t['pid']; ?><?php } ?>">查看</a>
		                </div>
	              	</div>
				</div>
            </li>
            <?php } ?>
          </ul>
          <?php } ?> 
          <?php if ($notifyStatus == '1') { ?>
          <ul class="topicUl">
            <?php if(is_array($notificationList)) foreach($notificationList as $t) { ?>
            <li class="topic" id="notification-<?php echo $t['nid']; ?>">
            	<div class="name">
	            	<a href="index.php?m=user&id=<?php echo $t['uid']; ?>" class="avatar">
	            		<img src="<?php echo $t['avatar']; ?>" title="<?php echo $t['nickname']; ?>" alt="<?php echo $t['nickname']; ?>">
	            	</a>
            	</div>
				<div class="post">
					<div class="container">
						<span class="org_box_cor"></span>
						<span class="org_box_cor_s"></span>
						<h4> <?php echo $t['message']; ?> </h4>
						<div class="post-info">
							<span><a href="index.php?m=user&id=<?php echo $t['uid']; ?>"><?php echo $t['nickname']; ?></a></span>
							<span>•</span>
							<small><?php echo $t['posttime']; ?></small>
							<span>•</span>
							<a href="./say-<?php echo $t['tid']; ?>.html<?php if ($t['pid'] != '' ) { ?>#reply-<?php echo $t['pid']; ?><?php } ?>">查看</a>
						</div>
					</div>
				</div>
            </li>
            <?php } ?>
          </ul>
          <?php } ?>
		<div id="pager">
		  <?php if ($notificationList == array() ) { ?> 
		  	暂无提醒 
		  <?php }else{ ?> 
		  	<?php echo $page; ?> 
		  <?php } ?>
		</div>
	</div>
	<div class="leftC">
	    <div class="box">
	      <h3 class="boxhead"><img src="<?php echo TPL; ?>/rocboss/images/notification.png" class="qqlogo">我的提醒</h3>
	      <ul class="list-topic">
			<li<?php if ($notifyStatus == '0') { ?> class="active"<?php } ?>><a href="./?m=user&w=notification&status=0">未读提醒</a></li>
			<li<?php if ($notifyStatus == '1') { ?> class="active"<?php } ?>><a href="./?m=user&w=notification&status=1">已读提醒</a></li>
	      </ul>
	    </div>
  	</div>
</div>
<?php require $this->_include('footer.tpl',__FILE__); ?>