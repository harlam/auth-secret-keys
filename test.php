<?php

require_once 'vendor/autoload.php';

var_dump(microtime(true));
exit;

//$codeGen = new \harlam\Security\CodeSimpleGenerator();

$cs = new \harlam\Security\CodeFileStorage('/tmp');

//$validator = new \harlam\Security\CodeValidator(3, 30000);

//$code = $codeGen->setPrefix('test')->generate();
//
//$code = $cs->create($code);

$code = $cs->find('612907', 'test');

var_dump($cs->getLast('test'));

//var_dump($code);
//var_dump($validator->validate($code));