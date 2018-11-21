<?php

class Group_Model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function groupList()
	{
		$sth = $this->db->prepare('SELECT id, grupo FROM grupos');
		$sth->execute();
		return $sth->fetchAll();
	}
	
}