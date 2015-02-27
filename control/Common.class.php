<?php
Class Common
{
    public static function getMemberCount($DB)
    {
        return $DB->selectOne("SELECT COUNT(`uid`) FROM `" . PRE . "user`");
    }
    public static function getUserFavoriteNumber($DB, $fuid)
    {
        return $DB->selectOne("SELECT COUNT(`fid`) FROM `" . PRE . "favorite` WHERE `fuid`=" . $fuid);
    }
    public static function getFavoriteNumber($DB, $tid, $fuid)
    {
        return $DB->selectOne("SELECT COUNT(`fid`) FROM `" . PRE . "favorite` WHERE `fuid`= '" . $fuid . "' AND `tid`='" . $tid . "'");
    }
    public static function getEsFollowNumber($DB, $uid, $fuid)
    {
        return $DB->selectOne("SELECT COUNT(`uid`) FROM `" . PRE . "follow` WHERE `uid`='" . $uid . "' AND `fuid`='" . $fuid . "'");
    }
    public static function getCommendNumber($DB, $tid, $uid)
    {
        return $DB->selectOne("SELECT COUNT(`uid`) FROM `" . PRE . "commend` WHERE `uid`='" . $uid . "' AND `tid`='" . $tid . "'");
    }
    public static function getUserFollowNumber($DB, $uid)
    {
        return $DB->selectOne("SELECT COUNT(`uid`) FROM `" . PRE . "follow` WHERE `uid`=" . $uid);
    }
    public static function getUserFansNumber($DB, $uid)
    {
        return $DB->selectOne("SELECT COUNT(`uid`) FROM `" . PRE . "follow` WHERE `fuid`=" . $uid);
    }
    public static function getUserUid($DB, $email)
    {
        return $DB->selectOne("SELECT `uid` FROM `" . PRE . "user` WHERE `email`='" . $email ."'");
    }
    public static function getResetPasswordCode($DB, $value, $which = true)
    {
        if($which) {
            return $DB->selectOneArray("SELECT * FROM `" . PRE . "resetpwd` WHERE `uid`='" . $value ."'");
        } else {
            return $DB->selectOneArray("SELECT * FROM `" . PRE . "resetpwd` WHERE `code`='" . $value ."'"); 
        }
    }
    public static function getschoolid($DB, $uid)
    {
        return $DB->selectOne("SELECT `schoolid` FROM `" .PRE. "user` WHERE `uid`=".$uid);
    }
    public static function getUserLasttime($DB, $uid)
    {
        return $DB->selectOne("SELECT `lasttime` FROM `" . PRE . "user` WHERE `uid`=" . $uid);
    }
    public static function getUserBalanceNumber($DB, $uid, $type = 'number')
    {
        if($type == 'number') {
            return $DB->selectOne("SELECT `money` FROM `" . PRE . "user` WHERE `uid`=" . $uid);
        } else {
            return $DB->selectOne("SELECT COUNT(`bid`) FROM `" . PRE . "balance` WHERE `uid`=" . $uid);
        }
    }
    public static function getTopicTopStatus($DB, $tid)
    {
        return $DB->selectOne("SELECT `istop` FROM `" . PRE . "topic` WHERE `tid`=" . $tid);
    }
    public static function getBanStatus($DB, $uid)
    {
        return $DB->selectOne("SELECT `groupid` FROM `" . PRE . "user` WHERE `uid`=" . $uid);
    }
    public static function getTopicTid($DB, $tid)
    {
        return $DB->selectOne("SELECT COUNT(`tid`) FROM `" . PRE . "topic` WHERE `tid`=" . $tid);
    }
    public static function getTopicUid($DB, $tid)
    {
        return $DB->selectOne("SELECT `uid` FROM `" . PRE . "topic` WHERE `tid`=" . $tid);
    }
    public static function getUnreadWhisperNumber($DB, $uid)
    {
        return $DB->selectOne("SELECT COUNT(`wid`) FROM `" . PRE . "whisper` WHERE `atuid` = " . $uid . " AND `isread` = 0");
    }
    public static function getGroupName($groupid)
    {
        $groupName = $GLOBALS['group_config']['' . $groupid . ''];
        return $groupName;
    }
    public static function getClubList($DB,$currentschoolid)
    {
        return $DB->selectAll("SELECT * FROM `" . PRE . "club` WHERE `".PRE."club`.`schoolid`='".$currentschoolid."' AND `position` > 0 ORDER BY `position` ASC");
    }
    public static function getPostImageAccess()
    {
        return json_decode(Secret::decrypt($_COOKIE['tmp_picture'], $GLOBALS['roc_config']['secure_key']));
    }
    public static function getStrlen($str)
    {
        return mb_strlen($str, "utf-8");
    }
    public static function getCurrentclubName($DB, $currentCid)
    {
        if ($currentCid == 0) {
            return '全部话题';
        } else {
            return $DB->selectOne("SELECT `clubname` FROM `" . PRE . "club` WHERE `cid` = '" . $currentCid . "'");
        }
    }
    public static function textSubstr($str, $start, $len)
    {
        return mb_substr($str, $start, $len, "utf-8");
    }
    public static function cutSubstr($str_cut, $length = '100')
    {
        if (mb_strlen($str_cut, 'utf8') > $length) {
            return trim(mb_substr($str_cut, 0, $length, 'utf-8') . '...');
        } else {
            return trim($str_cut);
        }
    }
    public static function textCount($str, $needle)
    {
        return mb_substr_count($str, $needle, "utf-8");
    }
    public static function checkNickname($nickname)
    {
        if (strlen($nickname) < 3 || self::getStrlen($nickname) < 2) {
            return "昵称太短了 ^_^";
        }
        if (self::getStrlen($nickname) > 10) {
            return "昵称太长了 ^_^";
        }
        if (is_numeric(substr($nickname, 0, 1)) || substr($nickname, 0, 1) == "_") {
            return "昵称不能以数字和下划线开头";
        }
        if (substr($nickname, -1, 1) == "_") {
            return "昵称不能以下划线结尾";
        }
        if (!preg_match('/^[\x{4e00}-\x{9fa5}_a-zA-Z0-9]+$/u', $nickname)) {
            return "昵称只能用汉字、英文、数字及下划线";
        }
        for ($i = 0, $l = self::getStrlen($nickname); $i < $l; $i++) {
            if (self::textCount($nickname, self::textSubstr($nickname, $i, 1)) > 3) {
                return "昵称内重复字符太多";
            }
        }
        return "";
    }
    public static function Currentpage()
    {
        return isset($_GET['page']) && intval($_GET['page']) > 0 ? intval($_GET['page']) : 1;
    }
    public static function loginCookie($sKey, $uid, $name, $group)
    {
        $loginTime = time();
        setcookie("roc_login", $name, $loginTime + 1209600, "/");
        $loginEncode = Secret::encrypt(json_encode(array(
            $uid,
            $name,
            $group,
            $loginTime
        )), $sKey);
        setcookie("roc_secure", $loginEncode, $loginTime + 1209600, "/");
        setcookie("roc_connect", "");
    }
    public static function isLogin($sKey, $cookie)
    {
        $userInfo = array(
            "uid"       => 0,
            "nickname"  => '',
            "signature" => '',
            "group"     => 0,
            "groupname" => '',
            "logintime" => 0,
            "avatar"    => ''
        );
        if (isset($cookie['roc_login'], $cookie['roc_secure'])) {
            $userArr = json_decode(Secret::decrypt($cookie['roc_secure'], $sKey), true);
            if (count($userArr) == 4) {
                if ($cookie['roc_login'] == $userArr[1]) {
                        $userInfo['uid']       = $userArr[0];
                        $userInfo['nickname']  = $userArr[1];
                        $userInfo['group']     = $userArr[2];
                        $userInfo['logintime'] = $userArr[3];
                    $userInfo['avatar']    = Image::getAvatarURL($userArr[0]);
                    $userInfo['groupname'] = self::getGroupName($userArr[2]);
                }
            }
        }
        return $userInfo;
    }
    public static function atName($str)
    {
        if (in_array($str[1], array(
            "。",
            "？",
            "，",
            "！"
        ))) {
            return $str[0];
        }
        return '<span class=atname><a href="./?m=user&id=' . urlencode($str[1]) . '">@' . $str[1] . '</a></span>' . $str[2];
    }
    public static function parseUrl($str)
    {
        $auto_arr = array(
            "/(?<=[^\]a-z0-9-=\"'\\/])((https?|ftp):\/\/)([a-z0-9\/\-_+=.~!%@?#%&;:$\\│]+)/i",
            "/(?<=[^\]a-z0-9\/\-_.~?=:.])([_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4}))/i"
        );
        $auto_url = array(
            '<a href="\\1\\3" target="_blank">\\1\\3</a>',
            '<a href="mailto:\\0">\\0</a>'
        );
        return preg_replace($auto_arr, $auto_url, " " . $str);
    }
    public static function is_email($user_email)
    {
        $chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
        if (strpos($user_email, '@') !== false && strpos($user_email, '.') !== false) {
            if (preg_match($chars, $user_email)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public static function deletePicture($path)
    {
        if ($path != '') {
            @unlink($path);
            @unlink(Image::getSmallImg($path));
        }
    }
    public static function getSmallImg($value)
    {
        $path     = substr($value, 0, strrpos($value, '/') + 1);
        $fileName = substr($value, -36);
        $value    = $path . 's_' . $fileName;
        return $value;
    }
    public static function checkMemberEmail($DB, $value)
    {
        return $DB->selectOne("SELECT COUNT(`uid`) FROM `" . PRE . "user` WHERE `email` = '" . $value . "'");
    }
    public static function checkMemberName($DB, $value)
    {
        return $DB->selectOne("SELECT COUNT(`uid`) FROM `" . PRE . "user` WHERE `nickname` = '" . $value . "'");
    }
    public static function checkClubCid($DB, $value)
    {
        return $DB->selectOne("SELECT COUNT(`cid`) FROM `" . PRE . "club` WHERE `cid` = '" . $value . "' AND `position` <> 0");
    }
    public static function addMember($DB, $nickname, $email, $password, $qqid, $groupid = 1)
    {
        $addDBArray = array(
            "nickname"  => $nickname,
            "email"     => $email,
            "password"  => $password,
            "regtime"   => time(),
            'lasttime'  => time(),
            "qqid"      => $qqid,
            "money"     => 0,
            "groupid"   => $groupid
        );
        $DB->query($DB->insert("`". PRE ."user`", $addDBArray));
        return $DB->lastInsertId();
    }
    public static function getNotificationNumber($DB, $uid, $isread)
    {
        if ($isread == '0') {
            return $DB->selectOne("SELECT COUNT(`nid`) FROM `" . PRE . "notification` WHERE `atuid`=" . $uid . " AND `isread` = 0");
        } else {
            return $DB->selectOne("SELECT COUNT(`nid`) FROM `" . PRE . "notification` WHERE `atuid`=" . $uid);
        }
    }
    public static function updateLogintime($DB, $value)
    {
        $DB->query("UPDATE `" . PRE . "user` SET `lasttime` = '" . time() . "' WHERE `uid` = '" . $value . "'");
    }
    public static function updateUserMoney($DB, $uid, $value, $type)
    {
        if($uid > 0) {
            if($value > 0) {
                $DB->query("UPDATE `" . PRE . "user` SET `money` = `money` + '". $value ."' WHERE `uid` = '" . $uid . "'");
            } else {
                $DB->query("UPDATE `" . PRE . "user` SET `money` = `money` - '". abs($value) ."' WHERE `uid` = '" . $uid . "'");
            }
            $addDBArray = array(
                "uid"       => $uid,
                "type"      => $type,
                'balance'   => self::getUserBalanceNumber($DB, $uid),
                "changed"   => $value,
                "time"      => time(),
            );
            $DB->query($DB->insert("`". PRE ."balance`", $addDBArray));
        }
    }
    public static function getUserFollow($DB, $uid, $page, $per, $Is = 'follow')
    {
        if ($Is == 'fans')
            $Total = self::getUserFansNumber($DB, $uid);
        else
            $Total = self::getUserFollowNumber($DB, $uid);
        $followList = array();
        if ($Total > 0) {
            if ($Is == 'fans') {
                $Result = $DB->query("SELECT * FROM `". PRE ."follow` WHERE `fuid`=" . $uid . " LIMIT " . ($page - 1) * $per . "," . $per);
                while ($Re = $DB->fetchArray($Result)) {
                    $getUser      = $DB->selectOneArray("SELECT * FROM `". PRE ."user` WHERE `uid`=" . $Re['uid']);
                    $followList[] = array(
                        "uid" => $Re['uid'],
                        "nickname" => $getUser['nickname'],
                        "signature" => $getUser['signature'],
                        "avatar" => Image::getAvatarURL($Re['uid'])
                    );
                }
            } else {
                $Result = $DB->query("SELECT * FROM `". PRE ."follow` WHERE `uid`=" . $uid . " LIMIT " . ($page - 1) * $per . "," . $per);
                while ($Re = $DB->fetchArray($Result)) {
                    $getUser      = $DB->selectOneArray("SELECT * FROM `". PRE ."user` WHERE `uid`=" . $Re['fuid']);
                    $followList[] = array(
                        "uid" => $Re['fuid'],
                        "nickname" => $getUser['nickname'],
                        "signature" => $getUser['signature'],
                        "avatar" => Image::getAvatarURL($Re['fuid'])
                    );
                }
            }
        }
        return $followList;
    }
    public static function getUserFavorite($DB, $fuid, $page, $per)
    {
        $Total    = self::getUserFavoriteNumber($DB, $fuid);
        $postList = array();
        if ($Total > 0) {
            $Result = $DB->query("SELECT `a`.*, `b`.`message` as `message`, `b`.`uid` as `uid`, `b`.`posttime` as `posttime`, `b`.`pictures` as `pictures`, `c`.`nickname` as `nickname` FROM `" . PRE . "favorite` `a`,`" . PRE . "topic` `b`,`" . PRE . "user` `c` WHERE `a`.`fuid`= '" . $fuid . "' AND `a`.`tid`= `b`.`tid` AND `b`.`uid`= `c`.`uid` ORDER BY `a`.`fid` DESC LIMIT " . ($page - 1) * $per . "," . $per);
            while ($Re = $DB->fetchArray($Result)) {
                $postList[] = array(
                    "fid" => $Re['fid'],
                    "fuid" => $Re['fuid'],
                    "uid" => $Re['uid'],
                    "tid" => $Re['tid'],
                    "nickname" => $Re['nickname'],
                    "avatar" => Image::getAvatarURL($Re['uid']),
                    "message" => self::text_out($Re['message'], false),
                    "posttime" => self::formatTime($Re["posttime"]),
                    "pictures" => Image::getImageURL($Re["pictures"])
                );
            }
        }
        return $postList;
    }
    public static function getUserBalance($DB, $uid, $page, $per)
    {
        $Total    = self::getUserBalanceNumber($DB, $uid, 'count');
        $postList = array();
        if ($Total > 0) {
            $Result = $DB->query("SELECT * FROM `" . PRE . "balance` WHERE `uid` = '".$uid."' ORDER BY `bid` DESC LIMIT " . ($page - 1) * $per . "," . $per);
            while ($Re = $DB->fetchArray($Result)) {
                $postList[] = array(
                    "bid"       => $Re['bid'],
                    "uid"       => $Re['uid'],
                    "type"      => $GLOBALS['balance_config']['type'][$Re['type']],
                    "balance"   => $Re['balance'],
                    "changed"   => $Re['changed'],
                    "time"      => date('Y年n月j日 H:i', $Re['time'])
                );
            }
        }
        return $postList;
    }
    public static function getAllMember($DB, $per = 30, $order = 'lasttime')
    {
        return $DB->selectAll("SELECT * FROM `" . PRE . "user` ORDER BY `" . $order . "` DESC LIMIT " . (self::Currentpage() - 1) * $per . "," . $per);
    }
    public static function getMemberInfo($DB, $key, $value)
    {
        $memberArray = array(
            "uid" => 0,
            "nickname" => "",
            "email" => "",
            "password" => "",
            "regtime" => "",
            "qqid" => "",
            "groupid" => 0
        );
        $DBArray     = $DB->selectOneArray("SELECT * FROM `" . PRE . "user` WHERE `" . $key . "`='" . $value . "'");
        if (!empty($DBArray['uid'])) {
            $memberArray['uid']       = $DBArray['uid'];
            $memberArray['avatar']    = Image::getAvatarURL($DBArray['uid']);
            $memberArray['nickname']  = $DBArray['nickname'];
            $memberArray['email']     = $DBArray['email'];
            $memberArray['signature'] = $DBArray['signature'];
            $memberArray['password']  = $DBArray['password'];
            $memberArray['regtime']   = date('Y年n月j日 H:i', $DBArray['regtime']);
            $memberArray['lasttime']  = date('Y年n月j日 H:i', $DBArray['lasttime']);
            $memberArray['money']     = $DBArray['money'];
            $memberArray['qqid']      = $DBArray['qqid'];
            $memberArray['groupid']   = $DBArray['groupid'];
            $memberArray['groupname'] = self::getGroupName($DBArray['groupid']);
        }
        return $memberArray;
    }
    public static function getOneTopic($DB, $tid)
    {
        $topicArray = array(
            "tid" => 0
        );
        $Re         = $DB->selectOneArray("SELECT  *, `" . PRE . "user`.`nickname` as `nickname` FROM `" . PRE . "user`,`" . PRE . "topic` WHERE `" . PRE . "topic`.`uid` = `" . PRE . "user`.`uid` AND `tid`='" . $tid . "'");
        if (!empty($Re['tid'])) {
            $topicArray = array(
                "tid"       => $Re['tid'],
                "uid"       => $Re['uid'],
                "nickname"  => $Re['nickname'],
                "cid"       => $Re['cid'],
                "client"    => $Re['client'],
                "lasttime"  => $Re["lasttime"],
                "comments"  => $Re["comments"],
                "posttime"  => self::formatTime($Re["posttime"]),
                "message"   => self::text_out($Re['message']),
                "pictures"  => Image::getImageURL($Re["pictures"]),
                "avatar"    => Image::getAvatarURL($Re['uid'])
            );
        }
        return $topicArray;
    }
    public static function getTopicCount($DB, $cid, $condition = '')
    {
        if ($cid == 0) {
            if ($condition == '') {
                $condition = 1;
            } else {
                $condition = '1 ' . $condition;
            }
            return $DB->selectOne("SELECT COUNT(`tid`) FROM `" . PRE . "topic` WHERE " . $condition);
        } else {
            return $DB->selectOne("SELECT COUNT(`tid`) FROM `" . PRE . "topic` WHERE `cid`='" . $cid . "' " . $condition);
        }
    }
    public static function formatTime($unixTime)
    {
        $showTime = date('Y', $unixTime) . "年" . date('n', $unixTime) . "月" . date('j', $unixTime) . "日 " . date('H:i', $unixTime);
        if (date('Y', $unixTime) == date('Y')) {
            $showTime = date('n', $unixTime) . "月" . date('j', $unixTime) . "日 " . date('H:i', $unixTime);
            if (date('n.j', $unixTime) == date('n.j')) {
                $timeDifference = time() - $unixTime + 1;
                if ($timeDifference < 60) {
                    return $timeDifference . "秒前";
                }
                if ($timeDifference >= 60 && $timeDifference < 3600) {
                    return floor($timeDifference / 60) . "分钟前";
                }
                return date('H:i', $unixTime);
            }
            if (date('n.j', ($unixTime + 86400)) == date('n.j')) {
                return "昨天 " . date('H:i', $unixTime);
            }
        }
        return $showTime;
    }
    public static function runtime()
    {
        global $sys_starttime;
        $mtime       = explode(' ', microtime());
        $sys_runtime = number_format(($mtime[1] + $mtime[0] - $sys_starttime), 4);
        unset($sys_starttime);
        return $sys_runtime . 's';
    }
    public static function getClient()
    {
        $agent = strtolower($_SERVER["HTTP_USER_AGENT"]);
        if (stripos($agent, "iphone") !== false) {
            $x_moblie = "iPhone";
        } else if (stripos($agent, "ipad") !== false) {
            $x_moblie = "iPad";
        } else if (stripos($agent, "ipod") !== false) {
            $x_moblie = "iPod";
        } else if (stripos($agent, "android") !== false) {
            $x_moblie = "Android";
        } else if (stripos($agent, "blackberry") !== false) {
            $x_moblie = "BlackBerry";
        } else if (stripos($agent, "windows phone") !== false) {
            $x_moblie = "Windows Phone";
        } else if (stripos($agent, "windows mobile") !== false) {
            $x_moblie = "Windows Mobile";
        } else if (stripos($agent, "windows ce") !== false) {
            $x_moblie = "Windows CE";
        } else if (stripos($agent, "symbian") !== false) {
            $x_moblie = "Symbian";
        } else if (stripos($agent, "uc") !== false) {
            $x_moblie = "UC浏览器";
        } else {
            $x_moblie = "";
        }
        return $x_moblie;
    }
        public static function in($data, $force = false)
    {
        if (is_string($data)) {
            $data = trim(htmlspecialchars($data));
            if (($force == true) || (!get_magic_quotes_gpc())) {
                $data = addslashes($data);
            }
            return $data;
        } else if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = in($value, $force);
            }
            return $data;
        } else {
            return $data;
        }
    }
    public static function out($data)
    {
        if (is_string($data)) {
            return $data = stripslashes($data);
        } else if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = out($value);
            }
            return $data;
        } else {
            return $data;
        }
    }
    public static function text_in($str)
    {
        $str = str_replace(array(
            "\r",
            "\n",
            "\t"
        ), "[p]", $str);
        $str = strip_tags($str, '[p]');
        if (!get_magic_quotes_gpc()) {
            $str = addslashes($str);
        }
        return trim($str);
    }
    public static function text_out($str, $p = 'true', $s = 'true')
    {
        $str = stripslashes($str);
        $str = htmlspecialchars($str);
        if ($p == true) {
            $str = self::parseUrl($str);
            $str = str_replace("[p]", "<p></p>", $str);
        } else {
            $str = str_replace("[p]", " ", $str);
            $str = self::cutSubstr($str);
        }
        if($s){
            $str = preg_replace_callback("/\@([^[:punct:]\s]{3,39})([\s]+)/", 'Common::atName', $str . ' ');
        }
        return trim($str);
    }
}
?>