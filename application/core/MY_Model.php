<?php
class MY_Model extends CI_Model
{

    function __construct() {
    
        parent::__construct();
        $this->load->database();
    }

    public function listar() {
        throw new Exception('Not Implemented Yet');
    }

    public function buscar($criteria) {
        throw new Exception('Not Implemented Yet');
    }

    public function crear($data) {
        throw new Exception('Not Implemented Yet');
    }

    public function editar($criteria, $data) {
        throw new Exception('Not Implemented Yet');
    }

    public function eliminar($criteria) {
        throw new Exception('Not Implemented Yet');
    }
}
