<?php
class Incidencia_model extends MY_Model
{

    function __construct() {
    
        parent::__construct();
        $this->load->database();
    }

    public function listar() {
        return $this->db
            ->join(
                'tipo_incidencia',
                'incidencia.id_tipo_incidencia = tipo_incidencia.id_tipo_incidencia'
            )
            ->get('incidencia');
    }

    public function buscar($criteria) {
        $dbo = $this->db->join('tipo_incidencia', 'incidencia.id_tipo_incidencia = tipo_incidencia.id_tipo_incidencia', 'LEFT');
        if (is_array($criteria)) {
            return $dbo->where($criteria)
                ->get('incidencia');
        }
        return $dbo->where($criteria)
            ->get('incidencia');
    }

    public function crear($data) {
        return $this->db
            ->insert('incidencia', $data);
    }

    public function editar($criteria, $data = null) {
        return $this->db
            ->where($criteria)
            ->update('incidencia', $data);
    }

    public function eliminar($criteria) {
        if (is_array($criteria)) {
            return $this->db
                ->where($criteria)
                ->delete('incidencia');
        }
        return $this->db
            ->where($criteria)
            ->delete('incidencia');
    }

    public function por_unidad($criteria = array())
    {
        $cuentaSalidaSQL = $this->db->select("COUNT(*)", false)
                    ->from("salida_incidencia")
                    ->join('salida', 'id_salida', 'left')
                    ->where($criteria['salida'])
                    ->where('id_unidad', 'unidad.id_unidad', false)
                    ->get_compiled_select();

        $cuentaEntradaSQL = $this->db->select("COUNT(*)", false)
                    ->from("entrada_incidencia")
                    ->join('entrada', 'id_entrada', 'left')
                    ->join('salida', 'id_salida', 'left')
                    ->where($criteria['entrada'])
                    ->where('salida.id_unidad', 'unidad.id_unidad', false)
                    ->get_compiled_select();
        
        $result = array();

        $salida_r = $this->db
            ->select("CONCAT(modelo_unidad, '(', placa_unidad,')') as label", false)
            ->select("({$cuentaSalidaSQL}) as total", true)
            ->from('unidad')
            ->get()->result();

        $entrada_r = $this->db
            ->select("CONCAT(modelo_unidad, '(', placa_unidad,')') as label", false)
            ->select("({$cuentaEntradaSQL}) as total", true)
            ->from('unidad')
            ->get()->result();

        $result['entrada'] = $entrada_r;
        $result['salida'] = $salida_r;
        return $result;
    }

    public function por_conductor($criteria = array())
    {
        $cuentaSalidaSQL = $this->db->select("COUNT(*)", false)
                    ->from("salida_incidencia")
                    ->join('salida', 'id_salida', 'left')
                    ->where($criteria['salida'])
                    ->where('id_conductor', 'conductor.id_conductor', false)
                    ->get_compiled_select();

        $cuentaEntradaSQL = $this->db->select("COUNT(*)", false)
                    ->from("entrada_incidencia")
                    ->join('entrada', 'id_entrada', 'left')
                    ->join('salida', 'id_salida', 'left')
                    ->where($criteria['entrada'])
                    ->where('salida.id_conductor', 'conductor.id_conductor', false)
                    ->get_compiled_select();
        
        $result = array();

        $salida_r = $this->db
            ->select("CONCAT(nombre_conductor, ' ', apellido_conductor) as label", false)
            ->select("({$cuentaSalidaSQL}) as total", true)
            ->from('conductor')
            ->get()->result();

        $entrada_r = $this->db
            ->select("CONCAT(nombre_conductor, ' ', apellido_conductor) as label", false)
            ->select("({$cuentaEntradaSQL}) as total", true)
            ->from('conductor')
            ->get()->result();
        $result['entrada'] = $entrada_r;
        $result['salida'] = $salida_r;
        return $result;
    }

    public function por_recorrido($criteria = array())
    {
        $cuentaSalidaSQL = $this->db->select("COUNT(*)", false)
                    ->from("salida_incidencia")
                    ->join('salida', 'id_salida', 'left')
                    ->where($criteria['salida'])
                    ->where('id_recorrido', 'recorrido.id_recorrido', false)
                    ->get_compiled_select();
        

        $cuentaEntradaSQL = $this->db->select("COUNT(*)", false)
                    ->from("entrada_incidencia")
                    ->join('entrada', 'id_entrada', 'left')
                    ->join('salida', 'id_salida', 'left')
                    ->where($criteria['entrada'])
                    ->where('salida.id_recorrido', 'recorrido.id_recorrido', false)
                    ->get_compiled_select();
        
        
        $result = array();

        $salida_r = $this->db
            ->select("nombre_recorrido as label", false)
            ->select("({$cuentaSalidaSQL}) as total", true)
            ->from('recorrido')
            ->get()->result();

        $entrada_r = $this->db
            ->select("nombre_recorrido as label", false)
            ->select("({$cuentaEntradaSQL}) as total", true)
            ->from('recorrido')
            ->get()->result();

        $result['entrada'] = $entrada_r;
        $result['salida'] = $salida_r;
        return $result;
    }

