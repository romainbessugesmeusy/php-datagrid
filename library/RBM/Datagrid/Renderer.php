<?php
/**
 * DataGrid - a utility for building datagrids (no kidding)
 *
 * @author      Romain Bessuges <romainbessuges@gmail.com>
 * @copyright   2013 Romain
 * @link        https://github.com/romainbessugesmeusy/${PROJECT}
 * @version
 * @package     DataGrid
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

namespace RBM\Datagrid;

use RBM\Datagrid\Data\Processor\AbstractResult;
use RBM\Datagrid\Renderer\Cell;

abstract class Renderer
{
    /**
     * @return\RBM\Datagrid\Renderer\Row
     */
    abstract protected function getRowRendererClass();

    /**
     * @return string
     */
    abstract public function getCellRendererClass();

    /**
     * @var Cell[]
     */
    protected $_cellsRenderer = array();

    /**
     * @var Cell
     */
    protected $_defaultCellRenderer;

    /**
     * @var\RBM\Datagrid\DataGrid
     */
    protected $_dataGrid;

    /**
     * @var\RBM\Datagrid\Renderer\Row
     */
    protected $_rowRenderer;

    /**
     * @param DataGrid $dataGrid
     */
    public function setDataGrid(DataGrid $dataGrid)
    {
        $this->_dataGrid = $dataGrid;
    }

    /**
     * @return DataGrid
     */
    public function getDataGrid()
    {
        return $this->_dataGrid;
    }

    /**
     * @return\RBM\Datagrid\Renderer\Row
     * @throws Exception
     */
    public function getRowRenderer()
    {
        if (!isset($this->_rowRenderer)) {

            if (!$this->getRowRendererClass()) {
                throw new\RBM\Datagrid\Exception("The Row Renderer has not been correctly specified");
            }

            $reflection = new \ReflectionClass($this->getRowRendererClass());
            if (!$reflection->isSubclassOf('\\RBM\\DataGrid\\Renderer\\Row')) {
                throw new\RBM\Datagrid\Exception("The Row Renderer must extend \\DataGrid\\Renderer\\Row");
            }

            $this->_rowRenderer = $reflection->newInstance();
            $this->_rowRenderer->setDataGrid($this->_dataGrid);
            $this->_rowRenderer->setRenderer($this);
        }

        return $this->_rowRenderer;
    }


    /**
     * @param $columnName
     * @return Renderer\Cell
     * @throws Exception
     */
    public function getCellRenderer($columnName)
    {
        if (!isset($this->_cellsRenderer[$columnName])) {
            $this->_cellsRenderer[$columnName] = clone $this->getDefaultCellRenderer();
        }

        return $this->_cellsRenderer[$columnName];
    }


    /**
     * @param $columnName
     * @param $cellRendererClass
     * @throws Exception
     */
    public function setCellRendererClass($columnName, $cellRendererClass)
    {
        if (class_exists($cellRendererClass)) {
            $this->_cellsRenderer[$columnName] = $cellRendererClass;
            return;
        }
        throw new Exception("cellRendererClass does not exist");
    }

    /**
     * @return Cell
     * @throws Exception
     */
    public function getDefaultCellRenderer()
    {
        if (!isset($this->_defaultCellRenderer)) {
            $reflection = new \ReflectionClass($this->getCellRendererClass());
            if (!$reflection->isSubclassOf('\\RBM\\DataGrid\\Renderer\\Cell')) {
                throw new\RBM\Datagrid\Exception("The Cell Renderer Class must extend \\DataGrid\\Renderer\\Cell");
            }
            $this->_defaultCellRenderer = $reflection->newInstance();
            $this->_defaultCellRenderer->setRenderer($this);
        }
        return $this->_defaultCellRenderer;
    }


    /**
     * @param bool $return
     * @return bool|string
     */
    public function render($return = false)
    {
        if ($return) ob_start();

        $result = $this->_dataGrid->getProcessor()->process();

        $rowIndex = 0;

        $this->_onBeforeRender($result);

        while ($row = $result->fetchRow()) {
            $metadata = new\RBM\Datagrid\Renderer\Metadata\Row();
            $metadata->setRowIndex($rowIndex);
            $metadata->setRowCount($result->getRowCount());
            $this->getRowRenderer()->render($row, $metadata);
            $rowIndex++;
        }

        $this->_onAfterRender($result);

        if ($return) ob_get_clean();
    }


    protected function _onBeforeRender(AbstractResult $result)
    {

    }


    protected function _onAfterRender(AbstractResult $result)
    {

    }
}