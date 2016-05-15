<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Salida extends Admin_Controller {

    public $registros_per_pagina = 10;

    public function __construct()
    {
		parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('salida_model');
        $this->load->model('conductor_model');
        $this->load->model('recorrido_model');
        $this->load->model('unidad_model');
    }
    public function get_index($page_incompletas = 1, $page_completas = 1)
    {
        $this->data['salidas_incompletas'] = $this->salida_model->listar_en_proceso((int)$page_incompletas, $this->registros_per_pagina);
        $total_salidas_incompletas = $this->salida_model->contar_en_proceso();
        $this->data['total_salidas_incompletas'] = $total_salidas_incompletas;
        $this->data['pagina_salida_incompleta'] = $page_incompletas;

        $this->data['total_paginas_incompleta'] = ceil($total_salidas_incompletas/$this->registros_per_pagina);

        
        $this->data['salidas_completas'] = $this->salida_model->listar_completas((int)$page_completas, $this->registros_per_pagina);
        $total_salidas_completas = $this->salida_model->contar_completas();
        $this->data['total_salidas_completas'] = $total_salidas_completas;
        $this->data['pagina_salida_completa'] = $page_completas;

        $this->data['total_paginas_completa'] = ceil($total_salidas_completas/$this->registros_per_pagina);
        
        return $this->load->view("admin/salida/index_view", $this->data);
    }

    public function get_test_map()
    {
        return $this->load->view("test-map", $this->data);
    }

    public function get_crear()
    {
        $this->data['conductores'] = $this->conductor_model->listar_disponibles();
        $this->data['recorridos'] = $this->recorrido_model->listar();
        $this->data['unidades'] = $this->unidad_model->listar_sin_salir();

        if(count($this->data['unidades']) == 0){
            $this->flash('error', 'error:salida:no_unidades');
            return redirect(site_url('admin/salida/index'));
        }
        if(count($this->data['conductores']) == 0){
            $this->flash('error', 'error:salida:no_conductores');
            return redirect(site_url('admin/salida/index'));
        }

        if(count($this->data['recorridos']) == 0){
            $this->flash('error', 'error:salida:no_recorridos');
            return redirect(site_url('admin/salida/index'));
        }

        return $this->load->view("admin/salida/crear_view", $this->data);
    }

    public function post_crear()
    {

        $this->form_validation->set_rules('cedula_conductor', 'Conductor', 'trim|required');
        $this->form_validation->set_rules('cedula_acompaniante', 'Conductor', 'trim');
        $this->form_validation->set_rules('id_recorrido', 'Recorrido', 'trim|required|xss_clean');
        $this->form_validation->set_rules('id_unidad', 'Unidad', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->flash_validation_error('error:salida:validation');
            redirect(site_url('admin/salida/crear'));
            exit;
        }
        
        $registro["cedula_conductor"] = $this->input->post("cedula_conductor");
        $registro["cedula_acompaniante"] = $this->input->post("cedula_acompaniante");
        $registro["id_recorrido"] = $this->input->post("id_recorrido");
        $registro["id_unidad"] = $this->input->post("id_unidad");
        // $registro["observacion_salida"] = $this->input->post("observacion");
        
        $registro["hora_salida"] = date('H:i');
        $registro["fecha_salida"] = date('Y-m-d');

        try {
            $this->salida_model->crear($registro);
            $this->flash('success', 'success:salida:created');
        } catch (Exception $e) {
            throw $e;
            
            $this->flash('error', 'error:salida:not_unique');
        }      

        return redirect( site_url("admin/salida/index") );
    
    }
    
    public function get_eliminar ($id_salida)
    {
        $this->salida_model->eliminar('id_salida', $id_salida);
        return redirect( site_url("admin/salida/index") );
    }
    public function get_editar ($id_salida)
    {
        $result = $this->salida_model->buscar('id_salida', $id_salida);
        if($result->num_rows() == 0){
            $this->flash('error', 'error:salida:not_found');
            redirect(site_url('admin/salida/'));
        }
        $this->data["salida"] = $result->row();
        $this->data['conductores'] = $this->conductor_model->listar();
        $this->data['recorridos'] = $this->recorrido_model->listar();
        $this->data['unidades'] = $this->unidad_model->listar();
        return $this->load->view("admin/salida/editar_view", $this->data);
    }
        
    public function post_editar ($id_salida)
    {
        $this->form_validation->set_rules('cedula_conductor', 'Conductor', 'trim|required');
        $this->form_validation->set_rules('cedula_acompaniante', 'Conductor', 'trim');
        $this->form_validation->set_rules('id_recorrido', 'Recorrido', 'trim|required|xss_clean');
        $this->form_validation->set_rules('id_unidad', 'Unidad', 'trim|required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->flash_validation_error('error:salida:validation');
            redirect(site_url('admin/salida/editar/' . $id_salida) );
            exit;
        }

        $registro = array();
        $registro["cedula_conductor"] = $this->input->post("cedula_conductor");
        $registro["cedula_acompaniante"] = $this->input->post("cedula_acompaniante");
        $registro["id_recorrido"] = $this->input->post("id_recorrido");
        $registro["id_unidad"] = $this->input->post("id_unidad");
        // $registro["observacion_salida"] = $this->input->post("observacion");
        $this->salida_model->editar('id_salida', $id_salida, $registro);
        return redirect( site_url("admin/salida/index") );

    }
}

/* End of file salida.php */
/* Location: ./application/controllers/salida.php */
