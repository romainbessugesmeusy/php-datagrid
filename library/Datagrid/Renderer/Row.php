<?php
//TODO Licence

namespace RBM\Datagrid\Renderer;




abstract class Row
{

    /**
     * @var\RBM\Datagrid\DataGrid
     */
    private $_dataGrid;

    /**
     * @var\RBM\Datagrid\Renderer
     */
    private $_renderer;

    /**
     * @param\RBM\Datagrid\DataGrid $dataGrid
     */
    public function setDataGrid(\RBM\Datagrid\DataGrid $dataGrid)
    {
        $this->_dataGrid = $dataGrid;
    }

    /**
     * @param\RBM\Datagrid\Renderer $renderer
     */
    public function setRenderer(\RBM\Datagrid\Renderer $renderer)
    {
        $this->_renderer = $renderer;
    }

    /**
     * @return\RBM\Datagrid\Renderer
     */
    public function getRenderer()
    {
        return $this->_renderer;
    }

    /**
     * @param\RBM\Datagrid\Data\Processor\ResultRow $row
     * @param Metadata\Row $metadata
     */
    public function render(\RBM\Datagrid\Data\Processor\ResultRow $row,\RBM\Datagrid\Renderer\Metadata\Row $metadata)
    {
        $this->_onBeforeRender($row, $metadata);
        $columns     = $this->_dataGrid->getActiveColumnsOrdered();
        $columnIndex = 0;
        $columnCount = count($columns);

        foreach ($columns as $columnName => $column) {
            $cellMetadata = new\RBM\Datagrid\Renderer\Metadata\Cell();
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
     * @param\RBM\Datagrid\Data\Processor\ResultRow $row
     * @param Metadata\Row $metadata
     */
    protected function _onBeforeRender(\RBM\Datagrid\Data\Processor\ResultRow $row,\RBM\Datagrid\Renderer\Metadata\Row $metadata)
    {

    }

    /**
     * @param\RBM\Datagrid\Data\Processor\ResultRow $row
     * @param Metadata\Row $metadata
     */
    protected function _onAfterRender(\RBM\Datagrid\Data\Processor\ResultRow $row,\RBM\Datagrid\Renderer\Metadata\Row $metadata)
    {

    }
}