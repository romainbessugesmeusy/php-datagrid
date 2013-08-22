<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rbm
 * Date: 11/04/13
 * Time: 09:08
 * To change this template use File | Settings | File Templates.
 */

namespace RBM\Datagrid\Renderer\Html;

use RBM\Datagrid\Exception;

trait Tag {

    protected $_attrCallbacks = array();

    protected $_classCallbacks = array();

    /**
     * @param $callbackParams
     * @return string
     */
    protected function getAttributes($callbackParams)
    {
        $attr = "";
        foreach ($this->_attrCallbacks as $name => $value) {
            $attr .= " $name=\"";
            $attr .= (is_callable($value)) ? call_user_func_array($value, $callbackParams) : $value;
            $attr .= '"';
        }

        if (count($this->_classCallbacks)) {
            $attr .= ' class="';
            $classes = array();

            foreach ($this->_classCallbacks as $class) {
                $classes[]= is_callable($class) ? call_user_func_array($class, $callbackParams) : $class;
            }
            $attr .= implode(" ", $classes);
            $attr .= '"';
        }
        return $attr;
    }


    /**
     * @param $name
     * @param $valueOrCallback
     * @throws\RBM\Datagrid\Exception
     */
    public function attr($name, $valueOrCallback)
    {
        if ($name === "class") {
            throw new Exception("Use addClass instead");
        }
        $this->_attrCallbacks[$name] = $valueOrCallback;
    }

    /**
     * @param $classNameOrCallback
     */
    public function addClass($classNameOrCallback)
    {
        $this->_classCallbacks[] = $classNameOrCallback;
    }

    /**
     * @param $name
     * @param $valueOrCallback
     */
    public function data($name, $valueOrCallback)
    {
        $this->attr("data-{$name}", $valueOrCallback);
    }
}