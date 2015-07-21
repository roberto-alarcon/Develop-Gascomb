

function viewAgregarActividades(){

	var layout = new dhtmlXLayoutObject("a_tabbar", "3L");

	// Nombreas a las etiquetas
	layout.cells("a").setText("Mis Folios");
	layout.cells("b").setText("Actividades");
	layout.cells("c").setText("Detalles de la actividad");

	var cell_3 = layout.cells('a');
	var grid = cell_3.attachGrid();
	grid.setHeader("Folio, Placa, Dependencia,Fecha de Ingreso");
	grid.setImagePath("./dhtmlxLibrary/dhtmlxGrid/codebase/imgs/");						
	grid.setInitWidths("80,100,400,110");
	grid.setColTypes("dyn,ed,ed,txt");
	grid.enableMultiline(true);
	grid.loadXML("ajax/grids/grid_folios_actividades.php");
	grid.init();

	grid.attachEvent("onRowSelect", function(id,cInd){

		var cell_b = layout.cells('b');
		var grid_b = cell_b.attachGrid();
		grid_b.setHeader("ID, Actividad, Mecánico asignado");
		grid_b.setImagePath("./dhtmlxLibrary/dhtmlxGrid/codebase/imgs/");						
		grid_b.setInitWidths("80,300,*");
		grid_b.setColTypes("dyn,ed,ed,txt");
		grid_b.enableMultiline(true);
		grid_b.loadXML("ajax/grids/grid_folios.php");
		grid_b.init();


		grid_b.attachEvent("onRowSelect", function(id,cInd){

			alert( "generamos detalles" );

		});


	});

};