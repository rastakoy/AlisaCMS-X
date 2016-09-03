<?php
class Email extends DatabaseInterface{

	/**
	
	*/
	function sendEmail($to,$from_mail,$from_name,$subject,$mess,$file_names=false) {
		global $site;
		$site_m = preg_replace("/^http:\/\//", "", $site);
		$site_m = preg_replace("/^www\./", "", $site_m);
		$site_m = preg_replace("/\..*$/", "", $site_m);
		
		$bound = "--zagadum.com"."-".time();
		$message  = "";
		
		$message .= "--$bound\n";
		$message .= "Content-type: text/html; charset=\"windows-1251\"  Content-Transfer-Encoding: 8bit\n\n";
		$message .= "$mess<br/>\n";
		$message .="--$bound\n\n";
		
		if(is_array($file_names)){
			foreach($file_names as $key=>$file_name){
				$file_name = trim($file_name);
				$message .= "\n--$bound\n";
				$file=fopen($file_name,"rb");
				$message .="Content-Type: application/octet-stream;";
				$message .="name=".basename($file_name)."\n";
				$message .="Content-Transfer-Encoding:base64\n";
				$message .="Content-Disposition:attachment\n\n";
				$amess = chunk_split(base64_encode(fread($file,filesize($file_name))));
				//file_put_contents("test_error.txt", $amess);
				$message .=$amess."\n";
			}
		}
		//if(is_array($file_names)){
			//$message .="$bound--\n\n";
		//}
		//****************************
		$headers   =  "MIME-Version: 1.0\n";
		$headers  .=  "X-Mailer: lenda-dekor-post\n"; 
		$headers  .=  "From: $from_name<$from_mail>\n";
		//$headers  .=  "Subject: =?windows-1251?Q?-->$subject?= \n";
		$headers  .=  "Content-Type: multipart/mixed; boundary=\"$bound\"\n";
		
		if(mail("$to", $subject, $message, $headers) ) {
			return true;
		} else {
			return false;
		}
		//****************************
		//mail("info@frukt-studio.biz", "$subject", $message, $headers);
	}
	
}
?>