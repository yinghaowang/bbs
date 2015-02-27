<table class="table-box" style="width:730px;">
    <tr class="table-title" id="table-title">

        <th width="100" valign="middle">选项内容</th>
        <th width="50" valign="middle">是否正确答案</th>
        <th width="100" valign="middle">选项管理</th>
    </tr>
    <!--{loop $OptionList $key $row}-->
    <tr>

        <td><!--{$row['Content']}--></td>
        <td><!--{if $row['IsRight']==1}-->是<!--{else}-->否<!--{/if}--></td>
        <td>
            <button class="btn btn-white btn-small" target="_blank"  onclick="openEditOptionDialog(<!--{$eid}-->,<!--{$eqid}-->,<!--{$row['Id']}-->);">编辑</button>
            <button class="btn btn-white btn-small" target="_blank"  onclick="openDelOptionDialog(<!--{$eid}-->,<!--{$eqid}-->,<!--{$row['Id']}-->)">删除</button>
        </td>
    </tr>
    <!--{/loop}-->
</table>

