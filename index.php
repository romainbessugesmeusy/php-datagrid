<?php

use RBM\Utils\Dsn;

function customAutoLoader($class)
{
    $file = '/' . str_replace('\\', '/', $class) . '.php';
    if(!requireIfExists(__DIR__ . $file)){
        requireIfExists(__DIR__ . '/Modules' . $file);
    }
}

function requireIfExists($filename)
{
    if (file_exists($filename)) {
        require $filename;
        return true;
    }
    return false;
}

spl_autoload_register('customAutoLoader');

require "vendor/autoload.php";

$data = array(
    array("age" => 26, "lastname" => "Bessuges", "forename" => "Romain", "location" => "Bordeaux"),
    array("age" => 30, "lastname" => "Neveu", "forename" => "Amanda", "location" => "Bordeaux"),
    array("age" => 52, "lastname" => "Neveu", "forename" => "Francis", "location" => "Chenay"),
    array("age" => 26, "lastname" => "Thomas", "forename" => 'Laur"ent', "location" => "Montpellier"),
    array("age" => 42, "lastname" => "Potier", "forename" => "François", "location" => "Montpellier"),
);

$dsn = new Dsn(Dsn::SQLITE, array(
    "filename" => __DIR__ . '/tests/Chinook_Sqlite.sqlite'
));


$pdo = new PDO($dsn);

$select = new \RBM\SqlQuery\Select();
$select->setTable("Track");
$select->cols("Name", "Composer");
$select->join("Album", "AlbumId")->cols("Title")->join("Artist", "ArtistId")->cols(array("ArtistName" => "Name"));

\RBM\SqlQuery\Select::setDefaultRenderer(new RBM\SqlQuery\Renderer\MySql());

$dataGrid = new\RBM\Datagrid\DataGrid();
$dataGrid->registerRenderer('html', '\\RBM\HtmlDataGridRenderer\\Renderer');
$dataGrid->registerRenderer('csv', '\\RBM\HtmlDataGridRenderer\\Renderer');

$dataGrid->setDataSource($select, new RBM\SqlDataGrid\Processor\SqlProcessor($pdo));
/*$dataGrid->addColumn("project_id", "project_id")->getCellRenderer("html")->attr('data-id', function($cell){
    return $cell;
});
$dataGrid->addColumn("name", "name");
$dataGrid->addColumn("identifier", "identifier");
$dataGrid->addColumn("owner", "email");
$dataGrid->limit(0, 100);
$dataGrid->getRenderer('html')->getRowRenderer()->addClass(function($data,\RBM\Datagrid\Renderer\Metadata\Row $metadata){
    return $metadata->isRowEven() ? 'even' : 'odd';
});
$dataGrid->setOrderedActiveColumns(array("project_id", "owner", "identifier"));
$dataGrid->getRenderer('csv')->setShowColumnNames(true);
$dataGrid->getRenderer('csv')->render();
*/

$dataGrid->addColumn("Name", "Name");
$dataGrid->addColumn("Composer", "Composer");
$dataGrid->addColumn("Album", "Title");
$dataGrid->addColumn("Artist", "ArtistName");
$dataGrid->sortOn("Composer");
$dataGrid->limit(0, 1000);
$dataGrid->getRenderer('html')->render();

