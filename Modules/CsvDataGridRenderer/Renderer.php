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

use DataGrid\Data\Processor\ResultRow;

class Renderer extends \DataGrid\Renderer
{
    protected $_showColumnNames = false;

    /**
     * @param string $_rowDelemiter
     */
    function __construct($_rowDelemiter = PHP_EOL)
    {
        $this->_rowDelemiter = $_rowDelemiter;
    }


    /**
     * @param $showColumnNames
     */
    public function setShowColumnNames($showColumnNames)
    {
        $this->_showColumnNames = $showColumnNames;
    }

    /**
     * @return bool
     */
    public function getShowColumnNames()
    {
        return $this->_showColumnNames;
    }

    /**
     * @return \DataGrid\Renderer\Row
     */
    protected function getRowRendererClass()
    {
        return '\\CsvDataGridRenderer\\Row';
    }

    /**
     * @return \DataGrid\Renderer\Row
     */
    public function getCellRendererClass()
    {
        return '\\CsvDataGridRenderer\\Cell';
    }

    /**
     * @param \DataGrid\Data\Processor\AbstractResult $result
     */
    protected function _onBeforeRender(\DataGrid\Data\Processor\AbstractResult $result)
    {
        if($this->getShowColumnNames()){
            $cols = $this->_dataGrid->getActiveColumnsOrdered();
            /** @var $renderer Cell */
            $renderer = $this->getDefaultCellRenderer();
            $i = 0; $nbCols = count($cols);
            foreach($cols as $col){
                echo $renderer->getEnclosingCharacter();
                echo $renderer->escapeCellContent($col->getName());
                echo $renderer->getEnclosingCharacter();
                if($i < $nbCols - 1)
                    echo $renderer->getSeparatorCharacter();
                $i++;
            }
            /** @var $rowRenderer Row */
            $rowRenderer = $this->getRowRenderer();
            echo $rowRenderer->getRowDelimiter();
        }
    }
}
