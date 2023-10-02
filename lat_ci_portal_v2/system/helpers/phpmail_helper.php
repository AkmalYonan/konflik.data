<?
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function sendmail($to,$subject,$body,$is_gmail = true,$from=false,$from_name=false) { 
	global $error;
    //print GUSER;
    //print GPWD;
    
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPAuth = true; 
	if ($is_gmail) {
		$mail->SMTPSecure = 'ssl'; 
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 465;  
		$mail->Username = GUSER;  
		$mail->Password = GPWD;   
	} else {
		$mail->Host = SMTPSERVER;
		$mail->Username = SMTPUSER;  
		$mail->Password = SMTPPWD;
	}        
	//$mail->SetFrom($from, $from_name);
	if(!$from):
		$mail->From=EMAIL_FROM;
		$mail->FromName=EMAIL_FROM_NAME;
	else:
		$mail->SetFrom($from, $from_name);
	endif;
	
	$mail->Subject = $subject;
	
	//set recipient
	if((count($to)>0)&&(is_array($to)==true)):
		foreach($to as $key => $val):
			$mail->AddAddress($key , $val);
		endforeach;
	else:
		$mail->AddAddress($to);
	endif;
	
	//$mail->AltBody = strip_tags($body);
	//$mail->MsgHTML($body);
	
	//same as above
	
	$mail->Body=$body;
	$mail->AltBody = strip_tags($body);
	$mail->isHTML(true);
	
	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo;
		return false;
	} else {
		$error = 'Message sent!';
		return true;
	}
}

function send_mail($to,$subject,$body,$is_gmail = true,$from=false,$from_name=false) { 
	global $error;
    //print GUSER;
    //print GPWD;
    
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPAuth = true; 
	if ($is_gmail) {
		$mail->SMTPSecure = 'ssl'; 
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 465;  
		$mail->Username = GUSER;  
		$mail->Password = GPWD;   
	} else {
		$mail->Host = SMTPSERVER;
		$mail->Username = SMTPUSER;  
		$mail->Password = SMTPPWD;
	}        
	//$mail->SetFrom($from, $from_name);
	if(!$from):
		$mail->From=EMAIL_FROM;
		$mail->FromName=EMAIL_FROM_NAME;
	else:
		$mail->SetFrom($from, $from_name);
	endif;
	
	$mail->Subject = $subject;
	
	//set recipient
	if((count($to)>0)&&(is_array($to)==true)):
		foreach($to as $key => $val):
			$mail->AddAddress($key , $val);
		endforeach;
	else:
		$mail->AddAddress($to);
	endif;
	
	//$mail->AltBody = strip_tags($body);
	//$mail->MsgHTML($body);
	
	//same as above
	
	$mail->Body=$body;
	$mail->AltBody = strip_tags($body);
	$mail->isHTML(true);
	
	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo;
		return false;
	} else {
		$error = 'Message sent!';
		return true;
	}
}


/*
function sendmailHTML($to,$to_name=false, $from, $from_name, $subject, $body, $is_gmail = true) { 
	global $error;
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPAuth = true; 
	if ($is_gmail) {
		$mail->SMTPSecure = 'ssl'; 
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 465;  
		$mail->Username = GUSER;  
		$mail->Password = GPWD;   
	} else {
		$mail->Host = SMTPSERVER;
		$mail->Username = SMTPUSER;  
		$mail->Password = SMTPPWD;
	}        
	$mail->SetFrom($from, $from_name);
	$mail->Subject = $subject;
	
	$mail->Body=$body;
	$mail->AltBody = strip_tags($body);
	//$mail->MsgHTML($body);
	//same as above with other script
	$mail->isHTML(true);
	
	foreach($to as $key => $val):
        $mail->AddAddress($val , $key);
    endif;
	
	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo;
		return false;
	} else {
		$error = 'Message sent!';
		return true;
	}
}

function sendmailToGroup($to,$from,$subject, $body, $is_gmail = true) { 
	global $error;
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPAuth = true; 
	if ($is_gmail) {
		$mail->SMTPSecure = 'ssl'; 
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 465;  
		$mail->Username = GUSER;  
		$mail->Password = GPWD;   
	} else {
		$mail->Host = SMTPSERVER;
		$mail->Username = SMTPUSER;  
		$mail->Password = SMTPPWD;
	}        
	$mail->From($from);
	$mail->FromName("Admin System OIKB");
	
	$mail->Subject = $subject;
	$mail->Body=$body;
	$mail->AltBody = strip_tags($body);
	//$mail->MsgHTML($body);
	//same as above with other script
	$mail->isHTML(true);
	
	foreach($to as $key => $val):
        $mail->AddAddress($val , $key);
    endif;
	
	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo;
		return false;
	} else {
		$error = 'Message sent!';
		return true;
	}
}
*/

function parse_email($input){
	//$in = 'test( test1@test2.com );"Another, Test" <1another@test1.com>, .........';
	$in=$input;
	preg_match_all('/[\,\;\s]?["]?(.*?)["]?\s?<*\(*\s*([\w]+@[\w]+.[\w]{2,3})\s*\)*>*/', $in, $matches);
	
	$out = array();
	for ($i=0; $i<count($matches[0]); $i++) {
	  $out[] = array(
		'name' => $matches[1][$i],
		'email' => $matches[2][$i],
	  );
	}
	if(cek_array($out)==true):
		foreach($out as $x=>$val):
			$data[$val["email"]]=$val["name"];
		endforeach;
	else:
		$data=FALSE;
	endif;
	
	return $data;
}

?>