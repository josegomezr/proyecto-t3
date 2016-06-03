<?php
class Unidad extends Admin_Controller
{

    public function __construct() {
    
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('unidad_model');
    }
    public function get_index() {
    
        $this->data['unidades'] = $this->unidad_model->listar()->result();
        return $this->load->view("admin/unidad/index_view", $this->data);
    }
    public function get_crear() {
    
        $this->load->model('dispositivo_model');
        return $this->load->view("admin/unidad/crear_view", $this->data);
    }

    public function post_crear() {
    

        $this->form_validation->set_rules('placa', 'Placa', 'trim|required|min_length[7]|max_length[12]|xss_clean|regex_match[/([a-z]{3}\s[a-z0-9]{3})?([a-z0-9]+)/i]');
        $this->form_validation->set_rules('modelo', 'Modelo', 'trim|min_length[4]|required');

        if ($this->form_validation->run() == false) {
            $this->flash_validation_error('error:unidad:validation');
            redirect(site_url('admin/unidad/crear'));
            exit;
        }
        
        $registro["placa_unidad"] = strtoupper($this->input->post("placa"));
        $registro["modelo_unidad"] = $this->input->post("modelo");

        try {
            $this->unidad_model->crear($registro);
            $this->flash('success', 'success:unidad:create');
        } catch (Exception $e) {
            $this->flash('error', 'error:unidad:duplicated');
        }
        return redirect(site_url("admin/unidad/index"));
    
    }
    
    public function get_eliminar($id_unidad) {
    
        try {
            $this->unidad_model->eliminar(array('id_unidad' => $id_unidad));
            $this->flash('info', 'success:unidad:deleted');
        } catch (Exception $e) {
            $this->flash('error', 'error:unidad:in_use');
        }
        return redirect(site_url("admin/unidad/index"));
    }

    public function get_editar($id_unidad) {
    
        $result = $this->unidad_model->buscar(array('id_unidad' => $id_unidad));

        if ($result->num_rows() == 0) {
            $this->flash('error', 'error:unidad:not_found');
            redirect(site_url('admin/unidad/'));
        }
        $this->data["unidad"] = $result->row();
        return $this->load->view("admin/unidad/editar_view", $this->data);
    }
        
    public function post_editar($id_unidad) {
    
        $this->form_validation->set_rules('placa', 'Placa', 'trim|required|min_length[7]|max_length[12]|xss_clean|regex_match[/([a-z]{3}\s[a-z0-9]{3})?([a-z0-9]+)/i]');
        $this->form_validation->set_rules('modelo', 'Modelo', 'trim|min_length[4]|required');

        if ($this->form_validation->run() == false) {
            $this->flash_validation_error('error:unidad:validation');
            redirect(site_url('admin/unidad/editar/' . $id_unidad));
            exit;
        }

        $registro = array();
        $registro["modelo_unidad"] = $this->input->post("modelo");

        $this->unidad_model->editar(array('id_unidad' => $id_unidad), $registro);
        $this->flash('success', 'success:unidad:editado');

        return redirect(site_url("admin/unidad/index"));

    }
}
