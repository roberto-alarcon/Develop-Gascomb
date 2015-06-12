<?php
// Include configuration 
include_once('/home/gascomb/secure_html/config/set_variables.php');
include_once(PATH_CLASSES_FOLDER.'class.activities.php');
$tab_height = (isset($_GET['tab_height']))?$_GET['tab_height'] : '610';
$folio_id = (isset($_GET['folio']))?$_GET['folio'] : '1';
$activity = new FloorActivity;



?>

<html>
<head>

<title>Grafica de Gantt</title>

<script src='<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxScheduler/dhtmlxscheduler.js' type="text/javascript" charset="utf-8"></script>
<script src='<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxScheduler/ext/dhtmlxscheduler_timeline.js' type="text/javascript" charset="utf-8"></script>
<script src='<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxScheduler/ext/dhtmlxscheduler_treetimeline.js' type="text/javascript" charset="utf-8"></script>
<script src='<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxScheduler/ext/dhtmlxscheduler_tooltip.js' type="text/javascript" charset="utf-8"></script>

<link rel='stylesheet' type='text/css' href='<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxScheduler/dhtmlxscheduler.css'>

</head>
<style type="text/css" media="screen">
	html, body{
		margin:0px;
		padding:0px;
		height:100%;
		overflow:hidden;
	}	
	.one_line{
		white-space:nowrap;
		overflow:hidden;
		padding-top:5px; padding-left:5px;
		text-align:left !important;
	}
</style>
<script type="text/javascript">
	function init() {

		scheduler.locale.labels.timeline_tab = "Linea de tiempo";
		scheduler.locale.labels.section_custom="Section";
		scheduler.config.drag_resize= false; //
		scheduler.config.drag_create = false;
		scheduler.config.drag_move = false;
		scheduler.config.details_on_create=false;
		scheduler.config.details_on_dblclick=false;
		scheduler.config.dblclick_create = false;
		scheduler.config.xml_date="%Y-%m-%d %H:%i";
		scheduler.config.first_hour = 9;//Hora inicial del dia
		scheduler.config.last_hour = 18;//Hora Final del dia
		scheduler.config.start_on_monday = true;
		
		
		scheduler.config.icons_select = []; //Iconos a mostrar: Editar, Detalles, Eliminar Desactivados}
		
		//Tooltip
		dhtmlXTooltip.config.className = 'dhtmlXTooltip tooltip'; 
		dhtmlXTooltip.config.timeout_to_display = 50; 
		dhtmlXTooltip.config.delta_x = 15; 
		dhtmlXTooltip.config.delta_y = -20;
		var format=scheduler.date.date_to_str("%H:%i %d/%m/%Y"); 
		scheduler.templates.tooltip_text = function(start,end,event) {
			return "<b>Actividad:</b> "+event.text+"<br/><b>Inicia:</b> "+
			format(start)+"<br/><b>Termina:</b> "+format(end);
		};
		
		
		//===============
		//Configuration
		//===============	
		<?php $activity->writeShedulerData($folio_id); ?>
		
		/*var elements = [ // original hierarhical array to display
			{key:10, label:"Web Testing Dep.", open: true, children: [
				{key:20, label:"Elizabeth Taylor"},
				{key:30, label:"Managers",  children: [
					{key:40, label:"John Williams"},
					{key:50, label:"David Miller"}
				]},
				{key:60, label:"Linda Brown"},
				{key:70, label:"George Lucas"}
			]},
			{key:110, label:"Human Relations Dep.", open:true, children: [
				{key:80, label:"Kate Moss"},
				{key:90, label:"Dian Fossey"}
			]}
		];*/
		
		
		
		scheduler.createTimelineView({
			section_autoheight: false,
			name:	"timeline",
			x_unit:	"minute",
			x_date:	"%H:%i",
			x_step:	60,
			x_size: 10,
			x_start: 9,
			x_length:	24,
			y_unit: elements,
			y_property:	"section_id",
			render: "bar",
			folder_dy:20,
			dy:60,
			event_dy: "full"
			
		});
		
		scheduler.locale={
			date:{
				month_full:["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
				month_short:["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
				day_full:["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
				day_short:["Dom", "Lun", "Mar", "Mier", "Jue", "Vier", "Sab"]
			},
			labels:{
				dhx_cal_today_button:"Hoy",
				day_tab:"Dia",
				week_tab:"Semana",
				month_tab:"Mes",
				new_event:"New event",
				icon_save:"Save",
				icon_cancel:"Cancel",
				icon_details:"Details",
				icon_edit:"Edit",
				icon_delete:"Delete",
				confirm_closing:"", //Your changes will be lost, are your sure?
				confirm_deleting:"Event will be deleted permanently, are you sure?",
				section_description:"Description",
				section_time:"Linea de tiempo",
				timeline_tab: "Linea de tiempo"
			}
		}
		
		
		

		//===============
		//Data loading
		//===============
		/*scheduler.config.lightbox.sections=[	
			{name:"description", height:130, map_to:"text", type:"textarea" , focus:true},
			{name:"custom", height:23, type:"timeline", options:null , map_to:"section_id" }, //type should be the same as name of the tab
			{name:"time", height:72, type:"time", map_to:"auto"}
		]*/
		<?php  			
			if($activity->getstart_date($folio_id)){
				$date = explode(",",$activity->getstart_date($folio_id));
				//echo "<!--".print_r($date)."-->";
				$date["1"] = ($date["1"])-1;
				$date = implode(",",$date);
			}
		?>
		scheduler.init('scheduler_here',new Date(<?php echo $date; ?>),"timeline");//2009,5,30
		//scheduler.load("events.xml");
		scheduler.load("activitiesxml.php?folio="+<?php echo $folio_id; ?>);
	}
	
</script>
<body onload="init();">
<?php
$activities = $activity->getActivitiesArray($folio_id);
//print_r($activities);exit(0);
//echo $date; exit(0);
if (empty($activities) ) {
				echo '<p style="color:#666;margin:20px;font-family:Arial;font-size: .9em;font-weight: bold;">No se han agregado tareas</p>';
}elseif(!isset($date)){
	echo '<p style="color:#666;margin:20px;font-family:Arial;font-size: .9em;font-weight: bold;">Se han agregado tareas, pero no han sido asignados</p>';
}else{	
 ?>
	<div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:100%;'>
		<div class="dhx_cal_navline">
			<div class="dhx_cal_prev_button">&nbsp;</div>
			<div class="dhx_cal_next_button">&nbsp;</div>
			<div class="dhx_cal_today_button"></div>
			<div class="dhx_cal_date"></div>
			<div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
			<div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
			<div class="dhx_cal_tab" name="timeline_tab" style="right:280px;width: 140px;"></div>
			<div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
		</div>
		<div class="dhx_cal_header">
		</div>
		<div class="dhx_cal_data">
		</div>		
	</div>
<?php } ?>	
</body>


</html>