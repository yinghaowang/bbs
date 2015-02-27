<!--{include header.tpl}-->

<div id="contain">
    <div class="rightC">
        <a class="topicBack" href="./?cid=<!--{$currentCid}-->">返回话题列表</a>
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

                        <div class="topic-content">
                            <p class="mt20">名称：<!--{$exam['Title']}--></p>
                            <p class="mt20">描述：<!--{$exam['Intro']}--></p>
                        </div>
                        <form id="mainform">
                            <input type="hidden" id="flag" name="flag" value="next">
                            <input type="hidden" id="judge" name="judge" value="1">
                            <input type="hidden" id="id" name="id" value="<!--{$exam['Id']}-->">
                            <input type="hidden" id="eqnum" name="eqnum" value="<!--{$eqnum}-->">
                            <input type="hidden" id="tid" name="tid" id="tid" value="<!--{$TestLog['Id']}-->">
                            <input type="hidden" id="tdtt" name="tdtt" id="tdtt" value="<!--{$TestLog['Dtt']}-->">
                            <p class="mt20"><!--{:echo $eqnum+1}--> / <!--{$exam['Questions']}--> <!--{if $examQuestion['IsSingleSelect']}-->单选题<!--{else}-->多选题<!--{/if}--></p>
                            <p class="mt20"><!--{$examQuestion['Title']}--></p>
                            <!--{loop $examQuestionOption $key $row}-->
                            <!--{if $examQuestion['IsSingleSelect']}-->
                            <p class="mt20"><input type="radio" id="x_option_<!--{$row['Id']}-->" name="option[]" value="<!--{$key}-->" /><label for="x_option_<!--{$row['Id']}-->"><!--{$row['Mark']}--> <!--{$row['Content']}--></label></p>
                            <!--{else}-->
                            <p class="mt20"><input type="checkbox" id="x_option_<!--{$row['Id']}-->" name="option[]" value="<!--{$key}-->" /><label for="x_option_<!--{$row['Id']}-->"><!--{$row['Mark']}--> <!--{$row['Content']}--></label></p>
                            <!--{/if}-->
                            <!--{/loop}-->
                            <div class="">
                                <label class="input-label">&nbsp;</label>
                                <div id="mainFormBtnBar">
                                    <a class="btn btn-green btn-big mt20" id="mainFormBtn" href="javascript:postExam();">提交</a>
                                    <a class="btn btn-green btn-big mt20" id="mainFormNextBtn" style="display:none;" href="">下一题</a>
                                </div>
                            </div>
                            <div class="mt20" id="JudgeResultDiv"></div>
                            <div class="mt20" id="OptionReasonDiv"></div>
                        </form>

                    </div>
                </div>

            </li>
        </ul>
    </div>

    <!--{include left.tpl}-->
</div>
<!--{include footer.tpl}-->