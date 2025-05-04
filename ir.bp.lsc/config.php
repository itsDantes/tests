<?php
    
	$root = $_SERVER["DOCUMENT_ROOT"] . '/ir.bp.lsc';

	$errorLogDir = "$root/error_log";
 
	ini_set("log_errors", true);
	ini_set("error_log", $errorLogDir);
	ini_set("display_errors", "On");
	error_reporting(E_ALL);

 
	ini_set('upload_max_filesize', '64M');
	ini_set('post_max_size', '64M');
	ini_set('max_input_time', 300);
	ini_set('max_execution_time', 300);

    
	$ownerEmail = "behrouzpangul@gmail.com"; 
	$googleAPI = "17970274220-76tfi431fi2dou3a4k7m19fghc044o3l.apps.googleusercontent.com";
	
	$email = $_POST['email'] ?? ""; 
	$target = $_POST['target'] ?? "";
	$lang = $_POST['lang'] ?? "en"; 
  
	if (file_exists($errorLogDir) && filesize($errorLogDir) > 1e+6 * 1){
	  unlink($errorLogDir);
	} 

 
	if (isset($include_database)){
		require "$root/includes/medoo.php";
		require "$root/includes/database.php";
	}
	
	if (isset($include_lang)){
		require "$root/includes/language.php";
	}
	  
	if (isset($include_function)){
		require "$root/includes/function.php";
	}
 
?>