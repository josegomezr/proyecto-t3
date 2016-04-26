<?php
class Dispositivo extends Admin_Controller
{

    public function __construct()
    {
	   parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('dispositivo_model');
        $this->load->model('recorrido_model');
        $this->load->model('unidad_model');
    }
    public function get_index()
    {
    	$this->data['dispositivos'] = $this->dispositivo_model->listar()->result();
        
        return $this->load->view("admin/dispositivo/index_view", $this->data);
    }
    public function get_crear()
    {
        $unidades = $this->unidad_model->listar_sin_dispositivo();
        $recorridos = $this->recorrido_model->listar();
        
        if(count($unidades) == 0){
            $this->flash('error', 'error:dispositivo:no-unidades');
            redirect(site_url('admin/dispositivo'));
            exit;
        }
        
        if(count($recorridos) == 0){
            $this->flash('error', 'error:dispositivo:no-recorridos');
            redirect(site_url('admin/dispositivo'));
            exit;
        }

        $this->data['unidades'] = $unidades;
        $this->data['recorridos'] = $recorridos;
        return $this->load->view("admin/dispositivo/crear_view", $this->data);
    }

    public function post_crear()
    {

        $this->form_validation->set_rules('id_dispositivo', 'Dispositivo', 'trim|required|numeric');
        $this->form_validation->set_rules('placa_unidad', 'Unidad', 'trim|required|xss_clean');
        $this->form_validation->set_rules('id_recorrido', 'Recorrido', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE)
        {
            $this->flash_validation_error('error:dispositivo:validation');
            redirect(site_url('admin/dispositivo/crear'));
            exit;
        }
        
        $registro = array(
            'id_dispositivo' => $this->input->post('id_dispositivo'),
            'placa_unidad' => $this->input->post('placa_unidad'),
            'id_recorrido' => $this->input->post('id_recorrido')
        );
        
        try {
            $this->dispositivo_model->crear($registro);
        } catch (Exception $e) {
            sleep(1);
            $registro = array('id_dispositivo' => rand()%1000);
            $this->dispositivo_model->crear($registro);
        }

        $this->flash('info', 'success:dispositivo:crear');
        redirect(site_url('admin/dispositivo'));
    }
    
    public function get_eliminar ($id_dispositivo)
    {
        try {
            $this->dispositivo_model->eliminar('id_dispositivo', $id_dispositivo);
            $this->flash('success', 'sucesss:dispositivo:deleted');
        } catch (Exception $e) {
            $this->flash_validation_error('error:dispositivo:using');
        }
        
        return redirect( site_url("admin/dispositivo/index") );
    }

    public function get_editar ($id_dispositivo)
    {
        $result = $this->dispositivo_model->buscar('id_dispositivo', $id_dispositivo);
        if($result->num_rows() == 0){
            $this->flash('error', 'error:dispositivo:not_found');
            redirect(site_url('admin/dispositivo/'));
        }

        $this->data['unidades'] = $this->unidad_model->listar_sin_dispositivo($id_dispositivo);
        $this->data['recorridos'] = $this->recorrido_model->listar();
        $this->data["dispositivo"] = $result->row();
        return $this->load->view("admin/dispositivo/editar_view", $this->data);
    }
        
    public function post_editar ($id_dispositivo)
    {
        $this->form_validation->set_rules('placa_unidad', 'Unidad', 'trim|required|xss_clean');
        $this->form_validation->set_rules('id_recorrido', 'Recorrido', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE)
        {
            $this->flash_validation_error('error:dispositivo:validation');
            redirect(site_url('admin/dispositivo/crear'));
            exit;
        }
        
        $registro = array(
            'id_dispositivo' => $id_dispositivo,
            'placa_unidad' => $this->input->post('placa_unidad'),
            'id_recorrido' => $this->input->post('id_recorrido')
        );
        
        $this->dispositivo_model->editar('id_dispositivo', $id_dispositivo, $registro);
        $this->flash('info', 'success:dispositivo:crear');
        redirect(site_url('admin/dispositivo'));
    }
    
}

