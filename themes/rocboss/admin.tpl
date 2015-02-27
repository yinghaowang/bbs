<!--{include header.tpl}-->

<div id="contain">
	<div class="rightC">
	<!--{if $adminType == 'users'}-->
	  <ul class="topicUl">
	  	<h4>共有 <strong><!--{$Total}--></strong> 名会员</h4>
	    <!--{loop $allMembers $r}-->
	    <li class="topic">
	    	<div class="name">
	        	<a href="index.php?m=user&id=<!--{$r['uid']}-->" class="avatar">
	            	<img src="<!--{Image::getAvatarURL($r['uid'])}-->" title="<!--{$r['nickname']}-->" alt="<!--{$r['nickname']}-->">
	            </a>
	        </div>
	      	<div class="post">
	      		<div class="container">
				<span class="org_box_cor"></span>
				<span class="org_box_cor_s"></span>
	        	<h4 class="media-heading"> 
	          		<a href="index.php?m=user&id=<!--{$r['uid']}-->"><!--{$r['nickname']}--></a>
	                <small><!--{if $r['signature'] != ''}--><!--{$r['signature']}--><!--{/if}--></small>
	        	</h4>
				<p> <!--{Common::getGroupName($r['groupid'])}--> <span>•</span>
					<!--{if $r['qqid'] != ''}-->QQ用户 <span>•</span><!--{/if}-->
					<!--{if $r['password'] != ''}-->已设密码 <span>•</span><!--{/if}-->
					<!--{$r['money']}--> 金币 
					<span>•</span>
					<!--{Common::formatTime($r['regtime'])}--> 加入 
					<span>•</span>
					<!--{Common::formatTime($r['lasttime'])}--> 最后 
				</p>
				</div>
	      	</div>
	    </li>
	    <!--{/loop}-->
	  </ul>
	<div id="pager">
	    <!--{$page}-->
	</div>
	<!--{/if}--> 

	  <!--{if $adminType == 'clubs'}-->
	  <div class="panel-body">
	    <form class="form-post" role="form" id="club-form">
	      <div class="form-group">
	        <label for="clubname">类目名称</label>
	        <input type="text" id="cid" name="cid" hidden>
	        <input type="text" class="form-control" id="clubname" name="clubname" placeholder="类目名称">
	      </div> 
	      <div class="form-group">
	        <label for="position">排序</label>
	        <input type="text" class="form-control" id="position" name="position" placeholder="排序(数字)" size="2">
	      </div>
            <div class="form-group">
                <label for="position">分类</label>
                <input type="text" class="form-control" id="schoolid" name="schoolid" placeholder="分类(B11~~)" size="2">
            </div>
	      <a href="javascript:addClub();" class="btn btn-default" id="addClub">添加</a>
	      <a href="javascript:resetForm();" class="btn btn-default">取消</a>
	    </form>
	    <p>
	        <ul class="media-list">
	        <!--{loop $clubList $r}-->
	        <li class="media">
	            <h4>
	            <a href="javascript:editClub(<!--{$r['cid']}-->,'<!--{$r['clubname']}-->',<!--{$r['position']}-->);" class="btn btn-default" id="editClub">修改</a> 
	            <a href="javascript:banClub(<!--{$r['cid']}-->,<!--{$r['position']}-->);" class="btn btn-<!--{if $r['position'] > 0}-->success<!--{else}-->danger<!--{/if}-->" id="banClub"><!--{if $r['position'] > 0}-->正常<!--{else}-->停用<!--{/if}--> </a>
	            	<small>类目名称:</small>
	                <!--{$r['clubname']}-->
	                &nbsp;
	                <small>顺序:</small>
	                <!--{$r['position']}-->
	            </h4>
	        </li>
	        <!--{/loop}-->
	        </ul>
	    </p>
	  </div>
	  <!--{/if}-->
        <!--{if $adminType == 'exam'}-->
        <div class="panel-body">
            <p>
            <ul class="media-list">
                <!--{loop $examlist $r}-->
                <li class="media">
                    <h4>
                        <small>ID:</small>
                        <!--{$r['Id']}-->
                        &nbsp;
                        <small>测试名:</small>
                        <!--{$r['Title']}-->
                        &nbsp;
                        <small>介绍:</small>
                        <!--{$r['Intro']}-->
                        <a href="javascript:showquestion(<!--{$r['Id']}-->);" class="btn btn-default" id="editexam">题目列表</a>
                        <a href="javascript:showcount(<!--{$r['Id']}-->);" class="btn btn-default" id="editexam">统计</a>
                        <a href="javascript:editexam(<!--{$r['Id']}-->);" class="btn btn-default" id="editexam">编辑</a>
                        <a href="javascript:closeexam(<!--{$r['cid']}-->);" class="btn btn-default" id="delexam">关闭</a>
                    </h4>
                </li>
                <!--{/loop}-->
            </ul>
            </p>
        </div>
        <!--{/if}-->

      <!--{if $adminType == 'links'}-->
      <div class="panel-body">
        <form class="form-post" id="link-form">
          <div class="form-group">
            <label for="linkname">链接名称</label>
            <input type="text" class="form-control" id="linkname" name="linkname" placeholder="链接名称">
          </div> 
          <div class="form-group">
            <label for="linkurl">链接</label>
            <input type="text" class="form-control" id="linkurl" name="linkurl" placeholder="形如http://xxx.xxx.xxx" size="30">
          </div>
          <div class="form-group">
            <label for="linkposition">排序</label>
            <input type="text" class="form-control" id="linkposition" name="linkposition" placeholder="排序(数字)" size="2">
            <input type="text" id="exist" name="exist" value="0" hidden>
          </div>
          <a href="javascript:addLink();" class="btn btn-default" id="addLink">添加</a>
          <a href="javascript:resetForm();" class="btn btn-default">取消</a>
        </form>
        <p>
            <ul class="media-list">
            <!--{loop $LinksList $r}-->
            <li class="media">
                <h4>
                <a href="javascript:editLink(<!--{$r['position']}-->,'<!--{$r['text']}-->','<!--{$r['url']}-->');" class="btn btn-default" id="editLink">修改</a> 
                <a href="javascript:delLink(<!--{$r['position']}-->);" class="btn btn-danger" id="delLink">删除</a>
                	<small>链接名称:</small>
                    <!--{$r['text']}-->
                    &nbsp;
                    <small>链接:</small>
                    <a href="<!--{$r['url']}-->" target="_blank"><!--{$r['url']}--></a>
                    &nbsp;
                    <small>顺序:</small>
                    <!--{$r['position']}-->
                 </p>
                </h4>
            </li>
            <!--{/loop}-->
            </ul>
        </p>
      </div>
      <!--{/if}--> 
      <!--{if $adminType == 'cache'}-->
      	<ul class="topicUl"></ul>
      	<button type="button" class="btn btn-default" onclick="javascript:ClearCache();">清理模版缓存</button>              
      <!--{/if}--> 
	</div>
	<div class="leftC">
	    <div class="box">
	      <h3 class="boxhead"><img src="<!--{TPL}-->/rocboss/images/admin.png" class="qqlogo"> 管理中心</h3>
	      <ul class="list-topic">
              <li<!--{if $adminType == 'users'}--> class="active"<!--{/if}-->><a href="./?m=admin&type=users">所有会员</a></li>
              <li<!--{if $adminType == 'clubs'}--> class="active"<!--{/if}-->><a href="./?m=admin&type=clubs">类目管理</a></li>
              <li<!--{if $adminType == 'links'}--> class="active"<!--{/if}-->><a href="./?m=admin&type=links">友链管理</a></li>
              <li<!--{if $adminType == 'exam'}--> class="active"<!--{/if}-->><a href="./?m=admin&type=exam">测试中心</a></li>
              <li<!--{if $adminType == 'cache'}--> class="active"<!--{/if}-->><a href="./?m=admin&type=cache">清空缓存</a></li>
	      </ul>
	    </div>
  	</div>
</div>
<script type="text/javascript">
    function showquestion(eid)
    {
        if(HXDialog.list[0]) HXDialog.list[0].close();
        new HXDialog({id:"0", title:"题目列表", width:1120, height:600, top:10, content:'<iframe src="index.php?m=admin&w=showquestion&eid='+ eid +'" width="1100" height="600" border="0" frameborder=0></iframe>' });
    }
</script>
<!--{include footer.tpl}-->