<?php
class Recorrido_model extends MY_Model
{

    function __construct() {
    
        parent::__construct();
        $this->load->database();
    }

    public function listar() {
        return $this->db->order_by('id_recorrido', 'asc')->get('recorrido');
    }

    public function buscar($criteria) {
        return $this->db->where($criteria)->get('recorrido');
    }

    public function crear($data) {
        return $this->db->insert('recorrido', $data);
    }

    public function editar($criteria, $data) {
        if (is_array($criteria)) {
            return $this->db->where($criteria)->update('recorrido', $data);
        }
        return $this->db->where($criteria)->update('recorrido', $data);
    }

    public function eliminar($criteria) {
        if (is_array($criteria)) {
            return $this->db->where($criteria)->delete('recorrido');
        }
        return $this->db->where($criteria)->delete('recorrido');
    }

    public function guardar_trazado($id_recorrido, $puntos) {
    
        $pks = array();
        foreach ($puntos as $punto) {
            $registro = array(
                'latitud' => $punto[0],
                'longitud' => $punto[1]
            );
            $this->db->insert('punto', $registro);
            $pk = $this->db->insert_id();
            
            $pks[] = array(
                'id_punto' => $pk,
                'id_recorrido' => $id_recorrido
            );
        }

        $this->db->where('id_recorrido', $id_recorrido)->delete('punto_recorrido');
        $this->db->insert_batch('punto_recorrido', $pks);
    }
    
    public function obtener_trazado($id_recorrido) {
    	
        return $this->db->join('punto', 'id_punto', 'left')
        		->where('id_recorrido', $id_recorrido)
        		->get('punto_recorrido');
    }
}
