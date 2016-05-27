<?php

namespace Debug{
    function show()
    {
        if (!extension_loaded('xdebug')) {
            echo "<pre>";
        }
        $args = func_get_args();
        foreach ($args as $arg) {
            print_r($arg);
        }
        if (!extension_loaded('xdebug')) {
            echo "</pre>";
        }
    }

    function dump()
    {
        if (!extension_loaded('xdebug')) {
            echo "<pre>";
        }
        $args = func_get_args();
        call_user_func_array('var_dump', $args);
        if (!extension_loaded('xdebug')) {
            echo "</pre>";
        }
    }

    function s()
    {
        $args = func_get_args();
        call_user_func_array('Debug\\show', $args);
    }

    function sd()
    {
        $args = func_get_args();
        call_user_func_array('Debug\\show', $args);
        exit;
    }    

    function d()
    {
        $args = func_get_args();
        call_user_func_array('Debug\\dump', $args);
    }

    function dd()
    {
        $args = func_get_args();
        call_user_func_array('Debug\\dump', $args);
        exit;
    }
}