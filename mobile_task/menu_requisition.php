<div data-role="navbar">
				<ul>
					<li><a href="./admin_requisition.php?folio=<?php echo $id;?>&tab=3&subtab=1" <?php echo($_GET['subtab']=='1')?'class="ui-btn-active"':''?> data-ajax="false">Ver Solicitudes</a></li>
					<li><a href="./admin_requisition_form.php?folio=<?php echo $id;?>&tab=3&subtab=2" <?php echo($_GET['subtab']=='2')?'class="ui-btn-active"':''?> data-ajax="false">Solicitar material</a></li>
					<li><a href="./admin_requisition_authorize.php?folio=<?php echo $id;?>&tab=3&subtab=3" <?php echo($_GET['subtab']=='3')?'class="ui-btn-active"':''?> data-ajax="false">Autorizar Material</a></li>
				</ul>
			</div><!-- /navbar -->