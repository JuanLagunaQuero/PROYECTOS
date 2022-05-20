<?php
class Empresa
{
    protected $id_empresa;
    private $nombre_empresa;

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

    /**
     * Get the value of nombre_empresa
     */
    public function getNombre_empresa()
    {
        return $this->nombre_empresa;
    }

    /**
     * Set the value of nombre_empresa
     *
     * @return  self
     */
    public function setNombre_empresa($nombre_empresa)
    {
        $this->nombre_empresa = $nombre_empresa;

        return $this;
    }

    public function __construct($id_empresa, $nombre_empresa)
    {
        $this->id_empresa = $id_empresa;
        $this->nombre_empresa = $nombre_empresa;
    }
}
