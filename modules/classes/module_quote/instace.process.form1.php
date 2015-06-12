<?php

include_once 'class.quote.config.php';
include_once MODULES_CLASES_QUOTE.'class.quote.process.php';
$formAction = new Quote_Process();

// LLamamos metodo para subir imagenes del formulario
// en la version 1 esta desactivado ya que despues de 20 FILE no permite realizar el POST
if(isset($_POST['imageControl'])){
	$formAction->uploadImage();
}

// Insertamos  $_POST dentro de la BD Elementos
$formAction->insertFormStep1();




?>