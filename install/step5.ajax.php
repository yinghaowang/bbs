<?php
function deaddslashes(&$str)
{
    if (is_array($str)) {
        foreach ($str as $key => $v) {
            deaddslashes($str[$key]);
        }
    } elseif (is_string($str)) {
        $str = stripslashes($str);
    }
}
if (get_magic_quotes_gpc()) {
    deaddslashes($_GET);
    deaddslashes($_POST);
    deaddslashes($_COOKIE);
    deaddslashes($_REQUEST);
}
if (!is_file('install.lock')) {
    ob_start();
    define('__ROOT__', realpath(dirname(__FILE__)) . '/');
    include_once '../config.php';
    if ($mysqli = @new mysqli($GLOBALS['db_config']['db_host'], $GLOBALS['db_config']['db_user'], $GLOBALS['db_config']['db_pass'], $GLOBALS['db_config']['db_name'])) {
        $mysqli->set_charset('utf8');
        // --- 创建创始人信息 ---
        $_POST['pwd'] = trim($_POST['pwd']);
        if ($_POST['pwd'] != '') {
            $_POST['username'] = trim($_POST['username']);
            if ($_POST['username'] != '') {
                // --- 整理数据 ---
                $pwdhash = md5($_POST['pwd']);
                $mysqli->query('INSERT INTO `'.$GLOBALS['db_config']['db_pre'].'club` (`cid`, `clubname`, `position`) VALUES (\'1\', \'微世界\', \'1\');');
                $mysqli->query('INSERT INTO `'.$GLOBALS['db_config']['db_pre'].'user` (`uid`, `nickname`, `email`, `signature`, `password`, `regtime`, `lasttime`, `qqid`, `money`, `groupid`) VALUES (\'1\',\'' . $mysqli->real_escape_string($_POST['username']) . '\',\'' . $mysqli->real_escape_string($_POST['email']) . '\',\'我是站长！\',\'' . $mysqli->real_escape_string($pwdhash) . '\',\'' . time() . '\',\'' . time() . '\',\'\',\'20\',\'9\');');
                $mysqli->close();
                // --- 锁定 ---
                rename('_install.lock', 'install.lock');
                echo json_encode(array('result' => '1'));
            } else {
                echo json_encode(array('result' => '0', 'msg' => '请输入创始人账户'));
            }
        } else {
            echo json_encode(array('result' => '0', 'msg' => '请输入创始人密码'));
        }
    } else {
        echo json_encode(array('result' => '0', 'msg' => '数据库连接失败'));
    }
}