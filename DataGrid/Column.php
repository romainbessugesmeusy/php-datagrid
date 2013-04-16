<?php
/**
 * DataGrid - a utility for building datagrids (no kidding)
 *
 * @author      Romain Bessuges <romainbessuges@gmail.com>
 * @copyright   2013 Romain
 * @link        https://github.com/romainbessugesmeusy/php-datagrid
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

namespace DataGrid;

class Column
{
    protected $_dataGrid;

    protected $_name;

    protected $_cellAccessor;

    protected $_sortAccessor;

    /**
     * @param DataGrid $dataGrid
     * @param string $name
     * @param int $index
     * @param $cellAccessor
     * @param $sortAccessor
     */
    public function __construct(DataGrid $dataGrid, $name, $index, $cellAccessor = null, $sortAccessor = null)
    {
        $this->_dataGrid = $dataGrid;
        $this->_name = $name;

        if (!is_null($cellAccessor)) {
            $this->setCellAccessor($cellAccessor);
        }

        if (!is_null($sortAccessor)) {
            $this->setSortAccessor($sortAccessor);
        }
    }

    /**
     * @param string $context
     * @return \DataGrid\Renderer\Cell
     */
    public function getCellRenderer($context)
    {
        return $this->_dataGrid
            ->getRenderer($context)
            ->getCellRenderer($this->_name);
    }

    public function getSortData($data)
    {
        return \DataGrid\Data\Extractor::extract($data, $this->getSortAccessor());
    }

    /**
     * @return int|bool
     */
    public function getIndex()
    {
        return $this->_dataGrid->getColumnIndex($this->_name);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param $cellAccessor string|callable
     */
    public function setCellAccessor($cellAccessor)
    {
        $this->_cellAccessor = $cellAccessor;
    }

    /**
     * @return string|callable
     */
    public function getCellAccessor()
    {
        return $this->_cellAccessor;
    }

    /**
     * @param $sortAccessor string|callable
     */
    public function setSortAccessor($sortAccessor)
    {
        $this->_sortAccessor = $sortAccessor;
    }

    /**
     * @return mixed
     */
    public function getSortAccessor()
    {
        if (!isset($this->_sortAccessor)) {
            return $this->getCellAccessor();
        }
        return $this->_sortAccessor;
    }
}
