<?php
class Salida_model extends MY_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function listar(){
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

    public function listar_en_proceso($pagina, $registros_per_pagina){
        $inicio = ($pagina-1) * $registros_per_pagina;
        return $this->db->query("SELECT *, 
(select 1 from entrada where entrada.id_salida = salida.id_salida ) as salio
FROM salida
LEFT JOIN conductor USING(id_conductor)
LEFT JOIN recorrido USING(id_recorrido)
LEFT JOIN unidad USING(id_unidad)
WHERE 
id_salida NOT IN 
(SELECT id_salida FROM entrada)
LIMIT $registros_per_pagina
OFFSET $inicio
");
    }

    public function contar_completas(){
        return $this->db->query("SELECT 1 from salida 
WHERE id_salida IN 
(SELECT id_salida FROM entrada)")->num_rows();
    }
    public function contar_en_proceso(){
        return $this->db->query("SELECT 1 from salida 
WHERE id_salida NOT IN 
(SELECT id_salida FROM entrada)")->num_rows();
    }

    public function listar_completas($pagina, $registros_per_pagina){
        $inicio = ($pagina-1) * $registros_per_pagina;

        return $this->db->query("SELECT *, 
(select 1 from entrada where entrada.id_salida = salida.id_salida LIMIT 1 ) as salio 
FROM salida 
LEFT JOIN conductor USING(id_conductor)
LEFT JOIN recorrido USING(id_recorrido)
LEFT JOIN unidad USING(id_unidad)
LEFT JOIN entrada USING(id_salida)
WHERE id_salida IN 
(SELECT id_salida FROM entrada)
ORDER BY entrada.fecha_entrada DESC, entrada.hora_entrada DESC
LIMIT $registros_per_pagina
OFFSET $inicio
");
    }

    public function buscar($criteria, $value=NULL){
        $sql = "SELECT * FROM salida 
        LEFT JOIN salida_incidencia USING (id_salida)
        LEFT JOIN incidencia USING (id_incidencia)
        ";
        if(is_array($criteria)){
            $sql .= ' WHERE ';
            
            $condiciones = array();
            if(isset($criteria['id_conductor'])){
                if($criteria['id_conductor'] === TRUE)
                    $condiciones[] = " salida.id_conductor <> '' ";
                else
                    $condiciones[] = " salida.id_conductor = '{$criteria['id_conductor']}' ";
            }

            if(isset($criteria['id_unidad']))
                $condiciones[] = " salida.id_unidad = '{$criteria['id_unidad']}' ";

            if(isset($criteria['id_recorrido']))
                $condiciones[] = " salida.id_recorrido = '{$criteria['id_recorrido']}'";

            if(isset($criteria['fecha_inicio']))
                $condiciones[] = " salida.fecha_salida::date >= '{$criteria['fecha_inicio']}'::date";

            if(isset($criteria['hora_inicio']))
                $condiciones[] =  " salida.hora_salida::time >= '{$criteria['hora_inicio']}'::time";

            $sql .= implode(' AND ', $condiciones);
        }
        
        $sql .= " ORDER BY fecha_salida DESC, hora_salida DESC";
        return $this->db->query($sql);

    }

    public function buscar_completas ($criteria) {
        $sql = "SELECT *, 
(select 1 from entrada where entrada.id_salida = salida.id_salida LIMIT 1) as salio 
FROM salida 
LEFT JOIN conductor USING(id_conductor)
LEFT JOIN recorrido USING(id_recorrido)
LEFT JOIN unidad USING(id_unidad)
LEFT JOIN entrada USING(id_salida)
WHERE id_salida IN 
(SELECT id_salida FROM entrada) ";
        
        if(isset($criteria['id_conductor'])){
            if($criteria['id_conductor'] === TRUE)
                $condiciones[] = " salida.id_conductor <> '' ";
            else
                $condiciones[] = " salida.id_conductor = '{$criteria['id_conductor']}' ";
        }

        if(isset($criteria['id_unidad']))
            $sql .= " AND salida.id_unidad = '{$criteria['id_unidad']}'";

        if(isset($criteria['id_recorrido']))
            $sql .= " AND salida.id_recorrido = '{$criteria['id_recorrido']}'";

        if(isset($criteria['fecha_salida_inicio']))
            $sql .= " AND salida.fecha_salida::date > ('{$criteria['fecha_salida_inicio']}'::date - '1 day'::interval)";

        if(isset($criteria['fecha_salida_final']))
            $sql .= " AND salida.fecha_salida::date < ('{$criteria['fecha_salida_final']}'::date + '1 day'::interval)";
        
        $sql .= " ORDER BY entrada.fecha_entrada DESC, salida.fecha_salida DESC";
        return $this->db->query($sql);
    }

    public function buscar_incompletas ($criteria) {
        $sql = "SELECT *, unidad.id_unidad as id_unidad
FROM salida 
LEFT JOIN conductor USING(id_conductor)
LEFT JOIN recorrido USING(id_recorrido)
LEFT JOIN unidad USING(id_unidad)
LEFT JOIN entrada USING(id_salida)
WHERE entrada.id_salida is null
 ";

        if(isset($criteria['id_conductor'])){
            if($criteria['id_conductor'] === TRUE)
                $condiciones[] = " salida.id_conductor <> '' ";
            else
                $condiciones[] = " salida.id_conductor = '{$criteria['id_conductor']}' ";
        }

        if(isset($criteria['id_recorrido']))
            $sql .= " AND salida.id_recorrido = '{$criteria['id_recorrido']}'";

        if(isset($criteria['id_unidad']))
            $sql .= " AND salida.id_unidad = '{$criteria['id_unidad']}'";

        if(isset($criteria['fecha_salida_inicio']))
            $sql .= " AND salida.fecha_salida::date > ('{$criteria['fecha_salida_inicio']}'::date - '1 day'::interval)";

        if(isset($criteria['fecha_salida_final']))
            $sql .= " AND salida.fecha_salida::date < ('{$criteria['fecha_salida_final']}'::date + '1 day'::interval)";
        
        $sql .= " ORDER BY entrada.fecha_entrada DESC, salida.fecha_salida DESC";
        return $this->db->query($sql);
    }

    public function crear($data){
        
        if(!$data['id_acompaniante'])
            $data['id_acompaniante'] = NULL;
        
        $tipo_incidencia = $data['id_tipo_incidencia'];
        $incidencia = $data['id_incidencia'];
        
        unset($data['id_tipo_incidencia'], $data['id_incidencia']);

        $this->db->set($data)->insert('salida');

        $id_salida = $this->db->insert_id();

        $this->db->set(array(
            'id_salida' => $id_salida,
            'id_incidencia' => $incidencia
        ))->insert('salida_incidencia');
    }

    public function editar($criteria, $value, $data){
        $tipo_incidencia = $data['id_tipo_incidencia'];
        $incidencia = $data['id_incidencia'];
        
        unset($data['id_tipo_incidencia'], $data['id_incidencia']);

        
        if(!$data['id_acompaniante'])
            $data['id_acompaniante'] = NULL;

        $dbo = $this->db->set($data)->where($criteria, $value);
        
        $r = $dbo->update('salida');

        $this->db->where('id_salida', $value)->set(array(
            'id_incidencia' => $incidencia
        ))->update('salida_incidencia');

        return $r;
    }

    public function eliminar($criteria, $value){
        $this->db->where($criteria, $value)->delete('salida_incidencia');
        // if(is_array($criteria))
        //     return $this->db->where($criteria)->delete('salida');
        return $this->db->where($criteria, $value)->delete('salida');
    }

    public function guardar_trazado($id_salida, $puntos)
    {
        foreach($puntos as &$punto){
            $punto['id_salida'] = $id_salida;
        }

        $this->db->insert_batch('punto_salida', $puntos);
    }

    public function eliminar_recorrido($id_salida)
    {
        return $this->db->query("DELETE FROM punto_salida    
WHERE id_salida = $id_salida");
    }

    public function buscar_recorrido($id_salida, $id_recorrido){

        return $this->db->where('id_salida', $id_salida)->get('punto_salida');
    }
}
