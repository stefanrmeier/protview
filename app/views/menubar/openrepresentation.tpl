<div id="open-representation-dialog">
	<div>Open representation</div>
	<div>
		<?php
		$representations = $d['representations'];

		foreach ($representations as $representation) {
			echo '<ul>';
			echo "<li><a href='#view/{$representation['protein_id']}/{$representation['id']}'>{$representation['title']} (creator: {$representation['creator']})</a></li>";
			echo '</ul>';
		}
		?>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		  $('#open-representation-dialog').jqxWindow({ 
			  theme: Application.THEME, 
			  width: 400,
              height: 220, 
              resizable: false,
              isModal: true
          });
		  $('#open-representation-dialog').bind('closed', function (event) {
			  //cleaning dom
			  $('#open-representation-dialog').remove();
			  $('.jqx-window-modal ').remove();
		  });
	});
</script>
