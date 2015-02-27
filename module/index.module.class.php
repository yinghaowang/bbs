<?php
!defined('MODULE') && exit('REFUSED!');
Class indexModule extends commonModule
{
    public $page;
    public $per = 30;
    public function index()
    {
        $currentCid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;
        $CurrentClubName = Common::getCurrentclubName($this->db, $currentCid);
        $Currentschoolid = Common::getschoolid($this->db, $this->loginInfo['uid']);
        //print_r($Currentschoolid);
        $RequestType = (isset($_GET['type']) && ($_GET['type'] == 'exam' || $_GET['type'] == 'topic')) ? $_GET['type'] : 'topic';
        if ($CurrentClubName == '') {
            header('location:./');
        }
        if ($this->loginInfo['group'] < 8) {
            $condition = " AND `" . PRE . "topic`.`cid` NOT IN(" . $GLOBALS['roc_config']['lock_mod'] . ")";
        } else {
            $condition = '';
        }

        $clubList = Common::getClubList($this->db, $Currentschoolid);
        $topicCount = Common::getTopicCount($this->db, $currentCid, $condition);
        $this->page = new Page($this->per, $topicCount, Common::Currentpage(), 10, '?cid=' . $currentCid . '&type=' . $RequestType . '&page=');
        $topic = array();
        if ($RequestType == 'topic') {
            if ($currentCid == 0) {
                $sql = "SELECT `" . PRE . "topic`.*,`" . PRE . "user`.`nickname` as `nickname`,`" . PRE . "club`.`clubname` as `clubname` FROM `" . PRE . "topic`,`" . PRE . "user`,`" . PRE . "club` WHERE `" . PRE . "topic`.`uid` = `" . PRE . "user`.`uid` AND `" . PRE . "topic`.`schoolid` = '" . $Currentschoolid . "'AND `" . PRE . "topic`.`cid` = `" . PRE . "club`.`cid` " . $condition . " ORDER BY `" . PRE . "topic`.`istop` DESC LIMIT " . (Common::Currentpage() - 1) * $this->per . "," . $this->per;
            } else {
                $sql = "SELECT `" . PRE . "topic`.*,`" . PRE . "user`.`nickname` as `nickname`,`" . PRE . "club`.`clubname` as `clubname` FROM `" . PRE . "topic`,`" . PRE . "user`,`" . PRE . "club` WHERE `" . PRE . "topic`.`uid` = `" . PRE . "user`.`uid` AND `" . PRE . "club`.`schoolid`='" . $Currentschoolid . "' AND `" . PRE . "topic`.`cid` = `" . PRE . "club`.`cid` AND `" . PRE . "topic`.`cid` = " . $currentCid . $condition . " ORDER BY `" . PRE . "topic`.`istop` DESC  LIMIT " . (Common::Currentpage() - 1) * $this->per . "," . $this->per;
            }
        }
        if ($RequestType == 'exam') {
            if ($currentCid == 0) {
                $sql = "select `" . PRE . "exam`.* from `" . PRE . "exam` where `" . PRE . "exam`.`schoolid` = '" . $Currentschoolid . "'LIMIT " . (Common::Currentpage() - 1) * $this->per . "," . $this->per;
            } else {
                $sql = "select `" . PRE . "exam`.* from `" . PRE . "exam`where `" . PRE . "exam`.`schoolid` = '" . $Currentschoolid . "'AND `" . PRE . "exam`.`cid`=" . $currentCid . " LIMIT " . (Common::Currentpage() - 1) * $this->per . "," . $this->per;
            }
        }
        //print_r($sql);
        $QUERY = $this->db->query($sql);
        if($RequestType ==  'topic'){
        while ($rows = $this->db->fetchArray($QUERY)) {
            $topic[] = array(
                'tid' => $rows['tid'],
                'uid' => $rows['uid'],
                'cid' => $rows['cid'],
                'client' => $rows['client'],
                'istop' => $rows['istop'],
                'nickname' => $rows['nickname'],
                'clubname' => $rows['clubname'],
                'comments' => $rows['comments'],
                'message' => Common::text_out($rows['message'], false, false),
                'avatar' => Image::getAvatarURL($rows['uid'], 50),
                'pictures' => Image::getImageURL($rows['pictures']),
                'posttime' => Common::formatTime($rows['posttime']),
                'lasttime' => Common::formatTime($rows['lasttime'])
            );
        }
    }
        if ($RequestType == 'exam') {
            while ($rows = $this->db->fetchArray($QUERY)) {
                $sql = "select `".PRE."user`.* from `".PRE."user` where `".PRE."user`.`uid`=".$rows['uid']."";
                $data = $this->db->query($sql);
                $user = $this->db->fetchArray($data);
                $topic[] = array(
                    'title' =>$rows['Title'],
                    'intro' =>$rows['Intro'],
                    'tid' =>$rows['Id'],//为了和上面一致,其实是测试id,不是tid
                    'cid' =>$rows['cid'],
                    'questions' =>$rows['Questions'],
                    'schoolid' =>$rows['schoolid'],
                    'expiretime' => Common::formatTime($rows['ExpireDtt']),
                    'uid' =>$rows['uid'],
                    'nickname' =>$user['nickname'],
                    'avatar' => Image::getAvatarURL($user['uid'], 50),
                    'lasttime' => Common::formatTime($rows['ExpireDtt'])
                );
            }
        }

        if ($this->loginInfo['uid'] > 0) {
            $this->tpls->assign('whisperNumber', Common::getUnreadWhisperNumber($this->db, $this->loginInfo['uid']));
            $this->tpls->assign('balanceNumber', Common::getUserBalanceNumber($this->db, $this->loginInfo['uid']));
            $this->tpls->assign('notificationNumber', Common::getNotificationNumber($this->db, $this->loginInfo['uid'], '0'));
        }
        $this->tpls->assign('title', '首页');
        $this->tpls->assign('id', $Currentschoolid);
        $this->tpls->assign('topicList', $topic);
        $this->tpls->assign('clubList', $clubList);
        $this->tpls->assign('currentCid', $currentCid);
        $this->tpls->assign('currentPage', Common::Currentpage());
        $this->tpls->assign('RequestType', $RequestType);
        $this->tpls->assign('loginInfo', $this->loginInfo);
        $this->tpls->assign('CurrentClubName', $CurrentClubName);
        $this->tpls->assign('page', $this->page->pageStyle());
        $this->tpls->assign('runtime', Common::runtime());
        $this->tpls->assign('LinksList', json_decode(file_get_contents("./cache/links.json"), true));
        $this->tpls->assign('currentStatus', 'index');
        $this->tpls->display('index');
    }
    public function read()
    {
        $tid       = (isset($_GET['id']) && is_numeric($_GET['id'])) ? intval($_GET['id']) : 0;
        $topicInfo = array(
            'tid' => 0
        );
        $Re        = $this->db->selectOneArray("SELECT  *, `" . PRE . "user`.`nickname` as `nickname` FROM `" . PRE . "user`,`" . PRE . "topic` WHERE `" . PRE . "topic`.`uid` = `" . PRE . "user`.`uid` AND `tid`='" . $tid . "'");
        if (!empty($Re['tid'])) {
            $topicInfo = array(
                'tid' => $Re['tid'],
                'uid' => $Re['uid'],
                'nickname' => $Re['nickname'],
                'cid' => $Re['cid'],
                'istop' => $Re['istop'],
                'client' => $Re['client'],
                'lasttime' => $Re['lasttime'],
                'comments' => $Re['comments'],
                'message' => Common::text_out($Re['message']),
                'avatar' => Image::getAvatarURL($Re['uid'], 50),
                'pictures' => Image::getImageURL($Re['pictures']),
                'posttime' => Common::formatTime($Re['posttime'])
            );
        } else {
            header('location:./');
        }
        if (in_array($topicInfo['cid'], explode(',', $GLOBALS['roc_config']['lock_mod'])) && $this->loginInfo['group'] < 8) {
            header('location:./');
        }
        $commendList  = array();
        $isFavorite   = Common::getFavoriteNumber($this->db, $topicInfo['tid'], $this->loginInfo['uid']);
        $isCommend    = Common::getCommendNumber($this->db, $topicInfo['tid'], $this->loginInfo['uid']);
        $commendTotal = $this->db->selectOne("SELECT COUNT(`uid`) FROM `" . PRE . "commend` WHERE `tid`=" . $topicInfo['tid']);
        if ($commendTotal > 0) {
            $Result = $this->db->query("SELECT `" . PRE . "user`.* FROM `" . PRE . "user`,`" . PRE . "commend` WHERE `" . PRE . "commend`.`uid` = `" . PRE . "user`.`uid` AND `" . PRE . "commend`.`tid` = " . $topicInfo['tid'] . " ORDER BY `" . PRE . "commend`.`cid` DESC LIMIT " . (Common::Currentpage() - 1) * 15 . ", 15");
            while ($Re = $this->db->fetchArray($Result)) {
                $commendList[] = array(
                    'uid' => $Re['uid'],
                    'nickname' => $Re['nickname'],
                    'tid' => $topicInfo['tid'],
                    'avatar' => Image::getAvatarURL($Re['uid'], 50)
                );
            }
        }
        $replyList = array();
        $Total     = $this->db->selectOne("SELECT COUNT(`pid`) FROM `" . PRE . "reply` WHERE `tid`=" . $topicInfo['tid']);
        if ($Total > 0) {
            $Result = $this->db->query("SELECT *, `" . PRE . "user`.`nickname` as `nickname` FROM `" . PRE . "user`,`" . PRE . "reply` WHERE `" . PRE . "reply`.`uid` = `" . PRE . "user`.`uid` AND `" . PRE . "reply`.`tid` = " . $topicInfo['tid'] . " ORDER BY `pid` ASC ");
            while ($Re = $this->db->fetchArray($Result)) {
                $replyList[] = array(
                    'pid' => $Re['pid'],
                    'tid' => $Re['tid'],
                    'uid' => $Re['uid'],
                    'client' => $Re['client'],
                    'nickname' => $Re['nickname'],
                    'message' => Common::text_out($Re['message']),
                    'avatar' => Image::getAvatarURL($Re['uid'], 50),
                    'pictures' => Image::getImageURL($Re['pictures']),
                    'posttime' => Common::formatTime($Re['posttime'])
                );
            }
        }
        if ($topicInfo['tid'] < 1) {
            header('location:./');
        } else {
            if ($this->loginInfo['uid'] > 0) {
                $this->tpls->assign('whisperNumber', Common::getUnreadWhisperNumber($this->db, $this->loginInfo['uid']));
                $this->tpls->assign('balanceNumber', Common::getUserBalanceNumber($this->db, $this->loginInfo['uid']));
                $this->tpls->assign('notificationNumber', Common::getNotificationNumber($this->db, $this->loginInfo['uid'], '0'));
            }
            $clubList               = Common::getClubList($this->db);
            $CurrentClubName        = Common::getCurrentclubName($this->db, $topicInfo['cid']);
            $memberInfo             = Common::getMemberInfo($this->db, is_numeric($topicInfo['uid']) ? 'uid' : 'nickname', $topicInfo['uid']);
            $topicInfo['signature'] = $memberInfo['signature'];
            $this->tpls->assign('title', $topicInfo['nickname'] . '发布的微文');
            $this->tpls->assign('currentStatus', 'index');
            $this->tpls->assign('clubList', $clubList);
            $this->tpls->assign('topicInfo', $topicInfo);
            $this->tpls->assign('replyList', $replyList);
            $this->tpls->assign('isCommend', $isCommend);
            $this->tpls->assign('isFavorite', $isFavorite);
            $this->tpls->assign('commendList', $commendList);
            $this->tpls->assign('commendTotal', $commendTotal);
            $this->tpls->assign('loginInfo', $this->loginInfo);
            $this->tpls->assign('currentCid', $topicInfo['cid']);
            $this->tpls->assign('CurrentClubName', $CurrentClubName);
            $this->tpls->assign('runtime', Common::runtime());
            $this->tpls->display('read');
        }
    }
    public function exam()
    {
        $id = $_REQUEST['id'];
        //print_r( $_POST);
        $Re        = $this->db->selectOneArray("SELECT  *, `" . PRE . "user`.`nickname` as `nickname` FROM `" . PRE . "user`,`" . PRE . "exam` WHERE `" . PRE . "exam`.`uid` = `" . PRE . "user`.`uid` AND `Id`='" . $id . "'");
        if (!empty($Re['Id'])) {
            $topicInfo = array(
                'tid' => $Re['tid'],
                'uid' => $Re['uid'],
                'nickname' => $Re['nickname'],
                'cid' => $Re['cid'],
                'avatar' => Image::getAvatarURL($Re['uid'], 50),
                'posttime' => Common::formatTime($Re['ExpireDtt'])
            );
        } else {
            header('location:./');
        }
        if ($topicInfo['uid'] > 0) {
            $this->tpls->assign('whisperNumber', Common::getUnreadWhisperNumber($this->db, $topicInfo['uid'] ));
            $this->tpls->assign('balanceNumber', Common::getUserBalanceNumber($this->db, $topicInfo['uid'] ));
            $this->tpls->assign('notificationNumber', Common::getNotificationNumber($this->db, $topicInfo['uid'] , '0'));
        }
        $sql  = " select `".PRE."exam`.* from `".PRE."exam` WHERE `".PRE."exam`.`Id`='".$id."'  ORDER BY Id ASC Limit ". (Common::Currentpage() - 1) * $this->per . "," . $this->per;
        $exam = $this->db->selectOneArray($sql);
        $flag = $_REQUEST["flag"] ? $_REQUEST["flag"] : "view";//选择要进入的模块
        if($flag=='view')
        {
            $this->tpls->assign("exam", $exam);
            $this->tpls->assign("topicInfo", $topicInfo);
            $this->tpls->assign('loginInfo', $this->loginInfo);
            $this->tpls->display('view');
        }
        if($flag=='next')
        {
            $mark = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
            $eqnum = $_REQUEST["eqnum"] ? intval($_REQUEST["eqnum"]) : 0;
            $examQuestion = $this->db->selectOneArray("select `".PRE."question`.* from `".PRE."Question` where EId='".$id."' ORDER BY SortId asc,Id asc limit ".$eqnum.",1");//每次取该题库下的一个问题
            if($examQuestion['Id'])
            {
                //问题选项
                $sSql = "select `".PRE."option`.* from `".PRE."Option` where EQId='".$examQuestion['Id']."' and EId='".$id."' ORDER BY SortId asc,Id asc limit 26";
                $examQuestionOption = $this->db->selectAll($sSql);
                if(is_array($examQuestionOption) && !empty($examQuestionOption)) foreach($examQuestionOption as $k=>$v)
                {
                    $examQuestionOption[$k]['Mark'] = $mark[$k];
                    if($v['IsRight']) $examQuestion['RightOption'] .= $mark[$k];
                }
            }
            if($_REQUEST["judge"])
            {
                $JudgeResult = '你的答案是 ';
                $myresult = ($eqnum+1).'、问：'.$examQuestion['Title'].'<br/>答：';
                if(is_array($_POST["option"]) && !empty($_POST["option"])) foreach($_POST["option"] as $v)
                {
                    $JudgeResult .= $examQuestionOption[$v]['Mark'];
                    $isscore .= $examQuestionOption[$v]['Mark'];
                    $myresult .= $examQuestionOption[$v]['Mark'].'、'.$examQuestionOption[$v]['Content'].'&nbsp;&nbsp;';
                }
                $JudgeResult .= ' 正确答案是 '.$examQuestion['RightOption'];
                $myresult .= '<br/>';
                $TestLog = array('Id'=>intval($_POST['tid']), 'Dtt'=>intval($_POST['tdtt']));
                //第一次测试时 插入一行测试记录
                if($eqnum==0)
                {
                    $TestLog = array();
                    $fieldList = array();
                    $fieldList["Dtt"]			= $TestLog['Dtt'] = time();
                    $fieldList["EId"]			= $exam['Id'];
                    $fieldList["Result"]		= '';
                    $fieldList["score"]        =0;
                    $fieldList["UID"]          = $topicInfo['uid'];
                    $this->db->query( $this->db->insert("`". PRE ."testlog`", $fieldList));
                }
                $TestLog = $this->db->selectOneArray("SELECT `". PRE ."testlog`.* from `".PRE."testlog` WHERE 1 ORDER BY `". PRE ."testlog`.Dtt DESC");//取出该条记录
                //记录测试结果
                if($TestLog['Id']>0 && $TestLog['Dtt']>0)
                {
                    $thisre = $TestLog['Result'].addslashes($myresult);
                    if($isscore == $examQuestion['RightOption'])
                    {
                        $TestLog['score'] = $TestLog['score']+1;
                    }
                    $this->db->query("update `".PRE."testLog` set `Result`='".$thisre."',score='".$TestLog['score']."' where Id='".$TestLog['Id']."' and Dtt='".$TestLog['Dtt']."' and EId='".$exam['Id']."' limit 1");
                }
                die ('{"result":"success", "message":"","ISShowReason":"' . $exam['ISShowReason'] . '","tid":"' . $TestLog['Id'] . '","tdtt":"' . $TestLog['Dtt'] . '","JudgeResult":"' . $JudgeResult . '","OptionReason":"' . $examQuestion['OptionReason'] . '"}');

            }
            else
            {
                $TestLog = array('Id'=>intval($_GET['tid']), 'Dtt'=>intval($_GET['tdtt']));
                if($examQuestion['Id'])
                {
                    $this->tpls->assign('eqnum',$eqnum);
                    $this->tpls->assign("exam", $exam);
                    $this->tpls->assign('examQuestion',$examQuestion);
                    $this->tpls->assign('examQuestionOption',$examQuestionOption);
                    $this->tpls->assign('TestLog',$TestLog);
                    $this->tpls->assign("topicInfo", $topicInfo);
                    $this->tpls->assign('loginInfo', $this->loginInfo);
                    $this->tpls->display('answer');
                    exit();
                 }
                else
                {
                    $TestLog = $this->db->selectOneArray("SELECT `". PRE ."testlog`.* from `".PRE."testlog` WHERE uid='".$topicInfo['uid']."' ORDER BY `". PRE ."testlog`.Dtt DESC");//取出该条记录
                    header("Location:index.php?w=showresult&UID=".$topicInfo['uid']."&id=".$id."&type=showresult&logid=". $TestLog['Id']);	exit();//测试结束跳转
                }
            }
        }
    }
    public function showresult()
    {
        $id = $_REQUEST['uid'];
        $logid = $_REQUEST['logid'];
        $examid = $_REQUEST[id];
        $sql  = " select `".PRE."exam`.* from `".PRE."exam` WHERE `".PRE."exam`.`Id`='".$examid."'  ORDER BY Id ASC Limit 1";
        $exam = $this->db->selectOneArray($sql);
        $Re = $this->db->selectOneArray("SELECT `".PRE."user`.* FROM `". PRE ."user` WHERE `uid`='".$id."' limit 1");
        if (!empty($Re['uid'])) {
            $topicInfo = array(
                'tid' => $Re['tid'],
                'uid' => $Re['uid'],
                'nickname' => $Re['nickname'],
                'cid' => $Re['cid'],
                'avatar' => Image::getAvatarURL($Re['uid'], 50),
                'posttime' => Common::formatTime($Re['ExpireDtt'])
            );
            $this->tpls->assign('whisperNumber', Common::getUnreadWhisperNumber($this->db, $Re['uid'] ));
            $this->tpls->assign('balanceNumber', Common::getUserBalanceNumber($this->db, $Re['uid'] ));
            $this->tpls->assign('notificationNumber', Common::getNotificationNumber($this->db, $Re['uid'] , '0'));
        }
        $Result = $this->db->selectOneArray("SELECT * from `".PRE."testlog` where Id='".$logid."'");
        $Result['Dtt'] = date("Y-m-d H:i:s",$Result['Dtt']);
        $Result['score'] = round(($Result['score']/$exam['Questions'])*100 ,2);
        $this->tpls->assign('Result',$Result);
        $this->tpls->assign('loginInfo', $this->loginInfo);
        $this->tpls->assign("exam", $exam);
        $this->tpls->assign("topicInfo", $topicInfo);
        $this->tpls->display('result');
        exit();
    }
    public function search()
    {
        $searchWord      = isset($_GET['s']) ? Common::text_in($_GET['s']) : '';
        if( strlen($searchWord) < "2" ||  mb_strlen($searchWord,"utf-8") > "15" ) {
            header("location:./");
        }
        if ($this->loginInfo['group'] < 8) {
            $condition = " AND `" . PRE . "topic`.`cid` NOT IN(" . $GLOBALS['roc_config']['lock_mod'] . ")";
        } else {
            $condition = '';
        }
        $clubList   = Common::getClubList($this->db);
        $topicCount = $this->db->selectOne("SELECT COUNT(`tid`) FROM `" . PRE . "topic` WHERE  POSITION('".$searchWord."' IN `" . PRE . "topic`.`message`)" . $condition);

        $this->page = new Page($this->per, $topicCount, Common::Currentpage(), 10, './?w=search&s=' . $searchWord .'&page=' );
        $topic      = array();
        $sql = "SELECT `" . PRE . "topic`.*,`" . PRE . "user`.`nickname` as `nickname`,`" . PRE . "club`.`clubname` as `clubname` FROM `" . PRE . "topic`,`" . PRE . "user`,`" . PRE . "club` WHERE  POSITION('".$searchWord."' IN `" . PRE . "topic`.`message`) AND `" . PRE . "topic`.`uid` = `" . PRE . "user`.`uid` AND `" . PRE . "topic`.`cid` = `" . PRE . "club`.`cid` " . $condition . " ORDER BY `" . PRE . "topic`.`istop` DESC LIMIT " . (Common::Currentpage() - 1) * $this->per . "," . $this->per;
        $QUERY = $this->db->query($sql);
        while ($rows = $this->db->fetchArray($QUERY)) {
            $topic[] = array(
                'tid'       => $rows['tid'],
                'uid'       => $rows['uid'],
                'cid'       => $rows['cid'],
                'client'    => $rows['client'],
                'istop'     => $rows['istop'],
                'nickname'  => $rows['nickname'],
                'clubname'  => $rows['clubname'],
                'comments'  => $rows['comments'],
                'message'   => Common::text_out($rows['message'], false,false),
                'avatar'    => Image::getAvatarURL($rows['uid'], 50),
                'pictures'  => Image::getImageURL($rows['pictures']),
                'posttime'  => Common::formatTime($rows['posttime']),
                'lasttime'  => Common::formatTime($rows['lasttime'])
            );
        }
        $this->tpls->assign('title', '搜索');
        $this->tpls->assign('topicList', $topic);
        $this->tpls->assign('searchWord', $searchWord);
        $this->tpls->assign('currentPage', Common::Currentpage());
        $this->tpls->assign('RequestType', $RequestType);
        $this->tpls->assign('loginInfo', $this->loginInfo);
        $this->tpls->assign('page', $this->page->pageStyle());
        $this->tpls->assign('runtime', Common::runtime());
        $this->tpls->assign('currentStatus', 'index');
        $this->tpls->display('search');
    }
    public function getTopicFullContent()
    {
        $tid = (isset($_POST['id']) && is_numeric($_POST['id'])) ? intval($_POST['id']) : 0;
        if($this->loginInfo['group'] >= 8) {
            $Re  = $this->db->selectOneArray("SELECT  * FROM `" . PRE . "topic` WHERE `tid`='" . $tid . "'");
        } else {
            $Re  = $this->db->selectOneArray("SELECT  * FROM `" . PRE . "topic` WHERE `tid`='" . $tid . "' AND `uid`='".$this->loginInfo['uid']."'");
        }
        if (!empty($Re['tid'])) {
            $topicInfo = array(
                'message' => str_replace('[p]', '\n', $Re['message'])
            );
            die('{"result":"success","message":"'.$topicInfo['message'].'"}');
        } else {
            die('{"result":"error","message":"非法请求，您无法编辑此帖子"}');
        }
    }
    public function createNewTopic()
    {
        $this->checkPrivate(TRUE);
        $Currentschoolid = Common::getschoolid($this->db, $this->loginInfo['uid']);
        if (isset($_POST['cid'], $_POST['msg'])) {
            $postArray = array(
                "uid" => $this->loginInfo['uid'],
                "cid" => intval($_POST['cid']),
                "pictures" => Common::text_in($_POST['pictures']),
                "message" => Common::text_in($_POST['msg']),
                "client" => Common::getClient(),
                "posttime" => time(),
                "lasttime" => time(),
                "schoolid" => $Currentschoolid,
            );
            if(isset($_POST['tempTid']) && Common::getTopicTid($this->db, intval($_POST['tempTid'])) > 0) {
                $updateArray = array(
                    'cid'       => $postArray['cid'],
                    'message'   => $postArray['message']." [p][ ".date('Y年n月j日 H:i:s', $postArray['posttime'])."最后修改 ]"
                );
                $this->db->query($this->db->update("`". PRE ."topic`", $updateArray, "`tid`=" . intval($_POST['tempTid'])));
                die('{"result":"success","message":"帖子修改成功"}');
            }

            if( Common::checkClubCid($this->db, $postArray['cid']) == 0 ) {
                die('{"result":"error","message":"您尚未选择分类"}');
            }
            if( $postArray['message'] == '') {
                die('{"result":"error","message":"内容不能为空"}');
            }
            if( $postArray['posttime'] - Common::getUserLasttime($this->db, $this->loginInfo['uid']) < 30 ) {
                die('{"result":"error","message":"防水策略生效中，您发的太快了"}');
            }
            $this->db->query($this->db->insert("`". PRE ."topic`", $postArray));
            $postResult = $this->db->lastInsertId();
            if (isset($postResult) && $postResult > 0) {
                setcookie("tmp_picture", "", 0, "/");
                Common::updateUserMoney($this->db, $this->loginInfo['uid'], $GLOBALS['balance_config']['change']['topic'], 3);
                Common::updateLogintime($this->db, $this->loginInfo['uid']);
                die('{"result":"success","message":"发布成功，正在刷新..."}');
            } else {
                die('{"result":"error","message":"发布失败"}');
            }
        } else {
            echo '{"result":"error","message":"发布失败"}';
        }
    }
    public function createNewReply()
    {
        $this->checkPrivate(TRUE);
        if (isset($_POST['tid'], $_POST['msg']) && is_numeric($_POST['tid'])) {
            $postArray = array(
                "tid" => intval($_POST['tid']),
                "uid" => $this->loginInfo['uid'],
                "message" => Common::text_in($_POST['msg']),
                "pictures" => Common::text_in($_POST['pictures']),
                "client" => Common::getClient(),
                "posttime" => time()
            );
        }
        if( Common::getTopicTid($this->db, $postArray['tid']) == 0 ) {
            die('{"result":"error","message":"不存在此主题"}');
        }
        if( $postArray['message'] == '') {
            die('{"result":"error","message":"内容不能为空"}');
        }
        if( $postArray['posttime'] - Common::getUserLasttime($this->db, $this->loginInfo['uid']) < 15 ) {
            die('{"result":"error","message":"防水策略生效中，您回复的太快了"}');
        }
        $this->db->query($this->db->insert("`". PRE ."reply`", $postArray));
        $postResult = $this->db->lastInsertId();
        if (isset($postResult) && $postResult > 0) {
            $updateArray = array(
                'comments' => array(
                    "`comments`+1"
                ),
                'lasttime' => $postArray['posttime']
            );
            $this->db->query($this->db->update("`". PRE ."topic`", $updateArray, "`tid`=" . $postArray['tid']));
            $array = array(
                'tid' => $postArray['tid'],
                'pid' => $postResult,
                'uid' => $postArray['uid'],
                'nickname' => $this->loginInfo['nickname'],
                'message' => $postArray['message']
            );
            $this->writeNotification($this->db, $array);
            setcookie("tmp_picture", "", 0, "/");
            Common::updateUserMoney($this->db, $this->loginInfo['uid'], $GLOBALS['balance_config']['change']['reply'], 4);
            Common::updateLogintime($this->db, $this->loginInfo['uid']);
            die('{"result":"success","message":"回复成功","pid":"' . $postResult . '"}');
        } else {
            die('{"result":"error","message":"回复失败"}');
        }
    }
    public function delTmpPicture()
    {
        $this->checkPrivate(TRUE);
        if (file_exists($_POST['path'])) {
            $check_access = json_decode(Secret::decrypt($_COOKIE['tmp_picture'], $GLOBALS['roc_config']['secure_key']), true);
            if (in_array($_POST['path'], $check_access)) {
                Common::deletePicture($_POST['path']);
                die('{"result":"success","message":"删除成功"}');
            } else {
                die('{"result":"error","message":"请求被拒绝，您没有权限或者授权超时"}');
            }
        } else {
            die('{"result":"error","message":"请求被拒绝，文件不存在"}');
        }
    }
    public function doCommend()
    {
        $this->checkPrivate();
        if (isset($_POST['tid']) && is_numeric($_POST['tid'])) {
            $postArray = array(
                'tid' => intval($_POST['tid']),
                'uid' => $this->loginInfo['uid']
            );
            if (Common::getTopicTid($this->db, $postArray['tid']) == 0) {
                die('{"result":"error","message":"不存在此微文"}');
            }
            if (Common::getCommendNumber($this->db, $postArray['tid'], $postArray['uid']) > 0) {
                $postResult = $this->db->affectedRows("DELETE FROM `" . PRE . "commend` WHERE `uid`='" . $postArray['uid'] . "' AND `tid`='" . $postArray['tid'] . "'");
                if ($postResult > 0) {
                    Common::updateUserMoney($this->db, Common::getTopicUid($this->db, $postArray['tid']), - $GLOBALS['balance_config']['change']['commend'], 9);
                    die('{"result":"success"}');
                } else {
                    die('{"result":"error","message":"取消赞失败"}');
                }
            } else {
                $postResult = $this->db->affectedRows($this->db->insert("`" . PRE . "commend`", $postArray));
                if ($postResult > 0) {
                    Common::updateUserMoney($this->db, Common::getTopicUid($this->db, $postArray['tid']), $GLOBALS['balance_config']['change']['commend'], 8);
                    die('{"result":"success"}');
                } else {
                    die('{"result":"error","message":"赞失败"}');
                }
            }
        }
    }
    public function doFavorite()
    {
        $this->checkPrivate();
        if (isset($_POST['tid']) && is_numeric($_POST['tid'])) {
            $postArray = array(
                'tid' => intval($_POST['tid']),
                'fuid' => $this->loginInfo['uid']
            );
            if (Common::getTopicTid($this->db, $postArray['tid']) == 0) {
                die('{"result":"error","message":"不存在此微文"}');
            }
            $isFavorite = Common::getFavoriteNumber($this->db, $postArray['tid'], $postArray['fuid']);
            if ($isFavorite > 0) {
                $postResult = $this->db->affectedRows("DELETE FROM `" . PRE . "favorite` WHERE `tid`='" . $postArray['tid'] . "' AND `fuid`='" . $postArray['fuid'] . "'");
                if ($postResult > 0) {
                    die('{"result":"success","message":"删除收藏成功"}');
                } else {
                    die('{"result":"error","message":"删除收藏失败"}');
                }
            } else {
                $postResult = $this->db->affectedRows($this->db->insert("`" . PRE . "favorite`", $postArray));
                if ($postResult > 0) {
                    die('{"result":"success","message":"收藏成功"}');
                } else {
                    die('{"result":"error","message":"收藏失败"}');
                }
            }
        }
    }
    private function writeNotification($DB, $array)
    {
        preg_match_all("@\@(.*?)([\s]+)@is", $array['message'] . " ", $nameArray);
        $topicNickname = $DB->selectOne("SELECT `a`.`nickname` FROM `" . PRE . "user` `a`, `" . PRE . "topic` `b` WHERE `b`.`tid`='" . $array['tid'] . "' AND `a`.`uid` = `b`.`uid`");
        if (!in_array($topicNickname, $nameArray[1]) && $topicNickname != $array['nickname']) {
            array_push($nameArray[1], $topicNickname);
        }
        if (isset($nameArray[1])) {
            $writeName = array(
                strtolower($array['nickname'])
            );
            foreach (array_unique($nameArray[1]) as $nickname) {
                if (in_array(strtolower($nickname), $writeName)) {
                    continue;
                }
                array_push($writeName, strtolower($nickname));
                $atUid = $DB->selectOne("SELECT `uid` FROM `" . PRE . "user` WHERE `nickname`='" . $nickname . "'");
                if (!empty($atUid)) {
                    $notificationArray = array(
                        'atuid' => $atUid,
                        'uid' => $array['uid'],
                        'tid' => $array['tid'],
                        'pid' => $array['pid']
                    );
                    $DB->query($DB->insert("`". PRE ."notification`", $notificationArray));
                }
            }
        }
    }
    private function checkPrivate($status = '')
    {
        if ($this->loginInfo['nickname'] == '') {
            die('{"result":"error","message":"您尚未登录，无权执行此操作"}');
        }
        $userInfo = Common::getMemberInfo($this->db, 'uid', $this->loginInfo['uid']);
        if ($status == TRUE && $userInfo['groupid'] == 0) {
            die('{"result":"error","message":"您当前被禁言了，请联系管理员"}');
        }
    }
}
?>