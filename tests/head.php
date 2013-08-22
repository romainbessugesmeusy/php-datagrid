<?php

require "../vendor/autoload.php";

header("Content-Type: text/html;charset=UTF-8");

$layout = [
    "Utilisateur" => [
        "Prénom"       => "prenom",
        "Nom"          => "nom",
        "Âge"          => "age",
        "Localisation" => [
            "Ville" => [
                "Ville" => "ville",
                "<input type='search' name='ville'>" => "ville",
            ],
            "Pays"  => "pays",
        ],
    ],
    "Droits"      => [
        "Page" => [
            "Édition"     => "page_edit",
            "Suppression" => "page_delete",
        ],
        "News" => [
            "Édition"     => "news_edit",
            "Suppression" => "news_delete",
        ],
    ]
];


$source = [
    [
        "prenom" => "Romain",
        "nom"    => "Bessuges",
        "age"    => 26,
        "ville"  => "Montpellier",
        "pays"   => "France",
        "page_edit"   => "1",
        "page_delete" => "0",
        "news_edit"   => "1",
        "news_delete" => "1",
    ],
    [
        "prenom" => "Delphine",
        "nom"    => "Dorseuil",
        "age"    => 30,
        "ville"  => "Montpellier",
        "pays"   => "France",
        "page_edit"   => "1",
        "page_delete" => "1",
        "news_edit"   => "0",
        "news_delete" => "0",
    ],
];

$dg = new \RBM\Datagrid\DataGrid();

$dg->setDataSource($source, new\RBM\Datagrid\Data\Processor\ArrayProcessor());
$dg->addColumn("prenom", "prenom");
$dg->addColumn("nom", "nom");
$dg->addColumn("age", "age");

$dg->addColumn("ville", "ville");
$dg->addColumn("pays", "pays");
$dg->addColumn("news_edit", "news_edit");
$dg->addColumn("news_delete", "news_delete");
$dg->addColumn("page_edit", "page_edit");
$dg->addColumn("page_delete", "page_delete");

$dg->registerRenderer("html", '\RBM\Datagrid\Renderer\Html\Renderer');
/** @var RBM\Datagrid\Renderer\Html\Renderer $r */
$r = $dg->getRenderer('html');

$head = new \RBM\Datagrid\Renderer\Html\Head($r);

$r->head()->setLayout($layout);

echo $r->render();

