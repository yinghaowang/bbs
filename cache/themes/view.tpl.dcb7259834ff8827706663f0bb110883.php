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
                            <a href="index.php?w=exam&id=<?php echo $exam['Id']; ?>&flag=next" class="btn btn-green btn-big mt20">开始答题</a>
                        </div>

                    </div>
                </div>

            </li>
        </ul>
    </div>

    <?php require $this->_include('left.tpl',__FILE__); ?>
</div>
<?php require $this->_include('footer.tpl',__FILE__); ?>