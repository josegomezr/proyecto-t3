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

        // Halamos los datos del formulario.
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

    public function get_test() {
    
        $data = array (
          array (
            'latitud' => '10.437824',
            'longitud' => '-64.141365',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.438921',
            'longitud' => '-64.142158',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.438098',
            'longitud' => '-64.143039',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.445305',
            'longitud' => '-64.151289',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.447494',
            'longitud' => '-64.153861',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.449567',
            'longitud' => '-64.156396',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.450601',
            'longitud' => '-64.158391',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.4516',
            'longitud' => '-64.159537',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.45264',
            'longitud' => '-64.160467',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.45385',
            'longitud' => '-64.161602',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.454222',
            'longitud' => '-64.16188',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.454742',
            'longitud' => '-64.162501',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.45522',
            'longitud' => '-64.163595',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.455692',
            'longitud' => '-64.166159',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.456499',
            'longitud' => '-64.170547',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.457006',
            'longitud' => '-64.171702',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.457164',
            'longitud' => '-64.172501',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.457549',
            'longitud' => '-64.173123',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.458377',
            'longitud' => '-64.17366',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.459168',
            'longitud' => '-64.173869',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.459532',
            'longitud' => '-64.174046',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.459348',
            'longitud' => '-64.174545',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.460049',
            'longitud' => '-64.17498',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.460888',
            'longitud' => '-64.175265',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.461595',
            'longitud' => '-64.175394',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.462808',
            'longitud' => '-64.175419',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.46352',
            'longitud' => '-64.175081',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.46375',
            'longitud' => '-64.174939',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.464243',
            'longitud' => '-64.175205',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.464037',
            'longitud' => '-64.175521',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.463536',
            'longitud' => '-64.175296',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.463025',
            'longitud' => '-64.175478',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.461685',
            'longitud' => '-64.175505',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.460645',
            'longitud' => '-64.175317',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.459422',
            'longitud' => '-64.174765',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.459047',
            'longitud' => '-64.174513',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.458657',
            'longitud' => '-64.173944',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.457802',
            'longitud' => '-64.173494',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.457333',
            'longitud' => '-64.17307',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.456942',
            'longitud' => '-64.172501',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.456678',
            'longitud' => '-64.171879',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.456431',
            'longitud' => '-64.17065',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.45584',
            'longitud' => '-64.167679',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.455518',
            'longitud' => '-64.16579',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.455133',
            'longitud' => '-64.163618',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.454669',
            'longitud' => '-64.162614',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.454231',
            'longitud' => '-64.162062',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.453761',
            'longitud' => '-64.16167',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.453315',
            'longitud' => '-64.161182',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.45287',
            'longitud' => '-64.160855',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.452031',
            'longitud' => '-64.160104',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.451382',
            'longitud' => '-64.159482',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.450622',
            'longitud' => '-64.158639',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.449815',
            'longitud' => '-64.1571',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.449451',
            'longitud' => '-64.156504',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.448639',
            'longitud' => '-64.155437',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.447774',
            'longitud' => '-64.154343',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.44656',
            'longitud' => '-64.15298',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.445595',
            'longitud' => '-64.151875',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.44502',
            'longitud' => '-64.151167',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.444371',
            'longitud' => '-64.150341',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.444271',
            'longitud' => '-64.150153',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.442672',
            'longitud' => '-64.148345',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.441622',
            'longitud' => '-64.147025',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.438198',
            'longitud' => '-64.143061',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.438673',
            'longitud' => '-64.142466',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.438985',
            'longitud' => '-64.142128',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.438631',
            'longitud' => '-64.141849',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.438341',
            'longitud' => '-64.141881',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          ),
          array (
            'latitud' => '10.437924',
            'longitud' => '-64.141565',
            'fecha_punto' => date('Y-m-d'),
            'hora_punto' => date('H:i:s'),
            'velocidad'=> 50.2,
            'num_satelites' => 6
          )
        );

        $this->load->model('salida_model');
        $this->salida_model->guardar_trazado('8',$data);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
