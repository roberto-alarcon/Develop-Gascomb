<?php
	include_once '/home/gascomb/secure_html/config/set_variables.php';
	include_once PATH_CLASSES_FOLDER.'class.checklist.form.php';
    $cheklist_folio = $_GET['cheklist_folio'];
   
    // Instanciamos clase que procesa el formulario    
    $Cheklist_Form = new Checklist_Fom($cheklist_folio,$_POST);
    $Cheklist_Form->insertUpdate();
    

?>