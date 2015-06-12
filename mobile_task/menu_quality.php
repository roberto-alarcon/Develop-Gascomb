<div data-role="navbar">
				<ul>
					<li><a href="./admin_quality.php?folio=<?php echo $id;?>&tab=4&subtab=1" <?php echo($_GET['subtab']=='1')?'class="ui-btn-active"':''?> data-ajax="false">Calidad</a></li>
					<li><a href="./admin_extends.php?folio=<?php echo $id;?>&tab=4&subtab=2" <?php echo($_GET['subtab']=='2')?'class="ui-btn-active"':''?> data-ajax="false">Ampliaciones</a></li>
					<li><a href="./admin_extends_form.php?folio=<?php echo $id;?>&tab=4&subtab=3" <?php echo($_GET['subtab']=='3')?'class="ui-btn-active"':''?> data-ajax="false">Nueva ampliaci&oacuten</a></li>
				</ul>
			</div>