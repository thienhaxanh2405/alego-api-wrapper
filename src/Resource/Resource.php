<?php
namespace AlegoApiWrapper\Resource;

class Resource
{
    private static function underscoreToCamelCase( $string )
    {
        $func = create_function('$c', 'return strtoupper($c[1]);');
        return preg_replace_callback('/_([a-z])/', $func, $string);
    } // end underscore to camel case

    public function updateAttributes($attrHash)
    {
        foreach ($attrHash as $attr => $val)
        {
            $action = "set" . ucfirst($attr);
            if (is_callable(array($this, $action))) {
                $this->$action($val);
            }
        }
    } // update attributes

    public function __construct($resources = null)
    {
        if(is_array($resources))
        {
            $this->updateAttributes($resources);
        }
    } // end construct
} // end class
