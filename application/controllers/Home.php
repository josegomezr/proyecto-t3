<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
* Home
* @Controlador
*
* Maneja el inicio de Sesion
*
*/
class Home extends Front_Controller
{
    /**
    * get_login
    * @vista
    *
    * Muestra la vista del login.
    */
    public function get_login() {
    
        $this->load->view('front/home/index_view');
    }

    /**
    * get_index
    * @redireccion
    *
    * Redirecciona hacia el formulario de login.
    */
    public function get_index() {
    
        return redirect(site_url('home/login'));
    }

    /**
    * post_index
    * @proceso
    *
    * Procesa los datos del formulario login si es incorrecto, redirecciona
    * de vuelta al formulario pasando errores, sino, redirecciona al panel de
    * administracion. 
    */
    public function post_login() {
        // Cargamos el modelo usuario_model
        $this->load->model('usuario_model');

        // Jalamos los datos del formulario.
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        
        // buscamos un usuario por `login_usuario`
        $result = $this->usuario_model->buscar(
            array('login_usuario' => $username)
        );
        
        // si da 0 (no existe un usuario con ese login)
        if ($result->num_rows() == 0) {
            // notificamos un error a la vista.
            $this->session->set_flashdata('error', 'user:bad:login');
            // y notificamos los campos para rellenar el formulario.
            $this->session->set_flashdata('form:fields', $_POST);
            // y redireccionamos de vuelta al formulario
            redirect(site_url('home/index'));
        }
        // el usuario existe, ahora revisamos si la clave es correcta.
        // jalamos la primera fila del resultado.
        $usuario = $result->row();
        
        // si la contraseña del registro DIFERENTE a la del formulario.
        if ($usuario->password_usuario != $password) {
            // notificamos un error a la vista.
            $this->session->set_flashdata('error', 'user:bad:password');
            // y notificamos los campos para rellenar el formulario.
            $this->session->set_flashdata('form:fields', $_POST);
            // y redireccionamos de vuelta al formulario
            redirect(site_url('home/index'));
        }
        // el usuario y la clave estan correctos

        // ahora vemos, si nivel == 0, ese usuario es invalido
        if ($usuario->nivel_usuario == 0) {
            // notificamos el error a la vista
            $this->session->set_flashdata('error', 'user:not_allowed');
            // y redireccionamos de vuelta al formulario.
            redirect(site_url('home/index'));
        }

        // montamos la data de sesion. Estos datos seran persistidos durante
        // la sesion activa.

        $newdata = array(
           'username'  => $usuario->login_usuario,
           'nivel'     => $usuario->nivel_usuario,
           'nombre'     => $usuario->nombre_usuario,
           'apellido'     => $usuario->apellido_usuario,
           'logged_in' => true
        );

        // mandamos a guardar en la session.
        $this->session->set_userdata($newdata);
        // notificamos success.
        $this->session->set_flashdata('info', 'user:login:success');
        // redireccionamos al panel de administracion.
        redirect(site_url('admin/home'));
    }

    public function get_pdf_test() {
    
        $this->load->library('dom_pdf');
        
        $this->dom_pdf->armar_pdf();
        $this->dom_pdf->establecer_papel('Letter', 'Landscape');
        $this->dom_pdf->mostrar();
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
