<!--{include header.tpl}-->
<div id="contain">
	<h3 class="topicTl">
		搜索主题： <span style="color:red;"><!--{$searchWord}--></span>
	</h3>
	<ul class="topicUl">
		<!--{loop $topicList $t}-->
		<li class="topic" id="topic-<!--{$t['tid']}-->">
		<div class="name">
			<a href="index.php?m=user&id=<!--{$t['uid']}-->" title="<!--{$t['nickname']}-->" class="avatar" rel="nofollow">
				<img src="<!--{$t['avatar']}-->">
			</a>
		</div>
		<div class="post">
			<div class="container">
				<span class="org_box_cor"></span>
				<span class="org_box_cor_s"></span>
				<div class="badge">
						<a class="title" href="say-<!--{$t['tid']}-->.html"><!--{$t['comments']}--></a>
                </div>
				<a class="title" id="topicContent" href="say-<!--{$t['tid']}-->.html">
					<!--{$t['message']}-->
				</a>
				<div class="post-info">
					<span class="right">
						<a href="./say-<!--{$t['tid']}-->.html">点击查看</a>
					</span>						
					<!--{if $t['clubname'] != '' }--> 
					<a href="./?cid=<!--{$t['cid']}-->" id="clubname"><b><!--{$t['clubname']}--></b></a>
					<!--{if $t['pictures'] != '' }-->
						<img src="<!--{TPL}-->/rocboss/images/picture.png" class="qqlogo">
					<!--{/if}--><span>•</span>
					<!--{/if}--> 
					<span><a href="index.php?m=user&id=<!--{$t['uid']}-->" rel="nofollow"><b><!--{$t['nickname']}--></b></a></span>
					<!--{if $t['client'] != ''}-->
						<font color="#87A797">
							[ <img src="<!--{TPL}-->/rocboss/images/phone.png" class="qqlogo"><!--{$t['client']}--> ]
						</font>
					<!--{/if}-->
					<span>•</span>
					<span><!--{$t['posttime']}--> 发布</span>
					<span>•</span>
					<span><!--{$t['lasttime']}--> 最后</span>
				</div>
				
			</div>
		</div>
		</li>
		<!--{/loop}-->
	</ul>
	<div id="pager">
		 <!--{if $topicList == array() }--> 
              暂无搜索数据
          <!--{else}--> 
              <!--{$page}--> 
          <!--{/if}-->
	</div>
</div>
<!--{include footer.tpl}--> 