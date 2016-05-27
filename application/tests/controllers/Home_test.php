<?php
/**
 * Part of ci-phpunit-test
 *
 * @author     Kenji Suzuki <https://github.com/kenjis>
 * @license    MIT License
 * @copyright  2015 Kenji Suzuki
 * @link       https://github.com/kenjis/ci-phpunit-test
 */
class Home_test extends TestCase
{
    public function setUp()
    {
        $this->resetInstance();
        $this->CI->load->database('test');

        $sqlPath = APPPATH."tests".DIRECTORY_SEPARATOR."sql".DIRECTORY_SEPARATOR."test_usuario.sql";
        $sqlData = $this->CI->load->file($sqlPath, true);
        $this->CI->db->simple_query($sqlData);
    }

    public function tearDown()
    {
        $sql = "DELETE FROM usuario;";
        $this->CI->db->simple_query($sql);
    }
    
    public function test_Login_con_malas_credenciales()
    {
        $output = $this->request('POST', ['Home', 'login'], array(
            'username' => 'prueba',
            'password' => '123123'
        ));
        
        $ci = &get_instance();
        $this->assertResponseCode(302);
        $this->assertEquals($ci->session->flashdata('error'), "user:bad:login");
    }

    public function test_Login_vacio()
    {

        $output = $this->request('POST', ['Home', 'login']);
        
        $ci = &get_instance();
        $this->assertResponseCode(302);
        $this->assertEquals($ci->session->flashdata('error'), "user:bad:login");
    }

    public function test_Login_con_usuario_bueno_pero_clave_mala()
    {
        $output = $this->request('POST', ['Home', 'login'], array(
            'username' => 'administrador',
            'password' => '123123'
        ));
        
        $ci = &get_instance();
        $this->assertResponseCode(302);
        $this->assertEquals($ci->session->flashdata('error'), "user:bad:password");
    }
}