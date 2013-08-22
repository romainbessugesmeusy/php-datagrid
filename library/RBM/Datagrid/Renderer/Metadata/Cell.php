<?php

namespace RBM\Datagrid\Renderer\Metadata;

class Cell extends Row
{
    /** @var  int */
    protected $_columnIndex;
    /** @var  int */
    protected $_columnCount;

    /**
     * @param int $columnCount
     */
    public function setColumnCount($columnCount)
    {
        $this->_columnCount = $columnCount;
    }

    /**
     * @return int
     */
    public function getColumnCount()
    {
        return $this->_columnCount;
    }

    /**
     * @param int $columnIndex
     */
    public function setColumnIndex($columnIndex)
    {
        $this->_columnIndex = $columnIndex;
    }

    /**
     * @return int
     */
    public function getColumnIndex()
    {
        return $this->_columnIndex;
    }

    public function isFirstColumn()
    {
        return $this->_columnIndex == 0;
    }

    public function isLastColumn()
    {
        return $this->_columnIndex == $this->_columnCount - 1;
    }

    public function isColumnEven()
    {
        return ($this->_columnIndex % 2) == 0;
    }
}