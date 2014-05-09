<?php
//POST受ける
if($_POST){
	require_once 'File_Format_Iaf.php';

	//zipする
	$zip = new ZipArchive();
	$zipname = 'iaf.zip';
	
	if(file_exists('./'.$zipname)){
		unlink('./'.$zipname);
	} else {
		$zip->open('./'.$zipname, ZipArchive::CREATE);
	}
	
	$domain = $_POST['domain'];
	$pop = 'pop3.'.$_POST['domain'];
	$smtp = 'smtp.'.$_POST['domain'];
	
	//アカウント一覧の配列化
	$accounts = $_POST['account'];
	$br = array("\r\n", "\r");
	
	$accounts = trim($accounts);
	$accounts = str_replace($br, "\n", $accounts);
	$accounts_arr = explode("\n", $accounts);
	
	
	
	//ループ
	foreach($accounts_arr as $val){
		$iaf = new File_Format_Iaf();
		$item = explode(',',$val);
		
		$email = $item[0].'@'.$domain;
		
		$iaf->AccountName  = $email;
		
		
		$iaf->POP3Server = $pop;
		$iaf->POP3SecureConnection = 0;
		$iaf->POP3LeaveMailOnServer = 0;
		$iaf->POP3SkipAccount = 0;
		$iaf->POP3PasswordPrompt = 0;
		$iaf->POP3UserName = $item[1];
		$iaf->POP3Password = $item[2];

		$iaf->SMTPAuthMethod = 2;
		$iaf->SMTPPort = 587;
		$iaf->SMTPSecureConnection = 0;
		$iaf->SMTPDisplayName = $email;
		$iaf->SMTPEmailAddress = $email;
		$iaf->SMTPServer = $smtp;
		$iaf->SMTPPasswordPrompt = 0;
		
		$zip->addFromString($email.'.iaf',$iaf->render());
	}
	$zip->close();
	
	header('Content-Type: application/zip; name="'.$zipname.'"');
	header('Content-Disposition: attachment; filename="' . $zipname . '"');
	header('Content-Length: '.filesize($zipname));
	
	echo file_get_contents($zipname);

	unlink('./'.$zipname);
	exit();
	
}


?>