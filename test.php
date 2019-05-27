<?php

require_once 'vendor/autoload.php';

$codeGen = new \harlam\Security\CodeSimpleGenerator();

$cs = new \harlam\Security\CodeFileStorage('/tmp');

//$code = $codeGen->setPrefix('test')->generate();
//
//$code = $cs->create($code);
$code = $cs->find('612907', 'test');

var_dump($code);