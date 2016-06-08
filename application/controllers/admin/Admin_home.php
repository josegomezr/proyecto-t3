<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
* Admin_home
* @Controlador
*
* Maneja el inicio del panel de administracion
*
*/
class Admin_home extends Admin_Controller
{

    /**
    * get_index
    * @vista
    *
    * Muestra la vista inicial del panel de administracion.
    */
    public function get_index() {
    	// cargamos la vista
        $this->load->view('admin/home/index_view', $this->data);
    }

    /**
    * get_logout
    * @redireccion
    *
    * Elimina / cierra la sesion actual y redirecciona al formulario de 
    * inicio de sesion
    */
    public function get_logout() {
    	// destruimos la sesion
        $this->session->sess_destroy();
        // redireccionamos.
        return redirect('home/index');
    }

    public function get_test_map() {
    
        $this->load->view('test-map');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
