<?php

//include_once('/home/grupome/public_html/dev_controlProcess/config/set_variables.php');
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
include_once('/home/gascomb/secure_html/config/set_variables.php');
include_once('class.watchful.php');

class manejaDB extends Watchful
{	

    var $_servidor;	
    var $_base;	
    var $_usuario;
    var $_password;
    var $_conexion;
    var $_query;
    var $_mensaje;
	var $numRows;
	var $affectedRows;

    function manejaDB()
    {
		
		$this->_usuario = ( @func_get_arg(0) != "" )? func_get_arg(0) : BD_USER;
        $this->_password = ( @func_get_arg(1) != "" )? func_get_arg(1) : BD_PASSWORD;
		$this->_base = ( @func_get_arg(2) != "" )? func_get_arg(2) : BD_DATABASE;
		$this->_servidor = ( @func_get_arg(3) != "" )? func_get_arg(3) : BD_SERVER;

		if ($this->conectar()) {
		    $this->abrirBase();
		}

    }

	/**************************************************************
    * M���todo que realiza la conexion al DBMS
	*
    * @access public 
    * @since 27/03/2003 10:00:00 p.m. 
	**************************************************************/

    function conectar()
    {
        if ($this->_conexion=mysql_connect($this->_servidor,$this->_usuario,$this->_password)) {
            return $this->_conexion;
        } else {
            $this->mensaje(1); // Error 1. No se pudo abrir la base de datos
			return false;
        }

    }

	/**************************************************************
    * M���todo que realiza la selecci���n de la base de datos
	*
    * @access public 
    * @since 27/03/2003 10:00:00 p.m. 
	**************************************************************/

    function abrirBase()
    {
        if (mysql_select_db($this->_base,$this->_conexion)) {
            return true;
        } else {
			
            $this->mensaje(2); // Error 2. No se pudo abrir la base de datos
            return false;
        }

    }

	/**************************************************************
    * M���todo que cierra la conexion al DBMS
	*
    * @access public 
    * @since 18/03/2006 01:38:00 p.m. GSV
	**************************************************************/

    function desconectar()
    {
        @mysql_close($this->_conexion);
		return true;
    }

	/**************************************************************
    * M���todo que retorna el ���ltimo error generado
	*
    * @access public 
    * @since 27/03/2003 10:00:00 p.m. 
	**************************************************************/

    function mensaje()
    {
        switch (func_num_args()) {
            case 0: return $this->_mensaje;
            case 1: $this->_mensaje = func_get_arg(0);
        }
    }


	/**************************************************************
    * M���todo que ejecuta la instrucci���n DML
	*
    * @access public 
    * @since 27/03/2003 10:00:00 p.m. 
	**************************************************************/

    function query($sql){
		$this->affectedRows = 0;
        if ($this->_query=mysql_query($sql,$this->_conexion)){
          	$this->affectedRows=$this->filasAfectadas();
			return $this->_query;
        }else{
            $this->mensaje(mysql_error($this->_conexion)); // Error 3. No se pudo ejecutar la consulta
            return false;
        }
    }
	
	/**************************************************************
    * M���todo que realiza retorna el array con los registros
	* obtenidos
	*
    * @access public 
    * @since 27/03/2003 10:00:00 p.m. 
	**************************************************************/
	
    function getArray() 
    { 	
		$valor = mysql_fetch_array($this->_query);
		if( !$valor || $this -> numLineas() == 1 ){
		}
        return  $valor;
    }
	
	function getArrayAsoc() 
    { 
		if (($this -> numLineas()) > 0 ){
			while($row = mysql_fetch_assoc($this->_query)){ 
				$valor[] = $row;
			}			
		}else{
			$valor = 0;
		}		
        return  $valor;
    }
	/**************************************************************
    * M���todo que realiza retorna el n���mero de registros afectados
	*
    * @access public 
    * @since 29/03/2003 10:00:00 p.m. 
	**************************************************************/
	
	function filasAfectadas()
	{
		return mysql_affected_rows();	
	}
	
	/**************************************************************
    * M���todo que realiza retorna el n���mero de registros de la
	* consulta
	*
    * @access public 
    * @since 29/03/2003 10:00:00 p.m. 
	**************************************************************/
	
	function numLineas()
	{
		return @mysql_num_rows($this->_query);
	}	

	/**************************************************************
    * M���todo que retorna el n���mero de columnas de la consulta
	*
    * @access public 
    * @since 13/04/2007 08:32:23 p.m. 
	**************************************************************/
	
	function numColumnas()
	{
		return @mysql_num_fields($this->_query);
	}


	/**************************************************************
    * M���todo que retorna para una consulta, el nombre de la columna 
    * que corresponde al n���mero que recibe como argumento 
	* (empezando por la columna n���mero 0)
	*
    * @access public 
    * @since 13/04/2007 08:32:23 p.m. 
	**************************************************************/
	
	function nombreColumna($num_col)
	{
		return @mysql_field_name($this->_query, $num_col);
	}
	

	/**************************************************************
    * M���todo que realiza utiliza el mysql_result() para obtener un
	* resultado
	*
    * @access public 
    * @since 29/03/2003 12:00:00 p.m. 
	**************************************************************/
	
	function result($rs, $numero)
	{
		return mysql_result($rs, $numero);
	}
	
	/**************************************************************
    * M���todo que permite obtener el resultado de query()
	*
    * @access public 
    * @since 29/03/2003 12:00:00 p.m. 
	**************************************************************/
	
	function getQuery()
	{
		return $this->_query;
	}
	
	function __destruct() 
		{		
		//@mysql_free_result( $this->_query );
		
  		}	
		
	function ultimo_id()
	{
		return mysql_insert_id($this->_conexion);
	}
	
	function makeQueryInsert($tabla,$array){
		
		$arreglo_campo=array();
		$arreglo_valores=array();
			
		//Generamos la linea de campos
		foreach($array as $indice =>$v){
			$arreglo_campo[] = $indice;
			$arreglo_valores[] ="'".$v."'";
		}
		
		$campos=implode(",",$arreglo_campo);
		$valores=implode(",",$arreglo_valores);
		
		$sql=
		"
		INSERT INTO $tabla 
		($campos)
		VALUES
		($valores)
		";
				
		$this->query($sql);
		$lastId=$this->ultimo_id();
		$this->logRegistry($tabla,"insert",$lastId);
		return $lastId;
		
		
		
	}
	
	
	function makeQueryUpdate($tabla,$array,$where){
	
		$datos=array();
		$datos_where=array();
			
		//Generamos la linea de campos a actualizar
		foreach($array as $indice =>$v){
			$datos[]= $indice." ='".$v."'";
		}
		$datos=implode(",",$datos);
		
		//Generamos linea para crear el where
		foreach($where as $apuntador => $v){
			$datos_where[]=$apuntador." ='".$v."'";
		}
		
		$datos_where=implode(" AND ",$datos_where);
		
		
		$sql="
		Update $tabla set 
		$datos
		Where
		$datos_where
		";
		
		if($this->query($sql) && $this->affectedRows > 0){
			return true;
		}else{
			return false;
		}
		#return $sql;
		
		
	}
	

		
}
?>