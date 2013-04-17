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

$dsn = new Dsn(Dsn::MYSQL, array(
    "dbname" => "kloook",
    "host" => "localhost",
    "port" => "3306"
));


$pdo = new PDO($dsn, "root", "");
$select = new \RBM\SqlQuery\Select("project");
$pu = $select->join("project_user", "project_id");
$pu->setJoinType(\RBM\SqlQuery\Select::JOIN_LEFT);
$pu->joinCondition()->eq("project_role_id", 1);
$u = $pu->join("user", "user_id");
$u->setJoinType(\RBM\SqlQuery\Select::JOIN_LEFT);
$u->cols("email");

\RBM\SqlQuery\Select::setDefaultRenderer(new RBM\SqlQuery\Renderer\MySql());

$dataGrid = new \DataGrid\DataGrid();
$dataGrid->registerRenderer('html', '\\HtmlDataGridRenderer\\Renderer');
$dataGrid->registerRenderer('csv', '\\CsvDataGridRenderer\\Renderer');

$dataGrid->setDataSource($select, new SqlDataGrid\Processor\SqlProcessor($pdo));
$dataGrid->addColumn("project_id", "project_id")->getCellRenderer("html")->attr('data-id', function($cell){
    return $cell;
});
$dataGrid->addColumn("name", "name");
$dataGrid->addColumn("identifier", "identifier");
$dataGrid->addColumn("owner", "email");
$dataGrid->limit(0, 100);
$dataGrid->getRenderer('html')->getRowRenderer()->addClass(function($data, \DataGrid\Renderer\Metadata\Row $metadata){
    return $metadata->isRowEven() ? 'even' : 'odd';
});
$dataGrid->setOrderedActiveColumns(array("project_id", "owner", "identifier"));
$dataGrid->getRenderer('csv')->setShowColumnNames(true);
$dataGrid->getRenderer('csv')->render();

