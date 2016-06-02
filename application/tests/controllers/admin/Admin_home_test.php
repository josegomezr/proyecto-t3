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
        $this->CI->load->library('session');
    }

    public function tearDown()
    {

    }
    
    public function test_Inicio_panel_administrador()
    {
        $this->CI->session->set_userdata(array('logged_in' => '1'));
        $output = $this->request('GET', ['admin', 'home','index']);
        $ci = &get_instance();
        $this->assertResponseCode(200);
    }
}