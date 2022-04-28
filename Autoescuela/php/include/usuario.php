<?php
class Usuario{
    protected $id_usuario;
    private $correo;
    private $nombre;
    private $apellidos;
    private $contrasena;
    private $fecha_nacimiento;
    private $rol;
    private $foto;

    public function getid_usuario(){return $this->id_usuario;}
    public function getcorreo(){return $this->correo;}
    public function getnombre(){return $this->nombre;}
    public function getapellidos(){return $this->apellidos;}
    public function getcontrasena(){return $this->contrasena;}
    public function getfecha_nacimiento(){return $this->fecha_nacimiento;}
    public function getrol(){return $this->rol;}
    public function getfoto(){return $this->foto;}
    
   
    public function __construct($id_usuario, $correo, $nombre, $apellidos, $contrasena, $fecha_nacimiento, $rol, $foto)
    {
        $this->id_usuario = $id_usuario;
        $this->correo = $correo;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->contrasena = $contrasena;
        $this->fecha_nacimiento = $fecha_nacimiento;
        $this->rol = $rol;
        $this->foto = $foto;
    }

    

}
