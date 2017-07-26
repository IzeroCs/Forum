<?php

    /*
     * Smarty plugin
     * -------------------------------------------------------------
     * File:     function.env.php
     * Type:     function
     * Name:     env
     * Purpose:  get env value
     * -------------------------------------------------------------
     */

    function smarty_function_env($params, Smarty_Internal_Template $template)
    {
        if (isset($params['name']) == false)
            return trigger_error('No found parameter "name"');

        return env($params['name']);
    }
