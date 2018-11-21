<?php

class User_Model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function userList()
	{
		$sth = $this->db->prepare('	SELECT id, nome, sobrenome
									FROM usuarios');
		$sth->execute();
		return $sth->fetchAll();
	}
	
	public function userSingleList($id)
	{
		if(isset($_POST['id'])){
			$id = $_POST['id'];
		}

		$sth = $this->db->prepare('SELECT  usuarios.id, nome, sobrenome, group_concat(grupos.id) as group_ids, group_concat(grupos.grupo) as group_descricao
									FROM usuarios 
										INNER JOIN usuario_grupos on usuario_grupos.usuario_id = usuarios.id
										INNER JOIN grupos on grupos.id = usuario_grupos.grupo_id
									WHERE usuarios.id = :id');
		$sth->execute(array(':id' => $id));
		return $sth->fetch();
	}
	
	public function create($data)
	{
		$sth = $this->db->prepare('INSERT INTO usuarios 
			(`nome`, `sobrenome`, `dtcad`) 
			VALUES (:nome, :sobrenome, :dtcad)
			');
		
		$sth->execute(array(
			':nome' => $data['nome'],
			':sobrenome' => $data['sobrenome'],
			':dtcad' => date("Y-m-d H:i:s")
		));

		return $this->db->lastInsertId();
	}
	
	public function edit($data)
	{	
		$sth = $this->db->prepare('UPDATE usuarios
			SET `nome` = :nome, `sobrenome` = :sobrenome, `dtupd` = :dtupd
			WHERE id = :id
			');
		
		$sth->execute(array(
			':id' => $data['usuario_id'],
			':nome' => $data['nome'],
			':sobrenome' => $data['sobrenome'],
			':dtupd' => date("Y-m-d H:i:s")
		));
	}
	
	public function delete($id)
	{
		$sth = $this->db->prepare('DELETE FROM usuarios WHERE id = :id');
		$sth->execute(array(
			':id' => $id
		));
	}

	public function validateData($data){
		$msgErro = '';
		
		if(strlen($data['nome']) > 50){
    		$msgErro = "Nome não pode ser maior que 50 caracteres<br>";
	    }

	    if(strlen($data['nome']) < 3){
	    	$msgErro .= "Nome não pode ser menor que 3 caracteres<br>";
	    }

	    if(strlen($data['sobrenome']) > 50){
	    	$msgErro .= "Sobrenome não pode ser maior que 100 caracteres<br>";
	    }

	    if(strlen($data['sobrenome']) < 3){
	    	$msgErro .= "Sobrenome não pode ser menor que 3 caracteres<br>";
	    }

	    return $msgErro;
	}
}