<?php

class Examen_Hecho{
    private static $id_examen_hecho;
    private static $id_examen;
    private static $id_alumno;
    private static $calificacion;
    private static $ejecucion;

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
?>