<?php
class Controller extends DatabaseInterface{

	/**
	
	*/
	function initController(){
		$classNotices = new Notices();
		$admin = new Admin();
		$classMenuSettings = new MenuSettings();
		$classSettings = new Settings();
		$classSettings->parseSettings();
		$classDate = new Date();
		$classEmail = new Email();
		//***************************
		
		//ѕолучение контрольной даты
		$controlDate =  date("Y-m-d H:i:s");
		//***************************
		
		//”даление временных объ€влений
		$q = "SELECT * FROM `notices` WHERE `tmp`='1' AND `folder`='0' ";
		$query = $this->query($q);
		while($notice=$query->fetch_assoc()){
			$endDate = $classDate->transforDate($notice['addDate'], array("minute"=>$GLOBALS['tempNotice']));
			echo $notice['addDate']." Ч ".$endDate." Ч ".$controlDate."<br/>";
			if($controlDate>$endDate){
				echo "ќбъ€вление уничтожаетс€<br/>";
				$classMenuSettings->deleteOption('notices', $notice['id']);
			}else{
				echo "ќбъ€вление сохран€етс€<br/>";
			}
		}
		//***************************
		
		//”даление просроченных объ€влений
		$q = "SELECT * FROM `notices` WHERE `tmp`='0' AND `folder`='0' ";
		$query = $this->query($q);
		while($notice=$query->fetch_assoc()){
			$endDate = $classDate->transforDate($notice['addDate'], array("day"=>$GLOBALS['keepNotice']));
			echo $notice['addDate']." Ч ".$endDate." Ч ".$controlDate."<br/>";
			if($controlDate>$endDate){
				echo "ќбъ€вление уничтожаетс€ (просрочено)<br/>";
				//$classMenuSettings->deleteOption('notices', $notice['id']);
			}else{
				echo "ќбъ€вление не просрочено<br/>";
			}
		}
		//***************************
		
		//”ведомлени€ клиентов о завершении срока объ€влени€
		$q = "SELECT * FROM `notices` WHERE `tmp`='0' AND `folder`='0' AND `sender`='0' ";
		$query = $this->query($q);
		while($notice=$query->fetch_assoc()){
			$endDate = $classDate->transforDate($notice['addDate'], array("day"=>$GLOBALS['keepNotice']-$GLOBALS['warning']));
			echo $notice['addDate']." Ч ".$endDate." Ч ".$controlDate."<br/>";
			if($controlDate>$endDate){
				$text  = "«дравствуйте, $array[noticeUserName]<br/><br/>";
				$text .= "«аканчиваетс€ срок действи€ вашего объ€влени€ на доске ".$GLOBALS['site']."<br/>";
				$text .= "ƒл€ продлени€ объ€влени€ перейдите по этой ссылке:<br/>";
				$href = $GLOBALS['site']."rus/confirm/$notice[hash]/";
				$text .= "<a href=\"$href\">”правление объ€влением</a><br/><br/>";
				$text .= "—пасибо за использование нашего ресурса.";
				$classEmail->sendEmail($notice['noticeEmail'],"robot@board.beststart.info",
				$notice['noticeUserName'],"ѕродление объ€влени€",$text);
				echo $text;
				$admin->updateDBRecord('notices', 'sender', '1', $notice['id']);
			}else{
				echo "ќтлсылка не происходит<br/>";
			}
		}
		//***************************
	}
	
}
?>