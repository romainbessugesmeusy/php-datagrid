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

namespace RBM\SqlDataGrid\Processor;

class SqlResult extends\RBM\Datagrid\Data\Processor\AbstractResult
{

    /**
     * @var \PDO
     */
    private static $_adapter;

    /**
     * @param \PDO $adapter
     */
    public static function setDatabaseAdapter(\PDO $adapter)
    {
        self::$_adapter = $adapter;
    }

    /**
     * @return\RBM\Datagrid\Data\Processor\ResultRow
     */
    public function fetchRow()
    {
        if($data = $this->_getStatement()->fetch(\PDO::FETCH_ASSOC)){
            return new\RBM\Datagrid\Data\Processor\ResultRow($this->_dataGrid, $data);
        }
        return false;
    }

    /**
     * @return void
     */
    public function reset()
    {
        $this->_getStatement()->closeCursor();
    }

    /**
     * @return int
     */
    public function getRowCount()
    {
        return $this->_getStatement()->rowCount();
    }

    /**
     * @return \PDOStatement
     */
    private function _getStatement()
    {
        return $this->_data;
    }
}
