<?php
class Conductor_model extends MY_Model
{

    function __construct() {
    
        parent::__construct();
        $this->load->database();
    }

    public function listar() {
        return $this->db
        	->select('*')
        	->from('conductor')
            ->order_by('apellido_conductor', 'asc')
            ->order_by('nombre_conductor', 'asc')
            ->get();
    }

    public function listar_disponibles() {
        return $this->db->query("SELECT * FROM conductor 
WHERE id_conductor NOT IN 
(SELECT salida.id_conductor FROM salida 
LEFT JOIN entrada USING (id_salida) 
WHERE entrada.id_salida IS NULL)");
    }

    public function listar_ocupados() {
        return $this->db->query("SELECT * FROM conductor 
WHERE id_conductor IN 
(SELECT salida.id_conductor FROM salida 
LEFT JOIN entrada USING (id_salida) 
WHERE entrada.id_salida IS NULL)");
    }

    public function buscar($criteria) {
        return $this->db->where($criteria)->get('conductor');
    }

    public function crear($data) {
        return $this->db->insert('conductor', $data);
    }

    public function editar($criteria, $data) {
        if (is_array($criteria)) {
            return $this->db->where($criteria)->update('conductor', $data);
        }
        return $this->db->where($criteria)->update('conductor', $data);
    }

    public function eliminar($criteria) {
        if (is_array($criteria)) {
            return $this->db->where($criteria)->delete('conductor');
        }
        return $this->db->where($criteria)->delete('conductor');
    }
}
