<?php
if($this->msg != ''){
?>
	<div class="form-group mt-4 container" id='alertgroup'>
		<div class="alert alert-danger text-center" role="alert">
			<?=$this->msg?>
		</div>
	</div>	
<?php
}
?>

<div class="container mt-4 mb-4">
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#insertUser" onclick="setAction('create')">
	  Novo Registro
	</button>
</div>	
<div class="modal fade" id="insertUser" tabindex="-1" role="dialog" aria-labelledby="insertUserLabel" aria-hidden="true">
	<form method="post" id="formAdd" action="" onsubmit="return validarForm()">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
		        <h5 class="modal-title" id="insertUserLabel">Adicionar Usuário</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
		          	<span aria-hidden="true">&times;</span>
		        </button>
	      	</div>
	      	<div class="modal-body">
		      	<div class="form-group">
			        <label for="name">Nome</label>
			        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required value="" maxlength="50">
		      	</div>
	    		<div class="form-group">
			        <label for="sobrenome">Sobrenome</label>
			        <input type="sobrenome" class="form-control" id="sobrenome" name="sobrenome" placeholder="Sobrenome" required value="" maxlength="100">
		      	</div>

		      	<?php
					foreach($this->grupos as $key => $value) {
						echo "<div class='form-check form-check-inline col-sm-5'>";
						echo "<input class='form-check-input' onclick='countGroup(this)' type='checkbox' id='inlineCheckbox{$value['id']}' name='grupos[]' value='{$value['id']}'>";
						echo "<label class='form-check-label' for='inlineCheckbox{$value['id']}'>{$value['grupo']}</label>";
						echo '</div>';
					}
				?>
				<div class="form-group mt-4" id='alertgroup'>
					<div class="alert alert-info" role="alert">
						Selecione pelo menos 2 grupos
					</div>
					<input type="hidden" id="contador">
				</div>
	      	</div>
	      	<div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
		        <button type="submit" class="btn btn-primary" id='submitbutton'>Salvar</button>
	      	</div>
	    </div>
	  </div>
	</form>
</div>

<div class="container">
	<table class="table table-striped">
	  	<thead>
		    <tr>
		      	<th scope="col">#</th>
		      	<th scope="col">Nome</th>
				<th scope="col">Sobrenome</th>
		      	<th scope="col">Ação</th>
		    </tr>
	  	</thead>
	 	<tbody>
		<?php
			foreach($this->userList as $key => $value) {
				echo '<tr>';
					echo '<th scope="row">' . $value['id'] . '</td>';
					echo '<td>' . $value['nome'] . '</td>';
					echo '<td>' . $value['sobrenome'] . '</td>';
					echo '<td>
							<a href="#" data-toggle="modal" data-target="#insertUser" onclick="setUser(\''. $value['id'] .'\')" >Editar |</a> 
							<a href="'.URL.'user/delete/'.$value['id'].'">Excluir</a></td>';
				echo '</tr>';
			}
		?>
		</tbody>
	</table>
</div>