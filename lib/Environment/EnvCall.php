<?php

    /**
     * Block call function and method static
     */

    namespace Lib\Environment;

    class EnvCall extends EnvBaseAbs
    {

        public function invoke($params, $strDefault = null)
        {
            $callback = $params[0];
            $isFunc   = function_exists($callback);
            $isMethod = false;

            if (($index = strpos($callback, '::')) !== false) {
                $className  = substr($callback, 0, $index);
                $methodName = substr($callback, $index + 2);
                $isMethod   = method_exists($className, $methodName);

                if ($isMethod) {
                    $callback = [
                        $className,
                        $methodName
                    ];
                }
            }

            if ($isFunc == false && $isMethod == false)
                return $strDefault;

            $callParams = array();

            if (count($params) > 1)
                $callParams = array_splice($params, 1);

            return @call_user_func_array($callback, $callParams);
        }

    }
