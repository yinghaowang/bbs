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
                        <span class="time">测试时间：<!--{$Result['Dtt']}--></span>
                        <div class="topic-content">
                            <p class="mt20">名称：<!--{$exam['Title']}--></p>
                            <p class="mt20">描述：<!--{$exam['Intro']}--></p>
                            <p><!--{$Result['Result']}--></p>
                            <p>得分率：<!--{$Result['score']}-->%</p>
                        </div>

                    </div>
                </div>

            </li>
        </ul>
    </div>

    <!--{include left.tpl}-->
</div>
<!--{include footer.tpl}-->