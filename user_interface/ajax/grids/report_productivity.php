<?php
ini_set('display_errors', '1');
include_once('/home/gascomb/secure_html/config/set_variables.php');
require_once '../grid-excel-php/lib/PHPExcel.php';
require_once '../grid-excel-php/lib/PHPExcel/IOFactory.php';	
include_once PATH_CLASSES_FOLDER.'class.folio.php';
include_once PATH_CLASSES_FOLDER.'class.dependency.php';
include_once PATH_CLASSES_FOLDER.'class.stock.php';
include_once PATH_CLASSES_FOLDER.'class.activities.php';
include_once PATH_CLASSES_FOLDER.'class.vehicles.php';
include_once PATH_CLASSES_FOLDER.'class.tracing.php';
//Estilos
$headee = array(
    'font' => array(
        'name' => 'Helvetica',
        'size' => 9,
        'bold' => true,
        'color' => array(
            'rgb' => '000000'
        ),
    ),
    'borders' => array(
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array(
                'rgb' => '000000'
            )
        )
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
            'rgb' => 'D1E5FE',
        ),
    ),
);

$stylecells = array(
    'font' => array(
        'name' => 'Helvetica',
        'size' => 9,
        'bold' => false,
        'color' => array(
            'rgb' => '000000'
        ),
    ),
    'borders' => array(
             'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => 'A4BED4'),
             ),
    )
    
);


//echo "Generando reporte, espere por favor...";

$Stock = new Stock;

$folio = new Folio;
$vehicles = new Vehicle;
$db = new manejaDB();


$db->query("select folio_id,dependency_id,area_sector,vehicles_record_id,mechanic_assigned,registration_plate,entry_date,tower from folios where support_status_id != '8' and support_status_id != '9'  order by folio_id DESC");
//$db->query("select * from folios ".$datos_where." order by folio_id DESC limit 500");
$folios = $db->getArrayAsoc();						
$db->desconectar();


