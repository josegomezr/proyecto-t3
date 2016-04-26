<?php
include 'dompdf/vendor/autoload.php';
define('DOMPDF_ENABLE_AUTOLOAD', false);
define('DOMPDF_ENABLE_REMOTE', true);
require_once 'dompdf/dompdf_config.inc.php';

class Dom_pdf 
{
    private $instance;

    function __construct($config = array()){
        $this->instance = new DOMPDF();
    }

    function armar_pdf($html){
        $this->instance->load_html($html);
    }

    function establecer_papel($paper, $orientation = 'portrait'){
        $this->instance->set_paper($paper, $orientation);
    }

    function mostrar(){
        $this->instance->render();
        header("Content-type: application/pdf");
        echo $this->instance->output();
        exit;
    }

    function descarga($filename){
        $this->instance->render();
        return $this->instance->stream($filename.".pdf");
    }
}