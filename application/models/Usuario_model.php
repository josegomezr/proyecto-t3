<?php
class Usuario_model extends MY_Model {

    function __construct()
    {
        parent::__construct();
    	$this->load->database();
    }

    public function listar(){
        return $this->db->get('usuario')->result();
    }

    public function buscar($criteria, $value){
        if(is_array($criteria))
            return $this->db->where($criteria)->get('usuario');
        return $this->db->where($criteria, $value)->get('usuario');
    }

    public function crear($data){
        return $this->db->insert('usuario', $data);
    }

    public function editar($criteria, $value, $data){
        if(is_array($criteria))
            return $this->db->where($criteria)->update('usuario', $data);
        return $this->db->where($criteria, $value)->update('usuario', $data);
    }

    public function eliminar($criteria, $value){
        if(is_array($criteria))
            return $this->db->where($criteria)->delete('usuario');
        return $this->db->where($criteria, $value)->delete('usuario');
    }

}
