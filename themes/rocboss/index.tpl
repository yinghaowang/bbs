<!--{include header.tpl}-->

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
			<!--{if $loginInfo['uid'] > 0 }--><a class="panel" href="javascript:showTopicForm();" rel="nofollow">发表新话题</a><!--{/if}-->
			<!--{$CurrentClubName}-->&nbsp;
            <small>
            	<a href="?cid=<!--{$currentCid}-->&page=<!--{$currentPage}-->&type=exam">
                	<!--{if $RequestType == 'exam'}--><b>测试</b><!--{else}-->测试<!--{/if}-->
            	</a>
            </small>
            <span>/</span>
            <small>
            	<a href="?cid=<!--{$currentCid}-->&page=<!--{$currentPage}-->&type=topic">
            		<!--{if $RequestType == 'topic'}--><b>话题</b><!--{else}-->话题<!--{/if}-->
            	</a>
            </small>
		</h3>
		<!--{if $loginInfo['uid'] > 0 }-->
		<div id="post-newtopic">
          <form id="talk-add" class="form-post">
            <fieldset>
				<select name="cid" id="cid" class="form-control">
					<option value="">选择分类</option>
					<!--{loop $clubList $c}-->
					<option value="<!--{$c['cid']}-->"><!--{$c['clubname']}--></option>
					<!--{/loop}-->
				</select>
                <textarea id="subject" name="subject" class="form-control" rows="4"></textarea>
                <input type="text" name="tempTid" id="tempTid" value="" style="display:none;"/>
                <input type="text" name="pictureString" id="pictureString" value="" style="display:none;"/>
				<a id="file_upload" data-uploader="uploader_0" rel="nofollow">
					<img src="<!--{TPL}-->/rocboss/images/camera.png" class="qqlogo">
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
        <!--{/if}-->
        <!--{if $RequestType=='topic'}-->
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
						<!--{if $loginInfo['uid'] > 0 }-->
							<!--{if $loginInfo['group'] > 7}-->
								<span class="right">
									<a href="javascript:editTopic(<!--{$t['tid']}-->);" rel="nofollow">编辑</a>
									<a href="javascript:alertConfirm('trash(<!--{$t['tid']}-->,0)');" rel="nofollow">删除</a>
								</span>
							<!--{else}-->
								<!--{if $t['uid'] == $loginInfo['uid'] }-->
								<span class="right">
									<a href="javascript:editTopic(<!--{$t['tid']}-->);" rel="nofollow">编辑<--!{id}--></a>
									<a href="javascript:alertConfirm('trash(<!--{$t['tid']}-->,0)');" rel="nofollow">删除</a>
								</span>
								<!--{/if}-->
							<!--{/if}-->
						<!--{/if}-->
						<!--{if $t['istop'] > 0 }--> 
						<span class="topicTop">置顶</span><span>•</span> 
						<!--{/if}--> 
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
        <!--{/if}-->
        <!--{if  $RequestType=='exam'}-->
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
                        <a class="title" id="topicContent" href="exam-<!--{$t['tid']}-->.html">
                            <!--{$t['title']}-->
                        </a>
                        <div class="post-info">
                            <!--{if $t['istop'] > 0 }-->
                            <span class="topicTop">置顶</span><span>•</span>
                            <!--{/if}-->
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
                            <span><!--{$t['lasttime']}--> 过期</span>
                        </div>

                    </div>
                </div>
            </li>
            <!--{/loop}-->
        </ul>
        <!--{/if}-->
		<div id="pager">
			 <!--{if $topicList == array() }--> 
                  暂无数据或版块无权访问 
              <!--{else}--> 
                  <!--{$page}--> 
              <!--{/if}-->
		</div>
	</div>
<!--{include left.tpl}--> 
</div>
<!--{include footer.tpl}--> 