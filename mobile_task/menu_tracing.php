<div data-role="navbar">
				<ul>
					<li><a href="./view_tracing.php?folio=<?php echo $id;?>&tab=5&subtab=1" <?php echo($_GET['subtab']=='1')?'class="ui-btn-active"':''?> data-ajax="false">Seguimiento</a></li>
					<li><a href="./tracing_form.php?folio=<?php echo $id;?>&tab=5&subtab=2" <?php echo($_GET['subtab']=='2')?'class="ui-btn-active"':''?> data-ajax="false">Agregar Avances</a></li>
				</ul>
			</div><!-- /navbar -->