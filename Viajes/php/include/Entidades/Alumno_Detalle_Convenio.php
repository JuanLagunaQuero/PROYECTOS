<?php
class Alumno_Detalle_Convenio
{
    protected $id_alumno_detalle_convenio;
    private $nombre_alumno;
    private $id_usuario;
    private $id_detalle_convenio;

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

    /**
     * Get the value of nombre_alumno
     */
    public function getNombre_alumno()
    {
        return $this->nombre_alumno;
    }

    /**
     * Set the value of nombre_alumno
     *
     * @return  self
     */
    public function setNombre_alumno($nombre_alumno)
    {
        $this->nombre_alumno = $nombre_alumno;

        return $this;
    }

    /**
     * Get the value of id_usuario
     */
    public function getId_usuario()
    {
        return $this->id_usuario;
    }

    /**
     * Set the value of id_usuario
     *
     * @return  self
     */
    public function setId_usuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;

        return $this;
    }

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

    public function __construct($id_alumno_detalle_convenio, $nombre_alumno, $id_usuario, $id_detalle_convenio)
    {
        $this->id_alumno_detalle_convenio = $id_alumno_detalle_convenio;
        $this->nombre_alumno = $nombre_alumno;
        $this->id_usuario = $id_usuario;
        $this->id_detalle_convenio = $id_detalle_convenio;
    }
}
