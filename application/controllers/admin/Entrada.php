<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Entrada extends Admin_Controller
{

    public function __construct() {
    
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('salida_model');
        $this->load->model('entrada_model');
        $this->load->model('conductor_model');
        $this->load->model('recorrido_model');
        $this->load->model('unidad_model');
        
    }
    public function post_registrar_entrada() {
    
        $id_salida = $this->input->post('id_salida', false);
        
        if (!$id_salida) {
            redirect(site_url('admin/salida'));
        }

        $result = $this->salida_model->buscar(array(
            'id_salida' => $id_salida
            ));

        if ($result->num_rows() == 0) {
            $this->flash('error', 'error:salida:not_found');
            redirect(site_url('admin/salida/'));
        }

        $registro = array();

        $registro['id_salida'] = $result->row()->id_salida;
        $registro['fecha_entrada'] = date('Y-m-d');
        $registro['hora_entrada'] = date('H:i');
        
        $registro["id_tipo_incidencia"] = $this->input->post("id_tipo_incidencia");
        $registro["comentario_entrada_incidencia"] = $this->input->post("comentario_entrada_incidencia");
        $registro["id_incidencia"] = $this->input->post("id_incidencia");

        $this->entrada_model->crear($registro);
        $this->flash('success', 'success:entrada:created');
        return redirect(site_url("admin/salida/index"));
    }

    public function get_editar($id_entrada) {
    
        $result = $this->entrada_model->buscar(array(
            'id_entrada' => $id_entrada
            ));
        if ($result->num_rows() == 0) {
            $this->flash('error', 'error:entrada:not_found');
            redirect(site_url('admin/salida'));
        }
        $entrada = $result->row();
        $salida = $this->salida_model->buscar(array(
            'id_salida' => $entrada->id_salida
            ))->row();

        $this->data["entrada"] = $entrada;

        $this->data['chofer'] = $this->conductor_model->buscar(array(
            'cedula_chofer' => $salida->cedula_chofer
            ))->row();
        
        if ($salida->cedula_acompaniante) {
            $this->data['acompaniante'] = $this->conductor_model->buscar(array(
                'cedula_chofer' => $salida->cedula_acompaniante
                ))->row();
        }

        $this->data['recorrido'] = $this->recorrido_model->buscar(array(
            'id_recorrido' => $salida->id_recorrido
            ))->row();
        $this->data['unidad'] = $this->unidad_model->buscar(array(
            'placa_unidad' => $salida->placa_unidad
            ))->row();

        return $this->load->view("admin/entrada/editar_view", $this->data);
    }
        
    public function post_editar($id_entrada) {
    
        $this->form_validation->set_rules('observacion', 'Observacion', 'trim');

        if ($this->form_validation->run() == false) {
            $this->flash_validation_error('error:entrada:validation');
            redirect(site_url('admin/entrada/editar/' . $id_entrada));
            exit;
        }

        $registro = array();
        // $registro["observacion_entrada"] = $this->input->post("observacion");
        $this->entrada_model->editar('id_entrada', $id_entrada, $registro);
        $this->flash('success', 'success:entrada:updated');
        return redirect(site_url("admin/salida/index"));

    }

    public function get_eliminar($id_entrada, $id_salida) {
    
        $this->salida_model->eliminar_recorrido($id_entrada);
        $this->entrada_model->eliminar('id_entrada', $id_entrada);

        $this->salida_model->eliminar('id_salida', $id_salida);

        $this->flash('success', 'success:entrada:deleted');
        return redirect(site_url("admin/salida/index"));
    }
}

/* End of file entrada.php */
/* Location: ./application/controllers/entrada.php */
