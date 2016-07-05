<?php
/**
* Conductor
* @Controlador
*
* Maneja las operaciones de conductor.
*
*/
class Conductor extends Admin_Controller
{
    /**
    * __construct
    * @constructor
    *
    * Carga la libreria de validacion de formulario y el modelo conductor_model
    * para que esten disponibles para todos los metodos.
    */
    public function __construct() {
        // esto es necesario, si sobre escribes el constructor no será un
        // controlador válido y no cargará.
        parent::__construct();

        // carga la libreria 'form_validation'
        $this->load->library('form_validation');
        // carga el modelo 'conductor_model'
        $this->load->model('conductor_model');
    }
    /**
    * get_index
    * @vista
    *
    * Busca todos los conductores y muestra la vista de la lista de conductores.
    */
    public function get_index() {
        // buscamos todos los conductores y los pasamos a la vista.
        $this->data['conductores'] = $this->conductor_model->listar()->result();
        // cargamos la vista
        return $this->load->view("admin/conductor/index_view", $this->data);
    }
    /**
    * get_crear
    * @vista
    *
    * Busca todos los conductores y muestra la vista de la lista de conductores.
    */
    public function get_crear() {
        // cargamos el formulario.
        return $this->load->view("admin/conductor/crear_view", $this->data);
    }

    /**
    * post_crear
    * @proceso
    *
    * Procesa el formulario de crear conductor, si no pasa la validacion se 
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

        $this->form_validation->set_rules('cedula', 'Cedula', 
            'trim|required|min_length[8]|is_unique[conductor.cedula_conductor]|max_length[12]|xss_clean|regex_match[/[VE]-[0-9]{8}/]');
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|min_length[3]|required');
        $this->form_validation->set_rules('apellido', 'apellido', 'trim|min_length[3]|required');

        // si la validacion no tiene exito (hay campos que no pasaron las reglas
        // de validacion)
        if ($this->form_validation->run() == false) {
            // notificamos el error de validacion
            $this->flash_validation_error('error:conductor:validation');
            // redireccionamos hacia el formulario de crear.
            return redirect(site_url('admin/conductor/crear'));
        }


        // llenamos el registro que guardaremos en la bd.

        $registro = array();
        $registro["nombre_conductor"] = $this->input->post("nombre");
        $registro["apellido_conductor"] = $this->input->post("apellido");
        $registro["cedula_conductor"] = $this->input->post("cedula");
        $registro["temporal"] = $this->input->post("temporal");

        try {
            // crea el registro
            $this->conductor_model->crear($registro);
            // notificamos la operacion exitosa
            $this->flash('success', 'success:conductor:create');
        } catch (Exception $e) {
            // hubo un error creando el registro.
            // notificamos el error.
            $this->flash_validation_error('error:conductor:duplicated');
            // redireccionamos al formulario de vuelta.
            redirect(site_url('admin/conductor/crear'));
            exit;
        }
        // todo creado, todo con exito, redireccionamos al listar.
        return redirect(site_url("admin/conductor/index"));
    }
    
    /**
    * get_eliminar
    * @proceso
    *
    * Elimina un conductor.
    */
    public function get_eliminar($cedula) {
        
        try {
            // eliminamos al conductor
            $this->conductor_model->eliminar(array('cedula_conductor' => $cedula));
            // notificamos la operacion exitosa
            $this->flash('success', 'success:conductor:deleted');
        } catch (Exception $e) {
            // notificamos el error
            $this->flash('error', 'error:conductor:using');
        }
        // Redireccionamos de vuelta al listar.
        return redirect(site_url("admin/conductor/index"));
    }

    /**
    * get_editar
    * @vista
    *
    * Muestra el formulario de editar conductor.
    */
    public function get_editar($cedula) {
    	
        $result = $this->conductor_model->buscar(array('cedula_conductor' => $cedula));
        if ($result->num_rows() == 0) {
            $this->flash('error', 'error:conductor:not_found');
            redirect(site_url('admin/conductor/'));
        }
        $this->data["conductor"] = $result->row();
        return $this->load->view("admin/conductor/editar_view", $this->data);
    }
    
    /**
    * post_editar
    * @proceso
    *
    * Procesa el formulario de edicion.
    */
    public function post_editar($cedula) {
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

        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|min_length[3]|required');
        $this->form_validation->set_rules('apellido', 'apellido', 'trim|min_length[3]|required');

        // si la validacion no tiene exito (hay campos que no pasaron las reglas
        // de validacion)
        if ($this->form_validation->run() == false) {
            // notificamos el error de validacion
            $this->flash_validation_error('error:conductor:validation');
            // redireccionamos
            redirect(site_url('admin/conductor/editar/' . $cedula));
            exit;
        }
        // armamos el registro con los datos nuevos
        $registro = array();
        $registro["nombre_conductor"] = $this->input->post("nombre");
        $registro["apellido_conductor"] = $this->input->post("apellido");
        $registro["temporal"] = $this->input->post("temporal");
        
        try {
        	// mandamos el registro para que se escriba en la bd.
            $this->conductor_model->editar(array('cedula_conductor' => $cedula), $registro);
            // notificamos el exito
            $this->flash('success', 'success:conductor:editado');
        } catch (Exception $e) {
        	// notificamos el error
            $this->flash('error', 'error:conductor:duplicated');
        }
        // redireccionamos al listar
        return redirect(site_url("admin/conductor/index"));
    }
}
