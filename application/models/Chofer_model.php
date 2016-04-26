<?php
class Chofer_model extends MY_Model {

    function __construct()
    {
        parent::__construct();
	$this->load->database();
    }

    public function listar(){
        return $this->db->order_by('cedula_chofer', 'asc')->get('chofer')->result();
    }

    public function listar_disponibles(){
        return $this->db->query("SELECT * FROM chofer 
WHERE cedula_chofer NOT IN 
(SELECT salida.cedula_chofer FROM salida 
LEFT JOIN entrada USING (id_salida) 
WHERE entrada.id_salida IS NULL)")->result();
    }

    public function listar_ocupados(){
        return $this->db->query("SELECT * FROM chofer 
WHERE cedula_chofer IN 
(SELECT salida.cedula_chofer FROM salida 
LEFT JOIN entrada USING (id_salida) 
WHERE entrada.id_salida IS NULL)")->result();
    }

    public function buscar($criteria, $value){
        if(is_array($criteria))
            return $this->db->where($criteria)->get('chofer');
        return $this->db->where($criteria, $value)->get('chofer');
    }

    public function crear($data){
        return $this->db->insert('chofer', $data);
    }

    public function editar($criteria, $value, $data){
        if(is_array($criteria))
            return $this->db->where($criteria)->update('chofer', $data);
        return $this->db->where($criteria, $value)->update('chofer', $data);
    }

    public function eliminar($criteria, $value){
        if(is_array($criteria))
            return $this->db->where($criteria)->delete('chofer');
        return $this->db->where($criteria, $value)->delete('chofer');
    }


}
