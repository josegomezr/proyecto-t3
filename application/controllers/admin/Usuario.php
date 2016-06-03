<?php
class Usuario extends Admin_Controller
{
    public $niveles = array();
    
    public function __construct() {
    
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('usuario_model');
        
        $this->niveles = array(
            0 => '',
            1 => 'Administrador',
            2 => 'Coordinador',
            3 => 'Secretario',
            4 => 'Reportero'
        );

        $this->data['niveles_usuario'] = $this->niveles;
    }
    public function get_index() {
    
        $this->data['usuarios'] = $this->usuario_model->listar()->result();
        return $this->load->view("admin/usuario/index_view", $this->data);
    }
    public function get_crear() {
    
        return $this->load->view("admin/usuario/crear_view", $this->data);
    }

    public function post_crear() {
    

        $this->form_validation->set_rules('login_usuario', 'Nombre de Usuario', 'trim|min_length[4]|required');
        $this->form_validation->set_rules('password', 'Contrase&ntilde;a', 'trim|min_length[4]|required');
        $this->form_validation->set_rules('password_repeat', 'Repita la Contrase&ntilde;a', 'trim|min_length[4]|matches[password]|required');
        $this->form_validation->set_rules('nivel_usuario', 'Nivel', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->flash_validation_error('error:usuario:validation');
            redirect(site_url('admin/usuario/crear'));
            exit;
        }
        $registro["nivel_usuario"] = $this->input->post("nivel_usuario");
        $registro["login_usuario"] = $this->input->post("login_usuario");
        $registro["password_usuario"] = $this->input->post("password");

        try {
            $this->usuario_model->crear($registro);
            $this->flash('success', 'success:usuario:create');
        } catch (Exception $e) {
            $this->flash_validation_error('error:usuario:duplicated');
            redirect(site_url('admin/usuario/crear'));
            exit;
        }
        return redirect(site_url("admin/usuario/index"));
    
    }
    
    public function get_eliminar($id_usuario) {
    
        try {
            $this->usuario_model->eliminar(array('id_usuario' => $id_usuario));
            $this->flash('success', 'success:usuario:deleted');
        } catch (Exception $e) {
            $this->flash('error', 'error:usuario:using');
        }
        return redirect(site_url("admin/usuario/index"));
    }

    public function get_editar($id_usuario) {
    
        $result = $this->usuario_model->buscar(array('id_usuario' => $id_usuario));
        if ($result->num_rows() == 0) {
            $this->flash('error', 'error:usuario:not_found');
            redirect(site_url('admin/usuario/'));
        }
        $this->data["usuario"] = $result->row();
        return $this->load->view("admin/usuario/editar_view", $this->data);
    }
        
    public function post_editar($id_usuario) {
    
        $this->form_validation->set_rules('password', 'Contrase&ntilde;a', 'trim|min_length[4]|required');
        $this->form_validation->set_rules('password_repeat', 'Repita la Contrase&ntilde;a', 'trim|min_length[4]|matches[password]|required');
        $this->form_validation->set_rules('nivel_usuario', 'Nivel', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->flash_validation_error('error:usuario:validation');
            redirect(site_url('admin/usuario/editar/' . $id_usuario));
            exit;
        }

        $registro = array();
        $registro["nivel_usuario"] = $this->input->post("nivel_usuario");
        $registro["password_usuario"] = $this->input->post("password");

        try {
            $this->usuario_model->editar(array('id_usuario' => $id_usuario), $registro);
            $this->flash('success', 'success:usuario:editado');
        } catch (Exception $e) {
            $this->flash('error', 'error:usuario:duplicated');
        }
        return redirect(site_url("admin/usuario/index"));

    }
}
