<?php
class Detalle_Convenio
{
    protected $id_detalle_convenio;
    private $fecha_inicio;
    private $fecha_fin;
    private $id_convenio;
    private $id_sede;

    /**
     * Get the value of id_detalle_convenio
     */
    public function getId_detalle_convenio()
    {
        return $this->id_detalle_convenio;
    }

    /**
     * Set the value of id_detalle_convenio
     *
     * @return  self
     */
    public function setId_detalle_convenio($id_detalle_convenio)
    {
        $this->id_detalle_convenio = $id_detalle_convenio;

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
     * Get the value of id_convenio
     */
    public function getId_convenio()
    {
        return $this->id_convenio;
    }

    /**
     * Set the value of id_convenio
     *
     * @return  self
     */
    public function setId_convenio($id_convenio)
    {
        $this->id_convenio = $id_convenio;

        return $this;
    }

    /**
     * Get the value of id_sede
     */
    public function getId_sede()
    {
        return $this->id_sede;
    }

    /**
     * Set the value of id_sede
     *
     * @return  self
     */
    public function setId_sede($id_sede)
    {
        $this->id_sede = $id_sede;

        return $this;
    }

    public function __construct($id_detalle_convenio, $fecha_inicio, $fecha_fin, $id_convenio, $id_sede)
    {
        $this->id_detalle_convenio = $id_detalle_convenio;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
        $this->id_convenio = $id_convenio;
        $this->id_sede = $id_sede;
    }
}
