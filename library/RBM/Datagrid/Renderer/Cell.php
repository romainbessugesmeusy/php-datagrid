<?php
/**
 *  *
 * @author      Romain Bessuges <romainbessuges@gmail.com>
 * @copyright   2013 Romain
 * @link        https://github.com/romainbessugesmeusy/${PROJECT}
 * @version
 * @package     PROJECT
 *
 * MIT LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace RBM\Datagrid\Renderer;

abstract class Cell
{
    protected $_callbacks = array();

    private $_renderer;

    public function setRenderer(\RBM\Datagrid\Renderer $renderer)
    {
        $this->_renderer = $renderer;
    }

    public function getRenderer()
    {
        return $this->_renderer;
    }


    public function addCallback($accessor)
    {
        $this->_callbacks[] = $accessor;
    }

    /**
     * @param $cell
     * @param $row
     * @param Metadata\Cell $metadata
     */
    public function render($cell, $row,\RBM\Datagrid\Renderer\Metadata\Cell $metadata)
    {
        $this->_onBeforeRender($cell, $row, $metadata);

        foreach ($this->_callbacks as $callback) {
            $cell = call_user_func($callback, $cell, $row, $metadata);
        }

        echo (string) $cell;

        $this->_onAfterRender($cell, $row, $metadata);
    }

    public function _onBeforeRender($cell, $row,\RBM\Datagrid\Renderer\Metadata\Cell $metadata)
    {

    }

    public function _onAfterRender($cell, $row,\RBM\Datagrid\Renderer\Metadata\Cell $metadata)
    {

    }
}