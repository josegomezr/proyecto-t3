<?php
class Entrada_model extends MY_Model
{

    function __construct() {
    
        parent::__construct();
        $this->load->database();
    }
    public function buscar($criteria) {
        if (is_array($criteria)) {
            return $this->db->where($criteria)->get('entrada');
        }
        return $this->db->where($criteria)->get('entrada');
    }

    public function reporte($id_entrada) {
        return $this->db->query("SELECT *, salida.id_conductor, entrada_incidencia.id_incidencia as id_incidencia_entrada, salida_incidencia.id_incidencia as id_incidencia_salida
FROM entrada
LEFT JOIN salida USING(id_salida)
LEFT JOIN recorrido USING(id_recorrido)
LEFT JOIN unidad USING(id_unidad)
LEFT JOIN entrada_incidencia USING(id_entrada)
LEFT JOIN salida_incidencia USING(id_salida)
WHERE id_entrada = '$id_entrada'");
    }

    public function crear($data) {
        
        $tipo_incidencia = $data['id_tipo_incidencia'];
        $incidencia = $data['id_incidencia'];
        $comentario_entrada_incidencia = $data['comentario_entrada_incidencia'];
        
        unset($data['id_tipo_incidencia'], $data['id_incidencia'], $data['comentario_entrada_incidencia']);

        $this->db->set($data)->insert('entrada');

        $id_entrada = $this->db->insert_id();
        if ($incidencia) {
            $this->db->set(array(
                'id_entrada' => $id_entrada,
                'id_incidencia' => $incidencia,
                'comentario_entrada_incidencia' => $comentario_entrada_incidencia
            ))->insert('entrada_incidencia');
        }
    }

    public function editar($criteria, $data) {

        $tipo_incidencia = $data['id_tipo_incidencia'];
        $incidencia = $data['id_incidencia'];
        $comentario_salida_incidencia = $data['comentario_entrada_incidencia'];
        
        unset($data['id_tipo_incidencia'], $data['id_incidencia'], $data['comentario_entrada_incidencia']);

        $this->db->set($data)->where($criteria)->update('entrada');

        $this->db->where(
            array('id_entrada' => $criteria['id_entrada']
            )
        )->delete('entrada_incidencia');

        if ($incidencia) {
            $this->db->set(array(
                'id_entrada' => $id_entrada,
                'id_incidencia' => $incidencia,
                'comentario_entrada_incidencia' => $comentario_entrada_incidencia
            ))->insert('entrada_incidencia');
        }
    }

    public function eliminar($criteria) {
        if (is_array($criteria)) {
            return $this->db->where($criteria)->delete('entrada');
        }
        return $this->db->where($criteria)->delete('entrada');
    }
}
