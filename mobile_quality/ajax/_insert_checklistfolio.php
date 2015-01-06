<?php
    header('Content-Type: text/html; charset=iso-8859-1');
    include_once '/home/gascomb/secure_html/config/set_variables.php';
	include_once PATH_CLASSES_FOLDER.'class.checklist.php';
	    
     $CheckList = new Checklist('204');
     $CheckList->insertChecklistItem(7);
    
    echo 'Hola Mundo';
?>