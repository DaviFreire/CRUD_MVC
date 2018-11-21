<?php

class UserGroup_Model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function userGroupsList($id)
	{
		$sth = $this->db->prepare("SELECT grupo_id FROM usuario_grupos where usuario_id = $id");
		$sth->execute();
		return $sth->fetchAll();
	}
	
	public function create($data)
	{
		$this->deleteAll($data['usuario_id']);
		foreach ($data['grupos'] as $value) {
			$sth = $this->db->prepare('INSERT INTO usuario_grupos 
			(`grupo_id`, `usuario_id`) 
			VALUES (:grupo_id, :usuario_id)
			');
		
			$sth->execute(array(
				':grupo_id' => $value,
				':usuario_id' => $data['usuario_id']
			));
		}
		
	}	
	
	public function deleteAll($id)
	{
		$sth = $this->db->prepare('DELETE FROM usuario_grupos WHERE usuario_id = :id');
		$sth->execute(array(
			':id' => $id
		));
	}

	public function validateData($data){
		$msgErro = '';

		if(count($data['grupos']) < 2){
    		$msgErro = "\nSelecione pelo menos dois grupos";
	    }

	    return $msgErro;
	}
}