<?php if ($flag=='addOption') { ?>
<form style="font-size:14px;" id="dialogForm">
    <input type="hidden" name="flag" value="Save">
    <input type="hidden" name="save" value="addOption">
    <input type="hidden" name="eid" value="<?php echo $eid; ?>">
    <input type="hidden" name="eqid" value="<?php echo $eqid; ?>">
    <div class="input-row" style="height:auto;">
        <label class="input-label"><strong>选项内容</strong></label>
        <div class="input-cont">
            <textarea class="input-text" id="x_Content" name="x_Content" style="width:600px;height:100px;"></textarea>
        </div>
    </div>
    <div class="input-row">
        <label class="input-label"><strong>是否正确</strong></label>
        <div class="input-cont">
            <select class="input-select" name="x_IsRight">
                <option value="0">否</option>
                <option value="1">是</option>
            </select>
        </div>
    </div>
    <div class="input-row">
        <label class="input-label"><strong>排序</strong></label>
        <div class="input-cont">
            <input type="text" class="input-text" id="x_SortId" name="x_SortId" style="width:400px;" value=""/>
        </div>
    </div>
    <div class="mt15">
        <label class="input-label">&nbsp;</label>
        <div id="dialogFormBtnBar">
            <input type="button" value="取消" class="btn btn-white w180 fw b f16 btn-big mr10 c6" onclick="HXDialog.list[0].close();">
            <input type="button" value="确定" id="dialogFormBtn" class="btn btn-green btn-big w180 fw b f16">
        </div>
        <div id="dialogFormLoading" class="dialogFormLoading"><label class="dialogFormLoadingImg">&nbsp;</label>正在操作中，请等待。。。</div>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $("#dialogFormBtn").click(function(){
            currentAjax = $.ajax({
                url: '?m=admin&w=option&flag=Save',
                data: $('#dialogForm').serialize(),
                type: "post",
                cache : false,
                beforeSend: function(){
                    $("#dialogFormBtnBar").hide();	$("#dialogFormLoading").show();
                },
                success: function(data){
                    $("#dialogFormBtnBar").show();	$("#dialogFormLoading").hide();
                    try{var myObject = eval('(' + data + ')');}catch (e){alert(data);return;}
                    if(myObject["rtn"]=="ok")
                    {
                        HXDialog.list[0].close();
                        setTimeout("window.location.reload();", 1500);
                    }

                    openTipsDialog('<p class="dialogFormTips">'+ myObject["error_text"] +'</p>', 2);
                },
                timeout:30000,
                error: function(data){ currentAjax.abort();	alert("网络超时");	$("#dialogFormBtnBar").show();	$("#dialogFormLoading").hide();}
            });
        });
    });
