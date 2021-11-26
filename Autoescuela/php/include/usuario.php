<?php
class Usuario{

    private $id_usuario;
    private $correo;
    private $nombre;
    private $apellidos;
    private $contraseña;
    private $fecha_nacimiento;
    private $rol;
    private $foto;

    public function getid_usuario(){return $this->id_usuario;}
    public function getcorreo(){return $this->correo;}
    public function getnombre(){return $this->nombre;}
    public function getapellidos(){return $this->apellidos;}
    public function getcontraseña(){return $this->contraseña;}
    public function getfecha_nacimiento(){return $this->fecha_nacimiento;}
    public function getrol(){return $this->rol;}
    public function getfoto(){return $this->foto;}
    
   
    public function __construct($id_usuario, $correo, $nombre, $apellidos, $contraseña, $fecha_nacimiento, $rol, $foto)
    {
        $this->id_usuario = $id_usuario;
        $this->correo = $correo;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->contraseña = $contraseña;
        $this->fecha_nacimiento = $fecha_nacimiento;
        $this->rol = $rol;
        $this->foto = $foto;
    }

    

}
