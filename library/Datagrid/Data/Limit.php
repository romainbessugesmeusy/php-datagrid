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

namespace RBM\Datagrid\Data;

class Limit
{

    /** @var int */
    protected $_start;

    /**
     * @var int
     */
    protected $_count;

    /**
     * @param int $start
     * @param int $count
     */
    public function __construct($start = 0, $count = null)
    {
        $this->setStart($start);
        if(!is_null($count)){
            $this->setCount($count);
        }
    }

    /**
     * @return bool
     */
    public function isNull()
    {
        return (is_null($this->_start) || $this->_start == 0) && is_null($this->_count);
    }

    /**
     * @param $count
     */
    public function setCount($count)
    {
        $this->_checkArgument($count);
        $this->_count = $count;
    }

    /**
     * @return int|null
     */
    public function getCount()
    {
        return $this->_count;
    }

    /**
     * @param int $start
     */
    public function setStart($start)
    {
        $this->_checkArgument($start);
        $this->_start = $start;
    }

    /**
     * @return int|null
     */
    public function getStart()
    {
        return $this->_start;
    }

    /**
     * @param $arg
     * @throws \OutOfRangeException
     * @throws \InvalidArgumentException
     */
    protected function _checkArgument($arg)
    {
        if(!is_integer($arg)){
            throw new \InvalidArgumentException('Integer expected, got ' . gettype($arg). ' instead');
        }

        if($arg < 0){
            throw new \OutOfRangeException('The value must be greater or equals than 0');
        }
    }

}
