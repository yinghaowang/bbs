<!--{if $flag=='add'}-->
<form style="font-size:14px;" id="dialogForm">
    <input type="hidden" name="flag" value="addSave">
    <div class="input-row">
        <label class="input-label"><strong>评测名称</strong></label>
        <div class="input-cont">
            <input type="text" class="input-text" id="x_Title" name="x_Title" style="width:400px;" value=""/>
        </div>
    </div>
    <div class="input-row" style="height:auto;">
        <label class="input-label"><strong>详情描述</strong></label>
        <div class="input-cont">
            <textarea class="input-text" id="x_Intro" name="x_Intro" style="width:600px;height:100px;"></textarea>
        </div>
    </div>
    <div class="input-row" style="height:auto;">
        <label class="input-label"><strong>展示解析</strong></label>
        <div class="input-cont">
            <select class="input-select" name="x_ISShowReason">
                <option value="1">是</option>
                <option value="0">否</option>
            </select>
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
                url: 's_m_mp_plugin_exam.php',
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
<!--{/if}-->
<!--{if $flag=='edit'}-->
<form style="font-size:14px;" id="dialogForm">
    <input type="hidden" name="flag" value="editSave">
    <input type="hidden" name="eid" value="<!--{$exam['Id']}-->">
    <div class="input-row">
        <label class="input-label"><strong>题目</strong></label>
        <div class="input-cont">
            <input type="text" class="input-text" id="x_Title" name="x_Title" style="width:400px;" value="<!--{$exam['Title']}-->"/>
        </div>
    </div>
    <div class="input-row" style="height:auto;">
        <label class="input-label"><strong>详情描述</strong></label>
        <div class="input-cont">
            <textarea class="input-text" id="x_Intro" name="x_Intro" style="width:600px;height:100px;"><!--{$exam['Intro']}--></textarea>
        </div>
    </div>
    <div class="input-row" style="height:auto;">
        <label class="input-label"><strong>展示解析</strong></label>
        <div class="input-cont">
            <select class="input-select" name="x_ISShowReason">
                <option value="1" <!--{if $exam['ISShowReason']}-->selected<!--{/if}-->>是</option>
                <option value="0" <!--{if $exam['ISShowReason']}--><!--{else}-->selected<!--{/if}-->>否</option>
            </select>
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
                url: 's_m_mp_plugin_exam.php',
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
<!--{/if}-->
<!--{if $flag=='del'}-->
<form style="font-size:14px;" id="dialogForm">
    <input type="hidden" name="flag" value="delSave">
    <input type="hidden" name="eid" value="<!--{$exam.Id}-->">

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
                url: 's_m_mp_plugin_exam.php',
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
<!--{/if}-->