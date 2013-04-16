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

namespace DataGrid\Data\Processor;

use DataGrid\Data\Limit;

abstract class AbstractProcessor
{
    /**
     * @var \DataGrid\DataGrid
     */
    protected $_dataGrid;

    /**
     * @var \DataGrid\Data\Limit
     */
    protected $_limit;

    /**
     * @var \DataGrid\Data\Sort[]
     */
    protected $_sorts = array();

    /**
     * @var array
     */
    protected $_sortPositions = array();

    /**
     * @var bool
     */
    protected $_processed = false;

    /**
     * @return int
     */
    abstract public function getTotalRowCount();

    /**
     * @return \DataGrid\Data\Processor\AbstractResult
     */
    abstract public function getResult();

    /**
     * @return void
     */
    abstract protected function _init();

    /**
     * @return void
     */
    abstract protected function _sort();

    /**
     * @return void
     */
    abstract protected function _truncate();


    public function __construct()
    {
    }
    /**
     * @return AbstractResult
     * @throws \DataGrid\Exception
     */
    public function process()
    {
        if(!isset($this->_limit)){
            $this->_limit = new Limit();
        }

        if(!isset($this->_dataGrid)){
            throw new \DataGrid\Exception("Processor's DataGrid has not been set");
        }

        $this->_init();
        // todo filter ?
        // todo group ?
        $this->_sort();
        $this->_truncate();
        $this->_processed = true;
        return $this->getResult();
    }

    /**
     * @param \DataGrid\DataGrid $dataGrid
     */
    public function setDataGrid(\DataGrid\DataGrid $dataGrid)
    {
        $this->_dataGrid = $dataGrid;
    }

    /**
     * @return \DataGrid\DataGrid
     */
    public function getDataGrid()
    {
        return $this->_dataGrid;
    }

    /**
     * @param \DataGrid\Data\Limit $limit
     */
    public function setLimit(\DataGrid\Data\Limit $limit)
    {
        $this->_limit = $limit;
    }

    /**
     * @return \DataGrid\Data\Limit
     */
    public function getLimit()
    {
        return $this->_limit;
    }

    /**
     *
     */
    public function removeLimit()
    {
        $this->_limit = new \DataGrid\Data\Limit();
    }

    /**
     * @param $position
     * @param $columnName
     * @param \DataGrid\Data\Sort $sort
     */
    public function setSort($position, $columnName, \DataGrid\Data\Sort $sort)
    {
        $this->_sorts[$columnName] = $sort;
        $this->_sortPositions[$position] = $columnName;
    }

    /**
     * @param $columnName
     * @return \DataGrid\Data\Sort
     */
    public function getSort($columnName)
    {
        if (isset($this->_sorts[$columnName])) {
            return $this->_sorts[$columnName];
        }
        return null;
    }

    /**
     * @return int|void
     */
    public function getSortsCount()
    {
        return count($this->_sorts);
    }

    /**
     * @param $columnName
     */
    public function removeSort($columnName)
    {
        unset($this->_sorts[$columnName]);
    }

}
