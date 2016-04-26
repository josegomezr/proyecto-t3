<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| CAPTCHA
| -------------------------------------------------------------------------
| This file lets you define captcha settings
|
*/
$config['captcha_setup'] = array(
    'word'          => substr(number_format(time() * rand(),0,'',''),0,4),
    'img_path'      => FCPATH.'captcha/',
    'img_url'       => base_url().'captcha/',
    'font_path'     => APPPATH.'third_party/captcha/fonts/zhafira.ttf',
    'img_width'     => '150',
    'img_height'    => 30,
    'expiration'    => 7200,
    'word_length'   => 8,
    'font_size'     => 80,
    'img_id'        => 'captcha_pic',
    'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
    'colors'        => array(
            'background' => array(204, 204, 204),
            'border' => array(243, 238, 238),
            'text' => array(0, 0, 0),
            'grid' => array(243, 238, 238)
    )
);