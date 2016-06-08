<?php
class Reporte extends Admin_Controller
{

    public function __construct() {
    
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('conductor_model');
        $this->load->model('unidad_model');
        $this->load->model('recorrido_model');
        $this->load->model('salida_model');
        $this->load->model('entrada_model');
        $this->load->model('incidencia_model');
    }

    public function get_lista_conductores() {
        $this->data['url'] = site_url('admin/pdf/lista_conductores');
        $this->load->view('admin/reporte/visor', $this->data);
    }

    public function get_lista_unidades() {
        $this->data['url'] = site_url('admin/pdf/lista_unidades');
        $this->load->view('admin/reporte/visor', $this->data);
    }
    public function get_lista_recorridos() {
        $this->data['url'] = site_url('admin/pdf/lista_recorridos');
        $this->load->view('admin/reporte/visor', $this->data);
    }
    public function get_visor_lista_salida() {
        $this->data['url'] = site_url('admin/pdf/lista_salida') . "?{$_SERVER['QUERY_STRING']}";
        $this->load->view('admin/reporte/visor', $this->data);
    }

    public function get_filtro_listar_salidas() {
      
        $conductor = $this->input->get('id_conductor', true);
        $recorrido = $this->input->get('id_recorrido', true);
        $fecha_inicio = $this->input->get('fecha_inicio', true);
        $fecha_final = $this->input->get('fecha_final', true);
        
        $fecha_inicio_parseada = null;
        $fecha_final_parseada = null;

        if ($fecha_final) {
            $fecha_final_parseada = implode('-', array_reverse(explode('/', $fecha_final)));
        }

        if ($fecha_inicio) {
            $fecha_inicio_parseada = implode('-', array_reverse(explode('/', $fecha_inicio)));
        }

        $criteria = array();

        if ($conductor) {
            $criteria['salida.id_conductor'] = $conductor;
        }
        if ($recorrido) {
            $criteria['salida.id_recorrido'] = $recorrido;
        }
        if ($fecha_inicio_parseada) {
            $criteria['salida.fecha_salida >='] = $fecha_inicio_parseada;
        }
        if ($fecha_final_parseada) {
            $criteria['salida.fecha_salida <='] = $fecha_final_parseada;
        }

        $salidas_incompletas = $this->salida_model->buscar_en_proceso($criteria)->result();
        $salidas_completas = $this->salida_model->buscar_completas($criteria)->result();

        if (count($salidas_incompletas) == 0 && count($salidas_completas) == 0) {
            if (count($criteria) > 0) {
                $this->flash('error', 'error:salidas:no-match');
            } else {
                $this->flash('error', 'error:salidas:empty');
            }
            redirect('admin/home');
        }

        $this->data['salidas_incompletas'] = $salidas_incompletas;
        $this->data['salidas_completas'] = $salidas_completas;

        $this->data['conductores'] = $this->conductor_model->listar()->result();
        $this->data['recorridos'] = $this->recorrido_model->listar()->result();
        
        $this->data['conductor_seleccionado'] = $conductor;
        $this->data['recorrido_seleccionado'] = $recorrido;
        $this->data['fecha_inicio_seleccionado'] = $fecha_inicio;
        $this->data['fecha_final_seleccionado'] = $fecha_final;
        $this->data['tiene_criteria'] = count($criteria) > 0;

        return $this->load->view("admin/reporte/lista_salidas", $this->data);
    }
    
    public function get_entrada($id_salida) {
    

        $this->load->library('gmap_lib');
        $this->load->model('incidencia_model');
        $entrada_result = $this->entrada_model->reporte($id_salida);
        if ($entrada_result->num_rows() == 0) {
            $this->flash('error', 'error:entrada:not_found');
            redirect(site_url('admin/salida'));
        }

        $entrada = $entrada_result->row();

        $incidencia_entrada = $this->incidencia_model->buscar(
            array('incidencia.id_incidencia' => $entrada->id_incidencia_entrada)
        )->row();

        $incidencia_salida = $this->incidencia_model->buscar(
            array('"incidencia".id_incidencia' => $entrada->id_incidencia_salida)
        )->row();

        $conductor = $this->conductor_model->buscar(
            array('id_conductor' => $entrada->id_conductor)
        )->row();
        
        if ($entrada->id_acompaniante) {
            $acompaniante = $this->conductor_model->buscar(
                array('id_conductor' => $entrada->id_acompaniante)
            )->row();
        }

        $puntos_result = $this->salida_model->obtener_recorrido($entrada->id_salida);
        $trazado_result = $this->recorrido_model->obtener_trazado($entrada->id_recorrido);
        
        $puntos = $puntos_result->result();
        $trazado = $trazado_result->result();
        
        $this->data["entrada"] = $entrada;
        $this->data["conductor"] = $conductor;
        

        $this->data['incidencia_entrada'] = $incidencia_entrada;
        $this->data['incidencia_salida'] = $incidencia_salida;

        if ($entrada->id_acompaniante) {
            $this->data["acompaniante"] = $acompaniante;
        }
        $this->data['puntos'] = $puntos;

        $bounds = $this->gmap_lib->get_bounds($puntos);

        $this->data['route_center'] = $this->gmap_lib->get_center($puntos);
        $this->data['route_pairs'] = $this->gmap_lib->route_to_pairs($puntos);

        $this->data['bounding_box'] = array(
            array(
                $bounds['min']['latitud'], $bounds['min']['longitud'],
            ),
            array(
                $bounds['max']['latitud'], $bounds['min']['longitud'],
            ),
            array(
                $bounds['min']['latitud'], $bounds['max']['longitud'],
            ),
            array(
                $bounds['max']['latitud'], $bounds['max']['longitud'],
            )
        );
        $this->data['markers'] = $this->gmap_lib->build_markers($puntos);

        $pairs = $this->gmap_lib->route_to_pairs($trazado);

        $this->data['defaultRoute'] = $this->gmap_lib->expand_path($pairs);
        $this->data['radioAccion'] = $this->gmap_lib->get_radius();

        $this->load->view("admin/reporte/entrada-js", $this->data);
        
    }

