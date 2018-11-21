<?php

class User extends Controller {

	public function __construct() {
		parent::__construct();		
		require 'models/group_model.php';
		require 'models/user_group_model.php';
		$this->grupo = new Group_Model();	
		$this->usuario_grupo = new UserGroup_Model();	
	}
	
	public function index() 
	{	
		$this->view->userList = $this->model->userList();
		$grupos = $this->grupo->groupList();
		$this->view->grupos = $grupos;
		$this->view->js = array('user/js/default.js');

		$this->view->msg = '';
		if(isset($_SESSION['msg'])){
			$this->view->msg = $_SESSION['msg'];
			unset($_SESSION['msg']);
		}

		$this->view->render('user/index');
	}
	
	public function create() 
	{	
		$data = array();
		$data['nome'] = $_POST['nome'];
		$data['sobrenome'] = $_POST['sobrenome'];
		$data['grupos'] = $_POST['grupos'];

		$dadosUsuario = $this->model->validateData($data);
		$dadosGrupos = $this->usuario_grupo->validateData($data);
		
		if($dadosUsuario == '' && $dadosGrupos == ''){
			$iduser = $this->model->create($data);

			$data['usuario_id'] = $iduser;

			$this->usuario_grupo->create($data);
			header('location: ' . URL . 'user');
		}else{
			$_SESSION['msg'] = $dadosUsuario.$dadosGrupos;
			header('location: ' . URL . "user");
		}
	}

	public function edit($id)
	{
		$data = array();
		$data['nome'] = $_POST['nome'];
		$data['sobrenome'] = $_POST['sobrenome'];
		$data['grupos'] = $_POST['grupos'];
		$data['usuario_id'] = $id;

		$dadosUsuario = $this->model->validateData($data);
		$dadosGrupos = $this->usuario_grupo->validateData($data);
		
		if($dadosUsuario == '' && $dadosGrupos == ''){
			$this->model->edit($data);

			$this->usuario_grupo->create($data);
			header('location: ' . URL . 'user');
		}else{
			$_SESSION['msg'] = $dadosUsuario.$dadosGrupos;
			header('location: ' . URL . "user");
		}
		
	}
	
	public function delete($id)
	{
		$this->usuario_grupo->deleteAll($id);
		$this->model->delete($id);
		header('location: ' . URL . 'user');
	}

	public function userSingleList()
	{
		$id = $_GET['id'];	
		echo json_encode ($this->model->userSingleList($id));
	}
}