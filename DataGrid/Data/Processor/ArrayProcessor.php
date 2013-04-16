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

class ArrayProcessor extends \DataGrid\Data\Processor\AbstractProcessor
{

    protected $_input;

    protected $_output;

    /**
     * @return string
     */
    public function getResult()
    {
        if (!$this->_processed) $this->process();
        return new ArrayResult($this->getDataGrid(), $this->_output);
    }

    /**
     * @return int
     */
    public function getTotalRowCount()
    {
        if (!$this->_processed) $this->process();

        return count($this->_input);
    }

    /**
     *
     */
    protected function _init()
    {
        $this->_input  = $this->_dataGrid->getDataSource();
        $this->_output = $this->_input;
    }

    /**
     * Performs an array_multisort, based on the sorts defined
     */
    protected function _sort()
    {
        if (!isset($this->_sorts) || count($this->_sorts) === 0) {
            return;
        }

        $columns      = $this->_dataGrid->getActiveColumnsOrdered();
        $sorts        = $this->_sorts;
        $sortPosition = $this->_sortPositions;

        usort($this->_output, function ($a, $b) use ($columns, $sortPosition, $sorts) {
            foreach ($sortPosition as $colIndex) {
                $sort = $sorts[$colIndex];
                /** @var $sort \DataGrid\Data\Sort */
                /** @var $column \DataGrid\Column */
                $column = $columns[$colIndex];
                $valueA = $column->getSortData($a);
                $valueB = $column->getSortData($b);

                if ($valueA == $valueB) {
                    continue;
                }

                $arr = array($valueA, $valueB);

                $args = array_merge(array(&$arr), array($sort->getDirection(), $sort->getType()));
                call_user_func_array('array_multisort', $args);

                return ($arr[0] == $valueA) ? -1 : 1;
            }
            return 0;
        });
    }

    /**
     * Simply splice the array
     */
    protected function _truncate()
    {
        if (!$this->getLimit()->isNull()) {
            if (is_null($this->getLimit()->getCount())) {
                $this->_output = array_splice($this->_output, $this->getLimit()->getStart());
            } else {
                $this->_output = array_splice($this->_output, $this->getLimit()->getStart(), $this->getLimit()->getCount());
            }
        }
    }
}