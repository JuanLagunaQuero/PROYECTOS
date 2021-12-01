<?php
    class Confirmacion{
        private $id;
        private $id_usuario;
        private $fecha_vencimiento;

        public function getid(){return $this->id;}
        public function getid_usuario(){return $this->id_usuario;}
        public function getfecha_vencimiento(){return $this->fecha_vencimiento;}

        public function __construct($id, $id_usuario, $fecha_vencimiento)
        {
            $this->id = $id;
            $this->id_usuario = $id_usuario;
            $this->fecha_vencimiento = $fecha_vencimiento;
            
        }


    }
?>