    public function detalle_por_unidad($criteria)
    {
        $ids = $criteria['id_unidad'];
        unset($criteria['id_unidad']);
        $cuentaSalidaConductorSQL = $this->db->select("id_conductor")
                    ->from("salida_incidencia")
                    ->join('salida', 'id_salida', 'left')
                    ->where($criteria['salida'])
                    ->where('id_conductor', 'conductor.id_conductor', false)
                    ->where_in('id_unidad', $ids)
                    ->group_by('id_conductor')
                    ->get_compiled_select();

        $cuentaSalidaRecorridoSQL = $this->db->select("id_recorrido")
                    ->from("salida_incidencia")
                    ->join('salida', 'id_salida', 'left')
                    ->where($criteria['salida'])
                    ->where('id_recorrido', 'recorrido.id_recorrido', false)
                    ->where_in('id_unidad', $ids)
                    ->group_by('id_recorrido')
                    ->get_compiled_select();

        $result = array();

        $salida_conductor_r = $this->db
            ->select("CONCAT(nombre_conductor, ' ', apellido_conductor) as label", false)
            ->select("COALESCE(({$cuentaSalidaConductorSQL}), 0) as total", true)
            ->from('conductor')
            ->get()->result();

        $salida_recorrido_r = $this->db
            ->select("nombre_recorrido as label", false)
            ->select("COALESCE(({$cuentaSalidaRecorridoSQL}), 0) as total", true)
            ->from('recorrido')
            ->get()->result();

        $result['salida'] = array(
            'conductor' => $salida_conductor_r,
            'recorrido' => $salida_recorrido_r
        );

        $cuentaSalidaConductorSQL = $this->db->select("COUNT(*)")
                    ->from("entrada_incidencia")
                    ->join('entrada', 'id_entrada', 'left')
                    ->join('salida', 'id_salida', 'left')
                    ->where($criteria['salida'])
                    ->where('id_conductor', 'conductor.id_conductor', false)
                    ->where_in('id_unidad', $ids)
                    ->group_by('id_conductor')
                    ->get_compiled_select();

        $cuentaSalidaRecorridoSQL = $this->db->select("COUNT(*)")
                    ->from("entrada_incidencia")
                    ->join('entrada', 'id_entrada', 'left')
                    ->join('salida', 'id_salida', 'left')
                    ->where($criteria['salida'])
                    ->where('id_recorrido', 'recorrido.id_recorrido', false)
                    ->where_in('id_unidad', $ids)
                    ->group_by('id_recorrido')
                    ->get_compiled_select();

        $entrada_conductor_r = $this->db
            ->select("CONCAT(nombre_conductor, ' ', apellido_conductor) as label", false)
            ->select("COALESCE(({$cuentaSalidaConductorSQL}), 0) as total", true)
            ->from('conductor')
            ->get()->result();

        $entrada_recorrido_r = $this->db
            ->select("nombre_recorrido as label", false)
            ->select("COALESCE(({$cuentaSalidaRecorridoSQL}), 0) as total", true)
            ->from('recorrido')
            ->get()->result();

        $result['entrada'] = array(
            'conductor' => $entrada_conductor_r,
            'recorrido' => $entrada_recorrido_r
        );
        return $result;
    }

