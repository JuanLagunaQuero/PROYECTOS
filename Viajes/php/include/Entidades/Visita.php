<?php
class Visita{
    protected $id_visita;
    private $fecha_inicio;
    private $hora_inicio;
    private $fecha_fin;
    private $hora_fin;
    private $id_alumno_detalle_convenio;

    /**
     * Get the value of id_visita
     */ 
    public function getId_visita()
    {
        return $this->id_visita;
    }

    /**
     * Set the value of id_visita
     *
     * @return  self
     */ 
    public function setId_visita($id_visita)
    {
        $this->id_visita = $id_visita;

        return $this;
    }

    /**
     * Get the value of fecha_inicio
     */ 
    public function getFecha_inicio()
    {
        return $this->fecha_inicio;
    }

    /**
     * Set the value of fecha_inicio
     *
     * @return  self
     */ 
    public function setFecha_inicio($fecha_inicio)
    {
        $this->fecha_inicio = $fecha_inicio;

        return $this;
    }

    /**
     * Get the value of hora_inicio
     */ 
    public function getHora_inicio()
    {
        return $this->hora_inicio;
    }

    /**
     * Set the value of hora_inicio
     *
     * @return  self
     */ 
    public function setHora_inicio($hora_inicio)
    {
        $this->hora_inicio = $hora_inicio;

        return $this;
    }

    /**
     * Get the value of fecha_fin
     */ 
    public function getFecha_fin()
    {
        return $this->fecha_fin;
    }

    /**
     * Set the value of fecha_fin
     *
     * @return  self
     */ 
    public function setFecha_fin($fecha_fin)
    {
        $this->fecha_fin = $fecha_fin;

        return $this;
    }

    /**
     * Get the value of hora_fin
     */ 
    public function getHora_fin()
    {
        return $this->hora_fin;
    }

    /**
     * Set the value of hora_fin
     *
     * @return  self
     */ 
    public function setHora_fin($hora_fin)
    {
        $this->hora_fin = $hora_fin;

        return $this;
    }

    /**
     * Get the value of id_alumno_detalle_convenio
     */ 
    public function getId_alumno_detalle_convenio()
    {
        return $this->id_alumno_detalle_convenio;
    }

    /**
     * Set the value of id_alumno_detalle_convenio
     *
     * @return  self
     */ 
    public function setId_alumno_detalle_convenio($id_alumno_detalle_convenio)
    {
        $this->id_alumno_detalle_convenio = $id_alumno_detalle_convenio;

        return $this;
    }

    
}
