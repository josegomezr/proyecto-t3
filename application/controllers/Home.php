<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Front_Controller {

	public function get_index()
	{
		$this->load->view('front/home/index_view');
	}

	public function post_login(){
		$this->load->model('usuario_model');

		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$result = $this->usuario_model->buscar('login_usuario', $username);
		if($result->num_rows() == 0){
			// esto es para que el formulario se vuelva a completar
			$this->session->set_flashdata('error', 'user:bad:login');
			$this->session->set_flashdata('form:fields', $_POST);
			// y redireccionamos
			redirect(site_url('home/index'));
		}
	
		// Usuario existe, revisa la clave
		$usuario = $result->row();

		if($usuario->password_usuario != $password){
			// esto es para que el formulario se vuelva a completar
			$this->session->set_flashdata('error', 'user:bad:password');
			$this->session->set_flashdata('form:fields', $_POST);
			// y redireccionamos
			redirect(site_url('home/index'));
		}

		if($usuario->nivel_usuario == 0){
			$this->session->set_flashdata('error', 'user:not_allowed');
			redirect(site_url('home/index'));
		}
		var_dump($usuario);
		$newdata = array(
           'username'  => $usuario->login_usuario,
           'nivel'     => $usuario->nivel_usuario,
           'nombre'     => $usuario->nombre_usuario,
           'apellido'     => $usuario->apellido_usuario,
           'logged_in' => TRUE
       	);

		$this->session->set_userdata($newdata);
		$this->session->set_flashdata('info', 'user:login:success');
		redirect(site_url('admin/home'));
	}

	public function get_pdf_test()
	{
		$this->load->library('dom_pdf');
		
		$this->dom_pdf->armar_pdf();
		$this->dom_pdf->establecer_papel('Letter', 'Landscape');
		$this->dom_pdf->mostrar();
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
