<table class="table-box" style="width:730px;">
    <tr class="table-title" id="table-title">

        <th width="100" valign="middle">选项内容</th>
        <th width="50" valign="middle">是否正确答案</th>
        <th width="100" valign="middle">选项管理</th>
    </tr>
    <?php if(is_array($OptionList)) foreach ($OptionList as $key => $row) { ?>
    <tr>

        <td><?php echo $row['Content']; ?></td>
        <td><?php if ($row['IsRight']==1) { ?>是<?php }else{ ?>否<?php } ?></td>
        <td>
            <button class="btn btn-white btn-small" target="_blank"  onclick="openEditOptionDialog(<?php echo $eid; ?>,<?php echo $eqid; ?>,<?php echo $row['Id']; ?>);">编辑</button>
            <button class="btn btn-white btn-small" target="_blank"  onclick="openDelOptionDialog(<?php echo $eid; ?>,<?php echo $eqid; ?>,<?php echo $row['Id']; ?>)">删除</button>
        </td>
    </tr>
    <?php } ?>
</table>

