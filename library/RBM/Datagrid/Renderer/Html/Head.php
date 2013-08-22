<?php

namespace RBM\Datagrid\Renderer\Html;

use RBM\Datagrid\Exception;

class Head
{
    /**
     * @var Renderer
     */
    protected $_renderer;

    /**
     * @var array
     */
    protected $_layout = [];

    /**
     * @param Renderer $renderer
     */
    function __construct(Renderer $renderer)
    {
        $this->_renderer = $renderer;

    }

    /**
     * @return \RBM\Datagrid\Renderer\Html\Renderer
     */
    public function getRenderer()
    {
        return $this->_renderer;
    }

    /**
     * @param $layout
     */
    public function setLayout(array $layout)
    {
        $this->_layout = $layout;
    }

    public function render()
    {
        if (!count($this->_layout)) {
            $this->_buildDefaultLayout();
        }

        $columns = $this->_renderer->getDataGrid()->getActiveColumnNamesOrdered();

        $rows      = [];
        $spans     = [];
        $prev      = [];
        $colIndex  = count($columns) - 1;
        $spanCount = [];

        foreach (array_reverse($columns) as $columnName) {

            // arborescence
            $path     = $this->_getColumn($this->_layout, $columnName, []);
            $rowIndex = 0;

            foreach ($path as $segment) {

                if (!isset($rows[$rowIndex])) $rows[$rowIndex] = [];

                $rows[$rowIndex][$colIndex] = $segment;

                if (isset($prev[$rowIndex]) && $prev[$rowIndex] == $segment) {
                    $spanCount[$rowIndex]++;
                } else {
                    if (!isset($spans[$rowIndex])) $spans[$rowIndex] = [];
                    if (!isset($spanCount[$rowIndex])) $spanCount[$rowIndex] = 1;
                    if ($spanCount[$rowIndex] > 1) $spans[$rowIndex][$colIndex + 1] = $spanCount[$rowIndex];
                    $spanCount[$rowIndex] = 1;
                }

                $prev[$rowIndex] = $segment;

                $rowIndex++;
            }
            $colIndex--;
        }

        foreach($spanCount as $rowIndex => $count){
            if($count > 1) $spans[$rowIndex][$colIndex + 1] = $count;
        }

        echo "<thead>";
        for ($i = 0; $i < count($rows); $i++) {

            $spanCount = 0;

            echo "<tr>";
            for ($j = 0; $j < count($columns); $j++) {

                if (isset($rows[$i][$j])) {

                    if (isset($spans[$i][$j])) {

                        $spanCount = $spans[$i][$j];
                        echo "<th colspan=$spanCount>{$rows[$i][$j]}</th>";
                    } else if ($spanCount == 0) {
                        echo "<th>{$rows[$i][$j]}</th>";
                    }
                } else if ($spanCount == 0) {
                    echo "<th></th>";
                }
                if ($spanCount > 0) $spanCount--;
            }
            echo "</tr>";
        }
        echo "</thead>";
    }

    public function _getColumn($from, $name, $path = [], $results = [])
    {

        foreach ($from as $k => $v) {
            if (is_array($v)) {
                $p2 = $path;
                $p2[] = $k;
                $result = $this->_getColumn($v, $name, $p2);
                if ($result !== false) return $result;
            } else if ($v == $name) {
                $path[] = $k;
                return $path;
            }
        }
        /** si rien de trouvé on retourne simplement le nom de la colonne */
        return false;
    }

    private function _buildDefaultLayout()
    {

        foreach ($this->getRenderer()->getDataGrid()->getActiveColumnNamesOrdered() as $columnName) {
            $this->_layout[$columnName] = $columnName;
        }
    }
}