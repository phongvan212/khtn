<link rel="stylesheet" type="text/css" href="<?php bloginfo('url');?>/wp-content/plugins/visits-counter/css/visits_counter_adminPage.css" />
<script type="text/javascript">
	var loading_content = "<?php _e("Loading data", "visits_counter");?>";
</script>
<script type="text/javascript" src="<?php bloginfo('url');?>/wp-content/plugins/visits-counter/js/functions.js"></script>
<div class="wrap">
	<div id="vs_left_column">
	    <?php screen_icon(); ?>
	    <h2><?php _e('Visits Counter - settings', 'visits_counter');?></h2>
	    <form action="options.php" method="post">
	        <?php settings_fields($this->section_name);?>
	        <table class="form-table">
	            <?php $this->drawOptionsField($this->settings->online_offset, "Online Users Offset"); ?>
	            <?php $this->drawOptionsField($this->settings->overall_offset, "Overall Users Offset"); ?>
	            <?php $this->drawOptionsField($this->settings->startTime, "Overall counter start time"); ?>
	            <?php $this->drawOptionsField($this->settings->startTimeFormat, "Start Time display format");?>
	            <?php $this->drawOptionsField($this->settings->disconnectTime, "Disconnect Time [s]"); ?>
	            <?php $this->drawOptionsField($this->settings->widgetTitle, "Widget's title"); ?>
	            <?php $this->drawOptionsField($this->settings->widgetNowOnlineLabel, "Now online counter's label in widget"); ?>
	            <?php $this->drawOptionsField($this->settings->widgetOverallLabel, "Overall counter's label in widget"); ?>
	            <?php $this->drawOptionsField($this->settings->widgetDailyLabel, "Daily counter's label in widget"); ?>
	            <?php $this->drawOptionsField($this->settings->widgetWeeklyLabel, "Weekly counter's label in widget"); ?>
	            <?php $this->drawOptionsField($this->settings->countBots, "Count Bots (like GoogleBot)"); ?>
	            <?php $this->drawOptionsField($this->settings->countAdmins, "Count Admins on page (like You)"); ?>
	            <?php $this->drawOptionsField($this->settings->displayTotalValue, "Display Total Counter in Widget");?>
	            <?php $this->drawOptionsField($this->settings->displayCurrentValue, "Display Current Online Counter in Widget"); ?>
	            <?php $this->drawOptionsField($this->settings->displayDailyValue, "Display Daily Counter in Widget"); ?>
	            <?php $this->drawOptionsField($this->settings->displayWeeklyValue, "Display Weekly Counter in Widget"); ?>            
	        </table>
	        <?php submit_button(); ?>
	    </form>
    </div>
    <div id="vs_right_column">
    	<h2><?php _e("Users currently online", "visits_counter");?></h2>
    	<table cellspacing="0" class="wp-list-table widefat fixed users">
			<thead>
				<tr>
					<th class="manage-column column-lp" id="lp" scope="col">
						<?php _e("No.", "visits_counter");?>
					</th>
					<th class="manage-column column-ip_address sortable desc" id="ip_address" scope="col">
						<?php _e("IP Address", "visits_counter");?>
					</th>
					<th class="manage-column column-entertime sortable desc" id="entertime" scope="col">
						<?php _e("Enters time", "visits_counter");?>
					</th>
				</tr>
			</thead>
			<tbody>
    	<?php if (is_array($ipsList) && sizeof($ipsList) > 0) { ?>
    		<?php $counter = 1; ?>
			<?php foreach($ipsList as $ip) { ?><tr>
				<tr class="alternate">
					<td class="lp column-lp"><?php echo $counter++; ?></td>
					<td class="ip_address column-ip_address"><?php echo $ip->IP; ?></td>
					<td class="entertime column-entertime"><?php echo date("Y-m-d H:i", $ip->time);?></td>
				</tr>
			<?php } ?>
    	<?php } else { ?>
    			<tr>
    				<td><?php _e("There is no any user on Your page", "visits-counter");?></td>
    			</tr>
    	<?php }?>
    		</tbody>
    		<tfoot>
				<tr>
					<th class="manage-column column-lp" id="lp" scope="col">
						<?php _e("No.", "visits_counter");?>
					</th>
					<th class="manage-column column-ip_address sortable desc" id="ip_address" scope="col">
						<?php _e("IP Address", "visits_counter");?>
					</th>
					<th class="manage-column column-entertime sortable desc" id="entertime" scope="col">
						<?php _e("Enters time", "visits_counter");?>
					</th>
				</tr>
			</tfoot>
		</table>
    </div>
</div>
