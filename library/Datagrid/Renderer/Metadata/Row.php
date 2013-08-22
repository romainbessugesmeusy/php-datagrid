<?php

namespace RBM\Datagrid\Renderer\Metadata;

class Row 
{
    /** @var  int */
    protected $_rowIndex;

    /** @var  int */
    protected $_rowCount;

    /**
     * @param int $rowCount
     */
    public function setRowCount($rowCount)
    {
        $this->_rowCount = $rowCount;
    }

    /**
     * @return int
     */
    public function getRowCount()
    {
        return $this->_rowCount;
    }

    /**
     * @param int $rowIndex
     */
    public function setRowIndex($rowIndex)
    {
        $this->_rowIndex = $rowIndex;
    }

    /**
     * @return int
     */
    public function getRowIndex()
    {
        return $this->_rowIndex;
    }

    /**
     * @return bool
     */
    public function isFirstRow()
    {
        return $this->_rowIndex == 0;
    }

    /**
     * @return bool
     */
    public function isLastRow()
    {
        return $this->_rowIndex == $this->_rowCount - 1;
    }

    /**
     * @return bool
     */
    public function isRowEven()
    {
        return ($this->_rowIndex % 2) != 0;
    }

    /**
     * @return bool
     */
    public function isRowOdd()
    {
        return !$this->isRowEven();
    }
}