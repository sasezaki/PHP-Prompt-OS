<?php
/**
 *
 */
class addcommand extends systemProcessing{

	function __construct(){
		# code...
	}
	public function FunctionName($value='')
	{
		# code...
	}
	public function addcommand($basecommand,$type,$des,$usage,$enadis='enable'){
		global $commands;
		global $br_count;
		global $strlen;
		$br_count = "a";
		// array_push($commands,$basecommand);
		$commands[$basecommand] = array('type' => $type, 'des' => $des, 'usage' => $usage, 'enadis'=> $enadis);
		// usleep(rand(1000,10000));///演出
		if ($br_count == "a") {
			echo("\x1b[38;5;214m{$basecommand} ");
			$br_count = "b";
		}else {
			if ($br_count == "b") {
				echo("\x1b[38;5;214m{$basecommand} \n");
				$br_count = "a";
			}
		}
	}
}


?>
