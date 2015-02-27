<?php
class Upload
{
    public static function upload_file($array, $condition = 0)
    {
        $filename                = $array['filename'];
        $allow_uploadedfile_type = $array['allow_uploadedfile_type'];
        $upload_file_size        = $array['upload_file_size'];
        $allow_uploaded_maxsize  = $array['allow_uploaded_maxsize'];
        $upload_target_dir       = $array['upload_target_dir'];
        $upload_tmp_name         = $array['upload_tmp_name'];
        $upload_filetype         = self::getFileExt($filename);
        if (in_array($upload_filetype, $allow_uploadedfile_type)) {
            if ($upload_file_size < $allow_uploaded_maxsize) {
                if (!is_dir($upload_target_dir)) {
                    $array_path = explode("/", $upload_target_dir);
                    $_path      = "";
                    for ($i = 0; $i < count($array_path); $i++) {
                        $_path .= $array_path[$i] . "/";
                        if ($array_path[$i] != "" && !file_exists($_path)) {
                            mkdir($_path, 0777);
                        }
                    }
                }
                if ($condition == 1) {
                    $upload_final_name = '100.png';
                } else {
                    $upload_final_name = md5(date("YmdHis") . rand(0, 100)) . '.' . $upload_filetype;
                }
                $upload_target_path = $upload_target_dir . "/" . $upload_final_name;
                if (!move_uploaded_file($upload_tmp_name, $upload_target_path)) {
                    return "1";
                } else {
                    return $upload_target_path;
                }
            } else {
                return "2";
            }
        } else {
            return "3";
        }
    }
    public static function getFileExt($filename)
    {
        $info = pathinfo($filename);
        return strtolower($info["extension"]);
    }
}
?>