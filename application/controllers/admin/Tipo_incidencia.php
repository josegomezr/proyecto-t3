<?php
class Tipo_incidencia extends Admin_Controller
{
    public $niveles = array();
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('tipo_incidencia_model');
    }
    public function get_index()
    {
    	$this->data['tipo_incidencias'] = $this->tipo_incidencia_model->listar()->result();
        return $this->load->view("admin/tipo_incidencia/index_view", $this->data);
    }
    public function get_crear()
    {
        return $this->load->view("admin/tipo_incidencia/crear_view", $this->data);
    }

    public function post_crear()
    {

        $this->form_validation->set_rules('descripcion_tipo_incidencia', 'Descripcion de Tipo Incidencia', 'trim|min_length[4]|required|max_length[45]');

        if ($this->form_validation->run() == FALSE)
        {
            $this->flash_validation_error('error:tipo_incidencia:validation');
            redirect(site_url('admin/tipo_incidencia/crear'));
            exit;
        }
        $registro["descripcion_tipo_incidencia"] = $this->input->post("descripcion_tipo_incidencia");

        try {
            $this->tipo_incidencia_model->crear($registro);
            $this->flash('success', 'success:tipo_incidencia:create');
        } catch (Exception $e) {
            $this->flash_validation_error('error:tipo_incidencia:duplicated');
            redirect(site_url('admin/tipo_incidencia/crear'));
            exit;
        }
        return redirect( site_url("admin/tipo_incidencia/index") );
    
    }
    
    public function get_eliminar ($id_tipo_incidencia)
    {
        try {
            $this->tipo_incidencia_model->eliminar('id_tipo_incidencia', $id_tipo_incidencia);
            $this->flash('success', 'success:tipo_incidencia:deleted');
        } catch (Exception $e) {
            $this->flash('error', 'error:tipo_incidencia:using');
        }
        return redirect( site_url("admin/tipo_incidencia/index") );
    }

    public function get_editar ($id_tipo_incidencia)
    {
        $result = $this->tipo_incidencia_model->buscar('id_tipo_incidencia', $id_tipo_incidencia);
        if($result->num_rows() == 0){
            $this->flash('error', 'error:tipo_incidencia:not_found');
            redirect(site_url('admin/tipo_incidencia/'));
        }
        $this->data["tipo_incidencia"] = $result->row();
        return $this->load->view("admin/tipo_incidencia/editar_view", $this->data);
    }
        
    public function post_editar ($id_tipo_incidencia)
    {
        $this->form_validation->set_rules('descripcion_tipo_incidencia', 'Descripcion de Tipo Incidencia', 'trim|min_length[4]|required|max_length[45]');

        if ($this->form_validation->run() == FALSE)
        {
            $this->flash_validation_error('error:tipo_incidencia:validation');
            redirect(site_url('admin/tipo_incidencia/editar/' . $id_tipo_incidencia) );
            exit;
        }

        $registro = array();
        $registro["descripcion_tipo_incidencia"] = $this->input->post("descripcion_tipo_incidencia");

        try {
            $this->tipo_incidencia_model->editar('id_tipo_incidencia', $id_tipo_incidencia, $registro);
            $this->flash('success', 'success:tipo_incidencia:editado');
        } catch (Exception $e) {
            $this->flash('error', 'error:tipo_incidencia:duplicated');
        }
        return redirect( site_url("admin/tipo_incidencia/index") );

    }
    
}

