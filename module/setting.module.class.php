<?php
!defined('MODULE') && exit('REFUSED!');
Class settingModule extends commonModule
{
    public function index()
    {
        $this->checkPrivate();
        $settingType = (isset($_GET['type']) && in_array($_GET['type'], array(
            'email',
            'password',
            'signature'
        ))) ? $_GET['type'] : 'avatar';
        $userInfo    = Common::getMemberInfo($this->db, 'uid', $this->loginInfo['uid']);
        $this->tpls->assign('title', '设置');
        $this->tpls->assign('currentStatus', 'setting');
        $this->tpls->assign('userInfo', $userInfo);
        $this->tpls->assign('settingType', $settingType);
        $this->tpls->assign('loginInfo', $this->loginInfo);
        $this->tpls->assign('runtime', Common::runtime());
        $this->tpls->display('setting');
    }
    public function setEmail()
    {
        $this->checkPrivate();
        if (isset($_POST['password'], $_POST['email'])) {
            $currentPasswd = stripslashes(trim($_POST['password']));
            $newEmail      = trim($_POST['email']);
            if (strlen($currentPasswd) < 6 || strlen($currentPasswd) > 26 || substr_count($currentPasswd, " ") > 0) {
                die('{"result":"error","message":"当前密码无效","position":1}');
            }
            if (Common::is_email($newEmail) == false) {
                die('{"result":"error","message":"邮件地址不合法","position":2}');
            }
            $userInfo = $this->db->selectOneArray("SELECT `email`,`password` FROM `" . PRE . "user` WHERE `uid`=" . $this->loginInfo['uid']);
            if ($userInfo['password'] != md5($currentPasswd)) {
                die('{"result":"error","message":"当前密码不正确","position":1}');
            } else {
                if ($userInfo['email'] == $newEmail) {
                    die('{"result":"error","message":"邮箱未修改","position":2}');
                } else {
                    if ($this->db->selectOne("SELECT COUNT(`uid`) FROM `" . PRE . "user` WHERE `email`='" . $newEmail . "'") > 0) {
                        die('{"result":"error","message":"该邮件地址已被其它账号占用","position":2}');
                    } else {
                        $this->db->query("UPDATE `" . PRE . "user` SET `email`='" . $newEmail . "' WHERE `uid`=" . $this->loginInfo['uid']);
                        die('{"result":"success","message":"邮箱修改成功"}');
                    }
                }
            }
        } else {
            die('{"result":"error","message":"非法请求"}');
        }
    }
    public function setSignature()
    {
        $this->checkPrivate();
        if (isset($_POST['signature'])) {
            $newSgn = Common::text_in($_POST['signature']);
            if (Common::getStrlen($newSgn) > 32) {
                die('{"result":"error","message":"您的字数超过32字了"}');
            } else {
                $userInfo = $this->db->selectOneArray("SELECT `signature` FROM `" . PRE . "user` WHERE `uid`=" . $this->loginInfo['uid']);
                if ($userInfo['signature'] == $newSgn) {
                    die('{"result":"error","message":"签名未修改","position":2}');
                }
                $this->db->query("UPDATE `" . PRE . "user` SET `signature` = '" . $newSgn . "' WHERE `uid`=" . $this->loginInfo['uid']);
                die('{"result":"success","message":"个性签名修改成功"}');
            }
        }
    }
    public function setPassword()
    {
        $this->checkPrivate();
        if (isset($_POST['currentPasswd'], $_POST['userPasswd'])) {
            $currentPasswd = stripslashes($_POST['currentPasswd']);
            $userPasswd    = stripslashes($_POST['userPasswd']);
            if (substr_count($currentPasswd, " ") > 0 || substr_count($userPasswd, " ") > 0) {
                die('{"result":"error","message":"密码不能使用空格","position":2}');
            }
            if (strlen($userPasswd) < 6) {
                die('{"result":"error","message":"密码长度不能少于6位","position":2}');
            }
            if (strlen($currentPasswd) > 26 || strlen($userPasswd) > 26) {
                die('{"result":"error","message":"密码长度不能超出26位","position":2}');
            }
            $currentPassword = $this->db->selectOne("SELECT `password` FROM `" . PRE . "user` WHERE `uid`=" . $this->loginInfo['uid']);
            if ($currentPassword != "" && md5($currentPasswd) != $currentPassword) {
                die('{"result":"error","message":"当前密码不正确","position":1}');
            } else {
                if ($currentPassword == md5($userPasswd)) {
                    die('{"result":"error","message":"新密码不能与当前密码相同","position":2}');
                } else {
                    $this->db->query("UPDATE `" . PRE . "user` SET password='" . md5($userPasswd) . "' WHERE `uid`=" . $this->loginInfo['uid']);
                    die('{"result":"success","message":"密码修改成功"}');
                }
            }
        }
    }
    public function setAvatar()
    {
        $this->checkPrivate();
    }
    private function checkPrivate()
    {
        if ($this->loginInfo['nickname'] == '') {
            die('{"result":"error","message":"您尚未登录，无权执行此操作"}');
        }
    }
}
?>