<?php
class Conductor extends Admin_Controller
{

    public function __construct()
    {
	parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('conductor_model');
    }
    public function get_index()
    {
    	$this->data['conductores'] = $this->conductor_model->listar()->result();
        return $this->load->view("admin/conductor/index_view", $this->data);
    }
    public function get_crear()
    {
        return $this->load->view("admin/conductor/crear_view", $this->data);
    }

    public function post_crear()
    {

        $this->form_validation->set_rules('cedula', 'Cedula', 'trim|required|min_length[8]|max_length[12]|xss_clean|regex_match[/[VE]-[0-9]{8}/]');
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|min_length[4]|required');
        $this->form_validation->set_rules('apellido', 'apellido', 'trim|min_length[4]|required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->flash_validation_error('error:conductor:validation');
            redirect(site_url('admin/conductor/crear'));
            exit;
        }
        
        $registro["nombre_conductor"] = $this->input->post("nombre");
        $registro["apellido_conductor"] = $this->input->post("apellido");
        $registro["cedula_conductor"] = $this->input->post("cedula");

        try {
            $this->conductor_model->crear($registro);
            $this->flash('success', 'success:conductor:create');
        } catch (Exception $e) {
            $this->flash_validation_error('error:conductor:duplicated');
            redirect(site_url('admin/conductor/crear'));
            exit;
        }
        return redirect( site_url("admin/conductor/index") );
    
    }
    
    public function get_eliminar ($cedula)
    {
        try {
            $this->conductor_model->eliminar('cedula_conductor', $cedula);
            $this->flash('success', 'success:conductor:deleted');
        } catch (Exception $e) {
            $this->flash('error', 'error:conductor:using');
        }
        return redirect( site_url("admin/conductor/index") );
    }

    public function get_editar ($cedula)
    {
        $result = $this->conductor_model->buscar('cedula_conductor', $cedula);
        if($result->num_rows() == 0){
            $this->flash('error', 'error:conductor:not_found');
            redirect(site_url('admin/conductor/'));
        }
        $this->data["conductor"] = $result->row();
        return $this->load->view("admin/conductor/editar_view", $this->data);
    }
        
    public function post_editar ($cedula)
    {
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|min_length[4]|required');
        $this->form_validation->set_rules('apellido', 'apellido', 'trim|min_length[4]|required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->flash_validation_error('error:conductor:validation');
            redirect(site_url('admin/conductor/editar/' . $cedula) );
            exit;
        }

        $registro = array();
        $registro["nombre_conductor"] = $this->input->post("nombre");
        $registro["apellido_conductor"] = $this->input->post("apellido");

        try {
        $this->conductor_model->editar('cedula_conductor', $cedula, $registro);
            $this->flash('success', 'success:conductor:editado');
        } catch (Exception $e) {
            $this->flash('error', 'error:conductor:duplicated');
        }
        return redirect( site_url("admin/conductor/index") );

    }
    
}

