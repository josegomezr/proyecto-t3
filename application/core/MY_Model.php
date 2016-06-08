<?php
abstract class MY_Model extends CI_Model
{
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    abstract public function listar();

    abstract public function buscar($criteria);

    abstract public function crear($data);

    abstract public function editar($criteria, $data);

    abstract public function eliminar($criteria);
}
