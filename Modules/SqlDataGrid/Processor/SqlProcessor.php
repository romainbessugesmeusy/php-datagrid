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

namespace SqlDataGrid\Processor;

use DataGrid\Data\Processor\AbstractProcessor;
use DataGrid\Exception;
use RBM\SqlQuery\OrderBy;
use RBM\SqlQuery\Select;

class SqlProcessor extends AbstractProcessor
{
    /**
     * @var \PDO
     */
    protected $_dbAdapter;

    private $_totalRowCount;

    /**
     * @param \PDO $adapter
     */
    public function __construct(\PDO $adapter)
    {
        parent::__construct();
        $this->_dbAdapter = $adapter;
    }

    /**
     * @return Select
     */
    public function getSelect()
    {
        return $this->getDataGrid()->getDataSource();
    }

    /**
     * @return int
     */
    public function getTotalRowCount()
    {
        if(isset($this->_totalRowCount)) return $this->_totalRowCount;

        $countQuery = $this->getSelect()->count(true);
        if ($result = $this->_dbAdapter->query($countQuery)) {
            $this->_totalRowCount = (int)$result->fetchColumn();
        }
        return $this->_totalRowCount;
    }

    /**
     * @return \DataGrid\Data\Processor\AbstractResult|SqlResult
     * @throws \DataGrid\Exception
     */
    public function getResult()
    {
        /** @var $query Select */
        $query = $this->getSelect();
        if($statement = $this->_dbAdapter->query((string) $query)){
            return new SqlResult($this->getDataGrid(), $statement);
        }

        throw new Exception("could not execute select " . $this->getDataGrid()->getDataSource() . print_r($this->_dbAdapter->errorInfo(), true));
    }

    /**
     * @return void
     */
    protected function _init()
    {

    }

    /**
     * @return void
     */
    protected function _sort()
    {
        foreach ($this->_sortPositions as $columnName) {

            $column = $this->_dataGrid->getColumn($columnName);
            $sort   = $this->getSort($columnName);

            $this->getSelect()->orderBy(
                $column->getSortAccessor(),
                $sort->getDirection() == SORT_ASC ? OrderBy::ASC : OrderBy::DESC
            );
        }
    }

    /**
     * @return void
     */
    protected function _truncate()
    {
        $this->getSelect()->limit($this->_limit->getStart(), $this->_limit->getCount());
    }

}
