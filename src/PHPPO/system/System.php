<?php
include_once dirname(__FILE__) . '/../display/display.php';
include_once dirname(__FILE__) . '/../system/environmentValues.php';

class systemProcessing {
	private static function add_zip( $zip, $dir_path, $new_dir )
	{
		if( ! is_dir( $new_dir ) ){
			$zip->addEmptyDir( $new_dir );
		}

		foreach( self::get_inner_path_of_directory( $dir_path ) as $file ){
			if( is_dir( $dir_path . "/" . $file ) ){
				self::add_zip( $zip, $dir_path . "/" . $file, $new_dir . "/" . $file );
			}
			else{
				$zip->addFile( $dir_path . "/" . $file, $new_dir . "/" . $file );
			}
		}
	}
	public static function all_zip( $dir_path, $new_dir ){
		$zip = new ZipArchive();
		if( $zip->open( $new_dir, ZipArchive::OVERWRITE ) === true ){
			self::add_zip( $zip, $dir_path, "" );
			$zip->close();
		}
		else{
			throw new Exception('It does not make a zip file');
		}
	}
	// public function showCsv($fname){
	//   $f = @fopen($fname,'rb') or $this->sendMessage("※ファイルを開く際にエラーが発生しました。");
	//   while(!feof($f)) $GLOBALS['/*ここ*/'] = something;fgetcsv($f,1024);
	//   fclose($f);
	// }

	public function systemFileOpen($path)
	{
		global $writeData;
		$writeData = fopen($path,'a');
	}

	public function systemFileClose()
	{
		global $writeData;
		fclose($writeData);
	}

	public function sysCls($res){
		global $revcFunc;
		for($i = 0; $i < $res;$i++){
		  	if ($revcFunc == true) {
		  		echo "                                                                                                                                                     ";
				echo PHP_EOL;
		  	}else {
		  		echo PHP_EOL;
		  	}
	  	}
	}
	public function sendMessage($pr_disp){
	  global $pr_TipeTxt;
	  global $pr_thread;
	  global $pr_info;
	  global $pr_time;
	  global $prompt;
	  global $writeData;
	  global $stanby;
	  global $logMode;
	  global $tipe_text;
	  global $echoFunc;
	  date_default_timezone_set('Asia/Tokyo');
	  $pr_time = date('A-H:i:s');
	  if ($echoFunc != "off") {
		  switch ($pr_info) {
			case 'ERROR':
				$prompt = "\x1b[38;5;83m" . "[{$pr_time}]" . "\x1b[38;5;87m " . "[{$pr_thread} Thread/{$pr_info}]" . "\x1b[38;5;203m ";
				break;
			default:
				$prompt = "\x1b[38;5;83m" . "[{$pr_time}]" . "\x1b[38;5;87m " . "[{$pr_thread} Thread/{$pr_info}]" . "\x1b[38;5;231m ";
				break;
		  }
	  }else {
		switch ($pr_info) {
			case 'ERROR':
				$prompt = "\x1b[38;5;203m";
				break;
			default:
				$prompt = "\x1b[38;5;231m";
				break;
		}
	  }
	  echo "{$prompt}{$pr_disp}\n";
	  ///ログを吐く
	  if ($logMode == "on") {
		  if (isset($writeData)){
			if ($stanby) {

			}else{
				fwrite($writeData,"{$prompt} {$pr_disp}" . PHP_EOL);
			}
		  }
	  }
	}
}

/**
 *
 */
class myPhar extends systemProcessing{

	function __construct(){
		# code...
	}
	public function compose($dir,$phar_name){

		$fileclass = new fileProcessing;
		$result = $fileclass->list_files($dir);
		var_dump($result);
		foreach ($result as $path) {
			$this->sendMessage("ファイルをスキャン中... : $path");
		}
		$pharfilepath = rtrim(dirname(__FILE__),"commands\src\PHPPO") . "\\" . "$phar_name.phar";
		$phar = new Phar($pharfilepath, 0);
		if (!file_exists($pharfilepath)) {
			$this->sendMessage("pharファイルを生成しています。:" . $pharfilepath);
			touch($pharfilepath);
			$this->sendMessage("pharファイルを生成しました。:" . $pharfilepath);
		}
		chmod( $pharfilepath, 0666 );
		foreach ($result as $path) {
			$this->sendMessage("ファイルを追加しています... : $path");
			$phar->addFile($path);
		}
		$this->sendMessage("pharを作成しました。 : $pharfilepath");
	}
}



/**
 *
 */
class fileProcessing extends systemProcessing{

	function __construct()
	{
		# code...
	}
	public function list_files($dir){
		$list = array();
		$files = scandir($dir);
		foreach($files as $file){
			if($file == '.' || $file == '..'){
				continue;
			} else if (is_file($dir . $file)){
				$list[] = $dir . $file;
			} else if( is_dir($dir . $file) ) {
				//$list[] = $dir;
				$list = array_merge($list, list_files($dir . $file . DIRECTORY_SEPARATOR));
			}
		}
	return $list;
	}
}