<?php
class Notices extends DatabaseInterface{

	/**
	
	*/
	function getNotices($parent='0', $folder=true, $url=false){
		if(preg_match("/\/editItem\/[0-9]{1,12}\/$/", $url, $matches)){
			//echo "matches = $matches[0]:::";
			$edited = $matches['0'];
			$url = preg_replace("/\/editItem\/[0-9]{1,12}\/$/", "/", $url);
			//echo "url=$url";
			//unset($url[count($url)-1]);
			//print_r($url);
		}
		$showTmp = '';
		if($GLOBALS['showTempNotice']=="Нет"){
			$showTmp = " AND `tmp`='0' ";
		}
		if($folder && !is_array($parent)){
			$q = "SELECT * FROM `notices` WHERE `parent`='$parent' AND `folder`='1' $showTmp ORDER BY `addDate` DESC ";
		}elseif(is_array($parent) && count($parent)>'1'){
			$parentNotice = $this->getNoticeFromLink($parent);
			$q = "SELECT * FROM `notices` WHERE `parent`='$parentNotice[id]' $showTmp  ORDER BY `addDate` DESC ";
		}elseif(count($parent)=='1'){
			$q = "SELECT * FROM `notices` WHERE `parent`='0' $showTmp ORDER BY `addDate` DESC ";
			$parent = '0';
		}else{
			$q = "SELECT * FROM `notices` WHERE `parent`='$parent' $showTmp ORDER BY `addDate` DESC ";
		}
		//echo $q;
		$query = $this->query($q);
		while($notice=$query->fetch_assoc()){
			$notice['children'] = $this->testNoticeForChildren($notice['id']);
			$notice['href'] = $this->getHref($notice['id']);
			$notice['tumb'] = $this->getNoticeImages($notice['id'], 1);
			$notice['comments'] = $this->getComments($notice['id']);
			//echo $url."\n";
			//echo $notice['href']."\n";
			$prega = "/".str_replace("/", "\\/", $notice['href'])."/";
			//echo "prega=$prega\n";
			if(preg_match($prega, $url) && $notice['children']>0){
				$notice['openBranch'] = $this->getNotices($notice['id'], true, $url);
			}
			//echo $notice['href'];
			$notices[] = $notice;
		}
		return $notices;
	}
	
	/**
	
	*/
	function getParentNotice($parent){
		$query = $this->query("SELECT * FROM `notices` WHERE `id`='$parent' ");
		if($query){
			return $query->fetch_assoc();
		}
		return false;
	}
	
	/**
	
	*/
	function testNoticeForChildren($id){
		$q = "SELECT * FROM `notices` WHERE `parent`='$id' AND `folder`='1' ORDER BY `addDate` DESC ";
		$query = $this->query($q);
		if($query){
			return $query->num_rows;
		}else{
			return '0';
		}
	}
	
	/**
	
	*/
	function getHref($parent, $href=''){
		if(!$parent){
			return false;
		}
		$q = "SELECT * FROM `notices` WHERE `id`='$parent'  ORDER BY `addDate` DESC ";
		//echo $q."<br/>";
		$query = $this->query($q);
		$notice = $query->fetch_assoc();
		//echo "<pre>"; print_r($notice); echo "</pre>";
		$href = $notice['link']."/".$href;
		return $this->getHref($notice['parent'], $href);
	}
	
	/**
	
	*/
	function getNoticeFromLink($links){
		$parent = '0';
		foreach($links as $link){
			if($link!="notices"){
				$query = $this->query("SELECT * FROM `notices` WHERE `link`='$link' AND `parent`='$parent' ");
				if($query->num_rows > 0){
					$childrenNotice = $query->fetch_assoc();
					$parent = $childrenNotice['id'];
				}
			}
		}
		return $childrenNotice;
	}
	
	/**
	
	*/
	function getEditNotice($id){
		$query = $this->query("SELECT * FROM `notices` WHERE `id`='$id' ");
		$notice = $query->fetch_assoc();
		return $notice;
	}
	
	/**
	
	*/
	function getEditNoticeFolder($id){
		$query = $this->query("SELECT * FROM `notices` WHERE `id`='$id' ");
		$notice = $query->fetch_assoc();
		return $notice;
	}
	
