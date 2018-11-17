<?php

require_once (dirname(__FILE__)."/sensitive.php");
/*
 * Created on 2008/05/13
 */
class DBO
{
	private $host;

	protected $username;
	protected $pw;
	protected $dbname;
	private $dbcon;


	public function __construct()
	{
		if($_SERVER['HTTP_HOST'] == "localhost")
		{
			$this->host = "localhost";
			$this->dbname = "mnlab";
			$this->username = "root";
			$this->pw = "";
		}
		elseif($_SERVER['HTTP_HOST'] == "192.168.1.21")
		{
			$this->host = "localhost";
			$this->dbname = "n030042002";
			$this->username = "iridium";
			$this->pw = $GLOBALS['DBPW_L'];
		}
		else
		{
        $this->host = $GLOBALS['DBHOST_P'];
        $this->dbname = $GLOBALS['DBNAME_P'];
        $this->username = $GLOBALS['DBUSERNAME_P'];
        $this->pw = $GLOBALS['DBPW_P'];
		}
		$ret = $this->dbcon = mysql_connect($this->host,$this->username,$this->pw);
		$ret = mysql_select_db($this->dbname,$this->dbcon);
		mysql_query("set character set utf8",$this->dbcon);
		mysql_query("set names utf8",$this->dbcon);
	}
	public function query($sql){
		$ret = mysql_query($sql, $this->dbcon);
		return $ret;
	}
	// 複数行
	public function selectrec($sql)
	{
		$data = mysql_query($sql, $this->dbcon);
		if($data == false || count($data) <= 0)
		{
			return false;
		}
		while($row = mysql_fetch_assoc($data))
		{
			$arr[] = $row;
		}
		return $arr;
	}
	// 一行
	public function selectrow($sql)
	{
		$data = mysql_query($sql, $this->dbcon);
		if($data == false || count($data) <= 0)
		{
			return false;
		}
		$row = mysql_fetch_assoc($data);
		return $row;
	}
	public function dbquote($val)
	{
		$val = mysql_escape_string($val);
		return $val;
	}
}
