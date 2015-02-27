<?php
!defined('MODULE') && exit('REFUSED!');
class commonModule
{
    public $db;
    public $tpls;
    public $loginInfo;
    public function __construct()
    {
        if ($GLOBALS['db_config']['db_switch'] == 'true')
        {
            $this->db = new DB();
            $this->db->connect(
            	$GLOBALS['db_config']['db_host'],
            	$GLOBALS['db_config']['db_user'],
            	$GLOBALS['db_config']['db_pass'],
            	$GLOBALS['db_config']['db_name'],
            	$GLOBALS['db_config']['db_code'],
            	$GLOBALS['db_config']['db_long']
        	);
        }
        $this->tpls             = new Template();

        $this->tpls->tpl_dir    = TPL .(Common::getClient()==""? $GLOBALS['tpl_config']['tpl_dir'] : 'mobile' ). '/';

        $this->tpls->cache_time = $GLOBALS['tpl_config']['tpl_time'];

        $this->tpls->tpl_ext    = $GLOBALS['tpl_config']['tpl_ext'];

        $this->tpls->cache_dir  = './cache/' . $GLOBALS['tpl_config']['tpl_cache'] . (Common::getClient()==""? '/': '/mobile/' );

        $this->loginInfo        = Common::isLogin($GLOBALS['roc_config']['secure_key'], $_COOKIE);

        if($this->loginInfo['logintime'] < strtotime(date('Y-m-d',time()))) {

            $loginEncode = Secret::encrypt(json_encode(array($this->loginInfo['uid'],$this->loginInfo['nickname'],$this->loginInfo['group'],time())),$GLOBALS['roc_config']['secure_key']);

            setcookie("roc_secure",$loginEncode,$this->loginInfo['logintime']+1209600-(time()-$this->loginInfo['logintime']),"/");

            if(Common::getUserLasttime($this->db, $this->loginInfo['uid']) < strtotime(date('Y-m-d',time()))) {
                Common::updateUserMoney($this->db, $this->loginInfo['uid'], $GLOBALS['balance_config']['change']['login'], 2);
            }

            Common::updateLogintime($this->db, $this->loginInfo['uid']);
        }
    }
}
?>