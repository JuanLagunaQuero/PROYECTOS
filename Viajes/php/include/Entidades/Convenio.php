<?php
class Convenio
{
    protected $id_convenio;
    private $descripicion;

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
     * Get the value of descripicion
     */
    public function getDescripicion()
    {
        return $this->descripicion;
    }

    /**
     * Set the value of descripicion
     *
     * @return  self
     */
    public function setDescripicion($descripicion)
    {
        $this->descripicion = $descripicion;

        return $this;
    }

    public function __construct($id_convenio, $descripicion)
    {
        $this->id_convenio = $id_convenio;
        $this->descripicion = $descripicion;
    }
}