    public function detalle_por_conductor($criteria)
    {
        $ids = $criteria['id_conductor'];
        unset($criteria['id_conductor']);

        $cuentaSalidaUnidadSQL = $this->db->select("COUNT(*)")
                    ->from("salida_incidencia")
                    ->join('salida', 'id_salida', 'left')
                    ->where($criteria['salida'])
                    ->where('id_unidad', 'unidad.id_unidad', false)
                    ->where_in('id_conductor', $ids)
                    ->group_by('id_unidad')
                    ->get_compiled_select();

        $cuentaSalidaRecorridoSQL = $this->db->select("COUNT(*)")
                    ->from("salida_incidencia")
                    ->join('salida', 'id_salida', 'left')
                    ->where($criteria['salida'])
                    ->where('id_recorrido', 'recorrido.id_recorrido', false)
                    ->where_in('id_conductor', $ids)
                    ->group_by('id_recorrido')
                    ->get_compiled_select();

        $result = array();

        $salida_unidad_r = $this->db
            ->select("CONCAT(modelo_unidad, '(', placa_unidad,')') as label", false)
            ->select("COALESCE(({$cuentaSalidaUnidadSQL}), 0) as total", true)
            ->from('unidad')
            ->get()->result();

        $salida_recorrido_r = $this->db
            ->select("nombre_recorrido as label", false)
            ->select("COALESCE(({$cuentaSalidaRecorridoSQL}), 0) as total", true)
            ->from('recorrido')
            ->get()->result();

        $result['salida'] = array(
            'unidad' => $salida_unidad_r,
            'recorrido' => $salida_recorrido_r
        );

        $cuentaSalidaUnidadSQL = $this->db->select("count(*)")
                    ->from("entrada_incidencia")
                    ->join('entrada', 'id_entrada', 'left')
                    ->join('salida', 'id_salida', 'left')
                    ->where($criteria['entrada'])
                    ->where('id_unidad', 'unidad.id_unidad', false)
                    ->where_in('id_conductor', $ids)
                    ->group_by('id_unidad')
                    ->get_compiled_select();

        $cuentaSalidaRecorridoSQL = $this->db->select("count(*)")
                    ->from("entrada_incidencia")
                    ->join('entrada', 'id_entrada', 'left')
                    ->join('salida', 'id_salida', 'left')
                    ->where($criteria['entrada'])
                    ->where('id_recorrido', 'recorrido.id_recorrido', false)
                    ->where_in('id_conductor', $ids)
                    ->group_by('id_recorrido')
                    ->get_compiled_select();

        $entrada_unidad_r = $this->db
            ->select("CONCAT(modelo_unidad, '(', placa_unidad,')') as label", false)
            ->select("COALESCE(({$cuentaSalidaUnidadSQL}), 0) as total", true)
            ->from('unidad')
            ->get()->result();

        $entrada_recorrido_r = $this->db
            ->select("nombre_recorrido as label", false)
            ->select("COALESCE(({$cuentaSalidaRecorridoSQL}), 0) as total", true)
            ->from('recorrido')
            ->get()->result();

        $result['entrada'] = array(
            'unidad' => $entrada_unidad_r,
            'recorrido' => $entrada_recorrido_r
        );
        return $result;
    }

    public function detalle_por_recorrido($criteria)
    {
        $ids = $criteria['id_recorrido'];
        unset($criteria['id_recorrido']);
        $cuentaSalidaUnidadSQL = $this->db->select("COUNT(*)")
                    ->from("salida_incidencia")
                    ->join('salida', 'id_salida', 'left')
                    ->where($criteria['salida'])
                    ->where('salida.id_unidad', 'unidad.id_unidad', false)
                    ->where_in('id_recorrido', $ids)
                    ->group_by('id_unidad')
                    ->get_compiled_select();

        $cuentaSalidaConductorSQL = $this->db->select("COUNT(*)")
                    ->from("salida_incidencia")
                    ->join('salida', 'id_salida', 'left')
                    ->where($criteria['salida'])
                    ->where('salida.id_conductor', 'conductor.id_conductor', false)
                    ->where_in('id_recorrido', $ids)
                    ->group_by('id_conductor')
                    ->get_compiled_select();

        $result = array();

        $salida_unidad_r = $this->db
            ->select("CONCAT(modelo_unidad, '(', placa_unidad,')') as label", false)
            ->select("COALESCE(({$cuentaSalidaUnidadSQL}), 0) as total", true)
            ->from('unidad')
            ->get()->result();

        $salida_conductor_r = $this->db
            ->select("CONCAT(nombre_conductor, ' ', apellido_conductor) as label", false)
            ->select("COALESCE(({$cuentaSalidaConductorSQL}), 0) as total", true)
            ->from('conductor')
            ->get()->result();

        $result['salida'] = array(
            'conductor' => $salida_unidad_r,
            'unidad' => $salida_unidad_r
        );

        $cuentaSalidaUnidadSQL = $this->db->select("COUNT(*)")
                    ->from("entrada_incidencia")
                    ->join('entrada', 'id_entrada', 'left')
                    ->join('salida', 'id_salida', 'left')
                    ->where($criteria['entrada'])
                    ->where('salida.id_unidad', 'unidad.id_unidad', false)
                    ->where_in('id_recorrido', $ids)
                    ->group_by('id_unidad')
                    ->get_compiled_select();

        $cuentaSalidaConductorSQL = $this->db->select("COUNT(*)")
                    ->from("entrada_incidencia")
                    ->join('entrada', 'id_entrada', 'left')
                    ->join('salida', 'id_salida', 'left')
                    ->where($criteria['entrada'])
                    ->where('salida.id_conductor', 'conductor.id_conductor', false)
                    ->where_in('id_recorrido', $ids)
                    ->group_by('id_conductor')
                    ->get_compiled_select();

        $entrada_unidad_r = $this->db
            ->select("CONCAT(modelo_unidad, '(', placa_unidad,')') as label", false)
            ->select("COALESCE(({$cuentaSalidaUnidadSQL}), 0) as total", true)
            ->from('unidad')
            ->get()->result();

        $entrada_conductor_r = $this->db
            ->select("CONCAT(nombre_conductor, ' ', apellido_conductor) as label", false)
            ->select("COALESCE(({$cuentaSalidaConductorSQL}), 0) as total", true)
            ->from('conductor')
            ->get()->result();

        $result['entrada'] = array(
            'conductor' => $entrada_conductor_r,
            'unidad' => $entrada_unidad_r
        );
        return $result;
    }
}
