<?php	
include_once '/home/gascomb/secure_html/config/set_variables.php';
include_once PATH_CLASSES_FOLDER.'class.mobile.folio.php';

    if(empty($_POST)){
		$results['return'] = 'false';
		echo json_encode($results);		
	} else {

		$folio_id = $_POST['folio_id'];

		#echo "<pre>"; print_r($inventorydata); echo "</pre>";

		$folio = new FoliosMobiles;		
		#$folio_data = $folio->selectbyId($folio_id);
		#$folio_inventory = $folio_data["inventory_id"];
		$folio_type_capture['type_capture'] = "0";
			
		try {
			
            $rss = $folio->update($folio_id,$folio_type_capture);
			if ($rss){
				$results['return'] = 'true';	
				#echo "id_inventario actualizado en folios, inventory y pdf ok ".  $folio_inventory. "<br />";
				echo json_encode($results);
			} else {
				$results['return'] = 'error-update-end-process';	
				echo json_encode($results);
			}			
			
        } catch (Exception $e) {
			
			$results['return'] = 'error-update-end-process';	
			echo json_encode($results);		
		}			
			

	}
?>