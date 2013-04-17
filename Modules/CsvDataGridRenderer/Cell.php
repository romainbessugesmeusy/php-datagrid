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

namespace CsvDataGridRenderer;

class Cell extends \DataGrid\Renderer\Cell
{

    protected $_enclosingCharacter;

    protected $_escapingCharacter;

    protected $_separatorCharacter;

    public function __construct($enclosingCharacter = '"', $escapingCharacter = "\\", $separatorCharacter = ",")
    {
        $this->_enclosingCharacter = $enclosingCharacter;
        $this->_escapingCharacter  = $escapingCharacter;
        $this->_separatorCharacter = $separatorCharacter;
        $this->addCallback(array($this, "escapeCellContent"));
    }

    public function escapeCellContent($string)
    {
        return str_replace(
            $this->_enclosingCharacter,
            $this->_escapingCharacter . $this->_enclosingCharacter,
            $string
        );
    }

    public function setSeparatorCharacter($separatorCharacter)
    {
        $this->_separatorCharacter = $separatorCharacter;
    }

    public function getSeparatorCharacter()
    {
        return $this->_separatorCharacter;
    }


    public function setEnclosingCharacter($enclosingCharacter)
    {
        $this->_enclosingCharacter = $enclosingCharacter;
    }

    public function getEnclosingCharacter()
    {
        return $this->_enclosingCharacter;
    }

    public function setEscapingCharacter($escapingCharacter)
    {
        $this->_escapingCharacter = $escapingCharacter;
    }

    public function getEscapingCharacter()
    {
        return $this->_escapingCharacter;
    }

    public function _onBeforeRender($cell, $row, \DataGrid\Renderer\Metadata\Cell $metadata)
    {
        echo $this->getEnclosingCharacter();
    }

    public function _onAfterRender($cell, $row, \DataGrid\Renderer\Metadata\Cell $metadata)
    {
        echo $this->getEnclosingCharacter();
        if($metadata->getColumnIndex() < $metadata->getColumnCount() -1){
            echo $this->getSeparatorCharacter();
        }
    }
}
