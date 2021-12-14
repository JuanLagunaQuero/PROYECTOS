<?php
class Respuesta{
    protected $id_respuesta;
    private $contenido;
    private $id_pregunta;

    public function getid_respuesta(){return $this->id_respuesta;}
    public function getcontenido(){return $this->contenido;}
    public function getid_pregunta(){return $this->id_pregunta;}

    public function __construct($id_respuesta, $contenido, $id_pregunta)
    {
        $this->id_respuesta = $id_respuesta;
        $this->contenido = $contenido;
        $this->id_pregunta = $id_pregunta;
    }
}