</script>
<?php } ?>
<?php if ($flag=='editOption') { ?>
<form style="font-size:14px;" id="dialogForm">
    <input type="hidden" name="flag" value="Save">
    <input type="hidden" name="save" value="editOption">
    <input type="hidden" name="eid" value="<?php echo $eid; ?>">
    <input type="hidden" name="eqid" value="<?php echo $eqid; ?>">
    <input type="hidden" name="eqoid" value="<?php echo $EQOId; ?>">
    <div class="input-row" style="height:auto;">
        <label class="input-label"><strong>选项内容</strong></label>
        <div class="input-cont">
            <textarea class="input-text" id="x_Content" name="x_Content" style="width:600px;height:100px;"><?php echo $editoption['Content']; ?></textarea>
        </div>
    </div>
    <div class="input-row">
        <label class="input-label"><strong>是否正确</strong></label>
        <div class="input-cont">
            <select class="input-select" name="x_IsRight">
                <option value="0" <?php if ($editoption['IsRight']) { ?><?php }else{ ?>selected<?php } ?>>否</option>
                <option value="1" <?php if ($editoption['IsRight']) { ?>selected<?php } ?>>是</option>
            </select>
        </div>
    </div>
    <div class="input-row">
        <label class="input-label"><strong>排序</strong></label>
        <div class="input-cont">
            <input type="text" class="input-text" id="x_SortId" name="x_SortId" style="width:400px;" value="<?php echo $editoption['SortId']; ?>"/>
        </div>
    </div>
    <div class="mt15">
        <label class="input-label">&nbsp;</label>
        <div id="dialogFormBtnBar">
            <input type="button" value="取消" class="btn btn-white w180 fw b f16 btn-big mr10 c6" onclick="HXDialog.list[2].close();">
            <input type="button" value="确定" id="dialogFormBtn" class="btn btn-green btn-big w180 fw b f16">
        </div>
        <div id="dialogFormLoading" class="dialogFormLoading"><label class="dialogFormLoadingImg">&nbsp;</label>正在操作中，请等待。。。</div>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $("#dialogFormBtn").click(function(){
            currentAjax = $.ajax({
                url: '?m=admin&w=option&flag=Save',
                data: $('#dialogForm').serialize(),
                type: "post",
                cache : false,
                beforeSend: function(){
                    $("#dialogFormBtnBar").hide();	$("#dialogFormLoading").show();
                },
                success: function(data){
                    $("#dialogFormBtnBar").show();	$("#dialogFormLoading").hide();
                    try{var myObject = eval('(' + data + ')');}catch (e){alert(data);return;}
                    if(myObject["rtn"]=="ok")
                    {
                        HXDialog.list[2].close();
                        //openOptionListDialog(<?php echo $eid; ?>,<?php echo $eqid; ?>);
                        setTimeout("window.location.reload();", 1500);
                    }

                    openTipsDialog('<p class="dialogFormTips">'+ myObject["error_text"] +'</p>', 2);
                },
                timeout:30000,
                error: function(data){ currentAjax.abort();	alert("网络超时");	$("#dialogFormBtnBar").show();	$("#dialogFormLoading").hide();}
            });
        });

    });
</script>
<?php } ?>
<?php if ($flag=='delOption') { ?>
<form style="font-size:14px;" id="dialogForm">
    <input type="hidden" name="flag" value="Save">
    <input type="hidden" name="save" value="delOption">
    <input type="hidden" name="eid" value="<?php echo $eid; ?>">
    <input type="hidden" name="eqid" value="<?php echo $eqid; ?>">
    <input type="hidden" name="eqoid" value="<?php echo $EQOId; ?>">

    <div class="mt15">
        <label class="input-label">&nbsp;</label>
        <div id="dialogFormBtnBar">
            <input type="button" value="取消" class="btn btn-white w180 fw b f16 btn-big mr10 c6" onclick="HXDialog.list[2].close();">
            <input type="button" value="确定" id="dialogFormBtn" class="btn btn-green btn-big w180 fw b f16">
        </div>
        <div id="dialogFormLoading" class="dialogFormLoading"><label class="dialogFormLoadingImg">&nbsp;</label>正在操作中，请等待。。。</div>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $("#dialogFormBtn").click(function(){
            currentAjax = $.ajax({
                url: '?m=admin&w=option',
                data: $('#dialogForm').serialize(),
                type: "post",
                cache : false,
                beforeSend: function(){
                    $("#dialogFormBtnBar").hide();	$("#dialogFormLoading").show();
                },
                success: function(data){
                    $("#dialogFormBtnBar").show();	$("#dialogFormLoading").hide();
                    try{var myObject = eval('(' + data + ')');}catch (e){alert(data);return;}
                    if(myObject["rtn"]=="ok")
                    {
                        HXDialog.list[2].close();
                        //openOptionListDialog(<?php echo $exam.Id; ?>,<?php echo $exam.T_Question.Id; ?>);
                        setTimeout("window.location.reload();", 1500);
                    }
                    openTipsDialog('<p class="dialogFormTips">'+ myObject["error_text"] +'</p>', 2);
                },
                timeout:30000,
                error: function(data){ currentAjax.abort();	alert("网络超时");	$("#dialogFormBtnBar").show();	$("#dialogFormLoading").hide();}
            });
        });

    });
</script>
<?php } ?>