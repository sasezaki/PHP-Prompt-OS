<?php
//////////////////////
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("unlink","default","ファイルを削除します。","<パス>");
//////////////////////
class unlink_command extends systemProcessing{
	function __construct(){

	}
	public function onCommand(){
		global $raw_input;
		global $currentdirectory;
		global $aryTipeTxt;
		$path = $currentdirectory . "\\" . substr($raw_input,6);
		if ($aryTipeTxt[1] == "") {
			$this->sendMessage("パラメーターが不足しています。");
return false;
			return false;
		}else{
			if (file_exists($path)) {
				$ask = $this->sendMessage("指定したファイルを削除します。よろしいですか？(y):","input");
				if ($ask == "y"||$ask == "Y") {
					unlink($path);
					$this->sendMessage("ファイルを削除しました。:{$path}");
				}
			}else {
				$this->sendMessage("指定したファイルまたはディレクトリは存在しません。","error");
				return false;
			}
		}
	}
}


?>
