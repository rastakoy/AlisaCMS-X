<?php
class Date extends DatabaseInterface{

	/**
	
	*/
	//$year, $month, $day, $hour, $minute, $second
	function transforDate($date, $array){
		$dt = explode(" ", $date);
		$dt1 = explode("-", $dt[0]);
		$dt2 = explode(":", $dt[1]);
		//print_r($dt2);
		$myDate = mktime (
			$dt2['0']+$array['hour'],
			$dt2['1']+$array['minute'],
			$dt2['2']+$array['second'],
			$dt1['1']+$array['month'],
			$dt1['2']+$array['day'],
			$dt1['0']+$array['year']
		);
		$myDate = strftime("%Y-%m-%d %H:%M:%S", $myDate);
		return $myDate;
	}
	
}