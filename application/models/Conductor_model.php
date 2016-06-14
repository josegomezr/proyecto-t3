<?php
class Conductor_model extends MY_Model
{

    function __construct() {
    
        parent::__construct();
        $this->load->database();
    }

    public function listar() {
        return $this->db
            ->select('*')
            ->from('conductor')
            ->order_by('apellido_conductor', 'asc')
            ->order_by('nombre_conductor', 'asc')
            ->get();
    }

    public function listar_disponibles($criteria = array()) {
        $sql = $this->db->select('salida.id_conductor')
            ->from('salida')
            ->join('entrada', 'id_salida', 'left')
            ->where('entrada.id_salida IS NULL', null, false)
            ->get_compiled_select();


        return $this->db->from("conductor")
            ->where("id_conductor NOT IN ({$sql})")
            ->where($criteria)
            ->get();
    }

    public function listar_ocupados($criteria = array()) {
        
        $sql = $this->db->select('salida.id_conductor')
            ->from('salida')
            ->join('entrada', 'id_salida', 'left')
            ->where('entrada.id_salida IS NULL', null, false)
            ->get_compiled_select();

        return $this->db->from("conductor")
            ->where("id_conductor IN ({$sql})")
            ->where($criteria)
            ->get();
    }

    public function buscar($criteria) {
        return $this->db->where($criteria)->get('conductor');
    }

    public function crear($data) {
        return $this->db->insert('conductor', $data);
    }

    public function editar($criteria, $data) {
        if (is_array($criteria)) {
            return $this->db->where($criteria)->update('conductor', $data);
        }
        return $this->db->where($criteria)->update('conductor', $data);
    }

    public function eliminar($criteria) {
        if (is_array($criteria)) {
            return $this->db->where($criteria)->delete('conductor');
        }
        return $this->db->where($criteria)->delete('conductor');
    }
}
