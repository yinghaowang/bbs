<?php require $this->_include('header.tpl',__FILE__); ?>

<div id="contain">
    <div class="rightC">
        <a class="topicBack" href="./?cid=<?php echo $currentCid; ?>">返回话题列表</a>
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

                        <div class="topic-content">
                            <p class="mt20">名称：<?php echo $exam['Title']; ?></p>
                            <p class="mt20">描述：<?php echo $exam['Intro']; ?></p>
                        </div>
                        <form id="mainform">
                            <input type="hidden" id="flag" name="flag" value="next">
                            <input type="hidden" id="judge" name="judge" value="1">
                            <input type="hidden" id="id" name="id" value="<?php echo $exam['Id']; ?>">
                            <input type="hidden" id="eqnum" name="eqnum" value="<?php echo $eqnum; ?>">
                            <input type="hidden" id="tid" name="tid" id="tid" value="<?php echo $TestLog['Id']; ?>">
                            <input type="hidden" id="tdtt" name="tdtt" id="tdtt" value="<?php echo $TestLog['Dtt']; ?>">
                            <p class="mt20"><?php echo $eqnum+1; ?> / <?php echo $exam['Questions']; ?> <?php if ($examQuestion['IsSingleSelect']) { ?>单选题<?php }else{ ?>多选题<?php } ?></p>
                            <p class="mt20"><?php echo $examQuestion['Title']; ?></p>
                            <?php if(is_array($examQuestionOption)) foreach ($examQuestionOption as $key => $row) { ?>
                            <?php if ($examQuestion['IsSingleSelect']) { ?>
                            <p class="mt20"><input type="radio" id="x_option_<?php echo $row['Id']; ?>" name="option[]" value="<?php echo $key; ?>" /><label for="x_option_<?php echo $row['Id']; ?>"><?php echo $row['Mark']; ?> <?php echo $row['Content']; ?></label></p>
                            <?php }else{ ?>
                            <p class="mt20"><input type="checkbox" id="x_option_<?php echo $row['Id']; ?>" name="option[]" value="<?php echo $key; ?>" /><label for="x_option_<?php echo $row['Id']; ?>"><?php echo $row['Mark']; ?> <?php echo $row['Content']; ?></label></p>
                            <?php } ?>
                            <?php } ?>
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

    <?php require $this->_include('left.tpl',__FILE__); ?>
</div>
<?php require $this->_include('footer.tpl',__FILE__); ?>