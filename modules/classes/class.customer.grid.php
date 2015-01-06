<?php

include_once("manejaDB.php");
include_once("class.dependency.php");
Class Grid{

	var $dependency;
	
	function __construct ($dependency = 0){
        $this->dependency = $dependency;
        
    }
	
	public function doGrid(){
	
		$db = new manejaDB();
        $query = "SELECT * FROM folios where dependency_id =".$this->dependency.";";
        $db->query($query);
		
		if( $db->numLineas() != 0 ){
		
            echo "<?xml version='1.0' encoding='ISO-8859-1'?><rows>";
            while( $rows = $db->getArray() ){
                
				$dependency = new dependency;			
				$dependency_data = $dependency->selectbyId($rows["dependency_id"]);
				
                echo "<row id='".$rows["folio_id"]."'>";
				echo "<cell>".$rows["folio_id"]."</cell>";
				echo "<cell>".$rows["registration_plate"]."</cell>";
				echo "<cell>".$rows["entry_date"]."</cell>";
				echo "<cell>".utf8_encode($dependency_data["name"])."</cell>";
				echo "<cell>".$rows["departure_date"]."</cell>";
				echo "<cell>Activo</cell>";				
				echo "<cell>".utf8_encode($rows["failures"])."</cell>";
				echo "</row>";
                    
            }
			echo "</rows>";

        }
		
	
	}

}

?>