<?php
class Dispositivo_model extends MY_Model {

    function __construct()
    {
        parent::__construct();
	   $this->load->database();
    }

    public function listar(){
        return $this->db->query("SELECT * 
FROM dispositivo
LEFT JOIN unidad USING (placa_unidad)
LEFT JOIN recorrido USING (id_recorrido)
");
    }

    public function buscar($criteria, $value){
        if(is_array($criteria))
            return $this->db->where($criteria)->get('dispositivo');
        return $this->db->where($criteria, $value)->get('dispositivo');
    }

    public function crear($data){
        return $this->db->insert('dispositivo', $data);
    }

    public function editar($criteria, $value, $data){
        if(is_array($criteria))
            return $this->db->where($criteria)->update('dispositivo', $data);
        return $this->db->where($criteria, $value)->update('dispositivo', $data);
    }

    public function eliminar($criteria, $value){
        if(is_array($criteria))
            return $this->db->where($criteria)->delete('dispositivo');
        return $this->db->where($criteria, $value)->delete('dispositivo');
    }
}
