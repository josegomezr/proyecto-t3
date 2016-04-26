<?php
class Entrada_model extends MY_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function buscar($criteria, $value){
        if(is_array($criteria))
            return $this->db->where($criteria)->get('entrada');
        return $this->db->where($criteria, $value)->get('entrada');
    }

    public function reporte($id_entrada){
        return $this->db->query("SELECT *, salida.cedula_chofer
FROM entrada
LEFT JOIN salida USING(id_salida)
LEFT JOIN recorrido USING(id_recorrido)
LEFT JOIN unidad USING(placa_unidad)
WHERE id_entrada = '$id_entrada'");
    }

    public function crear($data){
        return $this->db->insert('entrada', $data);
    }

    public function editar($criteria, $value, $data){
        if(is_array($criteria))
            return $this->db->where($criteria)->update('entrada', $data);
        return $this->db->where($criteria, $value)->update('entrada', $data);
    }

    public function eliminar($criteria, $value){
        if(is_array($criteria))
            return $this->db->where($criteria)->delete('entrada');
        return $this->db->where($criteria, $value)->delete('entrada');
    }
   
}
