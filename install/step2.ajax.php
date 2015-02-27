<?php
function deaddslashes(&$str) {
	if (is_array($str))
		foreach ($str as $key => $v)
			deaddslashes($str[$key]);
	elseif (is_string($str))
		$str = stripslashes($str);
}

if (get_magic_quotes_gpc())	{
	deaddslashes($_GET);
	deaddslashes($_POST);
	deaddslashes($_COOKIE);
	deaddslashes($_REQUEST);
}

function folderCanWrite($path) {
	$fPath=$path.'/testtestfiliant.txt';
	$dPath=$path.'/testtestfiliantfolder';
	if($fp=@fopen($fPath,'w')) {
		if(@is_writable($fPath)) {
			if(!@fwrite($fp,'test')) {
				@fclose($fp);
				@unlink($fPath);
				return false;
			} else {
				@fclose($fp);
				@unlink($fPath);
			}
		} else {
			@fclose($fp);
			@unlink($fPath);
			return false;
		}
		//folder
		$mydir = dir($path);
		while ($file = $mydir->read()) {
			if((is_dir($path.'/'.$file)) && ($file!='.') && ($file!='..')) {
				if($fp = @fopen($path.'/'.$file.'/testtestfiliant.txt','w')) {
					if(@is_writable($path.'/'.$file.'/testtestfiliant.txt')) {
						if(!@fwrite($fp,'test')) {
							@fclose($fp);
							@unlink($path.'/'.$file.'/testtestfiliant.txt');
							$mydir->close(); 
							return false;
						} else {
							@fclose($fp);
							@unlink($path.'/'.$file.'/testtestfiliant.txt');
							break;
						}
					} else {
						@fclose($fp);
						@unlink($path.'/'.$file.'/testtestfiliant.txt');
						$mydir->close();
						return false;
					}
				} else {
					$mydir->close();
					return false;
				}
			}
		}
		$mydir->close();
		return true;
	} else
		return false;
}

if(!is_file('install.lock')) {
	if($_POST['ac'] == 'JSON Support') {
		if(function_exists('json_encode')) {
			echo json_encode(array(
				'result' => '1',
				'msg' => 'OK<br />'
			));
		} else {
			echo '{"result":"0","msg":"NO<br />不支持 json_encode 函数。<br />"}';
		}
	} else if($_POST['ac'] == 'PHP_VERSION') {
		if(version_compare(PHP_VERSION,'5.0','>=')) {
			echo json_encode(array(
				'result' => '1',
				'msg' => PHP_VERSION . '...OK<br />'
			));
		} else {
			echo json_encode(array(
				'result' => '0',
				'msg' => PHP_VERSION . '...NO<br />PHP 版本太低，至少要 5.0。<br />'
			));
		}
	} else if($_POST['ac'] == 'MySQLi Support') {
		if(class_exists('mysqli')) {
			echo json_encode(array('result' => '1','msg' => 'OK<br />'));
		} else {
			echo json_encode(array('result' => '0','msg' => 'NO<br />必须开启 MySQLi 扩展支持才可继续。<br />'));
		}
	} else if($_POST['ac'] == 'mysql_connect Support') {
		if(function_exists('mysql_connect')) {
			echo json_encode(array('result' => '1','msg' => 'OK<br />'));
		} else {
			echo json_encode(array('result' => '0','msg' => 'NO<br />必须开启 MySQL 扩展支持才可继续。<br />'));
		}
	} else if($_POST['ac'] == 'file_get_contents Support') {
		if(function_exists('file_get_contents')) {
			echo json_encode(array('result' => '1','msg' => 'OK<br />'));
		} else {
			echo json_encode(array('result' => '0','msg' => 'NO<br />必须开启 file_get_contents 支持才可继续。<br />'));
		}
	} else if($_POST['ac'] == 'CURL Support') {
		if(function_exists('curl_init')) {
			echo json_encode(array('result' => '1','msg' => 'OK<br />'));
		} else {
			echo json_encode(array('result' => '0','msg' => 'NO<br />必须开启 CURL 扩展支持才可继续。<br />'));
		}
	} else if($_POST['ac'] == 'Write test of "cache" folder') {
		if(folderCanWrite('../cache')) {
			echo json_encode(array('result' => '1','msg' => 'OK<br />'));
		} else {
			echo json_encode(array('result' => '0','msg' => 'NO<br />请将 cache 目录权限设置为 0777。<br />'));
		}
	}else if($_POST['ac'] == 'Write test of "uploads" folder') {
		if(folderCanWrite('../uploads')) {
			echo json_encode(array('result' => '1','msg' => 'OK<br />'));
		} else {
			echo json_encode(array('result' => '0','msg' => 'NO<br />请将 uploads 目录权限设置为 0777。<br />'));
		}
	} else if($_POST['ac'] == 'Write test of "install" folder') {
		if(folderCanWrite('../install')) {
			echo json_encode(array('result' => '1','msg' => 'OK<br />'));
		} else {
			echo json_encode(array('result' => '0','msg' => 'NO<br />请将 install 目录权限设置为 0777。<br />'));
		}
	}
}

