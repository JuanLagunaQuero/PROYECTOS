<?php
class Examen_Hecho{
    protected $id_examen_hecho;
    private $id_examen;
    private $id_alumno;
    private $calificacion;
    private $ejecucion;

    public function getid_examen_hecho(){return $this-> id_examen_hecho;}
    public function getid_examen(){return $this-> id_examen;}
    public function getid_alumno(){return $this-> id_alumno;}
    public function getcalificacion(){return $this-> calificacion;}
    public function getejecucion(){return $this-> ejecucion;}

    public function __construct($id_examen_hecho, $id_examen, $id_alumno, $calificacion, $ejecucion)
    {
        $this->id_examen_hecho = $id_examen_hecho;
        $this->id_examen = $id_examen;
        $this->id_alumno = $id_alumno;
        $this->calificacion = $calificacion;
        $this->ejecucion = $ejecucion;
    }

}
