<?php
// Include configuration 
include_once ("../../../config/set_variables.php");
$tab_height = (isset($_GET['tab_height']))?$_GET['tab_height'] : '610';
$folio_id = (isset($_GET['folio']))?$_GET['folio'] : '1';

?>

<html>
<head>
<title>Grafica de Gantt</title>

<link type="text/css" rel="stylesheet" href="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxGantt/codebase/dhtmlxgantt.css" />
<script type="text/javascript" language="JavaScript" src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxGantt/codebase/dhtmlxcommon.js"></script>
<script type="text/javascript" language="JavaScript" src="<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxGantt/codebase/dhtmlxgantt.js"></script>
</head>
<body >
</body>

<?php
$file_to=PATH_SERV."user_interface/ajax/gantt/data/".$folio_id.".xml";
	if(is_file($file_to)){	
?>
<div style="width:99%; height:<?php echo $tab_height;?>px; position:relative" id="GanttDiv"></div>
<script type="text/javascript" language="JavaScript">

/*<![CDATA[*/

    // Initialize Gantt data structures
    //project 1
    
    // Create Gantt control
    var ganttChartControl = new GanttChart();
	var dayInPixels = 200;
	var hoursInDay = 24;	
    // Setup paths and behavior
    ganttChartControl.setImagePath("<?php echo PATH_DHTMLX_LIBRARY;?>dhtmlxGantt/codebase/imgs/");
    ganttChartControl.setEditable(true);
    ganttChartControl.showTreePanel(true);
    ganttChartControl.showContextMenu(false);
    ganttChartControl.showDescTask(true,'d,s-f');
    ganttChartControl.showDescProject(true,'n,d');
	ganttChartControl.dayInPixels = dayInPixels;
	ganttChartControl.hourInPixelsWork = dayInPixels / hoursInDay;
	ganttChartControl.hourInPixels = dayInPixels / 24;
   
    // Build control on the page
    ganttChartControl.create("GanttDiv");
	// Load data structure	
    ganttChartControl.loadData("<?php echo PATH_USER_INTERFACE_AJAX;?>gantt/data/<?php echo $folio_id;?>.xml",true,true);

/*]]>*/

	//window.addEventListener('load',function(){
		//createChartControl("GanttDiv");
	//});
</script>
<?php
}
else
	echo file_get_contents('./../system.msj.pending.php', true);
	
?>

</html>