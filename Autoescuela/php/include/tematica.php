<?php
class Tematica{
    protected $id_tematica;
    private $nombre;

    public function getid_tematica(){return $this->id_tematica;}
    public function getnombre(){return $this->nombre;}

    public function __construct($id_tematica, $nombre)
    {
        $this->id_tematica = $id_tematica;
        $this->nombre = $nombre;
    }
}
