<?php

    /*
     * Smarty plugin
     * -------------------------------------------------------------
     * File:     function.lng.php
     * Type:     function
     * Name:     lng
     * Purpose:  get value language
     * -------------------------------------------------------------
     */

    function smarty_function_lng($params, Smarty_Internal_Template $template)
    {
        if (isset($params['name']) == false)
            return trigger_error('No found parameter "name"');

        return lng($params['name']);
    }
