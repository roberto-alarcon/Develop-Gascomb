<?php
/**************************************************************
* Clase: users, Maneja el ABC de los usuarios
*
* @access public 
* @since 27/03/2003 10:00:00 p.m. 
**************************************************************/
include_once 'manejaDB.php';
class Inventory
{	

    var $errors= array();
	var $userdata = array();
	var $updatewhere = array("inventory_id"=>"9");
	var $table = 'inventory';
	var $primary = 'inventory_id';
	
	
		
	
	/* Metodo insert: inserta un nuevo usuario*/
	function add($data){
			
			if (is_array($data)){				
				$db = new manejaDB();			
				$id = $db->makeQueryInsert($this->table,$data);
				$result = $this->selectbyId($id);
				$db->desconectar();
				return($result);           			
			}			
    }

	function addAutomatic(){

		$inv = array(
			"tapon_gasolina" => "1",
			"llave_tapon_gasolina" => "1",
			"molduras" => "1", 	
			"tapones_ruedas" => "1",		
			"faro_derecho" => "1",
			"faro_izquierdo" => "1",
			"luces_stop" => "1",
			"direccional_derecha" => "1",
			"direccional_izquierda" => "1",
			"calavera_izquierda" => "1",
			"calavera_derecha" => "1",
			"llantas" => "1",
			"rines" => "1",
			"llanta_refaccion" => "1",
			"llave_ruedas" => "1",
			"dado_birlo_seguridad" => "1",
			"marcha" => "1",
			"antena" => "1",
			"limpiadores" => "1",
			"gomas_limpiadores" => "1",
			"espejo_lateral_derecho" => "1",
			"espejo_lateral_izquierdo" => "1",
			"defensa_delantera" => "1",
			"defensa_trasera" => "1",
			"porta_placas" => "1",
			"placa_delantera" => "1",
			"placa_trasera" => "1",
			"cristales_delanteros" => "1",
			"cristales_traseros" => "1",
			"cristales_laterales" => "1",
			"llave_cajuela" => "1",
			"manijas_exteriores" => "1",
			"emblema" => "1",
			"alternador" => "1",
			"focos_tablero" => "1",
			"amperimetro" => "1",
			"marcador_gasolina" => "1",
			"velocimetro" => "1",
			"manijas_interiores" => "1",
			"ceniceros" => "1",
			"encendedor" => "1",
			"radio" => "1",
			"caratula" => "1",
			"bocinas" => "1",
			"caja_discos" => "1",
			"aire_acondicionado" => "1",
			"defroster" => "1",
			"vestiduras" => "1",
			"botones_puertas" => "1",  		
			"viceras" => "1",
			"llave_switch" => "1",
			"switch" => "1",
			"reloj" => "1",
			"claxon" => "1",
			"espejo_retrovisor" => "1",
			"tapetes" => "1",
			"hule_piso" => "1",
			"tapete_cajuela" => "1",
			"alfombra_cajuela" => "1",
			"tapas_puertas" => "1",
			"tapa_guantera" => "1",
			"coderas" => "1",		
			"cielo" => "1",
			"juego_herramientas" => "1",
			"gato" => "1",
			"reflejantes" => "1",
			"extintor" => "1",
			"baston_seguridad" => "1",
			"tolvas" => "1",
			"tapon_radiador" => "1",
			"tapones_aceite" => "1",
			"nivel_aceite" => "1",
			"tapon_licuadora" => "1",
			"tapon_recuperador" => "1",
			"filtro_aceite" => "1",
			"filtro_gasolina" => "1",
			"filtro_aire" => "1",
			"bayoneta_motor" => "1",
			"bayoneta_transmisor" => "1",
			"bateria" => "1",
			"luz_motor" => "1",
			"golpes" => "1",
			"costado_derecho" => "1",
			"costado_izquierdo" => "1",
			"parte_delantera" => "1",
			"parte_trasera" => "1",
			"antena_oficial" => "1",
			"equipo_radiocomunicacion" => "1",
			"portafiltro" => "1",
			"observations" => "",
			"fuel_level" => "0"
		
		);		
	
		
		if (is_array($inv)){	
			$db = new manejaDB();			
			$id = $db->makeQueryInsert($this->table,$inv);
			$result = $this->selectbyId($id);
			$db->desconectar();
			return($result);
			#return($id);

		} 

    }	

	function update($data){
			if (is_array($data)){
				$db = new manejaDB();			
				$db->makeQueryUpdate($this->table,$data,$this->updatewhere);
				$result = $this->selectbyId($this->updatewhere["inventory_id"]);
				$db->desconectar();
				return($result);           			
			}	
               
    }
	function delete($id){ 
               //$this->db_consulta = mysql_query($query,$this->db_conexion); 
    }
	
	function selectbyId($id){ 
            $db = new manejaDB();
			$db->query("select * from ".$this->table." where $this->primary = '".$id."'");
			$result = $db->getArray();	
			if($result){
				foreach ($result as $clave => $valor) {
					if(is_numeric($clave)) { unset($result[$clave]); }		
				}
			}else{
				$result = "empty";
			}
			$db->desconectar();
			return($result); 						
    }
	
	function selectAll(){ 
            $db = new manejaDB();
			$db->query("select * from ".$this->table." order by $this->primary DESC limit 100");
			$result = $db->getArray();
			foreach ($result as $clave => $valor) {
				if(is_numeric($clave)) { unset($result[$clave]); }		
			}			
			$db->desconectar();
			return($result);
    }

	//Valida los parametros de entrada para insert
	function validateinsert(){
		global $_REQUEST;
		
		
		if(!empty($this->errors)){
			$result = false;
		}else{
			$result = true;
		}
		
		return $result;
	}
	//Valida los parametros de entrada para insert
	function validateupdate(){
		global $_REQUEST;		
		
		if(!empty($this->errors)){
			$result = false;
		}else{
			$result = true;
		}
		
		return $result;
	}
	function selectbyColumn($where, $limit){
			$limit = isset($limit) ? $limit : 10;			
			if($where){
				foreach($where as $apuntador => $v){
					$datos_[]=$apuntador." ='".$v."'";
				}
					$datos_where = " where ";
					$datos_where .= implode(" AND ",$datos_);		
			}else{
				$datos_where = '';
			}
			
            $db = new manejaDB();			
			$db->query("select * from ".$this->table." ".$datos_where." order by $this->primary DESC limit $limit");
			$result = $db->getArrayAsoc();
			if($result){
				$result = $result;
			}else{
				$result = "";
			}
			$db->desconectar();
			return($result);
    }
}