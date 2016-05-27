<?php
class Unidad_model extends MY_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function listar(){
        return $this->db->select('*, unidad.id_unidad')->join('dispositivo', 'dispositivo.id_unidad = unidad.id_unidad', 'left')->get('unidad');
    }

    public function listar_sin_salir(){
        return $this->db->query("SELECT * FROM unidad 
WHERE id_unidad NOT IN 
(SELECT salida.id_unidad FROM salida 
LEFT JOIN entrada USING (id_salida) 
WHERE entrada.id_salida IS NULL) ");

    }

    public function listar_sin_dispositivo($id_dispositivo = NULL){
        $sql = "SELECT * FROM unidad
        LEFT JOIN dispositivo USING(id_unidad)
        WHERE dispositivo.id_unidad IS NULL";
        if ($id_dispositivo) {
            $sql .= " OR id_dispositivo = $id_dispositivo";
        }
        return $this->db->query($sql);

    }

    public function buscar($criteria, $value){
        if(is_array($criteria))
            return $this->db->where($criteria)->get('unidad');
        return $this->db->where($criteria, $value)->get('unidad');
    }

    public function crear($data){
        return $this->db->insert('unidad', $data);
    }

    public function editar($criteria, $value, $data){
        if(is_array($criteria))
            return $this->db->where($criteria)->update('unidad', $data);
        return $this->db->where($criteria, $value)->update('unidad', $data);
    }

    public function eliminar($criteria, $value){
        if(is_array($criteria))
            return $this->db->where($criteria)->delete('unidad');
        return $this->db->where($criteria, $value)->delete('unidad');
    }


}
