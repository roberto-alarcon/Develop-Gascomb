<?php 

include_once 'html2pdf/html2pdf.class.php';
include_once 'class.inventory_control.config.php';
include_once 'manejaDB.php';

Class Services_PDF{
	
	var $folio_id;
	
	function __construct($folio_id){
		$this->folio_id = $folio_id;
		
	}
	
	
	public function creaPDF(){
	
		$content = file_get_contents(PATH_BASE_FOLDER.'user_interface/Modules/viewAdminRequisiciones/html/pdf_body.html', true);
	
		//$link = new InventoryLink($this->folio_id);
		
		
		
		require_once('html2pdf/html2pdf.class.php');
		try
		{
			$html2pdf = new HTML2PDF('P', 'A4', 'fr');
			//$html2pdf->setModeDebug();
			$html2pdf->setDefaultFont('Arial');
			$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
			//ob_end_clean();
			$html2pdf->Output('exemple00.pdf');
				
		}
		catch(HTML2PDF_exception $e) {
			echo $e;
			exit;
		}
	
	
	
	
	}
	
	
	
}



?>