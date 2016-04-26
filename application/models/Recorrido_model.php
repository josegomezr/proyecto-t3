<?php
class Recorrido_model extends MY_Model {

    function __construct()
    {
        parent::__construct();
	   $this->load->database();
    }

    public function listar(){
        return $this->db->order_by('id_recorrido', 'asc')->get('recorrido')->result();
    }

    public function buscar($criteria, $value){
        if(is_array($criteria))
            return $this->db->where($criteria)->get('recorrido');
        return $this->db->where($criteria, $value)->get('recorrido');
    }

    public function crear($data){
        return $this->db->insert('recorrido', $data);
    }

    public function editar($criteria, $value, $data){
        if(is_array($criteria))
            return $this->db->where($criteria)->update('recorrido', $data);
        return $this->db->where($criteria, $value)->update('recorrido', $data);
    }

    public function eliminar($criteria, $value){
        if(is_array($criteria))
            return $this->db->where($criteria)->delete('recorrido');
        return $this->db->where($criteria, $value)->delete('recorrido');
    }

    public function guardar_trazado($id_recorrido, $puntos)
    {
        $rows = array();
        foreach ($puntos as $punto) {
            $rows[] = array(
                'latitud' => $punto[0],
                'longitud' => $punto[1],
                'id_recorrido' => $id_recorrido
            );
        }

        $this->db->where('id_recorrido', $id_recorrido)->delete('punto_recorrido');
        $this->db->insert_batch('punto_recorrido', $rows);
    }
    
    public function obtener_trazado($id_recorrido)
    {
        return $this->db->where('id_recorrido', $id_recorrido)->get('punto_recorrido');
    }


}
