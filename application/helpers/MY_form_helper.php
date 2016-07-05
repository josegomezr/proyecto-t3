<?php

namespace Form {

    function set_value($field = '', $default = '') {
        $ci =& get_instance();
        $form_data = $ci->session->flashdata('form:fields');
        return isset($form_data[$field]) ? $form_data[$field] : $default;
    }

    function has_error($field) {
        $ci =& get_instance();
        $form_errors = $ci->session->flashdata('form:errors');
        return !!isset($form_errors[$field]);
    }

    function get_error($field) {
        $ci =& get_instance();
        $form_errors = $ci->session->flashdata('form:errors');
        return isset($form_errors[$field]) ? $form_errors[$field] : false;
    }
}

namespace{
	function time_elapsed_string($now, $ago, $full = false) {
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'año',
        'm' => 'mes',
        'w' => 'semana',
        'd' => 'dia',
        'h' => 'hora',
        'i' => 'minuto',
        's' => 'segundo',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? ($k == 'm' ? 'es' : 's') : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) : 'unos pocos segundos';
}

}