<?php

print_r($_POST);
include_once 'class.quote.process.php';

$formAction = new Quote_Process();
// Subimos las imagenes
$formAction->uploadImage();
// Insertamos a la BD Elementos
$formAction->insertFormStep1();




?>