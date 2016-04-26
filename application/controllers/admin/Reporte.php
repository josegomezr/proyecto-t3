<?php
class Reporte extends Admin_Controller
{

    public function __construct()
    {
	   parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('chofer_model');
        $this->load->model('unidad_model');
        $this->load->model('recorrido_model');
        $this->load->model('salida_model');
        $this->load->model('entrada_model');
    }

    public function get_lista_choferes()
    {
        $choferes = $this->chofer_model->listar();
        $this->data['choferes'] = $choferes;

        if(count($choferes) == 0){
            $this->flash('error', 'error:chofer:empty');
            redirect('admin/home');
        }

        $html = $this->load->view("admin/reporte/lista_choferes", $this->data, true);
        $this->load->library('dom_pdf');

        $this->dom_pdf->armar_pdf($html);
        $this->dom_pdf->establecer_papel('Letter', 'Portrait');
        $this->dom_pdf->mostrar();
    }
    public function get_lista_unidades()
    {
        $unidades = $this->unidad_model->listar();
        $this->data['unidades'] = $unidades;

        if(count($unidades) == 0){
            $this->flash('error', 'error:unidad:empty');
            redirect('admin/home');
        }

        $html = $this->load->view("admin/reporte/lista_unidades", $this->data, true);
        $this->load->library('dom_pdf');

        $this->dom_pdf->armar_pdf($html);
        $this->dom_pdf->establecer_papel('Letter', 'Portrait');
        $this->dom_pdf->mostrar();
    }
    public function get_lista_recorridos()
    {
        $recorridos = $this->recorrido_model->listar();
        $this->data['recorridos'] = $this->recorrido_model->listar();

        if(count($recorridos) == 0){
            $this->flash('error', 'error:recorrido:empty');
            redirect('admin/home');
        }

        $html = $this->load->view("admin/reporte/lista_recorridos", $this->data, true);
        $this->load->library('dom_pdf');

        $this->dom_pdf->armar_pdf($html);
        $this->dom_pdf->establecer_papel('Letter', 'Portrait');
        $this->dom_pdf->mostrar();
    }

    public function get_lista_salidas()
    {
        
        $chofer = $this->input->get('cedula_chofer', FALSE);
        $recorrido = $this->input->get('id_recorrido', FALSE);
        $fecha_inicio = $this->input->get('fecha_inicio', FALSE);
        $fecha_final = $this->input->get('fecha_final', FALSE);
        
        $fecha_inicio_parseada = NULL;
        $fecha_final_parseada = NULL;

        if($fecha_final)
            $fecha_final_parseada = implode('-', array_reverse(explode('/', $fecha_final)));

        if($fecha_inicio)
            $fecha_inicio_parseada = implode('-', array_reverse(explode('/', $fecha_inicio)));

        $criteria = array();

        if($chofer)
            $criteria['cedula_chofer'] = $chofer;
        if($recorrido)
            $criteria['id_recorrido'] = $recorrido;
        if($fecha_inicio_parseada)
            $criteria['fecha_salida_inicio'] = $fecha_inicio_parseada;
        if($fecha_final_parseada)
            $criteria['fecha_salida_final'] = $fecha_final_parseada;

        $salidas_incompletas = $this->salida_model->buscar_incompletas($criteria)->result();
        $salidas_completas = $this->salida_model->buscar_completas($criteria)->result();

        if(count($salidas_incompletas) == 0 && count($salidas_completas) == 0){
            if (count($criteria) > 0) {
                $this->flash('error', 'error:salidas:no-match');
            }else{
                $this->flash('error', 'error:salidas:empty');
            }
            redirect('admin/home');
        }

        $this->data['salidas_incompletas'] = $salidas_incompletas;
        $this->data['salidas_completas'] = $salidas_completas;

        $this->data['choferes'] = $this->chofer_model->listar();
        $this->data['recorridos'] = $this->recorrido_model->listar();
        
        $this->data['chofer_seleccionado'] = $chofer;
        $this->data['recorrido_seleccionado'] = $recorrido;
        $this->data['fecha_inicio_seleccionado'] = $fecha_inicio;
        $this->data['fecha_final_seleccionado'] = $fecha_final;

        return $this->load->view("admin/reporte/lista_salidas", $this->data);
    }

    public function get_pdf_lista_salida()
    {
        $chofer = $this->input->get('cedula_chofer', FALSE);
        $recorrido = $this->input->get('id_recorrido', FALSE);

        $salidas_incompletas = $this->salida_model->buscar_incompletas($chofer, $recorrido)->result();
        $salidas_completas = $this->salida_model->buscar_completas($chofer, $recorrido)->result();
        
        if(count($salidas_incompletas) == 0 && count($salidas_completas) == 0){
            $this->flash('error', 'error:salidas:no-match');
            redirect('admin/reporte/lista_salidas');
        }

        $this->data['salidas_incompletas'] = $salidas_incompletas;
        $this->data['salidas_completas'] = $salidas_completas;

        $this->data['choferes'] = $this->chofer_model->listar();
        $this->data['recorridos'] = $this->recorrido_model->listar();
        $this->data['chofer_seleccionado'] = $chofer;
        $this->data['recorrido_seleccionado'] = $recorrido;

        $html = $this->load->view("admin/reporte/pdf_lista_salidas", $this->data, true);

        $this->load->library('dom_pdf');

        $this->dom_pdf->armar_pdf($html);
        $this->dom_pdf->establecer_papel('Letter', 'Landscape');
        $this->dom_pdf->mostrar();
    }

    
    public function get_entrada($id_salida)
    {

        $this->load->library('gmap_lib');
        $entrada_result = $this->entrada_model->reporte($id_salida);

        if($entrada_result->num_rows() == 0){
            $this->flash('error', 'error:entrada:not_found');
            redirect(site_url('admin/salida'));
        }

        $entrada = $entrada_result->row();
        
        $chofer = $this->chofer_model->buscar('cedula_chofer', $entrada->cedula_chofer)->row();
        
        if($entrada->cedula_acompaniante)
            $acompaniante = $this->chofer_model->buscar('cedula_chofer', $entrada->cedula_acompaniante)->row();

        $puntos_result = $this->salida_model->buscar_recorrido($entrada->id_salida, $entrada->id_recorrido);
        $trazado_result = $this->recorrido_model->obtener_trazado($entrada->id_recorrido);

        $puntos = $puntos_result->result();
        $trazado = $trazado_result->result();
        $this->data["entrada"] = $entrada;
        $this->data["chofer"] = $chofer;
        if($entrada->cedula_acompaniante)
            $this->data["acompaniante"] = $acompaniante;
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
