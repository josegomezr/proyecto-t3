<?php
class Salida_model extends MY_Model
{

    public function __construct() {
    
        parent::__construct();
        $this->load->database();
    }

    public function listar() {
        return $this->db
                ->select("*")
                ->select("(select 1 from entrada where entrada.id_salida = salida.id_salida ) as salio", false)
                ->from("salida")
                ->join('conductor', 'salida.id_conductor = conductor.id_conductor')
                ->join('recorrido', 'salida.id_recorrido = recorrido.id_recorrido')
                ->join('unidad', 'salida.id_unidad = unidad.id_unidad')
                ->get()
                ;
    }

    public function listar_en_proceso($pagina, $registros_per_pagina) {
        $inicio = ($pagina-1) * $registros_per_pagina;
        return $this->_buscar_en_proceso()->limit($registros_per_pagina, $inicio)->get();
    }

    public function listar_completas($pagina, $registros_per_pagina) {
        $inicio = ($pagina-1) * $registros_per_pagina;
        return $this->_buscar_completas()->limit($registros_per_pagina, $inicio)->get();
    }

    public function contar_completas() {
        $idSalidaSQL = $this->db
            ->select('id_salida')
            ->from('entrada')
            ->get_compiled_select();

        return $this->db
            ->select('count(*) as cuenta', false)
            ->where("id_salida IN ({$idSalidaSQL})", null, false)
            ->get('salida')->row()->cuenta;
    }

    public function contar_en_proceso() {
        $idSalidaSQL = $this->db
            ->select('id_salida')
            ->from('entrada')
            ->get_compiled_select();

        return $this->db
            ->select('count(*) as cuenta', false)
            ->where("id_salida NOT IN ({$idSalidaSQL})", null, false)
            ->get('salida')->row()->cuenta;
    }

    private function _buscar($criteria = array()) {
        return $this->db
            ->select('*')
            ->select('unidad.id_unidad as id_unidad')
            ->from('salida')
            ->join('conductor', 'id_conductor', 'left')
            ->join('recorrido', 'id_recorrido', 'left')
            ->join('unidad', 'id_unidad', 'left')
            ->join('entrada', 'id_salida', 'left')
            ->join('salida_incidencia', 'id_salida', 'left')
            ->join('incidencia', 'id_incidencia', 'left')
            ->order_by('entrada.fecha_entrada', 'DESC')
            ->order_by('salida.fecha_salida', 'DESC')
            ->where($criteria)
            ;
    }
    public function buscar($criteria = array()) {
        return $this->_buscar($criteria)->get();
    }

    private function _buscar_completas($criteria = array()) {
        $salioSQL = $this->db
            ->select('1')
            ->from('entrada')
            ->where('entrada.id_salida', 'salida.id_salida', false)
            ->limit(1)
            ->get_compiled_select();

        $idSalidaSQL = $this->db
            ->select('id_salida')
            ->from('entrada')
            ->get_compiled_select();

        return $this->_buscar($criteria)
                ->select("(${salioSQL}) as salio")
                ->where('id_salida IN', "($idSalidaSQL)", false);
    }

    private function _buscar_en_proceso($criteria = array()) {
        return $this->_buscar($criteria)
                ->where('id_entrada IS NULL', null, false);
    }

    public function buscar_completas($criteria = array()) {
        return $this->_buscar_completas($criteria)->get();
    }

    public function buscar_en_proceso($criteria = array()) {
        return $this->_buscar_en_proceso($criteria)->get();
    }

    public function crear($data) {
        
        if (!$data['id_acompaniante']) {
            $data['id_acompaniante'] = null;
        }
        
        $tipo_incidencia = $data['id_tipo_incidencia'];
        $incidencia = $data['id_incidencia'];
        $comentario_salida_incidencia = $data['comentario_salida_incidencia'];
        
        unset($data['id_tipo_incidencia'], $data['id_incidencia'], $data['comentario_salida_incidencia']);

        $this->db->set($data)->insert('salida');

        $id_salida = $this->db->insert_id();
        if ($incidencia) {
            $this->db->set(array(
                'id_salida' => $id_salida,
                'id_incidencia' => $incidencia,
                'comentario_salida_incidencia' => $comentario_salida_incidencia
            ))->insert('salida_incidencia');
        }
    }

    public function editar($criteria, $data) {
        print_r($data);

        $tipo_incidencia = $data['id_tipo_incidencia'];
        $incidencia = $data['id_incidencia'];
        $comentario_salida_incidencia = $data['comentario_salida_incidencia'];
        
        unset($data['id_tipo_incidencia'], $data['id_incidencia'], $data['comentario_salida_incidencia']);

        
        if (!$data['id_acompaniante']) {
            $data['id_acompaniante'] = null;
        }

        $this->db->set($data)->where($criteria)->update('salida');

        $this->db->where(
            array('id_salida' => $criteria['id_salida']
            )
        )->delete('salida_incidencia');

        if ($incidencia) {
            $this->db->set(array(
                'id_salida' => $id_salida,
                'id_incidencia' => $incidencia,
                'comentario_salida_incidencia' => $comentario_salida_incidencia
            ))->insert('salida_incidencia');
        }
    }

    public function eliminar($criteria) {
        $this->db->where(
            array('id_salida' => $criteria['id_salida']
            )
        )->delete('salida_incidencia');
        return $this->db->where($criteria)->delete('salida');
    }

    public function guardar_trazado($id_salida, $puntos) {
    
        foreach ($puntos as &$punto) {
            $punto['id_salida'] = $id_salida;
        }

        $this->db->insert_batch('punto_salida', $puntos);
    }

    public function eliminar_recorrido($id_salida) {
    
        return $this->db->where('id_salida', $id_salida)->delete('punto_salida');
    }

    public function buscar_recorrido($id_salida, $id_recorrido) {
        return $this->db->where('id_salida', $id_salida)->get('punto_salida');
    }
}
