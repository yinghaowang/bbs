<?php require $this->_include('header.tpl',__FILE__); ?>
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
	<?php if ($loginInfo['uid'] > 0 ) { ?><a class="topicBack" href="javascript:showReplyForm();" rel="nofollow">发表回复</a><?php } ?>
	<a class="topicBack" href="./?cid=<?php echo $currentCid; ?>">返回话题列表</a>
	<a class="topicTl" href="./?cid=<?php echo $currentCid; ?>"><?php echo $CurrentClubName; ?></a> > <?php echo $title; ?> > 详情页
	<ul class="topicUl">
		<li class="topic">
			<div class="name">
				<a href="index.php?m=user&id=<?php echo $topicInfo['uid']; ?>" title="<?php echo $topicInfo['nickname']; ?>" class="avatar" rel="nofollow">
					<img class="useravatar" src="<?php echo $topicInfo['avatar']; ?>">
				</a>
			</div>
			<div class="post">
				<div class="container">
					<span class="org_box_cor"></span>
					<span class="org_box_cor_s"></span>
					<span class="author">
						<a href="index.php?m=user&id=<?php echo $topicInfo['uid']; ?>" rel="nofollow">
							<?php echo $topicInfo['nickname']; ?>
							<?php if ($topicInfo['client'] != '') { ?>
								<font color="#87A797">
									[ <img src="<?php echo TPL; ?>/rocboss/images/phone.png" class="qqlogo"><?php echo $topicInfo['client']; ?> ]
								</font>
							<?php } ?>
						</a>
					</span>
					<span class="time"><?php echo $topicInfo['posttime']; ?></span>
					<div class="post-info">
						<span class="right">楼主</span>
					</div>
					<div class="topic-content">
						<?php echo $topicInfo['message']; ?>
					</div>
					<?php if ($topicInfo['pictures'] != '' ) { ?>
		                <?php if(is_array($topicInfo['pictures'])) foreach($topicInfo['pictures'] as $p) { ?>
			                <span class="category">
			                	<a href="<?php echo $p; ?>" class="zoom"><img src="<?php echo Image::getSmallImg($p); ?>" alt="" title=""></a>
			                </span>
		                <?php } ?>
	                <?php } ?>
	                <div class="topicBottom">
	                <?php if ($loginInfo['uid'] > 0 ) { ?>
	                <div class="right-admin">
		                <?php if ($loginInfo['group'] >= 8 ) { ?>
		                	<a class="trash" id="trash" title="删除" href="javascript:alertConfirm('trash(<?php echo $topicInfo['tid']; ?>,1)');"></a>
							<a class="<?php if ($topicInfo['istop'] > 0 ) { ?>dotoped<?php }else{ ?>dotop<?php } ?>" id="top" href="javascript:doTop(<?php echo $topicInfo['tid']; ?>);" title="置顶"></a>
							<div class="move-topic">
			                  <ul class="move-club" topicdata="<?php echo $topicInfo['tid']; ?>" ciddata="<?php echo $currentCid; ?>">
			                  <?php if(is_array($clubList)) foreach($clubList as $c) { ?>
			                  	<li data="<?php echo $c['cid']; ?>"<?php if ($currentCid == $c['cid'] ) { ?> class="hidden"<?php } ?>><?php echo $c['clubname']; ?></li>
			                  <?php } ?>
			                  </ul>
			                </div>
			                <script type="text/javascript">topicAction();</script>
						<?php }else{ ?>
							<?php if ($topicInfo['uid'] == $loginInfo['uid'] ) { ?>
							<a class="trash" id="trash" title="删除" href="javascript:alertConfirm('trash(<?php echo $topicInfo['tid']; ?>,1)');"></a>
							<?php } ?>
						<?php } ?>
						<a class="<?php if ($isFavorite > 0 ) { ?>favorited<?php }else{ ?>favorite<?php } ?>" id="favorite" href="javascript:favorite(<?php echo $topicInfo['tid']; ?>);" title="<?php if ($isFavorite > 0 ) { ?>取消收藏<?php }else{ ?>收藏<?php } ?>"></a>
						<a class="<?php if ($isCommend > 0 ) { ?>commended<?php }else{ ?>commend<?php } ?>" id="commend" href="javascript:commend(<?php echo $topicInfo['tid']; ?>);" style="opacity: 0.8;" title="<?php if ($isCommend > 0 ) { ?>取消赞<?php }else{ ?>赞一个<?php } ?>"></a>
						<?php if ($topicInfo['uid'] != $loginInfo['uid'] ) { ?>
							<a class="AtReply" id="AtReply" href="javascript:AtReply('<?php echo $topicInfo['nickname']; ?>');" title="回复"></a>
						<?php } ?>
	                </div>
	                <?php } ?>
	                <?php if ($commendTotal > 0 ) { ?>
						<?php if(is_array($commendList)) foreach($commendList as $c) { ?>
							<a href="index.php?m=user&id=<?php echo $c['uid']; ?>" rel="nofollow">
								<img src="<?php echo $c['avatar']; ?>" title="<?php echo $c['nickname']; ?>" alt="<?php echo $c['nickname']; ?>" class="avatarC">
							</a>
						<?php } ?>
						<small class="timeago"><?php if ($commendTotal >15 ) { ?>...等<?php echo $commendTotal; ?>人<?php } ?>觉得很赞</small>
					<?php } ?>
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</li>
		<?php if ($loginInfo['uid'] > 0 ) { ?>
		<li class="topic">
			<div id="post-newreply">
				<form id="reply-add" class="form-post">
				<fieldset>
					<input type="text" name="pictureString" id="pictureString" value="" style="display:none;"/>
					<input type="text" name="tid" id="tid" value="<?php echo $topicInfo['tid']; ?>" hidden/>
					<textarea id="subject" name="subject" class="form-control" rows="4"></textarea>
					<a id="file_upload" data-uploader="uploader_0" rel="nofollow">
						<img src="<?php echo TPL; ?>/rocboss/images/camera.png" class="qqlogo">
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
	    <?php } ?>
		<?php if(is_array($replyList)) foreach ($replyList as $k => $r) { ?>
		<li class="topic" id="reply-<?php echo $r['pid']; ?>">
			<div class="name">
				<a href="index.php?m=user&id=<?php echo $r['uid']; ?>" title="<?php echo $r['nickname']; ?>" class="avatar" rel="nofollow">
					<img class="replyavatar" src="<?php echo $r['avatar']; ?>">
				</a>
			</div>
			<div class="post">
				<div class="container">
					<span class="org_box_cor"></span>
					<span class="org_box_cor_s"></span>
					<span class="author">
						<a href="index.php?m=user&id=<?php echo $r['uid']; ?>" rel="nofollow"><?php echo $r['nickname']; ?></a>
						<?php if ($r['client'] != '') { ?>
							<font color="#87A797">
								[ <img src="<?php echo TPL; ?>/rocboss/images/phone.png" class="qqlogo"><?php echo $r['client']; ?> ]
							</font>
						<?php } ?>
					</span>
					<span class="time"><?php echo $r['posttime']; ?></span>
					<?php if ($loginInfo['uid'] > 0 ) { ?>
						<?php if ($r['uid'] != $loginInfo['uid'] ) { ?>
							<span class="time"><a href="javascript:AtReply('<?php echo $r['nickname']; ?>');">回复TA</a></span>
						<?php } ?>
						<?php if ($loginInfo['group'] >= 8 ) { ?>
							<span class="time"><a href="javascript:alertConfirm('delReply(<?php echo $r['pid']; ?>)');">删除</a></span>
						<?php } ?>
					<?php } ?>
					<div class="post-info">
						<span class="right"><?php echo $k+1; ?> 楼</span>
					</div>
					<div class="topic-content">
						<?php echo $r['message']; ?>
					</div>
					<?php if ($r['pictures'] != '' ) { ?>
		                <?php if(is_array($r['pictures'])) foreach($r['pictures'] as $p) { ?>
			                <span class="category">
			                	<a href="<?php echo $p; ?>" class="zoom"><img src="<?php echo Image::getSmallImg($p); ?>" alt="" title=""></a>
			                </span>
		                <?php } ?>
	                <?php } ?>
				</div>
			</div>
			<div class="clear"></div>
		</li>
		<?php } ?>
	</ul>
	<div id="comment" name="comment">
		<ul>
			<li class="topic">

			</li>
		</ul>
	</div>
	</div>
<?php require $this->_include('left.tpl',__FILE__); ?>
</div>
<?php require $this->_include('footer.tpl',__FILE__); ?>
