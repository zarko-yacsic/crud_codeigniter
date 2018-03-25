<?php
class Users_model extends CI_Model {

    // Constructor...
    public function __construct()
    {
    	$this->load->database();
    }



    // Obtener listado de usuarios...
    public function get_users()
	{
		$query = $this->db->query("SELECT * FROM usuarios ORDER BY apellido, nombre ASC;");
		return $query->result_array();
	}



	// Obtener informacion de un usuario...
	public function get_user_info($id)
	{
		$query = $this->db->query("SELECT * FROM usuarios WHERE id=" . $id . " LIMIT 1;");
		return $query->row_array();
	}



	// Agregar un nuevo usuario...
	public function add_user($nombre, $apellido, $correo, $archivo, $archivo_size, $archivo_type, $archivo_dir)
	{
		$data = array(
			'nombre' => $nombre,
			'apellido' => $apellido,
			'correo' => $correo,
			'archivo' => $archivo,
			'archivo_size' => $archivo_size,
			'archivo_type' => $archivo_type,
			'archivo_dir' => $archivo_dir
		);
		$this->db->insert('usuarios', $data);
		return ($this->db->affected_rows() > 0) ? true : false; 
	}



	// Editar un usuario existente...
	public function edit_user($id, $nombre, $apellido, $correo){
		$data = array(
			'nombre' => $nombre,
			'apellido' => $apellido,
			'correo' => $correo
		);
		$this->db->where('id', $id);
		$this->db->update('usuarios', $data);
		return ($this->db->affected_rows() > 0) ? true : false;
	}



	// Eliminar un usuario...
	public function delete_user($id){
		$this->db->delete('usuarios', array('id' => $id));
		return ($this->db->affected_rows() > 0) ? true : false;
	}

}
?>