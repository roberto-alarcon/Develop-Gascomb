<?php 
// Esta libreria se encargara de modificar los comportamientos del menu de acciones

echo "

switch(id){
	case 'alertas':
		tabbar.setTabActive('a1');
		break;
	case 'buscar':
		tabbar.setTabActive('a2');
		break;
	case 'nuevo':
		tabbar.setTabActive('a3');
		break;

	case 'reportes':
		//viewReports();
		break;

	case 'salir':
		window.location = './log_out.php';
		break;

	case 'usuarios':
		viewUser();
		break;

	case 'empleados':

		viewEmployees();
		break;

	case 'vehiculos':
		viewAdminCars();
		break;

	case 'chief_department':
		view_chief_department();
		break;

	case 'actividades':
		console.log('Creamos ventana con actividades');
		break;

	case 'sistema':
		document.getElementById('a_tabbar').innerHTML = '';
		viewSistema();
		buffer_toolbar.enableItem('new');
		break;

	case 'preventivo':
		document.getElementById('a_tabbar').innerHTML = '';
		viewPreventivo();
		buffer_toolbar.disableItem('new');
		break;
	case 'requisiciones':
	  document.getElementById('a_tabbar').innerHTML = '';
	  viewAdminRequisiciones();
	  buffer_toolbar.disableItem('new');
	  break;

	case 'inventarios':
		document.getElementById('a_tabbar').innerHTML = '';
		viewControlInventarios();
		break;

	case 'images':
		document.getElementById('a_tabbar').innerHTML = '';
		viewAdminImages();
		break;
		
	case 'contratos':
		document.getElementById('a_tabbar').innerHTML = '';
		viewAdminContratos();
		break;

}";


?>