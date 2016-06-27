<?php

/**
* Dispositivo
* @Controlador
*
* Maneja las operaciones de Dispositivos
*
*/

class Dispositivo extends Admin_Controller
{
    /**
    * __construct
    * @constructor
    *
    * Carga la libreria de validacion de formulario y los modelos 
    * dispositivo_model, recorrido_model y unidad_model para que esten 
    * disponibles para todos los metodos.
    */
    public function __construct() {
    
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('dispositivo_model');
        $this->load->model('recorrido_model');
        $this->load->model('unidad_model');
    }

    /**
    * get_index
    * @vista
    *
    * Busca todos los dispositivos y muestra la vista de la lista de 
    * dispositivos.
    */
    public function get_index() {
        // buscamos todos los dispositivos y los pasamos a la vista.
        $this->data['dispositivos'] = $this->dispositivo_model->listar()->result();
        // cargamos la vista
        return $this->load->view("admin/dispositivo/index_view", $this->data);
    }

    /**
    * get_crear
    * @vista
    *
    * Carga el formulario de crear dispositivo
    */
    public function get_crear() {
        // buscamos todas las unidades sin dispositivos
        $unidades = $this->unidad_model->listar_sin_dispositivo();
        // buscamos los recorridos
        $recorridos = $this->recorrido_model->listar()->result();
        // si no hay unidades
        if (count($unidades) == 0) {
            // flasheamos el error
            $this->flash('error', 'error:dispositivo:no-unidades');
            // redireccionamos
            redirect(site_url('admin/dispositivo'));
            exit;
        }
        
        // si no hay recorridos
        if (count($recorridos) == 0) {
            // flasheamos el error
            $this->flash('error', 'error:dispositivo:no-recorridos');
            // redireccionamos
            redirect(site_url('admin/dispositivo'));
            exit;
        }

        // aqui hay recorridos y unidades
        // los pasamos a la vista
        $this->data['unidades'] = $unidades;
        $this->data['recorridos'] = $recorridos;
        // Cargamos la vista.
        return $this->load->view("admin/dispositivo/crear_view", $this->data);
    }

    /**
    * post_crear
    * @proceso
    *
    * Procesa el formulario de crear dispositivo, si no pasa la validacion se 
    * notifica el error y se envia al formulario otra vez.
    */ 
    public function post_crear() {
        // fijamos las reglas de validacion
        // set_rules (<nombre campo>, <nombre visible>,<reglas separadas por |>)
        // reglas:
        // - trim = eliminar espacios sobrantes al inicio 
        // - required = revisa si el campo tiene valor
        // - min_length[n] = revisa si el campo tiene al menos `n` caracteres
        // - max_length[n] = revisa si el campo tiene maximo `n` caracteres
        // - xss_clean = limpia elcampo de valores malisciosos.
        // - regex_match[RegExp] = Revisa si la expresion regular `RegExp` 
        //   concuerda con el valor del campo.

        $this->form_validation->set_rules('id_dispositivo', 'Dispositivo', 'trim|required|numeric');
        $this->form_validation->set_rules('id_unidad', 'Unidad', 'trim|required|xss_clean');
        $this->form_validation->set_rules('id_recorrido', 'Recorrido', 'trim|required|xss_clean');

        // si la validacion no tiene exito (hay campos que no pasaron las reglas
        // de validacion)
        if ($this->form_validation->run() == false) {
            // notificamos el error de validacion
            $this->flash_validation_error('error:dispositivo:validation');
            // redireccionamos hacia el formulario de crear.
            redirect(site_url('admin/dispositivo/crear'));
            exit;
        }
        
        // llenamos el registro que guardaremos en la bd.

        $registro = array(
            'id_dispositivo' => $this->input->post('id_dispositivo'),
            'id_unidad' => $this->input->post('id_unidad'),
            'id_recorrido' => $this->input->post('id_recorrido')
        );
        
        try {
            // creamos el dispositivo
            $this->dispositivo_model->crear($registro);
            // notificamos la operacion exitosa
            $this->flash('info', 'success:dispositivo:crear');
        } catch (Exception $e) {
            // esto es un catch-up por si el id autogenerado
            // se repite, lo generamos de nuevo
            sleep(1);
            $registro = array('id_dispositivo' => rand()%1000);
            // intentamos recrear.
            $this->dispositivo_model->crear($registro);
        }

        // todo creado, todo con exito, redireccionamos al listar.
        redirect(site_url('admin/dispositivo'));
    }
    