    public function get_incidencias()
    {
        return $this->load->view("admin/reporte/incidencias", $this->data);   
    }

    public function get_json_valores_para($criteria)
    {
        $dataset = array();
        $pk_col = '';
        $display_col = '';
        
        if ($criteria == 'unidad') {
            $result = $this->unidad_model->listar()->result();
            foreach ($result as $row) {
                $dataset[] = array(
                    'pk' => $row->id_unidad,
                    'display' => sprintf("%s (%s)", $row->modelo_unidad, $row->placa_unidad)
                );
            }
        }else if ($criteria == 'conductor') {
            $result = $this->conductor_model->listar()->result();
            foreach ($result as $row) {
                $dataset[] = array(
                    'pk' => $row->id_conductor,
                    'display' => sprintf("%s %s", $row->nombre_conductor, $row->apellido_conductor)
                );
            }
        }else if ($criteria == 'recorrido') {
            $result = $this->recorrido_model->listar()->result();
            foreach ($result as $row) {
                $dataset[] = array(
                    'pk' => $row->id_recorrido,
                    'display' => $row->nombre_recorrido
                );
            }
        }

        $this->output->set_header('Content-type: application/json');
        echo json_encode($dataset);
    }

    public function get_json_incidencias($entity){
        $fecha_inicio = $this->input->get('fecha_inicio', true);
        $fecha_final = $this->input->get('fecha_final', true);
        //// escribir entrada/salida respectivamente
        $filter = array(
            'entrada' => array(),
            'salida' => array()
        );
        if ($fecha_inicio) {
            $fecha_inicio = explode('/', $fecha_inicio);
            $fecha_inicio = implode('-', array_reverse($fecha_inicio));
            
            $filter['salida']['fecha_salida >='] = $fecha_inicio;
            $filter['entrada']['fecha_entrada >='] = $fecha_inicio;
        }
        if ($fecha_final) {
            $fecha_final = explode('/', $fecha_final);
            $fecha_final = implode('-', array_reverse($fecha_final));
            $filter['salida']['fecha_salida <='] = $fecha_final;
            $filter['entrada']['fecha_entrada <='] = $fecha_final;
        }

        if ($entity == 'unidad') {
            $result = $this->incidencia_model->por_unidad($filter);
        }else if ($entity == 'conductor') {
            $result = $this->incidencia_model->por_conductor($filter);
        }else if ($entity == 'recorrido') {
            $result = $this->incidencia_model->por_recorrido($filter);
        }
        $this->output->set_header('Content-type: application/json');
        echo json_encode($result);
    }

    public function get_json_incidencias_detalladas($entity){
        $fecha_inicio = $this->input->get('fecha_inicio', true);
        $fecha_final = $this->input->get('fecha_final', true);
        $ids = $this->input->get('ids', true);
        // $ids = implode(',', $ids);
        $filter = array(
            'entrada' => array(),
            'salida' => array()
        );

        if ($fecha_inicio) {
            $fecha_inicio = explode('/', $fecha_inicio);
            $fecha_inicio = implode('-', array_reverse($fecha_inicio));
            
            $filter['salida']['fecha_salida >='] = $fecha_inicio;
            $filter['entrada']['fecha_entrada >='] = $fecha_inicio;
        }
        if ($fecha_final) {
            $fecha_final = explode('/', $fecha_final);
            $fecha_final = implode('-', array_reverse($fecha_final));
            $filter['salida']['fecha_salida <='] = $fecha_final;
            $filter['entrada']['fecha_entrada <='] = $fecha_final;
        }
        $filter["id_{$entity}"] = $ids; 
        $filter["id_{$entity}"] = $ids;


        if ($entity == 'unidad') {
            $result = $this->incidencia_model->detalle_por_unidad($filter);
        }else if ($entity == 'conductor') {
            $result = $this->incidencia_model->detalle_por_conductor($filter);
        }else if ($entity == 'recorrido') {
            $result = $this->incidencia_model->detalle_por_recorrido($filter);
        }

        $this->output->set_header('Content-type: application/json');
        echo json_encode($result);
    }
}