	/**
	
	*/
	function saveNoticeFolder($array){
		$q  = "UPDATE `notices` SET `name`='$array[noticeName]', `link`='$array[noticeLink]', `filter`='$array[noticeFilter]' ";
		$q .= ", `css`='$array[noticeClass]' ";
		$q .= "WHERE `id`='$array[noticeId]' ";
		//echo $q;
		$query = $this->query($q);
		if($query){
			return "{\"return\":\"ok\"}";
		}
		return "{\"return\":\"false\"}";
	}
	
	/**
	
	*/
	function defineFilter($id){
		$query = $this->query("SELECT * FROM `notices` WHERE `id`='$id' ");
		$notice = $query->fetch_assoc();
		if($notice['filter']){
			return $notice['filter'];
		}elseif($notice['parent']!='0'){
			return $this->defineFilter($notice['parent']);
		}else{
			return false;
		}
	}
	
	/**
	
	*/
	function saveNotice($array, $filters){
		//print_r($array);
		
		$q  = "UPDATE `notices` SET `name`='$array[noticeName]', `link`='$array[noticeLink]', `content`='$array[noticeContent]' ";
		foreach($filters as $filter){
			$q .= " , `$filter[fieldname]`='".($array['filter_'.$filter['fieldname']])."' ";
		}
		$q .= "WHERE `id`='$array[noticeId]' ";
		//echo $q;
		$query = $this->query($q);
		if($query){
			return "{\"return\":\"ok\"}";
		}
		return "{\"return\":\"false\"}";
	}
	
	/**
	
	*/
	function getNotice($noticeId){
		
	}
	

	/**
	
	*/
	function getNoticeImages($noticeId, $limit=false){
		if($limit){
			$limit = " LIMIT 0, $limit ";
		}
		$q = "SELECT * FROM `images` WHERE `noticeId`='$noticeId' ORDER BY `prior` ASC $limit ";
		$query = $this->query($q);
		$images = array();
		while($image=$query->fetch_assoc()){
			$images[] = $image;
		}
		return $images;
	}
	
	/**
	
	*/
	function deleteNoticeImages($noticeId){
		$images = $this->getNoticeImages($noticeId);
		if(is_array($images)){
			foreach($images as $image){
				if(file_exists("../loadimages/".$image['name'])){
					unlink("../loadimages/".$image['name']);
				}
			}
			$query = $this->query("DELETE FROM `images` WHERE `id`='$image[id]' ");
		}
	}
	
	/**
	
	*/
	function addNoticeFolder($parent){
		if(!$parent){
			$parent = '0';
		}
		$query = $this->query("SELECT * FROM `notices` ORDER BY `id` DESC LIMIT 0,1 ");
		$foo = $query->fetch_assoc();
		$newId = $foo['id']+1;
		$q  = "INSERT INTO `notices` ";
		$q .= "(`parent`, `folder`, `prior`, `name`, `link`) VALUES ";
		$q .= "('$parent', '1', '0', 'Новая директория $newId', 'folder_$newId')";
		//echo $q;
		$query = $this->query($q);
		if($query){
			$sQuery = $this->query("SELECT `id` FROM `notices` ORDER BY `id` DESC LIMIT 0,1 ");
			$id = $sQuery->fetch_assoc();
			return $id['id'];
		}
		return false;
	}
	
	/**
	
	*/
	function changeShowTemp($array){
		$this->query("UPDATE `settings` SET `value`='$array[checked]' WHERE `arrayName`='showTempNotice' ");
	}
	
	/**
	
	*/
	function getNewNotices(){
		$query = $this->query("SELECT * FROM `notices` WHERE `moder`='0' AND `folder`='0' AND `tmp`='0' ORDER BY `id` DESC ");
		while($notice=$query->fetch_assoc()){
			$notices[] = $notice;
		}
		return $notices;
	}
	
	/**
	
	*/
	function acceptNotice($noticeId){
		$query = $this->query("UPDATE `notices` SET `moder`='1' WHERE `id`='$noticeId' ");
	}
	
	/**
	
	*/
	function getComments($noticeId){
		$query = $this->query("SELECT * FROM `comments` WHERE `parent`='$noticeId' AND `type`='notices' ORDER BY `addDate` DESC ");
		while($comment=$query->fetch_assoc()){
			$comments[] = $comment;
		}
		return $comments;
	}
	
	/**
	
	*/
	function deleteNoticeComment($cId){
		$query = $this->query("DELETE FROM `comments` WHERE `id`='$cId' ");
	}
	
}