<!--{include header.tpl}-->
<div id="contain">
    <div class="rightC">
    	<!--{if $notifyStatus == '0'}-->
          <ul class="topicUl">
            <!--{loop $notificationList $t}-->
            <li class="topic" id="notification-<!--{$t['nid']}-->">
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
		                	<span>•</span>
		                	<a href="./say-<!--{$t['tid']}-->.html<!--{if $t['pid'] != '' }-->#reply-<!--{$t['pid']}--><!--{/if}-->">查看</a>
		                </div>
	              	</div>
				</div>
            </li>
            <!--{/loop}-->
          </ul>
          <!--{/if}--> 
          <!--{if $notifyStatus == '1'}-->
          <ul class="topicUl">
            <!--{loop $notificationList $t}-->
            <li class="topic" id="notification-<!--{$t['nid']}-->">
            	<div class="name">
	            	<a href="index.php?m=user&id=<!--{$t['uid']}-->" class="avatar">
	            		<img src="<!--{$t['avatar']}-->" title="<!--{$t['nickname']}-->" alt="<!--{$t['nickname']}-->">
	            	</a>
            	</div>
				<div class="post">
					<div class="container">
						<span class="org_box_cor"></span>
						<span class="org_box_cor_s"></span>
						<h4> <!--{$t['message']}--> </h4>
						<div class="post-info">
							<span><a href="index.php?m=user&id=<!--{$t['uid']}-->"><!--{$t['nickname']}--></a></span>
							<span>•</span>
							<small><!--{$t['posttime']}--></small>
							<span>•</span>
							<a href="./say-<!--{$t['tid']}-->.html<!--{if $t['pid'] != '' }-->#reply-<!--{$t['pid']}--><!--{/if}-->">查看</a>
						</div>
					</div>
				</div>
            </li>
            <!--{/loop}-->
          </ul>
          <!--{/if}-->
		<div id="pager">
		  <!--{if $notificationList == array() }--> 
		  	暂无提醒 
		  <!--{else}--> 
		  	<!--{$page}--> 
		  <!--{/if}-->
		</div>
	</div>
	<div class="leftC">
	    <div class="box">
	      <h3 class="boxhead"><img src="<!--{TPL}-->/rocboss/images/notification.png" class="qqlogo">我的提醒</h3>
	      <ul class="list-topic">
			<li<!--{if $notifyStatus == '0'}--> class="active"<!--{/if}-->><a href="./?m=user&w=notification&status=0">未读提醒</a></li>
			<li<!--{if $notifyStatus == '1'}--> class="active"<!--{/if}-->><a href="./?m=user&w=notification&status=1">已读提醒</a></li>
	      </ul>
	    </div>
  	</div>
</div>
<!--{include footer.tpl}-->