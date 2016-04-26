<?php 
class MY_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    	$this->load->database();
    }

    public function listar(){
    	throw new Exception('Not Implemented Yet');
    }

    public function buscar($criteria, $value){
    	throw new Exception('Not Implemented Yet');
    }

    public function crear($data){
    	throw new Exception('Not Implemented Yet');
    }

    public function editar($criteria, $value, $data){
    	throw new Exception('Not Implemented Yet');
    }

    public function eliminar($criteria, $value){
    	throw new Exception('Not Implemented Yet');
    }
}
