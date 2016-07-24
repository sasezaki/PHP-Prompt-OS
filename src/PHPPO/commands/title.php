<?php
//////////////////////
namespace phppo\command\defaults;
use phppo\system\systemProcessing as systemProcessing;
include_once(dirname(__FILE__) . "/../system/System.php");
include_once dirname(__FILE__) . "/../command/AddCommand.php";
$addcom = new addcommand;
$addcom->addcommand("title","default","システムのタイトルを設定します。","");
//////////////////////
/**
 *
 */
class title_command extends systemProcessing{

	function __construct()
	{
		# code...
	}
	public function onCommand()
	{
		global $aryTipeTxt;
		$messageCount = "";
			$messageCount = count($aryTipeTxt);
			if ($messageCount <= 1) {
				$this->sendMessage("パラメーターが不足しています。");
return false;
				}else{
					$aryTipeTxt[1] = trim($aryTipeTxt[1]);
					$message = '';
					for ($i=1; $i < $messageCount; $i++) {
						$message .= $aryTipeTxt[$i] . " ";
					}
					cli_set_process_title($message);
				}
	}
}

?>
