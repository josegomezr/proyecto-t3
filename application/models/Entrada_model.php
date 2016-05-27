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
        return $this->db->query("SELECT *, salida.id_conductor, entrada_incidencia.id_incidencia as id_incidencia_entrada, salida_incidencia.id_incidencia as id_incidencia_salida
FROM entrada
LEFT JOIN salida USING(id_salida)
LEFT JOIN recorrido USING(id_recorrido)
LEFT JOIN unidad USING(id_unidad)
LEFT JOIN entrada_incidencia USING(id_entrada)
LEFT JOIN salida_incidencia USING(id_salida)
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
