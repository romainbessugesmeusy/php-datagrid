<?php
/**
 * DataGrid - a utility for building datagrids (no kidding)
 *
 * @author    Romain Bessuges <romainbessuges@gmail.com>
 * @copyright   2013 Romain
 * @link        https://github.com/romainbessugesmeusy/${PROJECT}
 * @version     0.0.1
 * @package     ${PROJECT}
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

class DataGrid
{

    protected static $_processorClass = '\\DataGrid\\Data\\Processor';

    /**
     * @var mixed
     */
    protected $_dataSource;

    /**
     * @var \DataGrid\Data\Processor\AbstractProcessor
     */
    protected $_processor;

    /**
     * @var array
     */
    protected $_renderers = array();

    /**
     * @var \DataGrid\Renderer[]
     */
    protected $_instanciatedRenderers = array();

    /**
     * @var \DataGrid\Column[]
     */
    protected $_columns = array();

    /**
     * @var array
     */
    protected $_columnsPositions = array();

    /**
     * @var \DataGrid\Data\Processor\AbstractProcessor
     */
    public function getProcessor()
    {
        return $this->_processor;
    }


    /**************************************************************************
     *  Columns Management
     *************************************************************************/

    /**
     * Ajoute une colonne au tableau. Crée un objet de type \DataGrid\Column et le retourne.
     * La colonne est par défaut visible.
     * @assert (null, null) throws InvalidArgumentException
     * @param $name
     * @param $accessor
     * @return \DataGrid\Column
     */
    public function addColumn($name, $accessor = null)
    {
        $col = new \DataGrid\Column($this, $name, count($this->_columns), $accessor);
        $this->_columns[$name] = $col;
        $this->_columnsPositions[] = $name;
        return $col;
    }

    /**
     * Récupère un \DataGrid\Column en fonction de sa position
     * @assert (null) throws InvalidArgumentException
     * @assert (true) throws InvalidArgumentException
     * @assert (-1) throws OutOfRangeException
     * @param $columnName
     * @return \DataGrid\Column|null
     */
    public function getColumn($columnName)
    {
        return isset($this->_columns[$columnName]) ? $this->_columns[$columnName] : null;
    }

    /**
     * @param $columnName
     * @return mixed
     */
    public function getColumnIndex($columnName)
    {
        return array_search($columnName, $this->_columnsPositions);
    }

    /**
     *
     * @return \DataGrid\Column[]
     */
    public function getColumns()
    {
        return $this->_columns;
    }

    /**
     * @param $columnNames
     * @throws Exception
     */
    public function setOrderedActiveColumns($columnNames)
    {
        foreach($columnNames as $columnName){
            if(!isset($this->_columns[$columnName])){
                throw new Exception("Invalid column specified : $columnName");
            }
        }
        $this->_columnsPositions = $columnNames;
    }

    /**
     * @return Column[]
     */
    public function getActiveColumnsOrdered()
    {
        $columns = array();
        foreach ($this->_columnsPositions as $columnName) {
            $columns[$columnName] = & $this->_columns[$columnName];
        }
        return $columns;
    }

    /**
     * @return string[]
     */
    public function getActiveColumnNamesOrdered()
    {
        return $this->_columnsPositions;
    }

    /**
     * @param $columnName
     * @return bool
     */
    public function isColumnActive($columnName)
    {
        return in_array($columnName, $this->_columnsPositions);
    }

    /**************************************************************************
     *  Renderers Management
     *************************************************************************/


    /**
     *
     * @assert (null) throws InvalidArgumentException
     * @assert ("") throws InvalidArgumentException
     * @param string $context
     * @param $rendererClassname
     * @internal param string $renderer
     */
    public function registerRenderer($context, $rendererClassname)
    {
        $this->_renderers[$context] = $rendererClassname;
    }

    /**
     * @assert (null) throws InvalidArgumentException
     * @assert ("") throws InvalidArgumentException
     * @param $context
     * @throws \OutOfRangeException
     * @throws \InvalidArgumentException
     * @throws \DataGrid\Exception
     * @return \DataGrid\Renderer
     */
    public function getRenderer($context)
    {
        if (!is_string($context)) {
            $message = 'String expected, got %s instead';
            throw new \InvalidArgumentException(sprintf($message, gettype($context)));
        }

        if (!isset($this->_renderers[$context])) {
            $message = 'No renderer defined for the requested context [{%s}]';
            throw new \OutOfRangeException(sprintf($message, $context));
        }

        if (isset($this->_instanciatedRenderers[$context])) {
            return $this->_instanciatedRenderers[$context];
        }

        $class = $this->_renderers[$context];

        $reflection = new \ReflectionClass($class);

        if (!$reflection->isSubclassOf('\\DataGrid\\Renderer')) {
            $message = 'The specified renderer "%s" does not extend \\DataGrid\\Renderer';
            throw new \DataGrid\Exception(sprintf($message, $class));
        }

        $renderer = $reflection->newInstance();
        $renderer->setDataGrid($this);

        $this->_instanciatedRenderers[$context] = $renderer;

        return $renderer;
    }


    /**************************************************************************
     *  DataSource Management
     *************************************************************************/

    /**
     * @param mixed $dataSource
     * @param Data\Processor\AbstractProcessor $processor
     */
    public function setDataSource($dataSource, \DataGrid\Data\Processor\AbstractProcessor $processor)
    {
        $this->_dataSource = $dataSource;
        $this->_processor = $processor;
        $this->_processor->setDataGrid($this);
    }

    /**
     * @return mixed
     */
    public function getDataSource()
    {
        return $this->_dataSource;
    }

    /**************************************************************************
     *  Processor Shorthands
     *************************************************************************/

    /**
     * @param int $start
     * @param null $count
     * @return DataGrid
     */
    public function limit($start, $count = null)
    {
        $this->getProcessor()->setLimit(new \DataGrid\Data\Limit($start, $count));

        return $this;
    }

    /**
     * @param $columnName
     * @param int $direction
     * @param int $type
     * @return DataGrid
     */
    public function sortOn($columnName, $direction = SORT_ASC, $type = SORT_NUMERIC)
    {
        $this->getProcessor()->setSort(
            $this->getProcessor()->getSortsCount(),
            $columnName,
            new \DataGrid\Data\Sort($direction, $type)
        );

        return $this;
    }

}
