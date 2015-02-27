<?php require $this->_include('header.tpl',__FILE__); ?>

<script type = "text/javascript" >
	$(document).ready(function() {
		$("#post-newtopic").hide();
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
		    fileTypeExts: 'jpg,png,gif',
		    action:'./?m=upload',
		    formData: {"setting": "pictures"},	
		   	swf:"themes/rocboss/js/uploader.swf?var=" + (new Date()).getTime(),
		   	onSelected:function(e){if(i>=4){alertMessage("列表一次最多只能上传4张图片");return false;}},
			onProgress: function(e){
			    $('#file_upload_notice').html('正在上传...');
			},
		    onSuccess: function(e){
		    	data = eval("(" + e.data + ")");
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
		<h3 class="topicTl">
			<?php if ($loginInfo['uid'] > 0 ) { ?><a class="panel" href="javascript:showTopicForm();" rel="nofollow">发表新话题</a><?php } ?>
			<?php echo $CurrentClubName; ?>&nbsp;
            <small>
            	<a href="?cid=<?php echo $currentCid; ?>&page=<?php echo $currentPage; ?>&type=exam">
                	<?php if ($RequestType == 'exam') { ?><b>测试</b><?php }else{ ?>测试<?php } ?>
            	</a>
            </small>
            <span>/</span>
            <small>
            	<a href="?cid=<?php echo $currentCid; ?>&page=<?php echo $currentPage; ?>&type=topic">
            		<?php if ($RequestType == 'topic') { ?><b>话题</b><?php }else{ ?>话题<?php } ?>
            	</a>
            </small>
		</h3>
		<?php if ($loginInfo['uid'] > 0 ) { ?>
		<div id="post-newtopic">
          <form id="talk-add" class="form-post">
            <fieldset>
				<select name="cid" id="cid" class="form-control">
					<option value="">选择分类</option>
					<?php if(is_array($clubList)) foreach($clubList as $c) { ?>
					<option value="<?php echo $c['cid']; ?>"><?php echo $c['clubname']; ?></option>
					<?php } ?>
				</select>
                <textarea id="subject" name="subject" class="form-control" rows="4"></textarea>
                <input type="text" name="tempTid" id="tempTid" value="" style="display:none;"/>
                <input type="text" name="pictureString" id="pictureString" value="" style="display:none;"/>
				<a id="file_upload" data-uploader="uploader_0" rel="nofollow">
					<img src="<?php echo TPL; ?>/rocboss/images/camera.png" class="qqlogo">
				</a>
				<span id="file_upload_notice"></span>
				<span class="upload-el">
					<div class="upload-btn-wrap">
						<input type="file" id="uploader_0" class="uploader">
					</div>
				</span>
              	<a class="right btn" id="create" href="javascript:postNewTopic();" rel="nofollow">创建</a>
				<div class="showPicQ"></div>
            </fieldset>
          </form>
        </div>
        <?php } ?>
        <?php if ($RequestType=='topic') { ?>
		<ul class="topicUl">
			<?php if(is_array($topicList)) foreach($topicList as $t) { ?>
			<li class="topic" id="topic-<?php echo $t['tid']; ?>">
			<div class="name">
				<a href="index.php?m=user&id=<?php echo $t['uid']; ?>" title="<?php echo $t['nickname']; ?>" class="avatar" rel="nofollow">
					<img src="<?php echo $t['avatar']; ?>">
				</a>
			</div>
			<div class="post">
				<div class="container">
					<span class="org_box_cor"></span>
					<span class="org_box_cor_s"></span>
					<div class="badge">
							<a class="title" href="say-<?php echo $t['tid']; ?>.html"><?php echo $t['comments']; ?></a>
	                </div>
					<a class="title" id="topicContent" href="say-<?php echo $t['tid']; ?>.html">
						<?php echo $t['message']; ?>
					</a>
					<div class="post-info">
						<?php if ($loginInfo['uid'] > 0 ) { ?>
							<?php if ($loginInfo['group'] > 7) { ?>
								<span class="right">
									<a href="javascript:editTopic(<?php echo $t['tid']; ?>);" rel="nofollow">编辑</a>
									<a href="javascript:alertConfirm('trash(<?php echo $t['tid']; ?>,0)');" rel="nofollow">删除</a>
								</span>
							<?php }else{ ?>
								<?php if ($t['uid'] == $loginInfo['uid'] ) { ?>
								<span class="right">
									<a href="javascript:editTopic(<?php echo $t['tid']; ?>);" rel="nofollow">编辑<--!{id; ?></a>
									<a href="javascript:alertConfirm('trash(<?php echo $t['tid']; ?>,0)');" rel="nofollow">删除</a>
								</span>
								<?php } ?>
							<?php } ?>
						<?php } ?>
						<?php if ($t['istop'] > 0 ) { ?> 
						<span class="topicTop">置顶</span><span>•</span> 
						<?php } ?> 
						<?php if ($t['clubname'] != '' ) { ?> 
						<a href="./?cid=<?php echo $t['cid']; ?>" id="clubname"><b><?php echo $t['clubname']; ?></b></a>
						<?php if ($t['pictures'] != '' ) { ?>
							<img src="<?php echo TPL; ?>/rocboss/images/picture.png" class="qqlogo">
						<?php } ?><span>•</span>
						<?php } ?> 
						<span><a href="index.php?m=user&id=<?php echo $t['uid']; ?>" rel="nofollow"><b><?php echo $t['nickname']; ?></b></a></span>
						<?php if ($t['client'] != '') { ?>
							<font color="#87A797">
								[ <img src="<?php echo TPL; ?>/rocboss/images/phone.png" class="qqlogo"><?php echo $t['client']; ?> ]
							</font>
						<?php } ?>
						<span>•</span>
						<span><?php echo $t['posttime']; ?> 发布</span>
						<span>•</span>
						<span><?php echo $t['lasttime']; ?> 最后</span>
					</div>
					
				</div>
			</div>
			</li>
			<?php } ?>
		</ul>
        <?php } ?>
        <?php if ($RequestType=='exam') { ?>
        <ul class="topicUl">
            <?php if(is_array($topicList)) foreach($topicList as $t) { ?>
            <li class="topic" id="topic-<?php echo $t['tid']; ?>">
                <div class="name">
                    <a href="index.php?m=user&id=<?php echo $t['uid']; ?>" title="<?php echo $t['nickname']; ?>" class="avatar" rel="nofollow">
                        <img src="<?php echo $t['avatar']; ?>">
                    </a>
                </div>
                <div class="post">
                    <div class="container">
                        <span class="org_box_cor"></span>
                        <span class="org_box_cor_s"></span>
                        <div class="badge">
                            <a class="title" href="say-<?php echo $t['tid']; ?>.html"><?php echo $t['comments']; ?></a>
                        </div>
                        <a class="title" id="topicContent" href="exam-<?php echo $t['tid']; ?>.html">
                            <?php echo $t['title']; ?>
                        </a>
                        <div class="post-info">
                            <?php if ($t['istop'] > 0 ) { ?>
                            <span class="topicTop">置顶</span><span>•</span>
                            <?php } ?>
                            <?php if ($t['clubname'] != '' ) { ?>
                            <a href="./?cid=<?php echo $t['cid']; ?>" id="clubname"><b><?php echo $t['clubname']; ?></b></a>
                            <?php if ($t['pictures'] != '' ) { ?>
                            <img src="<?php echo TPL; ?>/rocboss/images/picture.png" class="qqlogo">
                            <?php } ?><span>•</span>
                            <?php } ?>
                            <span><a href="index.php?m=user&id=<?php echo $t['uid']; ?>" rel="nofollow"><b><?php echo $t['nickname']; ?></b></a></span>
                            <?php if ($t['client'] != '') { ?>
                            <font color="#87A797">
                                [ <img src="<?php echo TPL; ?>/rocboss/images/phone.png" class="qqlogo"><?php echo $t['client']; ?> ]
                            </font>
                            <?php } ?>
                            <span>•</span>
                            <span><?php echo $t['lasttime']; ?> 过期</span>
                        </div>

                    </div>
                </div>
            </li>
            <?php } ?>
        </ul>
        <?php } ?>
		<div id="pager">
			 <?php if ($topicList == array() ) { ?> 
                  暂无数据或版块无权访问 
              <?php }else{ ?> 
                  <?php echo $page; ?> 
              <?php } ?>
		</div>
	</div>
<?php require $this->_include('left.tpl',__FILE__); ?> 
</div>
<?php require $this->_include('footer.tpl',__FILE__); ?> 