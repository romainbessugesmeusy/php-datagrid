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

namespace RBM\Datagrid\Renderer\Html;

use RBM\Datagrid\Data\Processor\AbstractResult;

class Renderer extends\RBM\Datagrid\Renderer
{
    /** @var  Head */
    protected $_head;

    /** @var  Foot */
    protected $_foot;

    /**
     * @return\RBM\Datagrid\Renderer\Row
     */
    protected function getRowRendererClass()
    {
        return '\\RBM\\DataGrid\\Renderer\\Html\\Row';
    }

    protected function _onBeforeRender(AbstractResult $result)
    {
        // todo should'nt the renderer only produce the inner tbody ?
        echo "<table>";
        $this->head()->render();
        echo "<tbody>";
    }

    protected function _onAfterRender(AbstractResult $result)
    {
        echo "</tbody></table>";
        echo "<p>";
        echo $result->getRowCount();
        echo " / ";
        echo $result->getTotalRowCount();
        echo "</p>";
    }

    /**
     * @return string
     */
    public function getCellRendererClass()
    {
        return "\\RBM\\DataGrid\\Renderer\\Html\\Cell";
    }

    public function head()
    {
        if(!isset($this->_head)) $this->_head = new Head($this);
        return $this->_head;
    }

    public function foot()
    {
        if(!isset($this->_foot)) $this->_foot = new Foot($this);
        return $this->_foot;
    }
}
