<!--{include header.tpl}-->
<div id="contain" style="margin:10px auto;">
	<a href="./?m=user&w=notification&status=0" class="settingPannel<!--{if $notifyStatus == '0'}--> active<!--{/if}-->">未读提醒</a>
	<a href="./?m=user&w=notification&status=1" class="settingPannel<!--{if $notifyStatus == '1'}--> active<!--{/if}-->">已读提醒</a>
</div>
<div class="main container">
	<!--{if $notifyStatus == '0'}-->
      	<!--{loop $notificationList $t}-->
		<div class="reply" style="padding:5px;">
		    <table border="0" cellpadding="0" cellspacing="0" width="100%">
		        <tbody><tr>
		            <td class="avatar">
		                <a href="index.php?m=user&id=<!--{$t['uid']}-->">
		                    <img alt="<!--{$t['nickname']}-->" title="<!--{$t['nickname']}-->" src="<!--{$t['avatar']}-->"  rel="nofollow">
		                </a>
		            </td>
		            <td class="title" style="padding:5px;">
	                    <!--{$t['message']}--> <a href="./say-<!--{$t['tid']}-->.html<!--{if $t['pid'] != '' }-->#reply-<!--{$t['pid']}--><!--{/if}-->">[GO]</a>
		            </td>
		        </tr>
		    </tbody></table>
		</div>
      	<!--{/loop}-->
      <!--{/if}--> 
      <!--{if $notifyStatus == '1'}-->
        <!--{loop $notificationList $t}-->
		<div class="reply" style="padding:5px;">
		    <table border="0" cellpadding="0" cellspacing="0" width="100%">
		        <tbody><tr>
		            <td class="avatar">
		                <a href="index.php?m=user&id=<!--{$t['uid']}-->">
		                    <img alt="<!--{$t['nickname']}-->" title="<!--{$t['nickname']}-->" src="<!--{$t['avatar']}-->"  rel="nofollow">
		                </a>
		            </td>
		            <td class="title" style="padding:5px;">
	                    <!--{$t['message']}--> <a href="./say-<!--{$t['tid']}-->.html<!--{if $t['pid'] != '' }-->#reply-<!--{$t['pid']}--><!--{/if}-->">[GO]</a>
		            </td>
		        </tr>
		    </tbody></table>
		</div>
        <!--{/loop}-->
      <!--{/if}-->
	<div class="pages">
	  <!--{if $notificationList == array() }--> 
	  	暂无提醒 
	  <!--{else}--> 
	  	<!--{$page}--> 
	  <!--{/if}-->
	</div>
</div>
<!--{include footer.tpl}-->