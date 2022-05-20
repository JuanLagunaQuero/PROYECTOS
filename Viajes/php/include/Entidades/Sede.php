<?php
class Sede
{
    protected $id_sede;
    private $descripcion;
    private $direccion;
    private $codigo_postal;
    private $localidad;
    private $municipio;
    private $provincia;
    private $id_empresa;

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

    /**
     * Get the value of descripcion
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     *
     * @return  self
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get the value of direccion
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set the value of direccion
     *
     * @return  self
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get the value of codigo_postal
     */
    public function getCodigo_postal()
    {
        return $this->codigo_postal;
    }

    /**
     * Set the value of codigo_postal
     *
     * @return  self
     */
    public function setCodigo_postal($codigo_postal)
    {
        $this->codigo_postal = $codigo_postal;

        return $this;
    }

    /**
     * Get the value of localidad
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * Set the value of localidad
     *
     * @return  self
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get the value of municipio
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * Set the value of municipio
     *
     * @return  self
     */
    public function setMunicipio($municipio)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get the value of provincia
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set the value of provincia
     *
     * @return  self
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get the value of id_empresa
     */
    public function getId_empresa()
    {
        return $this->id_empresa;
    }

    /**
     * Set the value of id_empresa
     *
     * @return  self
     */
    public function setId_empresa($id_empresa)
    {
        $this->id_empresa = $id_empresa;

        return $this;
    }

    public function __construct($id_sede, $descripcion, $direccion, $codigo_postal, $localidad, $municipio, $provincia, $id_empresa)
    {
        $this->id_sede = $id_sede;
        $this->descripcion = $descripcion;
        $this->direccion = $direccion;
        $this->codigo_postal = $codigo_postal;
        $this->localidad = $localidad;
        $this->municipio = $municipio;
        $this->provincia = $provincia;
        $this->id_empresa = $id_empresa;
    }
}
