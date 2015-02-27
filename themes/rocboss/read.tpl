<!--{include header.tpl}-->
<script type = "text/javascript" >
	$(document).ready(function(){
		locationHash();
		$("#post-newreply").hide();
	});
	var tmpArr = new Array();
	var i = 0;
	$(function(){
		$('#file_upload').uploader({
		    multi: true,
		    auto: true,
		    showQueue:false,
		    fileSizeLimit: '2M',
		    fileTypeDesc: '选择图片',
		    fileTypeExts: 'jpg,png,bmp,gif',
		    action:'./?m=upload',
		    formData: {"setting": "pictures"},
		   	swf:"themes/rocboss/js/uploader.swf?var=" + (new Date()).getTime(),
		   	onSelected:function(e){if(i>=4){alertMessage("列表一次最多只能上传4张图片");return false;}},
			onProgress: function(e){
			    $('#file_upload_notice').html('正在上传...');
			},
		    onSuccess: function(e){
		    	data = eval("(" + e.data + ")");
		    	alertMessage(data.message);
		    	$('#file_upload_notice').html('上传完成');
				$(".showPicQ").append("<div class=\"uploadSuccess\" id=\"tmp-"+parseInt(i)+"\"><span class=\"del-tmp-pic\" title=\"删除该图片\" onClick=\"javascript:delTmpPicture('"+data.message+"','tmp-" + parseInt(i) + "');\"><img src=\""+data.message+"\"/><span></div>");
				tmpArr[parseInt(i)] = data.message; i++;
		    	$("#pictureString").val(JSON.stringify(tmpArr));
			}
		});
	});
