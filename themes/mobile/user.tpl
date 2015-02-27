<!--{include header.tpl}-->
<div id="contain" style="margin:10px auto;">
  	<a href="./index.php?m=user&id=<!--{$userInfo['uid']}-->" class="settingPannel<!--{if $RequestType == 'topic'}--> active<!--{/if}-->">
  		<!--{if $userInfo['uid'] != $loginInfo['uid']}-->TA<!--{else}-->我<!--{/if}-->的主题
  	</a>
  	<a href="./index.php?m=user&id=<!--{$userInfo['uid']}-->&type=reply" class="settingPannel<!--{if $RequestType == 'reply'}--> active<!--{/if}-->">
  		<!--{if $userInfo['uid'] != $loginInfo['uid']}-->TA<!--{else}-->我<!--{/if}-->的回复
  	</a>
  	<a href="./index.php?m=user&id=<!--{$userInfo['uid']}-->&type=follow" class="settingPannel<!--{if $RequestType == 'follow'}--> active<!--{/if}-->">
  		<!--{if $userInfo['uid'] != $loginInfo['uid']}-->TA<!--{else}-->我<!--{/if}-->的关注
  	</a>
  	<a href="./index.php?m=user&id=<!--{$userInfo['uid']}-->&type=fans" class="settingPannel<!--{if $RequestType == 'fans'}--> active<!--{/if}-->">
  		<!--{if $userInfo['uid'] != $loginInfo['uid']}-->TA<!--{else}-->我<!--{/if}-->的粉丝
  	</a>
  <!--{if $loginInfo['uid'] == $userInfo['uid'] }--> 
  	<a href="./index.php?m=user&id=<!--{$userInfo['uid']}-->&type=favorite" class="settingPannel<!--{if $RequestType == 'favorite'}--> active<!--{/if}-->">
  		我的收藏
  	</a>
  	<a href="./index.php?m=user&id=<!--{$userInfo['uid']}-->&type=balance" class="settingPannel<!--{if $RequestType == 'balance'}--> active<!--{/if}-->">
  		我的账户
  	</a>
  <!--{/if}-->
</div>
<div class="main container">
		<!--{if $RequestType == 'topic' || $RequestType == 'reply' || $RequestType == 'favorite'}--> 
		<!--{loop $postList $t}-->
			<div class="item">
			    <table border="0" cellpadding="0" cellspacing="0" width="100%">
			        <tbody><tr>
			            <td class="avatar">
			                <a href="index.php?m=user&id=<!--{$t['uid']}-->">
			                    <img alt="<!--{$t['nickname']}-->" title="<!--{$t['nickname']}-->" src="<!--{$t['avatar']}-->"  rel="nofollow">
			                </a>
			            </td>
			            <td class="title">
			                <a class="title" id="topicContent" href="say-<!--{$t['tid']}-->.html">
			                    <!--{if $t['pictures'] != '' }--><img src="<!--{TPL}-->/mobile/images/picture.png" class="qqlogo"><!--{/if}-->
			                    <!--{$t['message']}-->
			                </a>
			            </td>
			            <!--{if $RequestType == 'topic'}-->
			            <td class="comments-count" width="30">
			                <a class="title" href="say-<!--{$t['tid']}-->.html"><!--{$t['comments']}--></a>
			            </td>
			            <!--{/if}--> 
			        </tr>
			    </tbody></table>
			</div>
		<!--{/loop}-->
		<div class="pages">
		  <!--{if $postList == array() }--> 
              暂无数据 
          <!--{else}--> 
          	<!--{$page}--> 
          <!--{/if}-->
		</div>
		<!--{else}-->
		<!--{if $RequestType == 'balance'}-->
			<!--{loop $postList $t}-->
			<div class="container">
	            <div>
	            	<h4>
	            		<!--{$t['type']}-->
	            		<small><!--{if $t['changed'] < 0}-->扣除<!--{else}-->收入<!--{/if}--></small><!--{abs($t['changed'])}--><small>金币</small>
	            		余额 <!--{$t['balance']}-->
	            	</h4>
	            	<small>时间 <b><!--{$t['time']}--></b></small>
	            </div>
	      	</div>
			<!--{/loop}-->
			<div class="pages">
				<!--{if $postList == array() }--> 
					暂无账户数据 
				<!--{else}--> 
					<!--{$page}--> 
				<!--{/if}-->
			</div>
		<!--{else}-->
		<!--{loop $followList $t}-->
		<div class="reply">
			<div class="avatar">
				<a href="index.php?m=user&id=<!--{$t['uid']}-->">
					<img src="<!--{$t['avatar']}-->" title="<!--{$t['nickname']}-->" alt="<!--{$t['nickname']}-->" class="commonpers">
				</a>
			</div>
					<h4><a href="index.php?m=user&id=<!--{$t['uid']}-->"><!--{$t['nickname']}--></a></h4>
					<!--{if $t['signature'] != ''}-->
						<!--{$t['signature']}-->
					<!--{else}-->
						这个家伙太懒了，还没有个性签名~
					<!--{/if}-->
		</div>
		<!--{/loop}-->
		<div class="pages">
			<!--{if $followList == array() }--> 
				暂无数据 
			<!--{else}--> 
				<!--{$page}--> 
			<!--{/if}-->
		</div>
		<!--{/if}-->
		<!--{/if}-->
</div>

<div id="contain" style="margin:10px auto;">
  	<!--{if $userInfo['uid'] != $loginInfo['uid']}-->
		<!--{if $userInfo['groupid'] < 8 }-->
			<!--{if $loginInfo['group'] > 7 }--> 
			<a href="javascript:ban(<!--{$userInfo['uid']}-->);" class="settingPannel" id="ban">
				<!--{if $userInfo['groupid'] == 0}-->解禁<!--{else}-->禁言<!--{/if}-->
			</a>
			<!--{/if}-->
		<!--{/if}-->
        <a href="javascript:follow(<!--{$userInfo['uid']}-->);" class="settingPannel" id="follow">
        	<!--{if $isFollow > 0}-->取消关注<!--{else}-->关注<!--{/if}-->
        </a>
	<!--{/if}-->
</div>

<!--{if $userInfo['uid'] != $loginInfo['uid']}-->
<div id="contain" class="reg-login">
    <form class="form">
        <input type="text" class="input" value=" 发给：<!--{$userInfo['nickname']}--> [<!--{abs($GLOBALS['balance_config']['change']['whisper'])}-->金币/条]" disabled="disabled">
        <textarea id="content" name="content" class="input" rows="5" placeholder="请输入内容"></textarea>
        <input type="hidden" name="touid" id="touid" value="<!--{$userInfo['uid']}-->">
        <input type="button" name="submit" onclick="javascript:whisper();" id="whisper_submit" value="发送"/>
	</form>
</div>
<!--{/if}-->
<!--{include footer.tpl}-->