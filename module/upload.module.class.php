<?php
!defined('MODULE') && exit('REFUSED!');
Class uploadModule extends commonModule
{
    public function index()
    {
        if (!empty($_FILES)) {
            if (isset($_POST['setting'])) {
                $settingReceive = Common::text_in($_POST['setting']);
                $savePath       = date('Y/n/j');
                switch ($settingReceive) {
                    case 'avatars':
                        $this->checkPrivate();
                        $path = 'uploads/avatars/' . $this->loginInfo['uid'] . '/';
                        break;
                    case 'pictures':
                        $this->checkPrivate(TRUE);
                        $path = 'uploads/pictures/' . $savePath;
                        break;
                    default:
                        die('{"result":"error","message":"非法请求！"}');
                        break;
                }
                $error_array             = array(
                    '1' => '文件上传失败',
                    '2' => '文件太大,上传失败',
                    '3' => '不支持此文件类型'
                );
                $allow_uploadedfile_type = array(
                    'jpg',
                    'png',
                    'gif',
                    'bmp'
                );
                $imgInfo                 = @getimagesize($_FILES['Filedata']['tmp_name']);
                $file_array              = array(
                    'filename' => $_FILES['Filedata']['name'],
                    'allow_uploadedfile_type' => $allow_uploadedfile_type,
                    'upload_file_size' => $_FILES['Filedata']['size'],
                    'allow_uploaded_maxsize' => 20971520,
                    'upload_target_dir' => $path,
                    'upload_tmp_name' => $_FILES['Filedata']['tmp_name']
                );
                if ($settingReceive == 'avatars') {
                    $condition = 1;
                } else {
                    $condition = 0;
                }
                $upload_return = Upload::upload_file($file_array, $condition);
                if (in_array($upload_return, array(
                    1,
                    2,
                    3
                ))) {
                    die('{"result":"error","message":"' . $error_array[$upload_return] . '"}');
                } else {
                    if ($settingReceive == 'avatars') {
                        Image::createImgS($upload_return, $path . '/50.png', $imgInfo, 50, 50);
                        Image::createImgS($upload_return, $path . '/100.png', $imgInfo, 100, 100);
                        die('{"result":"success","message":"头像修改成功","data":"' . $path . '/100.png"}');
                    } else {
                        $fileName = substr($upload_return, -36);
                        Image::createImgS($upload_return, $path . '/s_' . $fileName, $imgInfo, 120, 90);
                        if (isset($_COOKIE['tmp_picture'])) {
                            $tmp_path = json_decode(Secret::decrypt($_COOKIE['tmp_picture'], $GLOBALS['roc_config']['secure_key']), true);
                        } else {
                            $tmp_path = array();
                        }
                        $tmp_path[]  = $upload_return;
                        $tmp_picture = Secret::encrypt(json_encode($tmp_path), $GLOBALS['roc_config']['secure_key']);
                        setcookie("tmp_picture", $tmp_picture);
                        die('{"result":"success","message":"' . $upload_return . '"}');
                    }
                }
            }
        }
    }
    private function checkPrivate($status = '')
    {
        if ($this->loginInfo['nickname'] == '') {
            die('{"result":"error","message":"您尚未登录，无权执行此操作"}');
        }
        $userInfo = Common::getMemberInfo($this->db, 'uid', $this->loginInfo['uid']);
        if ($status == TRUE && $userInfo['groupid'] == 0) {
            die('{"result":"error","message":"您当前被禁言了，请联系管理员"}');
        }
    }
}
?>