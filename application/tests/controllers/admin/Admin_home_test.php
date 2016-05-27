<?php
/**
 * Part of ci-phpunit-test
 *
 * @author     Kenji Suzuki <https://github.com/kenjis>
 * @license    MIT License
 * @copyright  2015 Kenji Suzuki
 * @link       https://github.com/kenjis/ci-phpunit-test
 */
class Admin_home_test extends TestCase
{
    public function setUp()
    {
        $this->resetInstance();
        $this->CI->load->database('test');
        $this->CI->load->library('session');

        $sqlPath = APPPATH."tests".DIRECTORY_SEPARATOR."sql".DIRECTORY_SEPARATOR."test_usuario.sql";
        $sqlData = $this->CI->load->file($sqlPath, true);
        $this->CI->db->simple_query($sqlData);
    }

    public function tearDown()
    {
        $sql = "DELETE FROM usuario;";
        $this->CI->db->simple_query($sql);
    }
    
    public function test_Inicio_panel_administrador()
    {
        $this->CI->session->set_userdata(array('logged_in' => '1'));
        $output = $this->request('GET', ['admin', 'admin_home','index']);
        $ci = &get_instance();
        $this->assertResponseCode(200);
    }
}