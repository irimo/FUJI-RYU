<?php
require_once (dirname(__FILE__)."/DBO.php");

class DBManager
{
	private $dbo;
	public function __construct()
	{
		$this->dbo = new DBO();
	}
	public function setSite($user_status_arr)
	{
		if(!isset($user_status_arr["sitename"]))	return false;
		if(isset($user_status_arr["banner"]))		$banner_flag = true;
			else $banner_flag = false;
		if(!isset($user_status_arr["url"]))		return false;
		if(!isset($user_status_arr["master"]))		return false;
		if(!isset($user_status_arr["explain"]))	return false;
		if(!isset($user_status_arr["secret_q"]))	return false;
		if(!isset($user_status_arr["secret_a"]))	return false;
		if(!isset($user_status_arr["mail"]))		return false;
		if(!isset($user_status_arr["pw"]))			return false;

		$sitename = $user_status_arr["sitename"];
		$sitename = $this->dbo->dbquote($sitename);
		if($banner_flag === true){
			$banner = $user_status_arr["banner"];
			$banner = $this->dbo->dbquote($banner);
		} else {
			$banner = "";
		}
		$url = $user_status_arr["url"];
		$url = $this->dbo->dbquote($url);
		$master = $user_status_arr["master"];
		$master = $this->dbo->dbquote($master);
		$explain = $user_status_arr["explain"];
		$explain = $this->dbo->dbquote($explain);
		$secret_q = $user_status_arr["secret_q"];
		$secret_q = $this->dbo->dbquote($secret_q);
		$secret_a = $user_status_arr["secret_a"];
		$secret_a = $this->dbo->dbquote($secret_a);
		$mail = $user_status_arr["mail"];
		$mail = $this->dbo->dbquote($mail);
		$pw = $user_status_arr["pw"];
		$pw = $this->dbo->dbquote($pw);

		$sql = "INSERT INTO ring_site(sitename,banner,url,`master`,`explain`,secret_q,secret_a,mail,pw) ";
		$sql .= "VALUES('{$sitename}','{$banner}','{$url}','{$master}','{$explain}','{$secret_q}',";
		$sql .= "'{$secret_a}','{$mail}','{$pw}');";
		$ret = $this->dbo->query($sql);
		return $ret;
	}
	public function updateSite($id,$user_status_arr)
	{
		if(!isset($user_status_arr["sitename"]))	return false;
		if(isset($user_status_arr["banner"]))		$banner_flag = true;
			else $banner_flag = false;
		if(!isset($user_status_arr["url"]))		return false;
		if(!isset($user_status_arr["master"]))		return false;
		if(!isset($user_status_arr["explain"]))	return false;
		if(!isset($user_status_arr["secret_q"]))	return false;
		if(!isset($user_status_arr["secret_a"]))	return false;
		if(!isset($user_status_arr["mail"]))		return false;
		if(!isset($user_status_arr["pw"]))			return false;

		$sitename = $user_status_arr["sitename"];
		$sitename = $this->dbo->dbquote($sitename);
		if($banner_flag === true){
			$banner = $user_status_arr["banner"];
			$banner = $this->dbo->dbquote($banner);
		} else {
			$banner = "";
		}
		$url = $user_status_arr["url"];
		$url = $this->dbo->dbquote($url);
		$master = $user_status_arr["master"];
		$master = $this->dbo->dbquote($master);
		$explain = $user_status_arr["explain"];
		$explain = $this->dbo->dbquote($explain);
		$secret_q = $user_status_arr["secret_q"];
		$secret_q = $this->dbo->dbquote($secret_q);
		$secret_a = $user_status_arr["secret_a"];
		$secret_a = $this->dbo->dbquote($secret_a);
		$mail = $user_status_arr["mail"];
		$mail = $this->dbo->dbquote($mail);
		$pw = $user_status_arr["pw"];
		$pw = $this->dbo->dbquote($pw);

		$sql = "UPDATE ring_site SET";
		$sql .= " sitename='{$sitename}',banner='{$banner}',url='{$url}',`master`='{$master}',";
		$sql .= " `explain`='{$explain}',secret_q='{$secret_q}',secret_a='{$secret_a}',mail='{$mail}',pw='{$pw}' ";
		$sql .= " WHERE `id`={$id}";
		$ret = $this->dbo->query($sql);
		return $ret;
	}
	public function getSiteId($url)
	{
		$url = $this->dbo->dbquote($url);
		$sql = "SELECT id FROM ring_site WHERE url = '{$url}' ORDER BY id DESC LIMIT 1";
		$ret = $this->dbo->selectrow($sql);
		$id = $ret["id"];
		return $id;
	}
	public function setMangas($id,$mangas_arr)
	{
		$id = $this->dbo->dbquote($id);

		$column = "";
		$values = "";

		foreach($mangas_arr as $columnname => $value)
		{
			$columnname = $this->dbo->dbquote($columnname);
			$value = $this->dbo->dbquote($value);

			$column .= $columnname.",";
			$values .= $value.",";
		}
		$column = substr($column,0,-1);
		$values = substr($values,0,-1);

		$sql = "REPLACE INTO ring_mangas(`id`,{$column}) VALUES('{$id}',{$values})";
		return $this->dbo->query($sql);
	}
	public function checkPW($siteid,$pw)
	{
		$siteid = $this->dbo->dbquote($siteid);
		$pw = $this->dbo->dbquote($pw);

		$sql = "SELECT `id` FROM ring_site WHERE `id`='{$siteid}' AND `pw`='{$pw}'";
		$ret = $this->dbo->selectrow($sql);
		if($ret == false || count($ret) <= 0){
			return false;
		}
		else
		{
			return true;
		}
	}
	public function getSiteDataAll()
	{
		$sql = "SELECT `id`,sitename,banner,url,`master`,`explain`,`in`,`out` FROM ring_site WHERE del_flag=0 AND check_flag=1";
		return $this->dbo->selectrec($sql);
	}
	public function getSiteDataQue()
	{
		$sql = "SELECT `id`,sitename,banner,url,`master`,`explain`,`in`,`out` FROM ring_site WHERE del_flag=0 AND check_flag=0";
		return $this->dbo->selectrec($sql);
	}
	public function getSiteDataAll_master()
	{
		$sql = "SELECT `id`,sitename,banner,url,`master`,`explain`,secret_q,secret_a,mail,pw,`in`,`out`,del_flag,check_flag FROM ring_site";
		return $this->dbo->selectrec($sql);
	}
	public function getMangaDataAll($id = "all")
	{
		$sql = "SELECT * FROM ring_mangas";
		if($id !== "all"){
			$sql .= " WHERE `id`={$id}";
		}
		return $this->dbo->selectrec($sql);
	}
	public function getSiteDataRow($id)
	{
		$id = $this->dbo->dbquote($id);
		$sql = "SELECT `id`,sitename,banner,url,`master`,`explain`,secret_q,secret_a,mail,pw FROM ring_site WHERE `id`={$id} AND del_flag=0";
		return $this->dbo->selectrow($sql);
	}
	public function getMangaDataRow($id)
	{
		$id = $this->dbo->dbquote($id);
		$sql = "SELECT * FROM ring_mangas WHERE `id`={$id}";
		return $this->dbo->selectrow($sql);
	}
	public function getSearchSite($word)
	{
		$word = str_replace("　"," ",$word);
		$word_arr = split(" ",$word);
		$num = count($word_arr);
		if(count($num) <= 0 ) return false;
		$sql_where = "";
		for($i=0; $i<$num; $i++)
		{
			$word_arr[$i] = $this->dbo->dbquote($word_arr[$i]);
			$sql_where .= " (`explain` LIKE '%{$word_arr[$i]}%'";
			$sql_where .= " OR `sitename` LIKE '%{$word_arr[$i]}%'";
			$sql_where .= " OR `master` LIKE '%{$word_arr[$i]}%'";
			$sql_where .= " OR `url` LIKE '%{$word_arr[$i]}%'";
			$sql_where .= " OR `banner` LIKE '%{$word_arr[$i]}%'";
			$sql_where .= " OR `mail` LIKE '%{$word_arr[$i]}%')";
			if($i < $num-1)
			{
				$sql_where .= " AND";
			}
		}
		$sql = "SELECT `id`,sitename,banner,url,`explain`,`in`,`out`,`master` FROM ring_site WHERE {$sql_where} AND del_flag = 0 AND check_flag = 1";
		return $this->dbo->selectrec($sql);
	}
	public function getSearchFromMangas($mangas_arr)
	{
		$sql_where = "";
		$num = count($mangas_arr);
		for($i=0; $i<$num; $i++)
		{
			$mangas_arr[$i] = $this->dbo->dbquote($mangas_arr[$i]);
			$sql_where .= " `{$mangas_arr[$i]}` = 1";
			if($i < $num-1)
			{
				$sql_where .= " AND";
			}
		}
		$sql = "SELECT A.`id`,sitename,banner,url,`explain`,`in`,`out`,`master` FROM ring_site AS A, ring_mangas AS B ";
		$sql .= " WHERE del_flag = 0 AND check_flag = 1";
		$sql .= " AND ".$sql_where;
		$sql .= " AND A.`id` = B.`id`";
		return $this->dbo->selectrec($sql);
	}
	public function setCheckFlag($id,$flag = 1)
	{
		$id = $this->dbo->dbquote($id);
		$sql = "UPDATE ring_site SET check_flag = '{$flag}' WHERE id = '{$id}'";
		return $this->dbo->query($sql);
	}
	public function setDelFlag($id,$flag = 1)
	{
		$id = $this->dbo->dbquote($id);
		$flag = $this->dbo->dbquote($flag);
		$sql = "UPDATE ring_site SET del_flag = '{$flag}' WHERE id = '{$id}'";
		return $this->dbo->query($sql);
	}
	public function getSecretQ($id)
	{
		$id = $this->dbo->dbquote($id);
		$sql = "SELECT secret_q FROM ring_site WHERE `id` = {$id}";
		$ret = $this->dbo->selectrow($sql);
		return $ret["secret_q"];
	}
	public function getPwFromSecretQ($id,$secret_a)
	{
		$id = $this->dbo->dbquote($id);
		$secret_a = $this->dbo->dbquote($secret_a);
		$sql = "SELECT pw FROM ring_site WHERE `id`={$id} AND secret_a LIKE '{$secret_a}'";
		$ret = $this->dbo->selectrow($sql);
		if($ret == false || count($ret) <= 0)
		{
			return false;
		}
		return $ret["pw"];
	}
	public function getNextId($id)
	{
		$id = $this->dbo->dbquote($id);
		$sql = "SELECT `id` FROM ring_site WHERE `id` > {$id} AND del_flag = 0 AND check_flag = 1 ORDER BY `id` ASC LIMIT 1";
		$ret = $this->dbo->selectrow($sql);
		if($ret == false)
		{
			$sql = "SELECT `id` FROM ring_site WHERE del_flag = 0 AND check_flag = 1 ORDER BY `id` ASC LIMIT 1";
			$ret = $this->dbo->selectrow($sql);
			if($ret == false)
			{
				return false;
			}
		}
		return $ret["id"];
	}
	public function getbackId($id)
	{
		$id = $this->dbo->dbquote($id);
		$sql = "SELECT `id` FROM ring_site WHERE `id` < {$id} AND del_flag = 0 AND check_flag = 1 ORDER BY `id` DESC LIMIT 1";
		$ret = $this->dbo->selectrow($sql);
		if($ret == false)
		{
			$sql = "SELECT `id` FROM ring_site WHERE del_flag = 0 AND check_flag = 1 ORDER BY `id` DESC LIMIT 1";
			$ret = $this->dbo->selectrow($sql);
			if($ret == false)
			{
				return false;
			}
		}
		return $ret["id"];
	}
	public function getRandId()
	{
		$sql = "SELECT `id` FROM ring_site ORDER BY RAND() LIMIT 1";
		$ret = $this->dbo->selectrow($sql);
		if($ret == false || count($ret) <= 0)
		{
			return false;
		}
		return $ret["id"];
	}
	public function upIn($id)
	{
		$id = $this->dbo->dbquote($id);
		$sql = "SELECT `in` FROM ring_site WHERE `id` = {$id}";
		$ret = $this->dbo->selectrow($sql);
		$in = $ret["in"];
		$in++;
		$sql = "UPDATE ring_site SET `in` = {$in} WHERE `id` = {$id}";
		$ret = $this->dbo->query($sql);
		return $ret;
	}
	public function upOut($id)
	{
		$id = $this->dbo->dbquote($id);
		$sql = "SELECT `out` FROM ring_site WHERE `id` = {$id}";
		$ret = $this->dbo->selectrow($sql);
		$out = $ret["out"];
		$out++;
		$sql = "UPDATE ring_site SET `out` = {$out} WHERE `id` = {$id}";
		$ret = $this->dbo->query($sql);
		return $ret;
	}
	public function getUrl($id)
	{
		$id = $this->dbo->dbquote($id);
		$sql = "SELECT url FROM ring_site WHERE `id` = {$id}";
		$ret = $this->dbo->selectrow($sql);
		if($ret == false || count($ret) <= 0)
		{
			return false;
		}
		return $ret["url"];
	}
}
