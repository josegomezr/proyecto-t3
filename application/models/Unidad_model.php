<?php
class Unidad_model extends MY_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function listar(){
        return $this->db->select('*, unidad.placa_unidad')->join('dispositivo', 'dispositivo.placa_unidad = unidad.placa_unidad', 'left')->get('unidad')->result();
    }

    public function listar_sin_salir(){
        return $this->db->query("SELECT * FROM unidad 
WHERE placa_unidad NOT IN 
(SELECT salida.placa_unidad FROM salida 
LEFT JOIN entrada USING (id_salida) 
WHERE entrada.id_salida IS NULL) ")->result();

    }

    public function listar_sin_dispositivo(){
        return $this->db->query("SELECT * FROM unidad LEFT JOIN dispositivo USING(placa_unidad)
WHERE dispositivo.placa_unidad IS NULL")->result();

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