</script>
<div id="contain">
	<div class="rightC">
	<!--{if $loginInfo['uid'] > 0 }--><a class="topicBack" href="javascript:showReplyForm();" rel="nofollow">发表回复</a><!--{/if}-->
	<a class="topicBack" href="./?cid=<!--{$currentCid}-->">返回话题列表</a>
	<a class="topicTl" href="./?cid=<!--{$currentCid}-->"><!--{$CurrentClubName}--></a> > <!--{$title}--> > 详情页
	<ul class="topicUl">
		<li class="topic">
			<div class="name">
				<a href="index.php?m=user&id=<!--{$topicInfo['uid']}-->" title="<!--{$topicInfo['nickname']}-->" class="avatar" rel="nofollow">
					<img class="useravatar" src="<!--{$topicInfo['avatar']}-->">
				</a>
			</div>
			<div class="post">
				<div class="container">
					<span class="org_box_cor"></span>
					<span class="org_box_cor_s"></span>
					<span class="author">
						<a href="index.php?m=user&id=<!--{$topicInfo['uid']}-->" rel="nofollow">
							<!--{$topicInfo['nickname']}-->
							<!--{if $topicInfo['client'] != ''}-->
								<font color="#87A797">
									[ <img src="<!--{TPL}-->/rocboss/images/phone.png" class="qqlogo"><!--{$topicInfo['client']}--> ]
								</font>
							<!--{/if}-->
						</a>
					</span>
					<span class="time"><!--{$topicInfo['posttime']}--></span>
					<div class="post-info">
						<span class="right">楼主</span>
					</div>
					<div class="topic-content">
						<!--{$topicInfo['message']}-->
					</div>
					<!--{if $topicInfo['pictures'] != '' }-->
		                <!--{loop $topicInfo['pictures'] $p}-->
			                <span class="category">
			                	<a href="<!--{$p}-->" class="zoom"><img src="<!--{Image::getSmallImg($p)}-->" alt="" title=""></a>
			                </span>
		                <!--{/loop}-->
	                <!--{/if}-->
	                <div class="topicBottom">
	                <!--{if $loginInfo['uid'] > 0 }-->
	                <div class="right-admin">
		                <!--{if $loginInfo['group'] >= 8 }-->
		                	<a class="trash" id="trash" title="删除" href="javascript:alertConfirm('trash(<!--{$topicInfo['tid']}-->,1)');"></a>
							<a class="<!--{if $topicInfo['istop'] > 0 }-->dotoped<!--{else}-->dotop<!--{/if}-->" id="top" href="javascript:doTop(<!--{$topicInfo['tid']}-->);" title="置顶"></a>
							<div class="move-topic">
			                  <ul class="move-club" topicdata="<!--{$topicInfo['tid']}-->" ciddata="<!--{$currentCid}-->">
			                  <!--{loop $clubList $c}-->
			                  	<li data="<!--{$c['cid']}-->"<!--{if $currentCid == $c['cid'] }--> class="hidden"<!--{/if}-->><!--{$c['clubname']}--></li>
			                  <!--{/loop}-->
			                  </ul>
			                </div>
			                <script type="text/javascript">topicAction();</script>
						<!--{else}-->
							<!--{if $topicInfo['uid'] == $loginInfo['uid'] }-->
							<a class="trash" id="trash" title="删除" href="javascript:alertConfirm('trash(<!--{$topicInfo['tid']}-->,1)');"></a>
							<!--{/if}-->
						<!--{/if}-->
						<a class="<!--{if $isFavorite > 0 }-->favorited<!--{else}-->favorite<!--{/if}-->" id="favorite" href="javascript:favorite(<!--{$topicInfo['tid']}-->);" title="<!--{if $isFavorite > 0 }-->取消收藏<!--{else}-->收藏<!--{/if}-->"></a>
						<a class="<!--{if $isCommend > 0 }-->commended<!--{else}-->commend<!--{/if}-->" id="commend" href="javascript:commend(<!--{$topicInfo['tid']}-->);" style="opacity: 0.8;" title="<!--{if $isCommend > 0 }-->取消赞<!--{else}-->赞一个<!--{/if}-->"></a>
						<!--{if $topicInfo['uid'] != $loginInfo['uid'] }-->
							<a class="AtReply" id="AtReply" href="javascript:AtReply('<!--{$topicInfo['nickname']}-->');" title="回复"></a>
						<!--{/if}-->
	                </div>
	                <!--{/if}-->
	                <!--{if $commendTotal > 0 }-->
						<!--{loop $commendList $c}-->
							<a href="index.php?m=user&id=<!--{$c['uid']}-->" rel="nofollow">
								<img src="<!--{$c['avatar']}-->" title="<!--{$c['nickname']}-->" alt="<!--{$c['nickname']}-->" class="avatarC">
							</a>
						<!--{/loop}-->
						<small class="timeago"><!--{if $commendTotal >15 }-->...等<!--{$commendTotal}-->人<!--{/if}-->觉得很赞</small>
					<!--{/if}-->
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</li>
		<!--{if $loginInfo['uid'] > 0 }-->
		<li class="topic">
			<div id="post-newreply">
				<form id="reply-add" class="form-post">
				<fieldset>
					<input type="text" name="pictureString" id="pictureString" value="" style="display:none;"/>
					<input type="text" name="tid" id="tid" value="<!--{$topicInfo['tid']}-->" hidden/>
					<textarea id="subject" name="subject" class="form-control" rows="4"></textarea>
					<a id="file_upload" data-uploader="uploader_0" rel="nofollow">
						<img src="<!--{TPL}-->/rocboss/images/camera.png" class="qqlogo">
					</a>
					<span id="file_upload_notice"></span>
					<span class="upload-el">
						<div class="upload-btn-wrap">
							<input type="file" id="uploader_0" class="uploader">
						</div>
					</span>
					<a class="right btn" id="create" href="javascript:postReplyTopic();" rel="nofollow">回复</a>
					<div class="showPicQ"></div>
				</fieldset>
				</form>
		    </div>
	    </li>
	    <!--{/if}-->
		<!--{loop $replyList $k $r}-->
		<li class="topic" id="reply-<!--{$r['pid']}-->">
			<div class="name">
				<a href="index.php?m=user&id=<!--{$r['uid']}-->" title="<!--{$r['nickname']}-->" class="avatar" rel="nofollow">
					<img class="replyavatar" src="<!--{$r['avatar']}-->">
				</a>
			</div>
			<div class="post">
				<div class="container">
					<span class="org_box_cor"></span>
					<span class="org_box_cor_s"></span>
					<span class="author">
						<a href="index.php?m=user&id=<!--{$r['uid']}-->" rel="nofollow"><!--{$r['nickname']}--></a>
						<!--{if $r['client'] != ''}-->
							<font color="#87A797">
								[ <img src="<!--{TPL}-->/rocboss/images/phone.png" class="qqlogo"><!--{$r['client']}--> ]
							</font>
						<!--{/if}-->
					</span>
					<span class="time"><!--{$r['posttime']}--></span>
					<!--{if $loginInfo['uid'] > 0 }-->
						<!--{if $r['uid'] != $loginInfo['uid'] }-->
							<span class="time"><a href="javascript:AtReply('<!--{$r['nickname']}-->');">回复TA</a></span>
						<!--{/if}-->
						<!--{if $loginInfo['group'] >= 8 }-->
							<span class="time"><a href="javascript:alertConfirm('delReply(<!--{$r['pid']}-->)');">删除</a></span>
						<!--{/if}-->
					<!--{/if}-->
					<div class="post-info">
						<span class="right"><!--{:echo $k+1}--> 楼</span>
					</div>
					<div class="topic-content">
						<!--{$r['message']}-->
					</div>
					<!--{if $r['pictures'] != '' }-->
		                <!--{loop $r['pictures'] $p}-->
			                <span class="category">
			                	<a href="<!--{$p}-->" class="zoom"><img src="<!--{Image::getSmallImg($p)}-->" alt="" title=""></a>
			                </span>
		                <!--{/loop}-->
	                <!--{/if}-->
				</div>
			</div>
			<div class="clear"></div>
		</li>
		<!--{/loop}-->
	</ul>
	<div id="comment" name="comment">
		<ul>
			<li class="topic">

			</li>
		</ul>
	</div>
	</div>
<!--{include left.tpl}-->
</div>
<!--{include footer.tpl}-->
