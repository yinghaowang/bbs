<!--{include header.tpl}-->
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
		<!--{if $RequestType == 'topic' || $RequestType == 'reply' || $RequestType == 'favorite'}--> 
		<!--{loop $postList $t}-->
		<li class="topic">
			<div class="name">
		    	<a href="index.php?m=user&id=<!--{$t['uid']}-->" class="avatar">
		    		<img src="<!--{$t['avatar']}-->" title="<!--{$t['nickname']}-->" alt="<!--{$t['nickname']}-->">
		    	</a>
			</div>
			<div class="post">
				<div class="container">
					<span class="org_box_cor"></span>
					<span class="org_box_cor_s"></span>
					<!--{if $RequestType == 'topic'}-->
		            <div class="badge"><!--{$t['comments']}--></div>
		            <!--{/if}-->
		            <h5><!--{$t['message']}--></h5>
		            <div class="post-info">
		            	<!--{if $t['pictures'] != '' }--><img src="<!--{TPL}-->/rocboss/images/picture.png" class="qqlogo"><!--{/if}-->
		            	<span><a href="index.php?m=user&id=<!--{$t['uid']}-->"><!--{$t['nickname']}--></a></span>
		            	<span>•</span>
		            	<small><!--{$t['posttime']}--></small>
		            	<span>•</span>
		            	<a href="./say-<!--{$t['tid']}-->.html<!--{if isset($t['pid']) && $t['pid'] != '' }-->#reply-<!--{$t['pid']}--><!--{/if}-->">查看</a>
		            </div>
		      	</div>
			</div>
		</li>
		<!--{/loop}-->
		</ul>
		<div id="pager">
		  <!--{if $postList == array() }--> 
              暂无数据 
          <!--{else}--> 
          <!--{$page}--> 
          <!--{/if}-->
		</div>
		<!--{else}-->
		<!--{if $RequestType == 'balance'}-->
			<!--{loop $postList $t}-->
			<li class="topic" style="border-bottom: 1px solid #ededed;padding: 10px 0;">
			<div class="container">
		            <div>
		            	<span><b><!--{$t['type']}--></b></span>
		            	<span>•</span>
		            	<span><!--{if $t['changed'] < 0}-->扣除<!--{else}-->收入<!--{/if}--> <b><!--{abs($t['changed'])}--></b> 金币</span>
		            	<span>•</span>
		            	<small>余额 <b><!--{$t['balance']}--></b></small>
		            	<span>•</span>
		            	<small>时间 <b><!--{$t['time']}--></b></small>
		            </div>
		      	</div>
			</li>
			<!--{/loop}-->
			</ul>
			<div id="pager">
				<!--{if $postList == array() }--> 
					暂无账户数据 
				<!--{else}--> 
					<!--{$page}--> 
				<!--{/if}-->
			</div>
		<!--{else}-->
		<!--{loop $followList $t}-->
		<li class="topic">
			<div class="name">
				<a href="index.php?m=user&id=<!--{$t['uid']}-->" class="avatar">
					<img src="<!--{$t['avatar']}-->" title="<!--{$t['nickname']}-->" alt="<!--{$t['nickname']}-->">
				</a>
			</div>
			<div class="post">
				<div class="container">
					<span class="org_box_cor"></span>
					<span class="org_box_cor_s"></span>
					<h4><a href="index.php?m=user&id=<!--{$t['uid']}-->"><!--{$t['nickname']}--></a></h4>
					<p> <!--{if $t['signature'] != ''}-->个性签名：<!--{$t['signature']}-->
						<!--{else}-->这个家伙太懒了，还没有个性签名~
						<!--{/if}-->
					</p>
				</div>
			</div>
		</li>
		<!--{/loop}-->
		</ul>
		<div id="pager">
			<!--{if $followList == array() }--> 
			暂无数据 
			<!--{else}--> 
			<!--{$page}--> 
			<!--{/if}-->
		</div>
		<!--{/if}-->
		<!--{/if}-->
	</div>
	<div class="leftC">
	    <div class="box">
	      <h3 class="boxhead"><img src="<!--{TPL}-->/rocboss/images/user.png" class="qqlogo"> 会员中心</h3>
	      <div class="side-user">
	        <a href="./?m=user&id=<!--{$userInfo['uid']}-->" title="<!--{$userInfo['nickname']}-->">
	          <img src="<!--{$userInfo['avatar']}-->" alt="<!--{$userInfo['nickname']}-->" title="<!--{$userInfo['nickname']}-->" class="avatar">
	          <h4><!--{$userInfo['nickname']}--></h4>
	        </a>
	        <small>
	        	<img id="groupIdImg" src="<!--{TPL}-->rocboss/images/<!--{$userInfo['groupid']}-->.gif">
	        	<span id="groupname"><!--{$userInfo['groupname']}--></span>
	        </small>
	        <br>
	        <!--{if $loginInfo['group'] >= 8}--><p><strong><!--{$userInfo['money']}--></strong> 金币</p><!--{/if}-->
	        <p><!--{$userInfo['regtime']}--> 加入</p>
	        <p><!--{$userInfo['lasttime']}--> 最后</p>
	        <p>
	        	<!--{if $userInfo['signature'] != ''}-->个性签名：<!--{$userInfo['signature']}-->
	        	<!--{else}-->这个家伙太懒了，还没有个性签名~
	        	<!--{/if}-->
	        </p>
	      </div>
		<!--{if $userInfo['uid'] != $loginInfo['uid']}-->
	      <div class="side-profile">
			<!--{if $userInfo['groupid'] < 8 }-->
				<!--{if $loginInfo['group'] > 7 }--> 
				<a href="javascript:ban(<!--{$userInfo['uid']}-->);" class="btn" id="ban">
					<!--{if $userInfo['groupid'] == 0}-->解禁<!--{else}-->禁言<!--{/if}-->
				</a>
				<!--{/if}-->
			<!--{/if}-->
	        <a href="javascript:follow(<!--{$userInfo['uid']}-->);" class="btn" id="follow">
	        	<!--{if $isFollow > 0}-->取消关注<!--{else}-->关注<!--{/if}-->
	        </a>
	        <a href="#" class="btn" id="whisper">私信</a>
	      </div>
		<!--{/if}-->
	    </div>
	    <div class="clear"></div>
	    <div class="box">
	      <ul class="list-topic">
	          <li<!--{if $RequestType == 'topic'}--> class="active"<!--{/if}-->>
	          	<a href="./index.php?m=user&id=<!--{$userInfo['uid']}-->">
	          		<!--{if $userInfo['uid'] != $loginInfo['uid']}-->TA<!--{else}-->我<!--{/if}-->的主题
	          	</a>
	          </li>
	          <li<!--{if $RequestType == 'reply'}--> class="active"<!--{/if}-->>
	          	<a href="./index.php?m=user&id=<!--{$userInfo['uid']}-->&type=reply">
	          		<!--{if $userInfo['uid'] != $loginInfo['uid']}-->TA<!--{else}-->我<!--{/if}-->的回复
	          	</a>
	          </li>
	          <li<!--{if $RequestType == 'follow'}--> class="active"<!--{/if}-->>
	          	<a href="./index.php?m=user&id=<!--{$userInfo['uid']}-->&type=follow">
	          		<!--{if $userInfo['uid'] != $loginInfo['uid']}-->TA<!--{else}-->我<!--{/if}-->的关注
	          	</a>
	          </li>
	          <li<!--{if $RequestType == 'fans'}--> class="active"<!--{/if}-->>
	          	<a href="./index.php?m=user&id=<!--{$userInfo['uid']}-->&type=fans">
	          		<!--{if $userInfo['uid'] != $loginInfo['uid']}-->TA<!--{else}-->我<!--{/if}-->的粉丝
	          	</a>
	          </li>
	          <!--{if $loginInfo['uid'] == $userInfo['uid'] }--> 
	          <li<!--{if $RequestType == 'favorite'}--> class="active"<!--{/if}-->>
	          	<a href="./index.php?m=user&id=<!--{$userInfo['uid']}-->&type=favorite">
	          		我的收藏
	          	</a>
	          </li>
	          <li<!--{if $RequestType == 'balance'}--> class="active"<!--{/if}-->>
	          	<a href="./index.php?m=user&id=<!--{$userInfo['uid']}-->&type=balance">
	          		我的账户
	          	</a>
	          </li>
	          <!--{/if}-->
	      </ul>
	    </div>
  	</div>
</div>

<div id="LoginBox">
    <div class="row1">
        传送私信 (<!--{abs($GLOBALS['balance_config']['change']['whisper'])}-->金币/条)
    </div>
    <form class="form-post">
        <input type="text" class="form-control" value="发给：<!--{$userInfo['nickname']}-->" disabled="">
        <textarea id="content" name="content" class="form-control" rows="5" placeholder="请输入内容"></textarea>
        <input type="hidden" name="touid" id="touid" value="<!--{$userInfo['uid']}-->">
        <a class="btn" href="javascript:whisper();">发送</a>
        <a class="btn" id="cancel">取消</a>
	</form>
</div>

<!--{include footer.tpl}-->