<?php
class Recorrido extends Admin_Controller
{

    public function __construct() {
    
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('recorrido_model');
    }
    public function get_index() {
    
        $this->data['recorridos'] = $this->recorrido_model->listar()->result();
        return $this->load->view("admin/recorrido/index_view", $this->data);
    }
    public function get_crear() {
    
        return $this->load->view("admin/recorrido/crear_view", $this->data);
    }

    public function post_crear() {
    

        $this->form_validation->set_rules('nombre_recorrido', 'Nombre De Recorrido', 'trim|required|min_length[5]|xss_clean');


        if ($this->form_validation->run() == false) {
            $this->flash_validation_error('error:recorrido:validation');
            redirect(site_url('admin/recorrido/crear'));
            exit;
        }
        
        $registro["nombre_recorrido"] = $this->input->post("nombre_recorrido");
        $registro["temporal"] = $this->input->post("temporal");
        
        try {
            $this->recorrido_model->crear($registro);
            $this->flash('success', 'success:recorrido:create');
        } catch (Exception $e) {
            $this->flash('error', 'error:recorrido:duplicated');
        }
        return redirect(site_url("admin/recorrido/index"));
    
    }
    
    public function get_eliminar($id_recorrido) {
    
        try {
            $this->recorrido_model->eliminar(array('id_recorrido' => $id_recorrido));
            $this->flash('success', 'success:recorrido:delete');
        } catch (Exception $e) {
            $this->flash('error', 'error:recorrido:in_use');
        }

        return redirect(site_url("admin/recorrido/index"));
    }

    public function get_editar($id_recorrido) {
    
        $result = $this->recorrido_model->buscar(array('id_recorrido' => $id_recorrido));
        if ($result->num_rows() == 0) {
            $this->flash('error', 'error:recorrido:not_found');
            redirect(site_url('admin/recorrido/'));
        }
        $this->data["recorrido"] = $result->row();
        return $this->load->view("admin/recorrido/editar_view", $this->data);
    }
        
    public function post_editar($id_recorrido) {
    
        $this->form_validation->set_rules('nombre_recorrido', 'Nombre De Recorrido', 'trim|required|min_length[5]|xss_clean');

        if ($this->form_validation->run() == false) {
            $this->flash_validation_error('error:recorrido:validation');
            redirect(site_url('admin/recorrido/editar/' . $id_recorrido));
            exit;
        }

        $registro = array();
        $registro["nombre_recorrido"] = $this->input->post("nombre_recorrido");
        $registro["temporal"] = $this->input->post("temporal");


        try {
            $this->recorrido_model->editar(array('id_recorrido' => $id_recorrido), $registro);
            $this->flash('success', 'success:recorrido:editado');
        } catch (Exception $e) {
            $this->flash('error', 'error:unidad:duplicated');
        }
        return redirect(site_url("admin/recorrido/index"));

    }
 
    public function get_ver_trazo_establecido($id_recorrido) {
        $result = $this->recorrido_model->buscar(array('id_recorrido' => $id_recorrido));
        if ($result->num_rows() == 0) {
            $this->flash('error', 'error:recorrido:not_found');
            redirect(site_url('admin/recorrido/'));
        }
        $this->load->library('gmap_lib');
        $this->data["recorrido"] = $result->row();
        $trazado = $this->recorrido_model->obtener_trazado($id_recorrido)->result();
        $this->data["trazado"] = $trazado;
        $this->data["trazado_pairs"] = $this->gmap_lib->route_to_pairs($trazado);
        return $this->load->view("admin/recorrido/asignar_trazo_view", $this->data);
    }

    public function post_ver_trazo_establecido($id_recorrido) {
        $this->load->library('gmap_lib');
        $raw_points = $this->input->post('puntos');
        $points = array();
        foreach ($raw_points as $coords) {
            $points[] = explode(',', $coords);
        }
        $this->recorrido_model->guardar_trazado($id_recorrido, $points);
        $this->flash('success', 'success:recorrido:trazado:stored');
        return redirect(site_url("admin/recorrido/index"));

    }
}
