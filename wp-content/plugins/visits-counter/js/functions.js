jQuery(document).ready(function($) {
	jQuery("td.ip_address").live('click', function(){
		var ip_cell = jQuery(this);
		var whoisdatadiv = jQuery(this).find("div.whoisdata");
		if (whoisdatadiv.length){
			toggle_info_div(whoisdatadiv);
		} else {
			ip_to_check = ip_cell.text();
			var data = {
					action: 'vccheckIP',
					ip: ip_to_check
				};
			// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
			ip_cell.html(loading_content);
			$.post(ajaxurl, data, function(response) {
				new_content = "<div>"+ip_to_check+"</div><div class=\"whoisdata\" style=\"display:none\">"+response+"</div>";
				ip_cell.html(new_content);
				whoisdatadiv = jQuery(ip_cell).find("div.whoisdata");
				toggle_info_div(whoisdatadiv)
			});
		}
	});

	function toggle_info_div(div){
		div.toggle(500);
	}
});
