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
