<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>网上测验 - 微插件 - 厚学网学校管理后台</title>
    <link href="<!--{TPL}-->rocboss/css/basic.css" type="text/css" rel="stylesheet" />
    <script src="<!--{TPL}-->rocboss/js/jquery.js"></script>
    <script src="<!--{TPL}-->rocboss/js/common.js"></script>
    <script src="<!--{TPL}-->rocboss/js/jquery.uploader.js"></script>
    <script src="<!--{TPL}-->rocboss/js/jquery.flyout.js"></script>
    <script src="<!--{TPL}-->rocboss/js/hxdialog.min.js" ></script>
</head>
<body>

<div class="n_r_con">
    <button class="btn btn-green" onclick="openAddQuestionDialog({# $exam.Id #});">添加题目</button>
</div>
<div id="con_one_1" class="hover">
    <table class="table-box" style="width:1000px;">
        <tr class="table-title">
            <th width="50" height="26" valign="middle">题目</th>
            <th width="50" valign="middle">选项个数</th>
            <th width="50"  valign="middle">是否单选</th>
            <th width="200" valign="middle">&nbsp;</th>
        </tr>
       <!--{loop $questionlist $row}-->
        <tr>
            <td><span class="channel-title"><!--{$row[Title]}--></span></td>
            <td><!--{$row[options]}--></td>
            <td ><!--{if $row[IsSingleSelect]}-->单选<!--{else}-->多选<!--{/if}--></td>
            <td><button class="btn btn-white btn-small" onclick="openAddOptionDialog(<!--{$eid}-->,<!--{$row['Id']}-->);">添加选项</button>
                <button class="btn btn-white btn-small" onclick="openOptionListDialog(<!--{$eid}-->,<!--{$row['Id']}-->);">选项列表</button>
                <button class="btn btn-white btn-small" onclick="openEditQuestionDialog(<!--{$eid}-->,<!--{$row['Id']}-->);">编辑</button>
                <button class="btn btn-white btn-small" onclick="openDelQuestionDialog(<!--{$eid}-->,<!--{$row['Id']}-->);">删除</button>
            </td>
        </tr>
        <!--{/loop}-->
    </table>

</div>

<script type="text/javascript">
    //提示框
    function openTipsDialog(content, time)
    {
        if(HXDialog.list[1]) HXDialog.list[1].close();
        new HXDialog({id:"1", title:"提示框", content:content }).time(time);
    }
    //添加题目
    function openAddQuestionDialog(eid)
    {
        if(HXDialog.list[0]) HXDialog.list[0].close();
        new HXDialog({id:"0", title:"添加题目", width:800, height:400, contentAjax:{url:"s_m_mp_plugin_exam_question.php?flag=addQuestion&eid="+eid} });
    }
    //编辑题目
    function openEditQuestionDialog(eid, eqid)
    {
        if(HXDialog.list[0]) HXDialog.list[0].close();
        new HXDialog({id:"0", title:"编辑题目", width:800, height:400, contentAjax:{url:"?m=admin&w=option&flag=editQuestion&eid="+eid+"&eqid="+eqid} });
    }
    //删除题目
    function openDelQuestionDialog(eid, eqid)
    {
        if(HXDialog.list[0]) HXDialog.list[0].close();
        new HXDialog({id:"0", title:"删除题目", width:500, height:150, contentAjax:{url:"s_m_mp_plugin_exam_question.php?flag=delQuestion&eid="+eid+"&eqid="+eqid} });
    }
    //选项列表
    function openOptionListDialog(eid, eqid)
    {
        if(HXDialog.list[0]) HXDialog.list[0].close();
        new HXDialog({id:"0", title:"选项列表", width:900, height:500, contentAjax:{url:"?m=admin&w=option&flag=OpenOptionlist&eid="+eid+"&eqid="+eqid} });
    }
    //增加选项
    function openAddOptionDialog(eid, eqid)
    {
        if(HXDialog.list[0]) HXDialog.list[0].close();
        new HXDialog({id:"0", title:"增加选项", width:800, height:400, contentAjax:{url:"?m=admin&w=option&flag=addOption&eid="+eid+"&eqid="+eqid} });
    }
    //编辑选项
    function openEditOptionDialog(eid, eqid, eqoid)
    {
        if(HXDialog.list[2]) HXDialog.list[2].close();
        new HXDialog({id:"2", title:"编辑选项", width:800, height:400, contentAjax:{url:"?m=admin&w=option&flag=editOption&eid="+eid+"&eqid="+eqid+"&eqoid="+eqoid} });
    }
    //删除选项
    function openDelOptionDialog(eid, eqid, eqoid)
    {
        if(HXDialog.list[2]) HXDialog.list[2].close();
        new HXDialog({id:"2", title:"删除选项", width:500, height:150, contentAjax:{url:"?m=admin&w=option&flag=delOption&eid="+eid+"&eqid="+eqid+"&eqoid="+eqoid} });
    }
</script>
</body>
</html>
