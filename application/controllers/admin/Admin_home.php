<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_home extends Admin_Controller {

	public function get_index()
	{
		$this->load->view('admin/home/index_view', $this->data);
	}

	public function get_logout()
	{
		$this->session->sess_destroy();
		redirect('home/index');
	}

	public function get_test_map()
	{
		$this->load->view('test-map');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
