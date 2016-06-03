<?php
class Incidencia extends Admin_Controller
{
    public $niveles = array();
    
    public function __construct() {
    
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('incidencia_model');
        $this->load->model('tipo_incidencia_model');
    }
    public function get_index() {
    
        $this->data['incidencias'] = $this->incidencia_model->listar()->result();
        return $this->load->view("admin/incidencia/index_view", $this->data);
    }
    public function get_crear() {
    
        $this->data['tipos_incidencias'] = $this->tipo_incidencia_model->listar()->result();
        return $this->load->view("admin/incidencia/crear_view", $this->data);
    }

    public function post_crear() {
    

        $this->form_validation->set_rules('descripcion_incidencia', 'Descripcion Incidencia', 'trim|min_length[4]|required|max_length[45]');
        $this->form_validation->set_rules('id_tipo_incidencia', 'Descripcion Incidencia', 'trim|max_length[4]|required');

        if ($this->form_validation->run() == false) {
            $this->flash_validation_error('error:incidencia:validation');
            redirect(site_url('admin/incidencia/crear'));
            exit;
        }
        $registro = array();
        $registro["descripcion_incidencia"] = $this->input->post("descripcion_incidencia");
        $registro["id_tipo_incidencia"] = $this->input->post("id_tipo_incidencia");

        try {
            $this->incidencia_model->crear($registro);
            $this->flash('success', 'success:incidencia:create');
        } catch (Exception $e) {
            $this->flash_validation_error('error:incidencia:duplicated');
            redirect(site_url('admin/incidencia/crear'));
            exit;
        }
        return redirect(site_url("admin/incidencia/index"));
    
    }
    
    public function get_eliminar($id_incidencia) {
    
        try {
            $this->incidencia_model->eliminar(array('id_incidencia' => $id_incidencia));
            $this->flash('success', 'success:incidencia:deleted');
        } catch (Exception $e) {
            $this->flash('error', 'error:incidencia:using');
        }
        return redirect(site_url("admin/incidencia/index"));
    }

    public function get_editar($id_incidencia) {
    
        $result = $this->incidencia_model->buscar(array('id_incidencia' => $id_incidencia));
        if ($result->num_rows() == 0) {
            $this->flash('error', 'error:incidencia:not_found');
            redirect(site_url('admin/incidencia/'));
        }

        $this->data["incidencia"] = $result->row();
        $this->data['tipos_incidencias'] = $this->tipo_incidencia_model->listar()->result();
        return $this->load->view("admin/incidencia/editar_view", $this->data);
    }
        
    public function post_editar($id_incidencia) {
    
        $this->form_validation->set_rules('descripcion_incidencia', 'Descripcion Incidencia', 'trim|min_length[4]|required|max_length[45]');
        $this->form_validation->set_rules('id_tipo_incidencia', 'Descripcion Incidencia', 'trim|max_length[4]|required');

        if ($this->form_validation->run() == false) {
            $this->flash_validation_error('error:incidencia:validation');
            redirect(site_url('admin/incidencia/crear'));
            exit;
        }

        $registro = array();
        $registro["descripcion_incidencia"] = $this->input->post("descripcion_incidencia");
        $registro["id_tipo_incidencia"] = $this->input->post("id_tipo_incidencia");


        try {
            $this->incidencia_model->editar('id_incidencia', $id_incidencia, $registro);
            $this->flash('success', 'success:incidencia:editado');
        } catch (Exception $e) {
            $this->flash('error', 'error:incidencia:duplicated');
        }
        return redirect(site_url("admin/incidencia/index"));

    }
}
