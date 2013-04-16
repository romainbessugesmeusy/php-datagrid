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

use DataGrid\Column;
use DataGrid\DataGrid;

abstract class AbstractResult
{
    /**
     * @var array
     */
    protected $_data;

    /**
     * @var DataGrid
     */
    protected $_dataGrid;

    /**
     * @param DataGrid $dataGrid
     * @param null $data
     */
    public function __construct(DataGrid $dataGrid, $data = null)
    {
        $this->_dataGrid = $dataGrid;
        $this->_data = $data;
    }

    /**
     * @param $data mixed
     */
    public function setData($data)
    {
        $this->_data = $data;
    }

    /**
     * @return \DataGrid\Data\Processor\ResultRow
     */
    abstract public function fetchRow();

    /**
     * @return void
     */
    abstract public function reset();

    /**
     * @return int
     */
    abstract public function getRowCount();

    /**
     * @return int
     */
    public function getTotalRowCount()
    {
        return $this->_dataGrid->getProcessor()->getTotalRowCount();
    }
}
