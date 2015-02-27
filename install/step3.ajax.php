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
    $db = @new MySQLi($_POST['server'], $_POST['user'], $_POST['password'], '', $_POST['port']);
    if (@$db->get_server_info()) {
        // --- 数据库 ---
        $db->set_charset('utf8');
        if ($db->query('CREATE DATABASE IF NOT EXISTS `' . $db->real_escape_string($_POST['database']) . '` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;')) {
            // --- 检测版本 ---
            $mysqlVersion = $db->get_server_info();
            $db->close();
            $mysqlVersion = explode('-', $mysqlVersion);
            $mysqlVersion = $mysqlVersion[0];
            if (version_compare($mysqlVersion, '5.1.10', '>=')) {
                // --- 数据库连接成功，写入数据 ---
                $slexInfo = file_get_contents('../config.php');
                $slexInfo = preg_replace('/db_config.+?\\);/s', 'db_config = array(
				\'db_host\' => \'' . $_POST['server'] . '\',
				\'db_user\' => \'' . $_POST['user'] . '\',
				\'db_pass\' => \'' . $_POST['password'] . '\',
				\'db_name\' => \'' . $_POST['database'] . '\',
				\'db_pre\'	=>	\'' . $_POST['tpre'] . '\',
				\'db_code\' => \'utf8\',
				\'db_switch\' => 	\'true\',
				\'db_long\'	=>	\'false\'
				);', $slexInfo);
                file_put_contents('../config.php', $slexInfo);
                echo json_encode(array('result' => '1', 'msg' => 'config.php 数据文件写入失败，请确认是否有权限'));
            } else {
                echo json_encode(array('result' => '0', 'msg' => 'MySQL 版本太低，无法继续。
				当前版本：' . $mysqlVersion . '
				最低需要：5.1.10'));
            }
        } else {
            $db->close();
            echo json_encode(array('result' => '0', 'msg' => '数据库不存在且没有权限创建'));
        }
    } else {
        echo json_encode(array('result' => '0', 'msg' => '数据库连接失败'));
    }
}