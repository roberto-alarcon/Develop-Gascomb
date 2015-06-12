<?php

include_once 'class.quote.config.php';
include_once MODULES_CLASES_QUOTE.'class.quote.process.php';
$formAction = new Quote_Process();
$formAction->insertFormStep2();

?>