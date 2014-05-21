<?php // following line id to prevent these pages from being loaded directly (just from within debugger.php)
defined( 'DEBUGGER_LOADED' ) or die ( 'This page is restricted' ); ?>

<div id="debug_cooki_table_container" class="table-responsive">Cookies:
	<table class="table table-bordered table-hover table-condensed table-striped">
		<thead>
			<tr>
				<td>key</td>
				<td>value</td>
				<td>
					<button class="btn btn-danger btn-xs" name="delete" value="test" title=" Delete all cookies" id="debug_delete_all_cookies">
						Delete
					</button>
				</td>
			</tr>
		</thead>
		<tbody class="table-striped">
			<?php
			$cookie_count = 0;
			foreach ($_COOKIE as $key=>$val)
			{
				$cookie_count++;
				echo '<tr id="cookie_tr_'.$cookie_count.'">
					<td>'.$key.'</td>
					<td>'.$val.'</td>
					<td>
						<button id="cookie_btn_'.$cookie_count.'" value="'.$key.'" class="btn btn-warning btn-xs" name="delete" title=" Delete this cookie">
							Delete
						</button>
				</td></tr>';
			}
			?>
			<tr>
			<td><input id="new_cookie_key" type="text" name="Key" placeholder="Enter Key" autocomplete="on"></td>
			<td><input id="new_cookie_value" type="text" name="value" placeholder="Enter Value" autocomplete="on"></td>
			<td><button id="new_cookie_submit" class="btn btn-success btn-xs" name="add" title=" Add new Cookie!">Add it !</button></td>
			</tr>
		</tbody>
	</table>
</div>
<script>
	var cookie_count = "<?php echo $cookie_count; ?>";
	for(var i=0; i<<?php echo $cookie_count; ?>; i++){
			var btn_id = "cookie_btn_" + (i+1);
			window[btn_id].onclick = function() {
				cookie_editor(this.value,'=; expires=Thu, 01-Jan-1970 00:00:01 GMT; path=/; domain=.', window.location.host.toString());// will delet the cookie
				testtt = "cookie_tr_"+i;
				remove_cookie_table_row(this);
		}
	};
	function cookie_editor(name, value) {
	  var cookie = [name, '=', JSON.stringify(value), '; domain=.', window.location.host.toString(), '; path=/;'].join('');
	  document.cookie = cookie;
	}
	
	document.getElementById("new_cookie_submit").onclick = function() {
		cookie_editor(document.getElementById('new_cookie_key').value, document.getElementById('new_cookie_value').value);
	}

	document.getElementById("debug_delete_all_cookies").onclick = function() {
		var value =  this.value;
	    console.log(value);
	}

	function remove_cookie_table_row(n){
		var node = n;
		if (node.parentNode) {
		  node.parentNode.parentNode.parentNode.removeChild(node.parentNode.parentNode);
		}
	}
	
</script>