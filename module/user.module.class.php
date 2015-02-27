<?php
!defined('MODULE') && exit('REFUSED!');
Class userModule extends commonModule
{
    public $page;
    public $per = 30;
    public function index()
    {
        $RequestType = (isset($_GET['type']) && ($_GET['type'] == 'reply' || $_GET['type'] == 'follow' || $_GET['type'] == 'fans' || $_GET['type'] == 'favorite' || $_GET['type'] == 'balance')) ? $_GET['type'] : 'topic';
        $userId      = (isset($_GET['id']) && trim($_GET['id']) != '') ? $_GET['id'] : $this->loginInfo['uid'];
        $userInfo    = Common::getMemberInfo($this->db, is_numeric($userId) ? 'uid' : 'nickname', $userId);
        $isFollow    = Common::getEsFollowNumber($this->db, $this->loginInfo['uid'], $userInfo['uid']);
        if ($userInfo['uid'] > 0) {
            $postList   = array();
            $followList = array();
            switch ($RequestType) {
                case 'reply':
                    $Total = $this->db->selectOne("SELECT COUNT(`pid`) FROM `" . PRE . "reply` WHERE `uid`=" . $userInfo['uid']);
                    if ($Total > 0) {
                        $Result = $this->db->query("SELECT `" . PRE . "reply`.*, `" . PRE . "user`.`nickname` as `nickname` FROM `" . PRE . "user`,`" . PRE . "reply` WHERE `" . PRE . "reply`.`uid` = `" . PRE . "user`.`uid` AND `" . PRE . "reply`.`uid` = " . $userInfo['uid'] . " ORDER BY `pid` DESC LIMIT " . (Common::Currentpage() - 1) * $this->per . "," . $this->per);
                        while ($Re = $this->db->fetchArray($Result)) {
                            if ($this->loginInfo['group'] < 8) {
                                if (in_array($this->db->selectOne("SELECT `cid` FROM `" . PRE . "topic` WHERE `tid`='" . $Re['tid'] . "'"), explode(',', $GLOBALS['roc_config']['lock_mod']))) {
                                    continue;
                                }
                            }
                            $postList[] = array(
                                'pid' => $Re['pid'],
                                'tid' => $Re['tid'],
                                'uid' => $Re['uid'],
                                'nickname' => $Re['nickname'],
                                'message' => Common::text_out($Re['message'], false),
                                'pictures' => Image::getImageURL($Re['pictures']),
                                'avatar' => Image::getAvatarURL($Re['uid']),
                                'posttime' => Common::formatTime($Re['posttime']),
                                'client' => $Re['client']
                            );
                        }
                    }
                    break;
                case 'favorite':
                    $Total    = Common::getUserFavoriteNumber($this->db, $userInfo['uid']);
                    $postList = Common::getUserFavorite($this->db, $this->loginInfo['uid'], Common::Currentpage(), 30);
                    break;
                case 'balance':
                    $Total    = Common::getUserBalanceNumber($this->db, $this->loginInfo['uid'], 'count');
                    $postList = Common::getUserBalance($this->db, $this->loginInfo['uid'], Common::Currentpage(), 30);
                    break;
                case 'follow':
                    $Total      = Common::getUserFollowNumber($this->db, $userInfo['uid']);
                    $followList = Common::getUserFollow($this->db, $userInfo['uid'], Common::Currentpage(), 30);
                    break;
                case 'fans':
                    $Total      = Common::getUserFansNumber($this->db, $userInfo['uid']);
                    $followList = Common::getUserFollow($this->db, $userInfo['uid'], Common::Currentpage(), 30, 'fans');
                    break;
                default:
                    if ($this->loginInfo['group'] < 8) {
                        $whereSQL = "WHERE `" . PRE . "topic`.`uid` = " . $userInfo['uid'] . " AND `cid` NOT IN (" . $GLOBALS['roc_config']['lock_mod'] . ")";
                    } else {
                        $whereSQL = "WHERE `" . PRE . "topic`.`uid` = " . $userInfo['uid'];
                    }
                    $Total = $this->db->selectOne("SELECT COUNT(`tid`) FROM `" . PRE . "topic` " . $whereSQL);
                    if ($Total > 0) {
                        $Result = $this->db->query("SELECT *, `" . PRE . "user`.`nickname` as `nickname` FROM `" . PRE . "topic` ,`" . PRE . "user` " . $whereSQL . " AND `" . PRE . "topic`.`uid` = `" . PRE . "user`.`uid` ORDER BY `" . PRE . "topic`.`lasttime` DESC LIMIT " . (Common::Currentpage() - 1) * $this->per . "," . $this->per);
                        while ($Re = $this->db->fetchArray($Result)) {
                            $postList[] = array(
                                'pid' => '',
                                'tid' => $Re['tid'],
                                'uid' => $Re['uid'],
                                'cid' => $Re['cid'],
                                'client' => $Re['client'],
                                'nickname' => $Re['nickname'],
                                'comments' => $Re['comments'],
                                'avatar' => Image::getAvatarURL($Re['uid']),
                                'message' => Common::text_out($Re['message'], false),
                                'pictures' => Image::getImageURL($Re['pictures']),
                                'posttime' => Common::formatTime($Re['posttime']),
                                'lasttime' => Common::formatTime($Re['lasttime'])
                            );
                        }
                    }
                    break;
            }
            $this->page = new Page($this->per, $Total, Common::Currentpage(), 10, '?m=user&id=' . $userId . '&type=' . $RequestType . '&page=');
            $this->tpls->assign('title', '会员中心');
            $this->tpls->assign('loginInfo', $this->loginInfo);
            $this->tpls->assign('userInfo', $userInfo);
            $this->tpls->assign('isFollow', $isFollow);
            $this->tpls->assign('postList', $postList);
            $this->tpls->assign('followList', $followList);
            $this->tpls->assign('RequestType', $RequestType);
            $this->tpls->assign('page', $this->page->pageStyle());
            $this->tpls->assign('runtime', Common::runtime());
            $this->tpls->assign('currentStatus', 'user');
            $this->tpls->display('user');
        } else {
            header('location:./');
        }
    }
    public function notification()
    {
        $this->checkPrivate();
        $notifyStatus     = (isset($_GET['status']) && ($_GET['status'] == '0' || $_GET['status'] == '1')) ? intval($_GET['status']) : '0';
        $userInfo         = Common::getMemberInfo($this->db, 'uid', $this->loginInfo['uid']);
        $notificationList = array();
        $Total            = Common::getNotificationNumber($this->db, $this->loginInfo['uid'], $notifyStatus);
        if ($Total > 0) {
            if ($notifyStatus == "1") {
                $where = "";
            } else {
                $where = " AND `isread` = '0'";
            }
            $Result = $this->db->query("SELECT `a`.*, `b`.`nickname` as `nickname`, `c`.* FROM `" . PRE . "notification` `a`,`" . PRE . "user` `b`, `" . PRE . "reply` `c` WHERE `a`.`uid` = `b`.`uid` AND `a`.`atuid`=" . $this->loginInfo['uid'] . " AND `a`.`pid` = `c`.`pid`" . $where . " ORDER BY `nid` DESC LIMIT " . (Common::Currentpage() - 1) * $this->per . "," . $this->per);
            while ($Re = $this->db->fetchArray($Result)) {
                $notificationList[] = array(
                    'nid' => $Re['nid'],
                    'uid' => $Re['uid'],
                    'tid' => $Re['tid'],
                    'pid' => $Re['pid'],
                    'atuid' => $Re['atuid'],
                    'isread' => $Re['isread'],
                    'nickname' => $Re['nickname'],
                    'avatar' => Image::getAvatarURL($Re['uid']),
                    'message' => Common::text_out($Re['message']),
                    'posttime' => Common::formatTime($Re['posttime'])
                );
                if ($Re['isread'] == 0) {
                    $this->db->query("UPDATE `" . PRE . "notification` SET `isread`=1 WHERE `nid`=" . $Re['nid']);
                }
            }
        }
        $this->page = new Page($this->per, $Total, Common::Currentpage(), 10, '?m=user&w=notification&status=' . $notifyStatus . '&page=');
        $this->tpls->assign('title', '我的提醒');
        $this->tpls->assign('currentStatus', 'notification');
        $this->tpls->assign('userInfo', $userInfo);
        $this->tpls->assign('loginInfo', $this->loginInfo);
        $this->tpls->assign('notifyStatus', $notifyStatus);
        $this->tpls->assign('notificationList', $notificationList);
        $this->tpls->assign('page', $this->page->pageStyle());
        $this->tpls->assign('runtime', Common::runtime());
        $this->tpls->display('notification');
    }
    public function whisper()
    {
        $this->checkPrivate();
        $whisperStatus = (isset($_GET['status']) && ($_GET['status'] == '0' || $_GET['status'] == '1' || $_GET['status'] == '2')) ? intval($_GET['status']) : '0';
        if ($whisperStatus == "2") {
            $Total = $this->db->selectOne("SELECT COUNT(`wid`) FROM `" . PRE . "whisper` WHERE `uid`='" . $this->loginInfo['uid'] . "' AND `del_flag` <>" . $this->loginInfo['uid']);
        } else {
            if ($whisperStatus == "1") {
                $where = " IN(0,1)";
            } else {
                $where = " = '0'";
            }
            $Total = $this->db->selectOne("SELECT COUNT(`wid`) FROM `" . PRE . "whisper` WHERE `atuid`=" . $this->loginInfo['uid'] . " AND `isread` " . $where . " AND `del_flag` <>" . $this->loginInfo['uid']);
        }
        $whisperList = array();
        if ($Total > 0) {
            if ($whisperStatus == "2") {
                $Result = $this->db->query("SELECT `a`.*, `b`.`nickname` as `nickname`, `c`.`nickname` as `atnickname` FROM `" . PRE . "whisper` `a`, `" . PRE . "user` `b`, `" . PRE . "user` `c` WHERE `a`.`uid` = `b`.`uid` AND `a`.`atuid` = `c`.`uid` AND `a`.`uid` = " . $this->loginInfo['uid'] . " AND `a`.`del_flag` <> '" . $this->loginInfo['uid'] . "' ORDER BY `a`.`wid` DESC LIMIT " . (Common::Currentpage() - 1) * $this->per . "," . $this->per);
            } else {
                $Result = $this->db->query("SELECT `a`.*, `b`.`nickname` as `nickname`, `c`.`nickname` as `atnickname` FROM `" . PRE . "whisper` `a`, `" . PRE . "user` `b`, `" . PRE . "user` `c` WHERE `a`.`uid` = `b`.`uid` AND `a`.`atuid` = `c`.`uid` AND `a`.`isread` " . $where . " AND `a`.`atuid` = " . $this->loginInfo['uid'] . " AND `a`.`del_flag` <> '" . $this->loginInfo['uid'] . "' ORDER BY `a`.`wid` DESC LIMIT " . (Common::Currentpage() - 1) * $this->per . "," . $this->per);
            }
            while ($Re = $this->db->fetchArray($Result)) {
                $whisperList[] = array(
                    'wid' => $Re['wid'],
                    'uid' => $Re['uid'],
                    'atuid' => $Re['atuid'],
                    'isread' => $Re['isread'],
                    'nickname' => $Re['nickname'],
                    'atnickname' => $Re['atnickname'],
                    'message' => Common::text_out($Re['message']),
                    'avatar' => Image::getAvatarURL($Re['uid']),
                    'atavatar' => Image::getAvatarURL($Re['atuid']),
                    'posttime' => Common::formatTime($Re['posttime'])
                );
                if ($Re['isread'] == 0 && ($Re['atuid'] == $this->loginInfo['uid'])) {
                    $this->db->query("UPDATE `" . PRE . "whisper` SET `isread`=1 WHERE `wid`=" . $Re['wid']);
                }
            }
        }
        $this->page = new Page($this->per, $Total, Common::Currentpage(), 10, '?m=user&w=whisper&status=' . $whisperStatus . '&page=');
        $this->tpls->assign('title', '我的私信');
        $this->tpls->assign('currentStatus', 'whisper');
        $this->tpls->assign('whisperList', $whisperList);
        $this->tpls->assign('loginInfo', $this->loginInfo);
        $this->tpls->assign('whisperStatus', $whisperStatus);
        $this->tpls->assign('page', $this->page->pageStyle());
        $this->tpls->assign('runtime', Common::runtime());
        $this->tpls->display('whisper');
    }
    public function deliverWhisper()
    {
        $this->checkPrivate();
        if (isset($_POST['tid'], $_POST['msg'])) {
            $postArray = array(
                'atuid' => intval($_POST['tid']),
                'uid' => $this->loginInfo['uid'],
                'message' => Common::text_in($_POST['msg']),
                'posttime' => time(),
                'isread' => 0
            );
            if ($postArray['uid'] == $postArray['atuid']) {
                die('{"result":"error","message":"非法请求，不能@自己"}');
            }
            if (empty($postArray["message"]) || strlen($postArray["message"]) > 255) {
                die('{"result":"error","message":"内容长度不合法"}');
            }
            $userInfo = Common::getMemberInfo($this->db, 'uid', $postArray['atuid']);
            if ($userInfo['uid'] < 1) {
                die('{"result":"error","message":"请求被拒绝，不存在此会员"}');
            } else if ( Common::getUserBalanceNumber($this->db, $this->loginInfo['uid']) < $GLOBALS['roc_config']['balance']['whisper_money']) {
                die('{"result":"error","message":"您的金币不足！"}');
            } else {
                $this->db->query($this->db->insert("`" . PRE . "whisper`", $postArray));
                $postResult = $this->db->lastInsertId();
                if ($postResult > 0) {
                    Common::updateUserMoney($this->db, $this->loginInfo['uid'], $GLOBALS['balance_config']['change']['whisper'], 7);
                    echo '{"result":"success","message":"传送成功"}';
                } else {
                    echo '{"result":"error","message":"传送失败"}';
                }
            }
        }
    }
    public function doFollow()
    {
        $this->checkPrivate();
        if (isset($_POST['uid']) && is_numeric($_POST['uid'])) {
            $postArray = array(
                'fuid' => intval($_POST['uid']),
                'uid' => $this->loginInfo['uid']
            );
            if ($postArray['uid'] == $postArray['fuid']) {
                die('{"result":"error","message":"非法请求，不能关注自己"}');
            }
            $userInfo = Common::getMemberInfo($this->db, 'uid', $postArray['fuid']);
            if ($userInfo['uid'] < 1) {
                die('{"result":"error","message":"请求被拒绝，不存在此会员"}');
            }
            if (Common::getEsFollowNumber($this->db, $postArray['uid'], $postArray['fuid']) > 0) {
                $postResult = $this->db->affectedRows("DELETE FROM `" . PRE . "follow` WHERE `uid`='" . $postArray['uid'] . "' AND `fuid`='" . $postArray['fuid'] . "'");
                if ($postResult > 0) {
                    die('{"result":"success","message":"取消关注成功","text":"关注"}');
                } else {
                    die('{"result":"error","message":"取消关注失败"}');
                }
            } else {
                $postResult = $this->db->affectedRows($this->db->insert("`" . PRE . "follow`", $postArray));
                if ($postResult > 0) {
                    die('{"result":"success","message":"关注成功","text":"取消关注"}');
                } else {
                    die('{"result":"error","message":"关注失败"}');
                }
            }
        }
    }
    private function checkPrivate()
    {
        if ($this->loginInfo['nickname'] == '') {
            die('{"result":"error","message":"您尚未登录，无权执行此操作"}');
        }
    }
}