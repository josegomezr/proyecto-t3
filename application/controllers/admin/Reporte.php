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
    }

    public function get_lista_conductores() {
    
        $conductores = $this->conductor_model->listar()->result();
        $this->data['conductores'] = $conductores;

        if (count($conductores) == 0) {
            $this->flash('error', 'error:conductor:empty');
            redirect('admin/home');
        }

        $html = $this->load->view("admin/reporte/lista_conductores", $this->data, true);
        $this->load->library('dom_pdf');

        $this->dom_pdf->armar_pdf($html);
        $this->dom_pdf->establecer_papel('Letter', 'Portrait');
        $this->dom_pdf->mostrar();
    }
    public function get_lista_unidades() {
    
        $unidades = $this->unidad_model->listar()->result();
        $this->data['unidades'] = $unidades;

        if (count($unidades) == 0) {
            $this->flash('error', 'error:unidad:empty');
            redirect('admin/home');
        }

        $html = $this->load->view("admin/reporte/lista_unidades", $this->data, true);
        $this->load->library('dom_pdf');

        $this->dom_pdf->armar_pdf($html);
        $this->dom_pdf->establecer_papel('Letter', 'Portrait');
        $this->dom_pdf->mostrar();
    }
    public function get_lista_recorridos() {
    
        $recorridos = $this->recorrido_model->listar()->result();
        $this->data['recorridos'] = $this->recorrido_model->listar()->result();

        if (count($recorridos) == 0) {
            $this->flash('error', 'error:recorrido:empty');
            redirect('admin/home');
        }

        $html = $this->load->view("admin/reporte/lista_recorridos", $this->data, true);
        $this->load->library('dom_pdf');

        $this->dom_pdf->armar_pdf($html);
        $this->dom_pdf->establecer_papel('Letter', 'Portrait');
        $this->dom_pdf->mostrar();
    }

    public function get_listar_salidas() {
      
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

        return $this->load->view("admin/reporte/lista_salidas", $this->data);
    }

    public function get_pdf_lista_salida() {
    
        $conductor = $this->input->get('id_conductor', false);
        $recorrido = $this->input->get('id_recorrido', false);

        $salidas_incompletas = $this->salida_model->buscar_incompletas($conductor, $recorrido)->result();
        $salidas_completas = $this->salida_model->buscar_completas($conductor, $recorrido)->result();
        
        if (count($salidas_incompletas) == 0 && count($salidas_completas) == 0) {
            $this->flash('error', 'error:salidas:no-match');
            redirect('admin/reporte/lista_salidas');
        }

        $this->data['salidas_incompletas'] = $salidas_incompletas;
        $this->data['salidas_completas'] = $salidas_completas;

        $this->data['conductores'] = $this->conductor_model->listar()->result();
        $this->data['recorridos'] = $this->recorrido_model->listar()->result();
        $this->data['conductor_seleccionado'] = $conductor;
        $this->data['recorrido_seleccionado'] = $recorrido;

        $html = $this->load->view("admin/reporte/pdf_lista_salidas", $this->data, true);

        $this->load->library('dom_pdf');

        $this->dom_pdf->armar_pdf($html);
        $this->dom_pdf->establecer_papel('Letter', 'Landscape');
        $this->dom_pdf->mostrar();
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

        $incidencia_entrada = $this->incidencia_model->buscar('incidencia.id_incidencia', $entrada->id_incidencia_entrada)->row();

        $incidencia_salida = $this->incidencia_model->buscar('"incidencia".id_incidencia', $entrada->id_incidencia_salida)->row();

        $conductor = $this->conductor_model->buscar('id_conductor', $entrada->id_conductor)->row();
        
        if ($entrada->id_acompaniante) {
            $acompaniante = $this->conductor_model->buscar('id_conductor', $entrada->id_acompaniante)->row();
        }

        $puntos_result = $this->salida_model->buscar_recorrido($entrada->id_salida, $entrada->id_recorrido);
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
}
