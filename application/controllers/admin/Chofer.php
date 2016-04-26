<?php
class Chofer extends Admin_Controller
{

    public function __construct()
    {
	parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('chofer_model');
    }
    public function get_index()
    {
    	$this->data['choferes'] = $this->chofer_model->listar();
        return $this->load->view("admin/chofer/index_view", $this->data);
    }
    public function get_crear()
    {
        return $this->load->view("admin/chofer/crear_view", $this->data);
    }

    public function post_crear()
    {

        $this->form_validation->set_rules('cedula', 'Cedula', 'trim|required|min_length[8]|max_length[12]|xss_clean|regex_match[/[VE]-[0-9]{8}/]');
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|min_length[4]|required');
        $this->form_validation->set_rules('apellido', 'apellido', 'trim|min_length[4]|required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->flash_validation_error('error:chofer:validation');
            redirect(site_url('admin/chofer/crear'));
            exit;
        }
        
        $registro["nombre_chofer"] = $this->input->post("nombre");
        $registro["apellido_chofer"] = $this->input->post("apellido");
        $registro["cedula_chofer"] = $this->input->post("cedula");

        try {
            $this->chofer_model->crear($registro);
            $this->flash('success', 'success:chofer:create');
        } catch (Exception $e) {
            $this->flash_validation_error('error:chofer:duplicated');
            redirect(site_url('admin/chofer/crear'));
            exit;
        }
        return redirect( site_url("admin/chofer/index") );
    
    }
    
    public function get_eliminar ($cedula)
    {
        try {
            $this->chofer_model->eliminar('cedula_chofer', $cedula);
            $this->flash('success', 'success:chofer:deleted');
        } catch (Exception $e) {
            $this->flash('error', 'error:chofer:using');
        }
        return redirect( site_url("admin/chofer/index") );
    }

    public function get_editar ($cedula)
    {
        $result = $this->chofer_model->buscar('cedula_chofer', $cedula);
        if($result->num_rows() == 0){
            $this->flash('error', 'error:chofer:not_found');
            redirect(site_url('admin/chofer/'));
        }
        $this->data["chofer"] = $result->row();
        return $this->load->view("admin/chofer/editar_view", $this->data);
    }
        
    public function post_editar ($cedula)
    {
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|min_length[4]|required');
        $this->form_validation->set_rules('apellido', 'apellido', 'trim|min_length[4]|required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->flash_validation_error('error:chofer:validation');
            redirect(site_url('admin/chofer/editar/' . $cedula) );
            exit;
        }

        $registro = array();
        $registro["nombre_chofer"] = $this->input->post("nombre");
        $registro["apellido_chofer"] = $this->input->post("apellido");

        try {
        $this->chofer_model->editar('cedula_chofer', $cedula, $registro);
            $this->flash('success', 'success:chofer:editado');
        } catch (Exception $e) {
            $this->flash('error', 'error:chofer:duplicated');
        }
        return redirect( site_url("admin/chofer/index") );

    }
    
}

