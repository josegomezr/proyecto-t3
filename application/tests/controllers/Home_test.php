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
        $output = $this->request('POST', ['Home', 'post_login'], array(
            'username' => 'prueba',
            'password' => '123123'
        ));
        
        $ci = &get_instance();
        $this->assertResponseCode(302);
        $this->assertEquals($ci->session->flashdata('error'), "user:bad:login");
    }

    public function test_Login_vacio()
    {

        $output = $this->request('POST', ['Home', 'post_login']);
        
        $ci = &get_instance();
        $this->assertResponseCode(302);
        $this->assertEquals($ci->session->flashdata('error'), "user:bad:login");
    }

    public function test_Login_con_usuario_bueno_pero_clave_mala()
    {
        $output = $this->request('POST', ['Home', 'post_login'], array(
            'username' => 'administrador',
            'password' => '123123'
        ));
        
        $ci = &get_instance();
        $this->assertResponseCode(302);
        $this->assertEquals($ci->session->flashdata('error'), "user:bad:password");
    }

/*
    public function test_method_404()
    {
        $this->request('GET', ['Welcome', 'method_not_exist']);
        $this->assertResponseCode(404);
    }

    public function test_APPPATH()
    {
        $actual = realpath(APPPATH);
        $expected = realpath(__DIR__ . '/../..');
        $this->assertEquals(
            $expected,
            $actual,
            'Your APPPATH seems to be wrong. Check your $application_folder in tests/Bootstrap.php'
        );
    }
*/

}