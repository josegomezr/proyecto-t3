<?php
class Usuario_model extends MY_Model
{

    function __construct() {
    
        parent::__construct();
        $this->load->database();
    }

    public function listar() {
        return $this->db->get('usuario');
    }

    public function buscar($criteria) {
        if (is_array($criteria)) {
            return $this->db->where($criteria)->get('usuario');
        }
        return $this->db->where($criteria)->get('usuario');
    }

    public function crear($data) {
        return $this->db->insert('usuario', $data);
    }

    public function editar($criteria, $data = null) {
        if (is_array($criteria)) {
            return $this->db->where($criteria)->update('usuario');
        }
        return $this->db->where($criteria)->update('usuario', $data);
    }

    public function eliminar($criteria) {
        if (is_array($criteria)) {
            return $this->db->where($criteria)->delete('usuario');
        }
        return $this->db->where($criteria)->delete('usuario');
    }
}
