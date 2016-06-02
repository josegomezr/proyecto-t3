<?php
class Tipo_incidencia_model extends MY_Model
{

    function __construct() {
    
        parent::__construct();
        $this->load->database();
    }

    public function listar() {
        return $this->db
            ->get('tipo_incidencia');
    }

    public function buscar($criteria) {
        if (is_array($criteria)) {
            return $this->db
                ->where($criteria)
                ->get('tipo_incidencia');
        }
        return $this->db
            ->where($criteria)
            ->get('tipo_incidencia');
    }

    public function crear($data) {
        return $this->db
            ->insert('tipo_incidencia', $data);
    }

    public function editar($criteria, $data = null) {
        if (is_array($criteria)) {
            return $this->db
                ->where($criteria)
                ->update('tipo_incidencia');
        }
        return $this->db
            ->where($criteria)
            ->update('tipo_incidencia', $data);
    }

    public function eliminar($criteria) {
        if (is_array($criteria)) {
            return $this->db
                ->where($criteria)
                ->delete('tipo_incidencia');
        }
        return $this->db
            ->where($criteria)
            ->delete('tipo_incidencia');
    }
}
