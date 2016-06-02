<?php

class Usuario_model_testCase extends TestCase {

    public function setUp()
    {
        $this->resetInstance();
        $this->CI->load->model('Usuario_model', NULL, 'test');
        $sqlPath = APPPATH."tests".DIRECTORY_SEPARATOR."sql".DIRECTORY_SEPARATOR."test_usuario.sql";
        $sql = $this->CI->load->file($sqlPath, true);
        $this->CI->db->simple_query($sql);
    }

    public function tearDown()
    {
        $sql = "DELETE FROM usuario;";
        $this->CI->db->simple_query($sql);
    }
    public function test_Listar_Funciona_Correctamente(){
        $expected = array(
            1 => (object) array(
                'id_usuario' => '1',
                'login_usuario' => 'administrador',
                'password_usuario' => '1234',
                'nivel_usuario' => '1',
                'nombre_usuario' => 'Administra',
                'apellido_usuario' => 'dor'
            ),
            2 => (object) array(
                'id_usuario' => '2',
                'login_usuario' => 'coordinador',
                'password_usuario' => '1234',
                'nivel_usuario' => '2',
                'nombre_usuario' => 'Coor',
                'apellido_usuario' => 'dinador'
            ),
            3 => (object) array(
                'id_usuario' => '3',
                'login_usuario' => 'secretario',
                'password_usuario' => '1234',
                'nivel_usuario' => '3',
                'nombre_usuario' => 'Secre',
                'apellido_usuario' => 'tario'
            ),
            4 => (object) array(
                'id_usuario' => '4',
                'login_usuario' => 'reportero',
                'password_usuario' => '1234',
                'nivel_usuario' => '4',
                'nombre_usuario' => 'Repor',
                'apellido_usuario' => 'Tero'
            )
        );

        $usuarios = $this->CI->Usuario_model->listar()->result();
        
        $this->assertEquals(4, count($usuarios), "Deben existir 4 registros del setup");

        foreach ($usuarios as $usuario) {
            $this->assertEquals($expected[$usuario->id_usuario], $usuario, "Cada registro del setup debe ser igual al test");
        }
    }
    /**
     * test description
     */
    public function test_Buscar_Funciona_Correctamente_con_2_parametros(){
        $expected = (object) array(
            'id_usuario' => '1',
            'login_usuario' => 'administrador',
            'password_usuario' => '1234',
            'nivel_usuario' => '1',
            'nombre_usuario' => 'Administra',
            'apellido_usuario' => 'dor'
        );

        $actual = $this->CI->Usuario_model->buscar('id_usuario', '1')->result();

        $this->assertEquals(count($actual), 1, 'Debe encontrar 1 solo administrador [buscar($k, $v)]');

        $this->assertEquals($expected, $actual[0], 'Debe buscar por id_usuario a traves de [buscar($k, $v)]');
        
    }

    public function test_Buscar_Funciona_Correctamente_con_1_parametro()
    {
        $expected = (object) array(
            'id_usuario' => '1',
            'login_usuario' => 'administrador',
            'password_usuario' => '1234',
            'nivel_usuario' => '1',
            'nombre_usuario' => 'Administra',
            'apellido_usuario' => 'dor'
        );

        $actual = $this->CI->Usuario_model->buscar(
            array('id_usuario' => '1')
        )->result();

        $this->assertEquals(count($actual), 1, 'Debe encontrar 1 solo administrador [buscar($k, $v)]');
        $this->assertEquals($expected, $actual[0], 'Debe buscar por id_usuario a traves de [buscar($k, $v)]');
    }

    public function test_Crear_Usuario(){
        $expected = array(
            1 => (object) array(
                'id_usuario' => '1',
                'login_usuario' => 'administrador',
                'password_usuario' => '1234',
                'nivel_usuario' => '1',
                'nombre_usuario' => 'Administra',
                'apellido_usuario' => 'dor'
            ),
            2 => (object) array(
                'id_usuario' => '2',
                'login_usuario' => 'coordinador',
                'password_usuario' => '1234',
                'nivel_usuario' => '2',
                'nombre_usuario' => 'Coor',
                'apellido_usuario' => 'dinador'
            ),
            3 => (object) array(
                'id_usuario' => '3',
                'login_usuario' => 'secretario',
                'password_usuario' => '1234',
                'nivel_usuario' => '3',
                'nombre_usuario' => 'Secre',
                'apellido_usuario' => 'tario'
            ),
            4 => (object) array(
                'id_usuario' => '4',
                'login_usuario' => 'reportero',
                'password_usuario' => '1234',
                'nivel_usuario' => '4',
                'nombre_usuario' => 'Repor',
                'apellido_usuario' => 'Tero'
            )
        );

        $registro = array(
            'id_usuario' => '5',
            'login_usuario' => 'prueba',
            'password_usuario' => '1234',
            'nivel_usuario' => '5',
            'nombre_usuario' => 'Probador',
            'apellido_usuario' => 'Prueba'
        );
        
        $expected[$registro['id_usuario']] = (object)$registro;

        $this->CI->Usuario_model->crear($registro);

        $usuarios = $this->CI->Usuario_model->listar()->result();

        $this->assertEquals(count($usuarios), 5, "Deben existir 5 usuarios, 4 del setup y uno nuevo.");

        foreach ($usuarios as $usuario) {
            $this->assertEquals($expected[$usuario->id_usuario], $usuario, "Cada registro del setup debe ser igual al test");
        }
    }

    public function test_Editar_Usuario(){

        $criteria = array('id_usuario' => '2');
        $registro = array(
            'id_usuario' => '2',
            'login_usuario' => 'prueba',
            'password_usuario' => '1234',
            'nivel_usuario' => '5',
            'nombre_usuario' => 'Probador',
            'apellido_usuario' => 'Prueba'
        );


        $this->CI->Usuario_model->editar($criteria, $registro);

        $usuario = $this->CI->Usuario_model->buscar($criteria)->row();

        $this->assertEquals((object)$registro, $usuario, "Debe actualizar todas las propiedades correctamente");
    }

    public function test_Eliminar_Usuario(){
        $criteria = array('id_usuario' => '2');
        
        $this->CI->Usuario_model->eliminar($criteria);

        $cuenta = $this->CI->Usuario_model->buscar($criteria)->num_rows();

        $this->assertEquals($cuenta, 0, "Debe eliminar un registro por criterio");
    }

}