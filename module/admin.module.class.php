<?php
!defined('MODULE') && exit('REFUSED!');
Class adminModule extends commonModule
{
    public $page;
    public $per = 30;
    public function index()
    {
        $this->checkPrivate();
        $userInfo  = Common::getMemberInfo($this->db, 'uid', $this->loginInfo['uid']);
        $adminType = (isset($_GET['type']) && in_array($_GET['type'], array(
            'users',
            'links',
            'clubs',
            'cache','exam',
        ))) ? $_GET['type'] : 'users';
        switch ($adminType) {
            case 'users':
                $Total      = Common::getMemberCount($this->db);
                $allMembers = Common::getAllMember($this->db, $this->per);
                $this->page = new Page($this->per, $Total, Common::Currentpage(), 10, '?m=admin&type=users&page=');
                $this->tpls->assign('Total', $Total);
                $this->tpls->assign('allMembers', $allMembers);
                $this->tpls->assign('page', $this->page->pageStyle());
                break;
            case 'links':
                $this->tpls->assign('LinksList', json_decode(file_get_contents("./cache/links.json"), true));
                break;
            case 'clubs':
                $clubList = $this->db->selectAll("SELECT * FROM `" . PRE . "club` ORDER BY `position` DESC");
                $this->tpls->assign('clubList', $clubList);
                break;
            case 'exam':
                $sql  = " select `".PRE."Exam`.* from `".PRE."Exam` WHERE 1 ORDER BY Id ASC Limit ". (Common::Currentpage() - 1) * $this->per . "," . $this->per;
                $examlist = $this->db->selectAll($sql);
                print_r($sql);
                $this->tpls->assign('examlist', $examlist);
                break;
            default:
                break;
        }
        $this->tpls->assign('title', '管理中心');
        $this->tpls->assign('currentStatus', 'admin');
        $this->tpls->assign('userInfo', $userInfo);
        $this->tpls->assign('adminType', $adminType);
        $this->tpls->assign('loginInfo', $this->loginInfo);
        $this->tpls->assign('runtime', Common::runtime());
        $this->tpls->display('admin');
    }
    public function doTop()
    {
        $this->checkPrivate();
        if (isset($_POST['tid']) && is_numeric($_POST['tid'])) {
            $postArray = array(
                'tid' => intval($_POST['tid'])
            );
            if (Common::getTopicTopStatus($this->db, $postArray['tid']) > 0) {
                $postResult = $this->db->affectedRows("UPDATE `". PRE ."topic` SET `istop`= 0 WHERE `tid`=" . $postArray['tid']);
                if ($postResult > 0) {
                    die('{"result":"success","message":"取消置顶成功"}');
                } else {
                    die('{"result":"error","message":"取消置顶失败"}');
                }
            } else {
                $postResult = $this->db->affectedRows("UPDATE `". PRE ."topic` SET `istop`= 1 WHERE `tid`=" . $postArray['tid']);
                if ($postResult > 0) {
                    die('{"result":"success","message":"置顶成功"}');
                } else {
                    die('{"result":"error","message":"置顶失败"}');
                }
            }
        }
    }
    public function ban()
    {
        $this->checkPrivate();
        if (isset($_POST['uid']) && is_numeric($_POST['uid'])) {
            $postArray = array(
                'uid' => intval($_POST['uid'])
            );
            if (Common::getBanStatus($this->db, $postArray['uid']) > 0) {
                $postResult = $this->db->affectedRows("UPDATE `" . PRE . "user` SET `groupid` = 0 WHERE `uid`=" . $postArray['uid']);
                if ($postResult > 0) {
                    die('{"result":"success","message":"禁言成功","text":"解禁","groupname":"' . Common::getGroupName(0) . '","now":"0"}');
                } else {
                    die('{"result":"error","message":"禁言失败"}');
                }
            } else {
                $postResult = $this->db->affectedRows("UPDATE `" . PRE . "user` SET `groupid` = 1 WHERE `uid`=" . $postArray['uid']);
                if ($postResult > 0) {
                    die('{"result":"success","message":"解禁成功","text":"禁言","groupname":"' . Common::getGroupName(1) . '","now":"1"}');
                } else {
                    die('{"result":"error","message":"解禁失败"}');
                }
            }
        }
    }
    public function addClub()
    {
        $this->checkPrivate();
        if (isset($_POST['clubname'], $_POST['position']) && is_numeric($_POST['position'])) {
            $postArray = array(
                'clubname' => Common::text_in($_POST['clubname']),
                'position' => intval($_POST['position']),
                'schoolid' =>$_POST['schoolid'],
            );
            if (isset($_POST['cid']) && is_numeric($_POST['cid']) && Common::getCurrentclubName($this->db, intval($_POST['cid'])) != "") {
                $postResult = $this->db->affectedRows("UPDATE `" . PRE . "club` SET `clubname`='" . $postArray['clubname'] . "' , `position`='" . $postArray['position'] . "', `schoolid`='".$postArray['schoolid']."' WHERE `cid` = " . intval($_POST['cid']));
                if ($postResult > 0) {
                    die('{"result":"success","message":"修改分类成功"}');
                } else {
                    die('{"result":"error","message":"修改分类失败"}');
                }
            } else {
                $this->db->query($this->db->insert("`" . PRE . "club`", $postArray));
                $postResult = $this->db->lastInsertId();
                if ($postResult > 0) {
                    die('{"result":"success","message":"添加分类成功"}');
                } else {
                    die('{"result":"error","message":"添加分类失败"}');
                }
            }
        } else {
            die('{"result":"error","message":"请检查您的输入，分类不能为空且排序为数字"}');
        }
    }
    public function addLink()
    {
        $this->checkPrivate();
        if (isset($_POST['url'], $_POST['text'], $_POST['position']) && is_numeric($_POST['position'])) {
            $postArray  = array(
                'url' => Common::text_in($_POST['url']),
                'text' => Common::text_in($_POST['text']),
                'position' => intval($_POST['position']),
                'exist' => intval($_POST['exist'])
            );
            $LinksArray = array();
            $LinksList  = json_decode(file_get_contents("./cache/links.json"), true);
            foreach ($LinksList as $link) {
                if ($postArray['exist'] == 1 && $link['text'] == $postArray['text']) {
                    continue;
                }
                $LinksArray[$link['position']] = $link;
            }
            $LinksArray[$postArray['position']] = array(
                "url" => $postArray['url'],
                "text" => $postArray['text'],
                "position" => $postArray['position']
            );
            ksort($LinksArray);
            file_put_contents("./cache/links.json", json_encode($LinksArray));
            die('{"result":"success","message":"链接保存成功"}');
        } else {
            die('{"result":"error","message":"请检查您的输入，不能为空且排序为数字"}');
        }
    }
    public function delLink()
    {
        $this->checkPrivate();
        if (isset($_POST['position']) && is_numeric($_POST['position'])) {
            $LinksArray = array();
            $LinksList  = json_decode(file_get_contents("./cache/links.json"), true);
            foreach ($LinksList as $link) {
                if ($link['position'] == intval($_POST['position'])) {
                    continue;
                }
                $LinksArray[$link['position']] = $link;
            }
            ksort($LinksArray);
            file_put_contents("./cache/links.json", json_encode($LinksArray));
            die('{"result":"success","message":"链接删除成功"}');
        } else {
            die('{"result":"error","message":"链接不存在或参数非法"}');
        }
    }
    public function banClub()
    {
        $this->checkPrivate();
        if (isset($_POST['cid'], $_POST['position']) && is_numeric($_POST['cid']) && is_numeric($_POST['position'])) {
            $postArray = array(
                'cid' => intval($_POST['cid']),
                'position' => intval($_POST['position'])
            );
            if ($postArray['position'] > 0) {
                $postResult = $this->db->affectedRows("UPDATE `" . PRE . "club` SET `position`= 0 WHERE `cid` = " . $postArray['cid']);
                if ($postResult > 0) {
                    die('{"result":"success","message":"停用分类成功"}');
                } else {
                    die('{"result":"error","message":"停用分类失败"}');
                }
            } else {
                $postResult = $this->db->affectedRows("UPDATE `" . PRE . "club` SET `position`= 1 WHERE `cid` = " . $postArray['cid']);
                if ($postResult > 0) {
                    die('{"result":"success","message":"恢复分类成功"}');
                } else {
                    die('{"result":"error","message":"恢复分类失败"}');
                }
            }
        }
    }
    public function showquestion()
    {
        $eid = $_GET['eid'];
        $sql  = " select `".PRE."question`.* from `".PRE."question` WHERE `".PRE."question`.`Eid`='".$eid."'  ORDER BY Id ASC Limit ". (Common::Currentpage() - 1) * $this->per . "," . $this->per;
        $questionlist = $this->db->selectAll($sql);
        foreach($questionlist as $key=>$val)
        {
            $sql ="select count(*) as number from `".PRE."option` where `".PRE."option`.`EQId`=".$val['Id']."";
            $list = $this->db->selectAll($sql);
            $questionlist[$key]['options'] = $list[0]['number'];
        }
        $this->tpls->assign('eid', $eid);
        $this->tpls->assign('questionlist',$questionlist);
        $this->tpls->display('question');
    }
    public function option()
    {
        $eid = $_REQUEST['eid'];
        $eqid = $_REQUEST['eqid'];
        $flag = $_REQUEST['flag'];
        if($flag == "addOption")
        {
            $this->tpls->assign('flag', $flag);
            $this->tpls->assign('eid', $eid);
            $this->tpls->assign('eqid', $eqid);
            $this->tpls->display('question_option_dialog');
        }
        if($flag == "OpenOptionlist")
        {
            $sql = "SELECT `".PRE."option`.* FROM `".PRE."option` WHERE EId='".$eid ."' and EQId='".$eqid."'";
            $OptionList = $this->db->selectAll($sql);
            $this->tpls->assign('OptionList',$OptionList);
            $this->tpls->assign('eid', $eid);
            $this->tpls->assign('eqid', $eqid);
            $this->tpls->display('questionoption');
        }
        if($flag == "delOption")
        {
            $EQOId = $_REQUEST['eqoid'];
            $this->tpls->assign('flag', $flag);
            $this->tpls->assign('eid', $eid);
            $this->tpls->assign('eqid', $eqid);
            $this->tpls->assign('EQOId', $EQOId);
            $this->tpls->display('question_option_dialog');
        }
        if($flag == "editOption")
        {
            $EQOId = $_REQUEST['eqoid'];
            $editoption = $this->db->selectOneArray("SELECT `".PRE."option`.* FROM `".PRE."option` WHERE Id='".$EQOId."'");
            $this->tpls->assign('editoption',$editoption);
            $this->tpls->assign('flag', $flag);
            $this->tpls->assign('eid', $eid);
            $this->tpls->assign('eqid', $eqid);
            $this->tpls->assign('EQOId', $EQOId);
            $this->tpls->display('question_option_dialog');
        }
        if($flag == "Save")
        {
            $save = $_POST['save'];
            if($save == "delOption")
            {
                $this->db->query("delete from `".PRE."option` where Id='".$_POST['eqoid']."'");
                die ('{"rtn":"ok", "error_text":"删除成功"}');
            }
            $fieldList = array();
            $fieldList["Content"]		= $_POST['x_Content'];
            $fieldList["IsRight"]		= $_POST['x_IsRight'];
            $fieldList["SortId"]		= $_POST['x_SortId'];
            $fieldList["EId"]          = $_POST['eid'];
            $fieldList["EQId"]         = $_POST['eqid'];
            if($save == "addOption")
            {
                $this->db->query( $this->db->insert("`". PRE ."option`", $fieldList));
                die ('{"rtn":"ok", "error_text":"添加成功"}');
            }
            if($save == "editOption")
            {
                $this->db->query("update `".PRE."option` set `Content`='".$fieldList["Content"]."',`IsRight`='".$fieldList["IsRight"]."',`SortId`='".$fieldList["SortId"]."' where Id='".$_POST['eqoid']."'limit 1");
                die ('{"rtn":"ok", "error_text":"修改成功"}');
            }
        }
    }
    public function mexam()
    {
        $flag = $_REQUEST['falg'];
        $eid = $_REQUEST['eid'];
        $eqid = $_REQUEST['eqid'];
        if($flag == "addQuestion")
        {


        }
        if($flag == "editQuestion")
        {
            //$exam = $this->db->selectOneArray("SELECT `".PRE."exam`.* FROM `".PRE."exam` WHERE Id");

        }
        if($flag == "delQuestion")
        {

        }
        if($flag == "save")
        {


        }
    }
    public function trash()
    {
        if (isset($_POST['tid']) && is_numeric($_POST['tid'])) {
            $postInfo = $this->db->selectOneArray("SELECT `tid`,`uid`,`pictures`,`comments` FROM `" . PRE . "topic` WHERE `tid`='" . intval($_POST['tid']) . "'");
            if( $this->loginInfo['group'] < 8 && $postInfo['uid'] != $this->loginInfo['uid'] ) {
                die('{"result":"error","message":"您没有权限执行此操作"}');
            }
            if (!empty($postInfo['tid'])) {
                $this->db->query("DELETE FROM `" . PRE . "topic` WHERE `tid`=" . $postInfo['tid']);
                if (!empty($postInfo['pictures'])) {
                    $deletePics = Image::getImageURL($postInfo['pictures']);
                    foreach ($deletePics as $deletePic) {
                        Common::deletePicture($deletePic);
                    }
                }
                if ($postInfo['comments'] > 0) {
                    $Result = $this->db->query("SELECT `pictures` FROM `" . PRE . "reply` WHERE `tid`=" . $postInfo['tid']);
                    while ($Re = $this->db->fetchArray($Result)) {
                        if (!empty($Re['pictures'])) {
                            $deletePics = Image::getImageURL($Re['pictures']);
                            foreach ($deletePics as $deletePic) {
                                Common::deletePicture($deletePic);
                            }
                        }
                    }
                }
                $this->db->query("DELETE FROM `" . PRE . "reply` WHERE `tid`=" . $postInfo['tid']);
                $this->db->query("DELETE FROM `" . PRE . "commend` WHERE `tid`=" . $postInfo['tid']);
                $this->db->query("DELETE FROM `" . PRE . "favorite` WHERE `tid`=" . $postInfo['tid']);
                $this->db->query("DELETE FROM `" . PRE . "notification` WHERE `tid`=" . $postInfo['tid']);
                Common::updateUserMoney($this->db, $postInfo['uid'], - $GLOBALS['balance_config']['change']['topic'], 5);
                die('{"result":"success","message":"删除成功"}');
            } else {
                die('{"result":"error","message":"删除失败"}');
            }
        }
    }
    public function delReply()
    {
        $this->checkPrivate();
        if (isset($_POST['pid']) && is_numeric($_POST['pid'])) {
            $postInfo = $this->db->selectOneArray("SELECT `pid`, `tid`, `uid`, `pictures` FROM `" . PRE . "reply` WHERE `pid`='" . intval($_POST['pid']) . "'");
            if (!empty($postInfo['pid'])) {
                $this->db->query("DELETE FROM `" . PRE . "reply` WHERE `pid`=" . $postInfo['pid']);
                if (!empty($postInfo['pictures'])) {
                    $deletePics = Image::getImageURL($postInfo['pictures']);
                    foreach ($deletePics as $deletePic) {
                        Common::deletePicture($deletePic);
                    }
                }
                $updateArray = array(
                    'comments' => array(
                        "`comments`-1"
                    )
                );
                $this->db->query($this->db->update("`" . PRE . "topic`", $updateArray, "`tid`='" . $postInfo['tid'] . "'"));
                $this->db->query("DELETE FROM `" . PRE . "notification` WHERE `pid`='" . $postInfo['pid'] . "'");
                Common::updateUserMoney($this->db, $postInfo['uid'], - $GLOBALS['balance_config']['change']['reply'], 6);
                die('{"result":"success","message":"删除回复成功"}');
            } else {
                die('{"result":"error","message":"删除回复失败"}');
            }
        }
    }
    public function moveTopic()
    {
        $this->checkPrivate();
        if(isset($_POST['cid'], $_POST['tid']) && is_numeric($_POST['cid']) && is_numeric($_POST['tid'])) {
            $updateArray = array(
                'cid' => intval($_POST['cid'])
            );
            $this->db->query($this->db->update("`" . PRE . "topic`", $updateArray, "`tid`='" . intval($_POST['tid']) . "'"));
            die('{"result":"success","message":"移动分组成功"}');
        } else {
            die('{"result":"error","message":"移动分组失败"}');
        }
    }
    public function ClearCache()
    {
        $this->checkPrivate();
        switch (Common::text_in($_POST['do'])) {
            case 'template':
                $this->tpls->Clean($this->tpls->cache_dir);
                $this->tpls->Clean($this->tpls->cache_dir . 'mobile/');
                die('{"result":"success","message":"模版缓存清理成功"}');
                break;
            case 'data':
                break;
            default:
                $this->tpls->Clean($this->tpls->cache_dir);
                die('{"result":"success","message":"模版缓存清理成功"}');
                break;
        }
    }
    private function checkPrivate()
    {
        if ($this->loginInfo['group'] < 8) {
            die('{"result":"error","message":"您没有权限执行此操作"}');
        }
    }
}
?>