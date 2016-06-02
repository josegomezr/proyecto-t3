<?php
class Incidencia_model extends MY_Model
{

    function __construct() {
    
        parent::__construct();
        $this->load->database();
    }

    public function listar() {
        return $this->db
            ->join(
                'tipo_incidencia',
                'incidencia.id_tipo_incidencia = tipo_incidencia.id_tipo_incidencia'
            )
            ->get('incidencia');
    }

    public function buscar($criteria) {
        $dbo = $this->db->join('tipo_incidencia', 'incidencia.id_tipo_incidencia = tipo_incidencia.id_tipo_incidencia', 'LEFT');
        if (is_array($criteria)) {
            return $dbo->where($criteria)
                ->get('incidencia');
        }
        return $dbo->where($criteria)
            ->get('incidencia');
    }

    public function crear($data) {
        return $this->db
            ->insert('incidencia', $data);
    }

    public function editar($criteria, $data = null) {
        if (is_array($criteria)) {
            return $this->db
                ->where($criteria)
                ->update('incidencia');
        }
        return $this->db
            ->where($criteria)
            ->update('incidencia', $data);
    }

    public function eliminar($criteria) {
        if (is_array($criteria)) {
            return $this->db
                ->where($criteria)
                ->delete('incidencia');
        }
        return $this->db
            ->where($criteria)
            ->delete('incidencia');
    }
}
