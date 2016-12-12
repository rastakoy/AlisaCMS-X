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
		
		//��������� ����������� ����
		$controlDate =  date("Y-m-d H:i:s");
		//***************************
		
		//�������� ��������� ����������
		$q = "SELECT * FROM `notices` WHERE `tmp`='1' AND `folder`='0' ";
		$query = $this->query($q);
		while($notice=$query->fetch_assoc()){
			$endDate = $classDate->transforDate($notice['addDate'], array("minute"=>$GLOBALS['tempNotice']));
			echo $notice['addDate']." � ".$endDate." � ".$controlDate."<br/>";
			if($controlDate>$endDate){
				echo "���������� ������������<br/>";
				$classMenuSettings->deleteOption('notices', $notice['id']);
			}else{
				echo "���������� �����������<br/>";
			}
		}
		//***************************
		
		//�������� ������������ ����������
		$q = "SELECT * FROM `notices` WHERE `tmp`='0' AND `folder`='0' ";
		$query = $this->query($q);
		while($notice=$query->fetch_assoc()){
			$endDate = $classDate->transforDate($notice['addDate'], array("day"=>$GLOBALS['keepNotice']));
			echo $notice['addDate']." � ".$endDate." � ".$controlDate."<br/>";
			if($controlDate>$endDate){
				echo "���������� ������������ (����������)<br/>";
				//$classMenuSettings->deleteOption('notices', $notice['id']);
			}else{
				echo "���������� �� ����������<br/>";
			}
		}
		//***************************
		
		//����������� �������� � ���������� ����� ����������
		$q = "SELECT * FROM `notices` WHERE `tmp`='0' AND `folder`='0' AND `sender`='0' ";
		$query = $this->query($q);
		while($notice=$query->fetch_assoc()){
			$endDate = $classDate->transforDate($notice['addDate'], array("day"=>$GLOBALS['keepNotice']-$GLOBALS['warning']));
			echo $notice['addDate']." � ".$endDate." � ".$controlDate."<br/>";
			if($controlDate>$endDate){
				$text  = "������������, $array[noticeUserName]<br/><br/>";
				$text .= "������������� ���� �������� ������ ���������� �� ����� ".$GLOBALS['site']."<br/>";
				$text .= "��� ��������� ���������� ��������� �� ���� ������:<br/>";
				$href = $GLOBALS['site']."rus/confirm/$notice[hash]/";
				$text .= "<a href=\"$href\">���������� �����������</a><br/><br/>";
				$text .= "������� �� ������������� ������ �������.";
				$classEmail->sendEmail($notice['noticeEmail'],"robot@board.beststart.info",
				$notice['noticeUserName'],"��������� ����������",$text);
				echo $text;
				$admin->updateDBRecord('notices', 'sender', '1', $notice['id']);
			}else{
				echo "�������� �� ����������<br/>";
			}
		}
		//***************************
	}
	
}
?>