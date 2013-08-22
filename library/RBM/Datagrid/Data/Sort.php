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

class Sort
{

    protected static $_allowedDirections = array(SORT_ASC, SORT_DESC);

    protected static $_allowedTypes = array(SORT_NUMERIC, SORT_STRING);

    /**
     * @var int
     */
    protected $_direction;

    /**
     * @var int
     */
    protected $_type;

    /**
     * @param int $direction
     * @param int $type
     */
    public function __construct($direction = SORT_ASC, $type = SORT_NUMERIC)
    {
        $this->setDirection($direction);
        $this->setType($type);
    }

    /**
     * @param $direction
     * @throws \InvalidArgumentException
     */
    public function setDirection($direction)
    {
        if(!in_array($direction, self::$_allowedDirections, true)){
            throw new \InvalidArgumentException("Invalid direction provided, expecting one of [SORT_ASC, SORT_DESC]");
        }

        $this->_direction = $direction;
    }

    /**
     * @return int
     */
    public function getDirection()
    {
        return $this->_direction;
    }

    /**
     * @param $type
     * @throws \InvalidArgumentException
     */
    public function setType($type)
    {
        if(!in_array($type, self::$_allowedTypes, true)){
            throw new \InvalidArgumentException("Invalid type provided, expecting one of [SORT_NUMERIC, SORT_STRING]");
        }

        $this->_type = $type;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->_type;
    }



}
