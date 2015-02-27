<?php
ob_start();
define('__ROOT__', realpath(dirname(__FILE__)) . '/');
define('__DATA__', __ROOT__ . 'data/');
include_once '../config.php';
if (!is_file('install.lock')) {
    if ($mysqli = @new mysqli($GLOBALS['db_config']['db_host'], $GLOBALS['db_config']['db_user'], $GLOBALS['db_config']['db_pass'], $GLOBALS['db_config']['db_name'])) {
        $mysqli->set_charset('utf8');
        // --- 导入 SQL ---
        $sql = file_get_contents('rocboss.sql');
        $sql = str_replace('

', '
', str_replace('
', '
', str_replace('
', '
', $sql)));
        $sql = str_replace("roc_",$GLOBALS['db_config']['db_pre'],$sql);
        $sqlList = explode(';
', $sql);
        $okey = true;
        $sqlStr = '';
        foreach ($sqlList as $sqlStr) {
            $sqlStr = trim($sqlStr);
            if ($sqlStr != '') {
                $r = $mysqli->query($sqlStr . ';');
                if ($r === false) {
                    $okey = false;
                    break;
                }
            }
        }
        if ($okey) {
            echo json_encode(array('result' => '1'));
        } else {
            echo json_encode(array('result' => '0', 'msg' => '数据表导入失败，在：' . '

' . $sqlStr . ';

安装失败'));
        }
        $mysqli->close();
    } else {
        echo json_encode(array('result' => '0', 'msg' => '数据库连接失败'));
    }
}