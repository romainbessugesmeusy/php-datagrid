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
     * @param Metadata\Row $metadata
     */
    public function render(\DataGrid\Data\Processor\ResultRow $row, \DataGrid\Renderer\Metadata\Row $metadata)
    {
        $this->_onBeforeRender($row, $metadata);
        $columns     = $this->_dataGrid->getActiveColumnsOrdered();
        $columnIndex = 0;
        $columnCount = count($columns);

        foreach ($columns as $columnName => $column) {
            $cellMetadata = new \DataGrid\Renderer\Metadata\Cell();
            $cellMetadata->setRowCount($metadata->getRowCount());
            $cellMetadata->setRowIndex($metadata->getRowIndex());
            $cellMetadata->setColumnIndex($columnIndex);
            $cellMetadata->setColumnCount($columnCount);
            $cellRenderer = $this->getRenderer()->getCellRenderer($columnName);

            $cellRenderer->render(
                $row->getCellDataForColumnName($columnName),
                $row->getData(),
                $cellMetadata
            );

            $columnIndex++;
        }
        $this->_onAfterRender($row, $metadata);
    }

    /**
     * @param \DataGrid\Data\Processor\ResultRow $row
     * @param Metadata\Row $metadata
     */
    protected function _onBeforeRender(\DataGrid\Data\Processor\ResultRow $row, \DataGrid\Renderer\Metadata\Row $metadata)
    {

    }

    /**
     * @param \DataGrid\Data\Processor\ResultRow $row
     * @param Metadata\Row $metadata
     */
    protected function _onAfterRender(\DataGrid\Data\Processor\ResultRow $row, \DataGrid\Renderer\Metadata\Row $metadata)
    {

    }
}