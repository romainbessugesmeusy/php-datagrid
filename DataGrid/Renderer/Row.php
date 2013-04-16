<?php
//TODO Licence

namespace DataGrid\Renderer;


abstract class Row
{

    /**
     * @var \DataGrid\DataGrid
     */
    private $_dataGrid;

    /**
     * @var \DataGrid\Renderer
     */
    private $_renderer;

    /**
     * @param \DataGrid\DataGrid $dataGrid
     */
    public function setDataGrid(\DataGrid\DataGrid $dataGrid)
    {
        $this->_dataGrid = $dataGrid;
    }

    /**
     * @param \DataGrid\Renderer $renderer
     */
    public function setRenderer(\DataGrid\Renderer $renderer)
    {
        $this->_renderer = $renderer;
    }

    /**
     * @return \DataGrid\Renderer
     */
    public function getRenderer()
    {
       return $this->_renderer;
    }

    /**
     * @param \DataGrid\Data\Processor\ResultRow $row
     * @param $position
     * @param $count
     */
    public function render(\DataGrid\Data\Processor\ResultRow $row, $position, $count)
    {
        $this->_onBeforeRender($row, $position, $count);
        $columns = $this->_dataGrid->getActiveColumnsOrdered();
        $columnIndex = 0;
        $columnCount = count($columns);

        foreach ($columns as $columnName => $column) {
                $cellRenderer = $this->getRenderer()->getCellRenderer($columnName);
                $cellRenderer->render(
                    $row->getCellDataForColumnName($columnName),
                    $row->getData(),
                    $columnIndex,
                    $columnCount,
                    $position,
                    $count
                );
            $columnIndex++;
        }
        $this->_onAfterRender($row, $position, $count);
    }

    /**
     * @param \DataGrid\Data\Processor\ResultRow $row
     */
    protected function _onBeforeRender(\DataGrid\Data\Processor\ResultRow $row, $position, $count)
    {

    }

    /**
     * @param \DataGrid\Data\Processor\ResultRow $row
     */
    protected function _onAfterRender(\DataGrid\Data\Processor\ResultRow $row, $position, $count)
    {

    }
}