<?php
!defined('MODULE') && exit('REFUSED!');
Class connectModule extends commonModule
{
    public $page;
    public $cache;
    public $per = 30;
    public function login()
    {
        $this->checkPrivate();
        if (isset($_POST['email'], $_POST['password'], $_POST['do']) && $_POST['do'] == 'login') {
            $loginAccount  = Common::in($_POST['email']);
            $loginPassword = Common::in($_POST['password']);
            if (strlen($loginAccount) < 2) {
                die('{"result":"error","message":"账号无效","position":1}');
            }
            if ((strlen($loginPassword) < 6 || strlen($loginPassword) > 26) || substr_count($loginPassword, ' ') > 0) {
                die('{"result":"error","message":"密码无效","position":2}');
            }
            if (Common::is_email($loginAccount)) {
                $loginType = 'email';
            } else if (Common::checkNickname($loginAccount) != '') {
                die('{"result":"error","message":"账号不合法","position":1}');
            } else {
                $loginType = 'nickname';
            }
            $userInfo = Common::getMemberInfo($this->db, $loginType, $loginAccount);
            if (empty($userInfo['uid'])) {
                die('{"result":"error","message":"账号不存在","position":1}');
            } else {
                if (md5($loginPassword) == $userInfo['password']) {
                    Common::loginCookie($GLOBALS['roc_config']['secure_key'], $userInfo['uid'], $userInfo['nickname'], $userInfo['groupid']);
                    if(Common::getUserLasttime($this->db, $userInfo['uid']) < strtotime(date('Y-m-d',time()))) {
                        Common::updateUserMoney($this->db, $userInfo['uid'], $GLOBALS['balance_config']['change']['login'], 2);
                    }
                    Common::updateLogintime($this->db, $userInfo['uid']);
                    die('{"result":"success","message":"登录成功","position":0}');
                } else {
                    die('{"result":"error","message":"账号与密码不匹配","position":2}');
                }
            }
        }
        $this->tpls->assign('title', '登录');
        $this->tpls->assign('currentStatus', 'login');
        $this->tpls->assign('loginInfo', $this->loginInfo);
        $this->tpls->assign('runtime', Common::runtime());
        $this->tpls->display('login');
    }
    public function register()
    {
        $this->checkPrivate();
        if (isset($_POST['email'], $_POST['nickname'], $_POST['password'], $_POST['verify']) && $_POST['do'] == 'register') {
            if (!$GLOBALS['roc_config']['emailjoin']) {
                die('{"result":"error","message":"账号注册暂不开放，请使用QQ登录","position":0}');
            }
            $email    = strtolower(stripslashes(trim($_POST['email'])));
            $nickname = Common::text_in($_POST['nickname']);
            $password = stripslashes(trim($_POST['password']));
            $verify   = trim($_POST['verify']);
            if ($email == "" || $nickname == "" || $password == "" || $verify == "") {
                if ($verify == "") {
                    die('{"result":"error","message":"验证码不能为空","position":4}');
                }
                if ($email == "") {
                    die('{"result":"error","message":"邮箱不能为空","position":1}');
                }
                if ($nickname == "") {
                    die('{"result":"error","message":"用户名不能为空","position":2}');
                }
                if ($password == "") {
                    die('{"result":"error","message":"密码不能为空","position":3}');
                }
            }
            if (md5(strtolower($verify) . $GLOBALS['roc_config']['secure_key']) != $_SESSION['identifying_code']) {
                die('{"result":"error","message":"验证码错误","position":4}');
            }
            if (!Common::is_email($email)) {
                die('{"result":"error","message":"邮件地址不正确","position":1}');
            }
            $nicknameError = Common::checkNickname($nickname);
            if ($nicknameError != '') {
                die(('{"result":"error","message":"' . $nicknameError) . '","position":2}');
            }
            if (substr_count($password, ' ') > 0) {
                die('{"result":"error","message":"密码不能使用空格","position":3}');
            }
            if (strlen($password) < 6 || strlen($password) > 26) {
                die('{"result":"error","message":"密码长度不合法","position":3}');
            }
            if (Common::checkMemberEmail($this->db, $email) != 0) {
                die('{"result":"error","message":"邮件地址已被占用","position":1}');
            } else {
                if (Common::checkMemberName($this->db, $nickname) != 0) {
                    die('{"result":"error","message":"昵称已被占用","position":2}');
                } else {
                    $userID = Common::addMember($this->db, $nickname, $email, md5($password), '', 1);
                    Common::updateUserMoney($this->db, $userID, $GLOBALS['balance_config']['change']['register'], 1);
                    if ($userID > 0) {
                        Image::CreatDefaultAvatar($userID);
                        die('{"result":"success","message":"注册成功"}');
                    } else {
                        die('{"result":"error","message":"注册失败","position":0}');
                    }
                }
            }
        }
        $this->tpls->assign('title', '注册');
        $this->tpls->assign('currentStatus', 'register');
        $this->tpls->assign('loginInfo', $this->loginInfo);
        $this->tpls->assign('runtime', Common::runtime());
        $this->tpls->display('login');
    }
    public function qqlogin()
    {
        $this->checkPrivate();
        require(PLUGIN . 'qq/QQAPI.class.php');
        $qc = new QC($GLOBALS['qq_config']['appid'], $GLOBALS['qq_config']['appkey']);
        $qc->qq_login();
    }
    public function qqjoin()
    {
        $this->checkPrivate();
        $nickname      = Common::text_in($_POST['nickname']);
        $nicknameError = Common::checkNickname($nickname);
        if ($nicknameError != '') {
            die(('{"result":"error","message":"' . $nicknameError) . '"}');
        }
        if (Common::checkMemberName($this->db, $nickname) != 0) {
            die('{"result":"error","message":"昵称已被占用"}');
        }
        $QQArr = json_decode(Secret::decrypt($_COOKIE['qqjoin'], $GLOBALS['roc_config']['secure_key']), true);
        if (strlen($QQArr['openid']) == 32) {
            $userID = Common::addMember($this->db, $nickname, '', '', $QQArr['openid'], 1);
            Common::updateUserMoney($this->db, $userID, $GLOBALS['balance_config']['change']['register'], 1);
            if ($userID > 0) {
                Image::CreatQQAvatar($userID, $QQArr['avatar']);
                Common::loginCookie($GLOBALS['roc_config']['secure_key'], $userID, $nickname, 1);
                die('{"result":"success","message":"QQ登录注册成功"}');
            } else {
                die('{"result":"error","message":"QQ登录注册失败"}');
            }
        } else {
            die('{"result":"error","message":"QQ登录注册失败"}');
        }
    }
    public function QQCallBack()
    {
        $this->checkPrivate();
        require(PLUGIN . 'qq/QQAPI.class.php');
        $qc           = new QC($GLOBALS['qq_config']['appid'], $GLOBALS['qq_config']['appkey']);
        $access_token = $qc->qq_callback();
        $openid       = $qc->get_openid();
        $QQArray      = array(
            "connect" => "QQ",
            "access_token" => "",
            "openid" => "",
            "nickname" => "",
            "avatar" => "",
            "sAvatar" => ""
        );
        if (strlen($openid) == 32) {
            $qc                      = new QC($GLOBALS['qq_config']['appid'], $GLOBALS['qq_config']['appkey'], $access_token, $openid);
            $qqInfo                  = $qc->get_user_info();
            $QQArray['access_token'] = $access_token;
            $QQArray['openid']       = $openid;
            $QQArray['nickname']     = isset($qqInfo['nickname']) ? $qqInfo['nickname'] : "";
            $QQArray['avatar']       = isset($qqInfo['figureurl_qq_2']) ? $qqInfo['figureurl_qq_2'] : "";
        }
        if ($QQArray['openid'] != '') {
            $userArr = Common::getMemberInfo($this->db, 'qqid', $QQArray['openid']);
            if (empty($userArr['uid'])) {
                $qa = Secret::encrypt(json_encode($QQArray), $GLOBALS['roc_config']['secure_key']);
                setcookie("qqjoin", $qa, time() + 600, "/");
                $this->tpls->assign('title', 'QQ登录');
                $this->tpls->assign('QQArray', $QQArray);
                $this->tpls->assign('currentStatus', 'qqjoin');
                $this->tpls->assign('loginInfo', $this->loginInfo);
                $this->tpls->assign('runtime', Common::runtime());
                $this->tpls->display('login');
            } else {
                Common::loginCookie($GLOBALS['roc_config']['secure_key'], $userArr['uid'], $userArr['nickname'], $userArr['groupid']);
                if(Common::getUserLasttime($this->db, $userArr['uid']) < strtotime(date('Y-m-d',time()))) {
                    Common::updateUserMoney($this->db, $userArr['uid'], $GLOBALS['balance_config']['change']['login'], 2);
                }
                Common::updateLogintime($this->db, $userArr['uid']);
                header('location:./');
            }
        }
    }
    public function resetPassword()
    {
        $this->checkPrivate();
        if (isset($_POST['email'], $_POST['verify']) && $_POST['do'] == 'resetPassword') {
            $email    = strtolower(stripslashes(trim($_POST['email'])));
            $verify   = trim($_POST['verify']);
            if ($email == "" || $verify == "") {
                if ($verify == "") {
                    die('{"result":"error","message":"验证码不能为空","position":2}');
                }
                if ($email == "") {
                    die('{"result":"error","message":"邮箱不能为空","position":1}');
                }
            }
            if (md5(strtolower($verify) . $GLOBALS['roc_config']['secure_key']) != $_SESSION['identifying_code']) {
                die('{"result":"error","message":"验证码错误","position":2}');
            }
            if (!Common::is_email($email)) {
                die('{"result":"error","message":"邮件地址不正确","position":1}');
            }
            if (Common::checkMemberEmail($this->db, $email) == 0) {
                die('{"result":"error","message":"邮件地址不存在","position":1}');
            }
            $userUid = Common::getUserUid($this->db, $email);
            $getCode = Common::getResetPasswordCode($this->db, $userUid);
            if ($getCode['code'] == "") {
                $insertArray = array(
                    'uid'       => $userUid,
                    'code'      => md5(rand(1,5000).rand(100,2000).$GLOBALS['roc_config']['secure_key']),
                    'dateline'  => time()
                );
                $this->db->query($this->db->insert("`" . PRE . "resetpwd`", $insertArray));
                $getCode['code'] = $insertArray['code'];
            } else if ( time() - $getCode['dateline'] > 3600) {
                $getCode = array(
                    'code'       => md5(rand(1,5000).rand(100,2000).$GLOBALS['roc_config']['secure_key']),
                    'dateline'   => time()
                );
                $this->db->query($this->db->update("`". PRE ."resetpwd`", $getCode, "`uid`=" . $userUid));
            }
            require(CONTROL . 'Mail.class.php');
            $resetUrl = "http://".$_SERVER['HTTP_HOST']."/?m=connect&w=doReset&code=".$getCode['code'];
            $mailBody = '<b>'.$email.'</b>，请点击以下链接重设密码（<u>'.date('Y-m-d H:i',time()+3600).'</u>前有效，自动邮件请勿回复！）<br>';
            $mailBody .= '<a href="'.$resetUrl.'" target="_blank">'.$resetUrl.'</a>';
            $mail = new Mail();
            $mail->setServer($GLOBALS['roc_config']['smtp'], $GLOBALS['roc_config']['sitemail'], $GLOBALS['roc_config']['mailpwd']);
            $mail->setFrom($GLOBALS['roc_config']['sitemail']);
            $mail->setReceiver($email);
            $mail->setMailInfo(SITENAME . ' - 密码重置', $mailBody);
            $mail->sendMail();
            die('{"result":"success","message":"找回密码邮件发送成功"}');
        }

        $this->tpls->assign('title', '找回密码');
        $this->tpls->assign('currentStatus', 'resetPassword');
        $this->tpls->assign('runtime', Common::runtime());
        $this->tpls->display('login');
    }
    public function doReset()
    {
        $this->checkPrivate();
        if( isset($_POST['code'], $_POST['password'], $_POST['repassword']) ) {
            $code = Common::text_in($_POST['code']);
            $newPassword = stripslashes($_POST['password']);
            $rePassword  = stripslashes($_POST['repassword']);
            if( $newPassword != $rePassword ) {
                die('{"result":"error","message":"两次密码不一样"}');
            }
            if( substr_count($newPassword," ") > 0 ) {
                die('{"result":"error","message":"密码不能使用空格"}');
            }
            if( strlen($newPassword) < 6 || strlen($newPassword) > 26 ) {
                die('{"result":"error","message":"密码长度不合法"}');
            }
            $codeArr = Common::getResetPasswordCode($this->db, $code, false);
            if( empty($codeArr['uid']) || time() - $codeArr['dateline'] > 3600 ) {
                die('{"result":"error","message":"链接已失效，请重新获取链接"}');
            } else {
                $this->db->query("UPDATE `". PRE ."user` SET `password`='".md5($newPassword)."' WHERE `uid`=".$codeArr['uid']);
                $this->db->query("DELETE FROM `". PRE ."resetpwd` WHERE `uid`=".$codeArr['uid']);
                die('{"result":"success","message":"重置密码成功，请返回登录"}');
            }
        }

        $this->tpls->assign('title', '重置密码');
        $this->tpls->assign('currentStatus', 'doReset');
        $this->tpls->assign('runtime', Common::runtime());
        $this->tpls->display('login');
    }
    public function identifyImage()
    {
        return Image::RandomCode();
    }
    public function checkPrivate()
    {
        if ($this->loginInfo['uid'] > 0) {
            header('location:./');
        }
    }
    public function logout()
    {
        session_destroy();
        setcookie("roc_secure", "", 0, "/");
        setcookie("roc_login", "", 0, "/");
        setcookie("roc_checkOpenid", "", 0, "/");
        setcookie("tmp_picture", "", 0, "/");
        header("location:./");
    }
}
?>