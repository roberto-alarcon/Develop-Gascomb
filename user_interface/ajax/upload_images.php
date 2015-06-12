<?php
ini_set('display_errors', '1');
include_once('/home/gascomb/secure_html/config/set_variables.php');	
include_once PATH_CLASSES_FOLDER.'class.image.php';
//include_once '../../config/set_variables.php';

if(!empty($_FILES)){	
	//print_r($_FILES);
	function reArrayFiles(&$file_post) {

		$file_ary = array();
		$file_count = count($file_post['name']);
		$file_keys = array_keys($file_post);

		for ($i=0; $i<$file_count; $i++) {
			foreach ($file_keys as $key) {
				$file_ary[$i][$key] = $file_post[$key][$i];
			}
		}

		return $file_ary;
	}
	//$_POST["inventory_id"] = "26";
	if(isset($_REQUEST["folio_id"]) && $_REQUEST["folio_id"] !== ''){
	
		//$file_ary = reArrayFiles($_FILES["file"]);
		$name = $_FILES["file"]["name"];
		$tmp_name = $_FILES["file"]["tmp_name"];
		$size = $_FILES["file"]["size"];

			if($name !== ''){
				$folio_id = $_REQUEST["folio_id"];//"30";//$Inventory["inventory_id"];			
				$directory = PATH_MULTIMEDIA_BASE."/".$folio_id."/images/";			
				//echo $directory; exit(0);
				$image = new Image;	
				$image_up["image_name"] = $name;
				$image_up["tmp_name"] = $tmp_name;
				$image_up["size"] = $size;			
				$image = $image->imageUpload($image_up,$directory);
				$datatobd[] = $name;
			}
		
		if(!empty($datatobd)){
			//print_r($datatobd);
			echo "{state: true, name:'$name'}";
		}else{
			echo "0";
		}
	}else{
		echo "favor de enviar el id de inventario";
	}

}else{
	echo "0";
}
?>