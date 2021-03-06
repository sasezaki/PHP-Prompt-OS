<?php
//////////////////////
namespace phppo\command\defaults;
use phppo\system\systemProcessing as systemProcessing;
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("reboot","default","PHPPOを再起動します。","<mode>");
//////////////////////
class reboot_command extends systemProcessing{
	function __construct(){

	}
	public function onCommand(){
		global $aryTipeTxt;
		global $writeData;
		$this->sysCls(100);
		$this->info("PHP Prompt OS を再起動します。");
		$this->info("This window will be closed when the top of the thread has been completed");
		if (isset($aryTipeTxt[1])) {
			exec("start.cmd");
		}else {
			exec("start.cmd");
		}
		exit;
	}
}


?>
