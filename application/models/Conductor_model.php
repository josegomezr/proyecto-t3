<?php
class Conductor_model extends MY_Model {

    function __construct()
    {
        parent::__construct();
	$this->load->database();
    }

    public function listar(){
        return $this->db->order_by('cedula_conductor', 'asc')->get('conductor')->result();
    }

    public function listar_disponibles(){
        return $this->db->query("SELECT * FROM conductor 
WHERE cedula_conductor NOT IN 
(SELECT salida.cedula_conductor FROM salida 
LEFT JOIN entrada USING (id_salida) 
WHERE entrada.id_salida IS NULL)")->result();
    }

    public function listar_ocupados(){
        return $this->db->query("SELECT * FROM conductor 
WHERE cedula_conductor IN 
(SELECT salida.cedula_conductor FROM salida 
LEFT JOIN entrada USING (id_salida) 
WHERE entrada.id_salida IS NULL)")->result();
    }

    public function buscar($criteria, $value){
        if(is_array($criteria))
            return $this->db->where($criteria)->get('conductor');
        return $this->db->where($criteria, $value)->get('conductor');
    }

    public function crear($data){
        return $this->db->insert('conductor', $data);
    }

    public function editar($criteria, $value, $data){
        if(is_array($criteria))
            return $this->db->where($criteria)->update('conductor', $data);
        return $this->db->where($criteria, $value)->update('conductor', $data);
    }

    public function eliminar($criteria, $value){
        if(is_array($criteria))
            return $this->db->where($criteria)->delete('conductor');
        return $this->db->where($criteria, $value)->delete('conductor');
    }


}
