<?php 

class usuarioModel{
	
	//privadas por que solo podremos acceder a ellas por metodos

	private $id;
	private $nombre;
	private $apellidos;
	private $email;
	private $password;
	private $rol;
	private $imagen;
	private $db;

	public function __construct() {
		$this->db = conexion::conectar();
	}

   function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return password_hash($this->db->real_escape_string($this->password), PASSWORD_BCRYPT, ['cost' => 4]);
    }

    function getRol() {
        return $this->rol;
    }

    function getImagen() {
        return $this->imagen;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $this->db->real_escape_string($nombre);
    }

    function setApellidos($apellidos) {
        $this->apellidos = $this->db->real_escape_string($apellidos);
    }

    function setEmail($email) {
        $this->email = $this->db->real_escape_string($email);
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setRol($rol) {
        $this->rol = $rol;
    }

    function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    public function save() {
    	$sql = "INSERT INTO usuario VALUES(NULL, '{$this->getNombre()}', '{$this->getApellidos()}', '{$this->getEmail()}', '{$this->getPassword()}', 'user', null)";
    	$save =  $this->db->query($sql);

    	$result = false;
    	if ($save) {
    		$result = true;
    	}

    	return $result;
    }

   
    public function login() {
        $result = false;
        $email = $this->email;
        $password = $this->password;
        //Comporbar si existe el usuario
        //
        $sql = "SELECT * FROM usuario WHERE email = '$email'";
        $login = $this->db->query($sql);

        if ($login && $login->num_rows == 1) {

            $usuarioData = $login->fetch_object();
             $passer=$usuarioData->password;

            //Verificar contraseña
            $verify = password_verify($password, $usuarioData->password);

            if ($verify) {
              $result = $usuarioData;
            }
        }

        return $result;
    }

}