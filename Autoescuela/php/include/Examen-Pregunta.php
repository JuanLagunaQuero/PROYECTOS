<?php
    class Examen_Pregunta{
        protected $id_examen;
        protected $id_pregunta;

        public function getid_examen(){return $this-> id_examen;}
        public function getid_pregunta(){return $this-> id_pregunta;}

        public function __construct($id_examen, $id_pregunta)
        {
            $this->id_examen = $id_examen;
            $this->id_pregunta = $id_pregunta;
        }

    }

?>