    /**
    * get_eliminar
    * @proceso
    *
    * Elimina un dispositivo.
    */
    public function get_eliminar($id_dispositivo) {
    
        try {
            // eliminamos al dispositivo
            $this->dispositivo_model->eliminar(array('id_dispositivo' => $id_dispositivo));
            // notificamos el exito de la operacion
            $this->flash('success', 'sucesss:dispositivo:deleted');
        } catch (Exception $e) {
            // notificamos el error
            $this->flash_validation_error('error:dispositivo:using');
        }
        // redireccionamos
        return redirect(site_url("admin/dispositivo/index"));
    }

    /**
    * get_editar
    * @vista
    *
    * Muestra el formulario de editar conductor.
    */
    public function get_editar($id_dispositivo) {
        // buscamos el dispositivo que vamos a editar
        $result = $this->dispositivo_model->buscar(array('id_dispositivo' => $id_dispositivo));
        // si no existe
        if ($result->num_rows() == 0) {
            // notificamos el error
            $this->flash('error', 'error:dispositivo:not_found');
            // redireccionamos
            redirect(site_url('admin/dispositivo/'));
        }
        // buscamos las unidades sin dispositivos INCLUYENDO la unidad
        // actual en la que el dispositivo esta adjunto
        $this->data['unidades'] = $this->unidad_model
            ->listar_sin_dispositivo($id_dispositivo)->result();
        // buscamos los recorridos
        $this->data['recorridos'] = $this->recorrido_model->listar()->result();
        // mandamos el dispositivo encontrado a la vista
        $this->data["dispositivo"] = $result->row();
        // cargamos la vista
        return $this->load->view("admin/dispositivo/editar_view", $this->data);
    }

    /**
    * post_editar
    * @proceso
    *
    * Procesa el formulario de edicion.
    */
        
    public function post_editar($id_dispositivo) {
        // fijamos las reglas de validacion
        // set_rules (<nombre campo>, <nombre visible>,<reglas separadas por |>)
        // reglas:
        // - trim = eliminar espacios sobrantes al inicio 
        // - required = revisa si el campo tiene valor
        // - min_length[n] = revisa si el campo tiene al menos `n` caracteres
        // - max_length[n] = revisa si el campo tiene maximo `n` caracteres
        // - xss_clean = limpia elcampo de valores malisciosos.
        // - regex_match[RegExp] = Revisa si la expresion regular `RegExp` 
        //   concuerda con el valor del campo.

        $this->form_validation->set_rules('id_unidad', 'Unidad', 'trim|required|xss_clean');
        $this->form_validation->set_rules('id_recorrido', 'Recorrido', 'trim|required|xss_clean');

        //   si la validacion no tiene exito (hay campos que no pasaron las reglas
        // de validacion)
        if ($this->form_validation->run() == false) {
            // notificamos el error de validacion
            $this->flash_validation_error('error:dispositivo:validation');
            // redireccionamos al formulario
            redirect(site_url('admin/dispositivo/crear'));
            exit;
        }
        // armamos el registro
        $registro = array(
            'id_dispositivo' => $id_dispositivo,
            'id_unidad' => $this->input->post('id_unidad'),
            'id_recorrido' => $this->input->post('id_recorrido')
        );
        // mandamos el registro para actualizar
        $this->dispositivo_model->editar(array('id_dispositivo' => $id_dispositivo), $registro);
        // notificamos el exito
        $this->flash('info', 'success:dispositivo:crear');
        // redireccionamos al listar
        redirect(site_url('admin/dispositivo'));
    }
}
