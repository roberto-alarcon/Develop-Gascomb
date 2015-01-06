<?php
global $id;
include_once PATH_CLASSES_FOLDER.'class.activities.php';
include_once(PATH_CLASSES_FOLDER.'class.employees.php');


?>
<script>
			function changefolio(){
				var folio_d = document.getElementById('search_folio').value;
				if(folio_d ==""){
					alert("Favor de escribir un folio en el campo indicado");
					document.getElementById('search_folio').focus();
				}else{					
					location.href='admin_info.php?folio='+folio_d+'&tab=1';
				}
			}
</script>
<style>	
	.nav-glyphish-example .ui-btn .ui-btn-inner { padding-top: 30px !important; }
	.nav-glyphish-example .ui-btn .ui-icon { width: 30px!important; height: 30px!important; margin-left: -15px !important; box-shadow: none!important; -moz-box-shadow: none!important; -webkit-box-shadow: none!important; -webkit-border-radius: 0 !important; border-radius: 0 !important; }
	
	.nav-glyphish-example1 .ui-btn .ui-btn-inner { padding-top: 20px !important; }
	.nav-glyphish-example1 .ui-btn .ui-icon { width: 30px!important; height: 30px!important; margin-left: -15px !important; box-shadow: none!important; -moz-box-shadow: none!important; -webkit-box-shadow: none!important; -webkit-border-radius: 0 !important; border-radius: 0 !important; }
	
	
	#info .ui-icon { background:  url(img/69-display.png) 50% 50% no-repeat;  }
	#task .ui-icon { background:  url(img/83-calendar.png) 50% 50% no-repeat; }
	#requisitions .ui-icon { background:  url(img/40-inbox.png) 50% 50% no-repeat;  }
	#quality .ui-icon { background:  url(img/17-bar-chart.png) 50% 50% no-repeat;  }
	#change_folio .ui-field-contain { margin:0 2px; }
	#change_folio label.ui-input-text { line-height: 1.9; }
	#change_folio .ui-btn { margin:0;}
	
</style>
		<div class="ui-btn-right" id="change_folio"> 
			<fieldset class="ui-grid-a">
				<div class="ui-block-a">
					<div data-role="fieldcontain">
						<label for="search_folio">Folio:::::::ddd:</label>
						<input type="text" name="search_folio" id="search_folio" data-theme="c" value=""/>
					</div>
				</div>
				<div class="ui-block-b"><button type="button" id="changefolio" onclick="changefolio()" data-theme="b">Enviar</button></div>	   
			</fieldset>						
		</div>
		
		<!-- Menu provicionale de alertas -->
		
		<div data-role="navbar" class="nav-glyphish-example1">
			<div class="ui-bar ui-bar-e">
				Bienvenido: <?php print_r( $_SESSION['active_user_name']  ); ?> <br>
				<a href="./admin_alert_view.php" data-role="none" class="ui-link" data-ajax="false">Mis Alertas</a>
				<a href="./log_out.php" data-role="none" class="ui-link" data-ajax="false">Salir Sistema</a>
				
			</div>
		</div> 
		
		<?php
		if (isset ($_GET['folio']) ){
			$activity = new FloorActivity();
			$employee = new Employee;
			$listado_mecanicos = array();
			$where = array('folio_id'=>$_GET['folio']);
			$elements = $activity->selectbyColumn($where,10);
			foreach($elements as $myActivity){
				
				if(!empty($myActivity['employee_id'])){
					$arrayEmpleado = $employee->selectbyId($myActivity['employee_id']);
					$listado_mecanicos[] = strtoupper($arrayEmpleado['name'].' '.$arrayEmpleado['last_name']);
				}
				
			}
			
			$listado_mecanicos = array_unique($listado_mecanicos);
			if ( !empty($listado_mecanicos)){
		?>
			
			<div data-role="navbar">
				<div class="ui-bar ui-bar-e">
				Mecánico(s) asignado(s): <br/>
				
				<?php 
				foreach($listado_mecanicos as $mecanico){
					echo "<li>".utf8_encode($mecanico)."</li>";
				}
				?>
				</div>
			
			</div>
			
		
		<?php
			}
		 }
		?>
		
		
		<div data-role="navbar" class="nav-glyphish-example">
		<ul>
		<li><a href="./admin_info.php?folio=<?php echo $id;?>&tab=1" id="info" data-icon="custom" <?php echo($_GET['tab']=='1')?'class="ui-btn-active"':''?> data-ajax="false">Datos Generales</a></li>
		<li><a href="./admin_task.php?folio=<?php echo $id;?>&tab=2" id="task" data-icon="custom" <?php echo($_GET['tab']=='2')?'class="ui-btn-active"':''?> data-ajax="false">Tareas</a></li>
		<li><a href="./admin_requisition.php?folio=<?php echo $id;?>&tab=3&subtab=1" id="requisitions" data-icon="custom" <?php echo($_GET['tab']=='3')?'class="ui-btn-active"':''?> data-ajax="false">Requisiciones</a></li>
		<li><a href="./admin_quality.php?folio=<?php echo $id;?>&tab=4&subtab=1" id="quality" data-icon="custom" <?php echo($_GET['tab']=='4')?'class="ui-btn-active"':''?> data-ajax="false">Calidad y ampliaciones</a></li>
		<li><a href="./view_tracing.php?folio=<?php echo $id;?>&tab=5&subtab=1" id="quality" data-icon="custom" <?php echo($_GET['tab']=='5')?'class="ui-btn-active"':''?> data-ajax="false">Seguimiento</a></li>
		
		
	</ul>
		</div>
		
		
