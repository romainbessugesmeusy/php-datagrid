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

class Row extends \DataGrid\Renderer\Row
{
    /**
     * @var string
     */
    protected $_rowDelimiter = PHP_EOL;

    /**
     * @return string
     */
    public function getCellRendererClass()
    {
        return 'CsvDataGridRenderer\\Cell';
    }

    public function _onAfterRender(ResultRow $row, $position, $count)
    {
        echo $this->getRowDelimiter();
    }

    /**
     * @param string $rowDelimiter
     */
    public function setRowDelimiter($rowDelimiter)
    {
        $this->_rowDelimiter = $rowDelimiter;
    }

    /**
     * @return string
     */
    public function getRowDelimiter()
    {
        return $this->_rowDelimiter;
    }


}