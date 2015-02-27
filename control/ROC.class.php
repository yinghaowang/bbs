<?php
class LoadingClass
{
    public static function LoadingDir($Class_Root, $ROC_Class)
    {
        $File = ROOT . $Class_Root . $ROC_Class . '.class.php';
        if (!is_file($File)) {
            Error::debug('Load File ' . $File . ' Fail!');
        } else {
            require($File);
        }
    }
    public static function LoadingSystem($Class_Root, $ROC_Class)
    {
        foreach ($ROC_Class as $v) {
            $coreFile = CONTROL . $Class_Root . '/' . $v . '.class.php';
            require($coreFile);
        }
    }
}
class ROC
{
    public static function checkmod($str)
    {
        return preg_match('/^[A-Za-z0-9_]+$/', $str);
    }
    public static function ROC_START($Class_Root = MODULE, $ROC_Class = 'common.module')
    {
        $ROC_mod    = isset($_GET['m']) ? Common::text_in($_GET['m']) : 'index';
        $ROC_action = isset($_GET['w']) ? Common::text_in($_GET['w']) : 'index';
        self::checkmod($ROC_mod);
        self::checkmod($ROC_action);
        $ctrlname = $ROC_mod . 'Module';
        LoadingClass::LoadingDir($Class_Root, $ROC_Class);
        $ROC_ctrl_file = ROOT . MODULE . $ROC_mod . '.module.class.php';
        if (is_file($ROC_ctrl_file)) {
            require $ROC_ctrl_file;
            $controller = new $ctrlname();
        } else {
            Error::debug('Module ' . Common::text_in($_GET['m']) . ' Does Not Exist');
        }
        if (method_exists($ctrlname, $ROC_action)) {
            $controller->$ROC_action();
        } else {
            Error::debug('Method ' . Common::text_in($_GET['w']) . ' Does Not Exist');
        }
    }
}
?>