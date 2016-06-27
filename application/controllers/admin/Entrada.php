<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Entrada
* @Controlador
*
* Maneja las operaciones de entradas
*
*/
class Entrada extends Admin_Controller {
	/**
    * __construct
    * @constructor
    *
    * Carga la libreria de validacion de formulario y los modelos salida_model,
    * entrada_model, conductor_model, recorrido_model, unidad_model 
    * disponibles para todos los metodos.
    */

    public function __construct() {
    
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('salida_model');
        $this->load->model('entrada_model');
        $this->load->model('conductor_model');
        $this->load->model('recorrido_model');
        $this->load->model('unidad_model');
        $this->load->model('tipo_incidencia_model');
        $this->load->model('incidencia_model');
       
        $this->data['tipos_incidencia'] = $this->tipo_incidencia_model->listar()->result();
        $this->data['incidencias'] = $this->incidencia_model->listar()->result();         
    }
	
	/**
    * post_registrar_entrada
    * @proceso
    *
    * Procesa el formulario de registro de entradas.
    */ 
    public function post_registrar_entrada() {
        // sacamos la salida que se quiere marcar como completa 
        $id_salida = $this->input->post('id_salida', false);
        // si no hay salida
        if (!$id_salida) {
        	// notifica el error
            $this->flash('error', 'error:salida:not_found');
        	// redirecciona al listar
            redirect(site_url('admin/salida'));
        }

        $result = $this->salida_model->buscar(array(
            'id_salida' => $id_salida
        ));

        // si no hay salida
        if ($result->num_rows() == 0) {
        	// notifica el error
            $this->flash('error', 'error:salida:not_found');
        	// redirecciona al listar
            redirect(site_url('admin/salida/'));
        }

        // armamos el registro
        $registro = array();
        $registro['id_salida'] = $result->row()->id_salida;
        $registro['fecha_entrada'] = date('Y-m-d');
        $registro['hora_entrada'] = date('H:i');
        
        $registro["id_tipo_incidencia"] = $this->input->post("id_tipo_incidencia");
        $registro["comentario_entrada_incidencia"] = $this->input->post("comentario_entrada_incidencia");
        $registro["id_incidencia"] = $this->input->post("id_incidencia");

        // creamos la entrada
        $this->entrada_model->crear($registro);
        // notificamos el exito
        $this->flash('success', 'success:entrada:created');
        // redirecciona al listar
        return redirect(site_url("admin/salida/index"));
    }

    /**
    * get_editar
    * @vista
    *
    * Carga el formulario de editar entrada
    */
    
    public function get_editar($id_entrada) {

    	// buscamos la entrada
        $result = $this->entrada_model->buscar(array(
            'id_entrada' => $id_entrada
		));
		// si no existe
        if ($result->num_rows() == 0) {
            // notificamos el error
            $this->flash('error', 'error:entrada:not_found');
            // redireccionaos al listar
            redirect(site_url('admin/salida'));
        }
        $entrada = $result->row();
        // jalamos la salida
        $salida = $this->salida_model->buscar(array(
            'id_salida' => $entrada->id_salida
        ))->row();

        // enviamos todo a la vista
        // la entrada
        $this->data["entrada"] = $entrada;
        $this->data["salida"] = $salida;
        // el conductor
        $this->data['chofer'] = $this->conductor_model->buscar(array(
            'id_conductor' => $salida->id_conductor
        ))->row();

        // el acompañante
        if ($salida->id_acompaniante) {
            $this->data['acompaniante'] = $this->conductor_model->buscar(array(
                'id_conductor' => $salida->id_acompaniante
            ))->row();
        }

        // el recorrido
        $this->data['recorrido'] = $this->recorrido_model->buscar(array(
            'id_recorrido' => $salida->id_recorrido
        ))->row();
        // la unidad
        $this->data['unidad'] = $this->unidad_model->buscar(array(
            'placa_unidad' => $salida->placa_unidad
        ))->row();
        // cargamos la vista

        $this->data['tipos_incidencia'] = $this->tipo_incidencia_model
        	->listar()->result();
        $this->data['incidencias'] = $this->incidencia_model
        	->listar()->result();
        
        return $this->load->view("admin/entrada/editar_view", $this->data);
    }
    
    /**
    * post_editar
    * @proceso
    *
    * Procesa el formulario de editar entrada.
    * @todo poner los nuevos campos.
    */ 
    public function post_editar($id_entrada) {
    	
        $this->form_validation->set_rules('id_tipo_incidencia',
        	'tipo_incidencia', 'trim');
        $this->form_validation->set_rules('id_incidencia',
        	'incidencia', 'trim');
        $this->form_validation->set_rules('comentario_entrada_incidencia',
        	'Detalles Adicionales', 'trim');

        if ($this->form_validation->run() == false) {
            $this->flash_validation_error('error:entrada:validation');
            redirect(site_url('admin/entrada/editar/' . $id_entrada));
            exit;
        }

        $registro = array();
        $registro["id_tipo_incidencia"] = $this->input->post("id_tipo_incidencia");
        $registro["id_incidencia"] = $this->input->post("id_incidencia");
        $registro["comentario_entrada_incidencia"] = $this->input->post("comentario_entrada_incidencia");
        $this->entrada_model->editar(array('id_entrada' => $id_entrada), $registro);
        $this->flash('success', 'success:entrada:updated');
        return redirect(site_url("admin/salida/index"));

    }

    /**
    * get_eliminar
    * @proceso
    *
    * Elimina una salida.
    */
    public function get_eliminar($id_entrada, $id_salida) {
    	// eliminamos los puntos asociados a esa entrada
        $this->salida_model->eliminar_recorrido($id_entrada);
    	// eliminamos la entrada
        $this->entrada_model->eliminar(array('id_entrada' => $id_entrada));
    	// eliminamos la salida
        $this->salida_model->eliminar(array('id_salida' => $id_salida));

        // notificamos el exito
        $this->flash('success', 'success:entrada:deleted');
        // redireccionamos al listar
        return redirect(site_url("admin/salida/index"));
    }
}

/* End of file entrada.php */
/* Location: ./application/controllers/entrada.php */
