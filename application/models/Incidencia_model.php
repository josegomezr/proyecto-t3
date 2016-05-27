<?php 
class Incidencia_model extends MY_Model {

    function __construct()
    {
        parent::__construct();
    	$this->load->database();
    }

    public function listar(){
        return $this->db
            ->join('tipo_incidencia', 'incidencia.id_tipo_incidencia = tipo_incidencia.id_tipo_incidencia')
            ->get('incidencia');
    }

    public function buscar($criteria, $value = NULL){
        $dbo = $this->db->join('tipo_incidencia', 'incidencia.id_tipo_incidencia = tipo_incidencia.id_tipo_incidencia');
        if(is_array($criteria)){
            return $dbo->where($criteria)
                ->get('incidencia');
        }
        return $dbo->where($criteria, $value)
            ->get('incidencia');
    }

    public function crear($data){
        return $this->db
            ->insert('incidencia', $data);
    }

    public function editar($criteria, $value = NULL, $data = NULL){
        if(is_array($criteria)){
            return $this->db
                ->where($criteria)
                ->update('incidencia', $value);
        }
        return $this->db
            ->where($criteria, $value)
            ->update('incidencia', $data);
    }

    public function eliminar($criteria, $value = NULL){
        if(is_array($criteria)){
            return $this->db
                ->where($criteria)
                ->delete('incidencia');
        }
        return $this->db
            ->where($criteria, $value)
            ->delete('incidencia');
    }

}