if($folios or $folios != 0){

$objPHPExcel = new PHPExcel();
$F=$objPHPExcel->getActiveSheet();
$Line=2;
//Estilos
$F->getStyle('A1:L1')->applyFromArray($headee);
//Centrado
$F->getStyle('A1:L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//Ancho de columna
$F->getColumnDimension('A')->setWidth(30);
$F->getColumnDimension('B')->setWidth(20);
$F->getColumnDimension('C')->setWidth(10);
$F->getColumnDimension('D')->setWidth(20);
$F->getColumnDimension('E')->setWidth(20);
$F->getColumnDimension('F')->setWidth(20);
$F->getColumnDimension('G')->setWidth(20);
$F->getColumnDimension('H')->setWidth(40);
$F->getColumnDimension('I')->setWidth(30);
$F->getColumnDimension('J')->setWidth(30);
$F->getColumnDimension('K')->setWidth(10);
$F->getColumnDimension('L')->setWidth(10);
//Titulos
$F->setCellValue('A1', "Dependencia")
                    ->setCellValue('B1', "Area")
                    ->setCellValue('C1', "Folio")
                    ->setCellValue('D1', "Marca")
                    ->setCellValue('E1', "Tipo")
                    ->setCellValue('F1', "Placas")
                    ->setCellValue('G1', "Entrada")
                    ->setCellValue('H1', "Reparación")
                    ->setCellValue('I1', "Mecanico")
                    ->setCellValue('J1', "Seguimiento")
                    ->setCellValue('K1', "Fecha de asignación")
                    ->setCellValue('L1', "Torre");
             
//print_r($folios); exit(0);

    foreach ($folios as $clave => $valor) {
    		$dependency = new dependency;			
    		$dependency_data = $dependency->selectbyId($valor["dependency_id"]);	
    		$Stockid = $Stock->selectbyFolioId($valor["folio_id"]);
    		
    		$vehicle = $vehicles->selectbyId($valor["vehicles_record_id"]);	
    		$brand = $vehicles->getBrandd($vehicle["support_brand_vehicular_id"]);		
    		$model = $vehicles->getModel($vehicle["support_models_vehicular_id"]);
    		$users = new Users;
    	
    		//Mecanicos asignados
    		$db = new manejaDB();
    			//Sacar mecanicos que tienen asignada alguna tarea en proceso
    		$db->query("
    			SELECT group_concat(DISTINCT CONCAT(employees.name,' ' ,employees.last_name) separator ', ') as mecanicos
    			FROM floor_activities
    			left join employees
    			on employees.employee_id = floor_activities.employee_id
    			where floor_activities.folio_id = '".$valor["folio_id"]."' group by floor_activities.folio_id;
    		");//and floor_activities.status = 1
    		$mecanicos = $db->getArrayAsoc();						
    		$db->desconectar();
    		if($mecanicos and ISSET($mecanicos[0]["mecanicos"])){
    			$jefemecanicos = $mecanicos[0]["mecanicos"];
    		}else{
    			$jefemecanicos ="";
    		}
    		
    		
    		$activity = new FloorActivity;
    		if($activity->getstart_date($valor["folio_id"])){
    				$date = explode(",",$activity->getstart_date($valor["folio_id"]));				
    				$date["1"] = ($date["1"])-1;
    				list($año, $mes, $dia) = $date;
    				$mes = ($mes< 10)? "0".$mes : $mes;
    				$date = $dia."/".$mes."/".$año;
    				//$date = implode("/",$date);
    		}else{
    			$date = "";
    		}
    		$Tracing = new Tracing;
    		$seguimiento = array();
    		$mensajes = $Tracing->getTracings($valor["folio_id"]);
    					if($mensajes){foreach($mensajes as $rows){
    								$seguimiento[] = utf8_encode($rows['comments']);								
    							}
    					}
    		
    		$seguimiento = implode(" , ",$seguimiento);
    		$f_activity = new FloorActivity; 
    		$folioidd["folio_id"] = $valor["folio_id"];
    		$activities = $f_activity->selectbyColumn($folioidd, 30);
                
                $acts = array();
    			if($activities){
    				foreach($activities as $value){
    					if($value["description"] !== ""){
    						$acts[] = $value["description"];										
    					}
    				}								
    			}else{
    				$acts[] = "";
    			}
            
    			
    			// Depedencia, area, folio, marca, tipo, placas, fecha de entrada, actividades, mecanico,seguimiento,fechadeasignacion,torre
                $F->getStyle('A'.$Line.':L'.$Line)->applyFromArray($stylecells);
                $F->getRowDimension(1)->setRowHeight(-1);
                //$F->setCellValue('A'.$Line,$valor["folio_id"])
	           $F->setCellValue('A'.$Line, utf8_encode($dependency_data["name"]))
                  ->setCellValue('B'.$Line, utf8_encode($valor["area_sector"]))
                  ->setCellValue('C'.$Line, utf8_encode($valor["folio_id"]))
                  ->setCellValue('D'.$Line, utf8_encode($brand))
                  ->setCellValue('E'.$Line, utf8_encode($model))
                  ->setCellValue('F'.$Line, utf8_encode($valor["registration_plate"]))
                  ->setCellValue('G'.$Line, utf8_encode($valor["entry_date"]))
                  ->setCellValue('H'.$Line, utf8_encode(implode(',',$acts)))
                  ->setCellValue('I'.$Line, utf8_encode($jefemecanicos))
                  ->setCellValue('J'.$Line, $seguimiento)
                  ->setCellValue('K'.$Line, $date)
                  ->setCellValue('L'.$Line, $valor["tower"]);
                 ++$Line;
    }
}

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="reporte_de_productividad.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

exit;




/*
include_once('/home/gascomb/secure_html/config/set_variables.php');	
include_once PATH_CLASSES_FOLDER.'class.folio.php';
include_once PATH_CLASSES_FOLDER.'class.dependency.php';
include_once PATH_CLASSES_FOLDER.'class.stock.php';
include_once PATH_CLASSES_FOLDER.'class.activities.php';
include_once PATH_CLASSES_FOLDER.'class.vehicles.php';
include_once PATH_CLASSES_FOLDER.'class.tracing.php';
$Stock = new Stock;
$folio = new Folio;
$vehicles = new Vehicle;



$db = new manejaDB();
$db->query("select folio_id,dependency_id,area_sector,vehicles_record_id,mechanic_assigned,registration_plate,entry_date,tower from folios where support_status_id != '8' and support_status_id != '9'  order by folio_id DESC");
//$db->query("select * from folios ".$datos_where." order by folio_id DESC limit 500");
$folios = $db->getArrayAsoc();						
$db->desconectar();

if($folios or $folios != 0){

echo "<?xml version='1.0' encoding='ISO-8859-1'?><rows>";
foreach ($folios as $clave => $valor) {
		$dependency = new dependency;			
		$dependency_data = $dependency->selectbyId($valor["dependency_id"]);	
		$Stockid = $Stock->selectbyFolioId($valor["folio_id"]);
		
		$vehicle = $vehicles->selectbyId($valor["vehicles_record_id"]);	
		$brand = $vehicles->getBrandd($vehicle["support_brand_vehicular_id"]);		
		$model = $vehicles->getModel($vehicle["support_models_vehicular_id"]);
		$users = new Users;
		//Jefe de mecanicos
		
		//Mecanicos asignados
		$db = new manejaDB();
			//Sacar mecanicos que tienen asignada alguna tarea en proceso
		$db->query("
			SELECT group_concat(DISTINCT CONCAT(employees.name,' ' ,employees.last_name) separator ', ') as mecanicos
			FROM floor_activities
			left join employees
			on employees.employee_id = floor_activities.employee_id
			where floor_activities.folio_id = '".$valor["folio_id"]."' group by floor_activities.folio_id;
		");//and floor_activities.status = 1
		$mecanicos = $db->getArrayAsoc();						
		$db->desconectar();
		if($mecanicos and ISSET($mecanicos[0]["mecanicos"])){
			$jefemecanicos = $mecanicos[0]["mecanicos"];
		}else{
			$jefemecanicos ="";
		}
		
		
		$activity = new FloorActivity;
		if($activity->getstart_date($valor["folio_id"])){
				$date = explode(",",$activity->getstart_date($valor["folio_id"]));				
				$date["1"] = ($date["1"])-1;
				list($año, $mes, $dia) = $date;
				$mes = ($mes< 10)? "0".$mes : $mes;
				$date = $dia."/".$mes."/".$año;
				//$date = implode("/",$date);
		}else{
			$date = "";
		}
		$Tracing = new Tracing;
		$seguimiento = array();
		$mensajes = $Tracing->getTracings($valor["folio_id"]);
					if($mensajes){foreach($mensajes as $rows){
								$seguimiento[] = utf8_encode($rows['comments']);								
							}
					}
		
		$seguimiento = implode(" , ",$seguimiento);
		$f_activity = new FloorActivity; 
		$folioidd["folio_id"] = $valor["folio_id"];
		$activities = $f_activity->selectbyColumn($folioidd, 30);
			// Depedencia, folio, marca, tipo, placas, fecha de entrada, actividades, mecanico,seguimiento,fechadeasignacion,torre
			echo "<row id='".$valor["folio_id"]."'>";
			echo "<cell>".utf8_encode($dependency_data["name"])."</cell>";
			echo "<cell>".utf8_encode($valor["area_sector"])."</cell>";			
			echo "<cell>".$valor["folio_id"]."</cell>";
			echo "<cell>".$brand."</cell>";
			echo "<cell>".$model."</cell>";
			echo "<cell>".$valor["registration_plate"]."</cell>";
			echo "<cell>".$valor["entry_date"]."</cell>";
			
			$acts = array();
			if($activities){
							foreach($activities as $value){
								if($value["description"] !== ""){
									$acts[] = $value["description"];										
								}
							}								
						}else{
							$acts[] = "";
						}
			echo "<cell>".utf8_encode(implode(',',$acts))."</cell>";
			echo "<cell>".utf8_encode($jefemecanicos)."</cell>";				
			//echo "<cell>".$valor["departure_date"]."</cell>";
			echo "<cell>".$seguimiento."</cell>";
			echo "<cell>".$date."</cell>";			
			echo "<cell>".$valor["tower"]."</cell>";				
				
			echo "</row>";
				
}
echo "</rows>";
}*/
?>