<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Users extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('users_model');
	}

	
	
	// Listar todos los usuarios...
	public function index($rnd)
	{
	    $data['users'] = $this->users_model->get_users();
	    $this->load->view('pages/users', $data);
	}



	// Obtener informacion de un usuario...
	public function get_user_info()
	{
		if($_REQUEST['accion'] == 'get_user'){
			$done = false;			
			$row = $this->users_model->get_user_info($_REQUEST['id_usuario']);

			if(is_array($row)){
				$done = true;
				$data = array(
					'nombre' => $row['nombre'],
					'apellido' => $row['apellido'],
					'correo' => $row['correo'],
					'archivo' => $row['archivo'],
					'archivo_dir' => $row['archivo_dir'],
					'status' => 'SUCCESS'
				);
			}
			if($done == false){
				$data = array(
					'status' => 'ERROR',
					'error' => 'No se he encontrado el usuario seleccionado.'
				);
			}
			$json_data = json_encode($data);
			echo $json_data;
		}
	}



	// Obtener información de un archivo seleccionado...
	public function get_file_info()
	{
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){	$data = array(
				'file_name' => $_FILES['archivo']['name'],
				'file_type' => $_FILES['archivo']['type'],
				'file_temp' => $_FILES['archivo']['tmp_name'],
				'file_size' => $_FILES['archivo']['size'],
				'status' => 'SUCCESS'
			);
		}
		else{
			$data['status'] = 'ERROR';
			$data['error'] = 'Error al subir el archivo seleccionado.';
		}
		$json_data = json_encode($data);
		echo $json_data;
	}



	// Agregar nuevo usuario...
	public function add_user()
	{
		$this->set_timezone();
		$user_dir = sha1(trim($_POST['correo'] . strftime('%F %T')));
		$user_path = './public/uploads/' . $user_dir . '/';
		$done = false;

		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
			if(mkdir($user_path, 0755, true)){
				if($_FILES['archivo']['name'] && move_uploaded_file($_FILES['archivo']['tmp_name'], $user_path . $_FILES['archivo']['name'])){
					
					// Preparar array con la respuesta...
					$data = array(
							'nombre' => $_POST['nombre'],
							'apellido' => $_POST['apellido'],
							'correo' => $_POST['correo'],
							'archivo' => array(
								'nombre' => $_FILES['archivo']['name'],
								'tipo' => $_FILES['archivo']['type'],
								'temporal' => $_FILES['archivo']['tmp_name'],
								'peso' => $_FILES['archivo']['size'],
								'path_dir' => $user_dir
							)
						);

					// Insertar registro en la BD...
					$new_insert = $this->users_model->add_user(
							$data['nombre'],
							$data['apellido'],
							$data['correo'],
							$data['archivo']['nombre'],
							$data['archivo']['peso'],
							$data['archivo']['tipo'],
							$data['archivo']['path_dir']
						);
					if($new_insert == true){					
						$data['status'] = 'SUCCESS';
						$done = true;
					}
				}
			}
		}
		if($done == false){
			$data['status'] = 'ERROR';
			$data['error'] = 'Error al crear usuario.';
		}
		$json_data = json_encode($data);
		echo $json_data;
	}



	// Editar un usuario existente...
	public function edit_user()
	{
		if($_POST['accion'] == 'edit_user'){
		$done = false;
			$edit_data = $this->users_model->edit_user(
				$_POST['id_usuario'],
				$_POST['nombre'],
				$_POST['apellido'],
				$_POST['correo']
			);
			if($edit_data == true){					
				$data['status'] = 'SUCCESS';
				$done = true;
			}
			if($done == false){
				$data['status'] = 'ERROR';
				$data['error'] = 'Error al actualizar datos de usuario.';
			}
		$json_data = json_encode($data);
		echo $json_data;
		}
	}


	// Eliminar un usuario...
	public function delete_user()
	{
		if($_POST['accion'] == 'delete_user'){
		$done = false;
		$delete = $this->users_model->delete_user($_POST['id_usuario']);
			if($delete == true){
				$file_dir = './public/uploads/' . $_POST['archivo_dir'];
				$file_path = $file_dir . '/' . $_POST['archivo'];
					if(file_exists($file_path))
						unlink($file_path);
					if(is_dir($file_dir))
						rmdir($file_dir);
				$data['status'] = 'SUCCESS';
				$done = true;
			}
			if($done == false){
				$data['status'] = 'ERROR';
				$data['error'] = 'Error al eliminar usuario.';
			}
		$json_data = json_encode($data);
		echo $json_data;
		}
	}



	// Definir zona horaria...
	private function set_timezone(){
		date_default_timezone_set('America/Santiago');
	}

}


