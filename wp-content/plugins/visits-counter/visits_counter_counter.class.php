<?php

class vs_counter {

	private $online_counter_table;
	private $overall_counter_table;
	private $options_table;
	private $time_range;

	private $section_name;
	private $section_title;
	private $section_callback;
	private $section_page;
	
	private $settings;
	
	
	public function __construct($time = 120){
		global $wpdb;
		global $table_prefix;
	
		load_plugin_textdomain('visits_counter', false, basename( dirname( __FILE__ ) ) . '/languages/');
	
		$this->online_counter_table = $table_prefix."vs_current_online_users";
		$this->overall_counter_table = $table_prefix."vs_overall_counter";
	
		$this->settings = vs_settings::getInstance();
	
		$this->section_name = 'visits-counter';
	
		if ($time < 0)
			return new WP_Error('wrong_time', "I can't check users from future. Parameter time range can't be less than 0 in visits counter plugin.");
		else
			$this->time_range = $time;
	}
	
	/**
	 * Method which check is user already online on page
	 * @param: $userIP
	 * @return: true or false
	 */
	private function check_user_online($userIP){
		global $wpdb;
		$check = $wpdb->get_row("SELECT time FROM $this->online_counter_table WHERE IP = '$userIP'");
		if ($check)
			$result = true;
		else
			$result = false;
		return $result;
	}
	
	/**
	 * Main method which counts users actuall online and overall users which visits page
	 * @param: none
	 * @return: none;
	 */
	public function vc_count_users(){
		global $wpdb;
		$this->settings->get_option_values();
		$IP = $_SERVER['REMOTE_ADDR'];
		$current_time = time();
		$checking_time_range = $current_time - $this->settings->disconnectTime_value;
	
		$this->removeOldUsers($checking_time_range);
	
		$user_already_here = $this->check_user_online($IP);
	
		if ($user_already_here){
			$wpdb->update($this->online_counter_table, array('time'=>$current_time), array('IP' => $IP));
		} else {
			if ($this->checkCountCurrentUser() && $this->checkCountBotUser()){
				$wpdb->insert($this->online_counter_table, array('IP'=>$IP, 'time'=>$current_time));
				$this->increase_counters();
			}
		}
	
		$online_users = $wpdb->get_results("SELECT * FROM $this->online_counter_table");
		$overall_count = $this->get_count_value('overall');
		$daily_count = $this->get_count_value('daily');
		$weekly_count = $this->get_count_value('weekly');
		$result = array('online_users'      => sizeof($online_users)+$this->settings->online_offset_value,
				'overall_counter'   => $overall_count+$this->settings->overall_offset_value,
				'daily_counter'     => $daily_count,
				'weekly_counter'    => $weekly_count,
				'counterStartTime'  => date($this->settings->startTimeFormat_value, $this->settings->startTime_value));
		return $result;
	}
	
	/**
	 * Function which remove old entries:
	 * @param: $timeRange
	 * @return: none
	 */
	private function removeOldUsers($timeRange){
		global $wpdb;
		$wpdb->query("DELETE FROM $this->online_counter_table WHERE time < $timeRange");
	}
	
	/**
	 * Function which increase counters: overall, daily and weekly (+1)
	 * @param: none
	 * @return: none
	 */
	private function increase_counters(){
		global $wpdb;
	
	
		//$wpdb->query("UPDATE $this->overall_counter_table SET visits = visits+1 WHERE id = 1");
		$this->increase_counter("overall");
		$this->increase_counter("daily");
		$this->increase_counter("weekly");
	}
	
	/**
	 * Function which gets count value
	 * @param: $valueType = 'overall'
	 * @return: overall count value
	 */
	private function get_count_value($valueType = 'overall'){
		global $wpdb;
		switch ($valueType) {
			case "overall" : $period = "overall"; $id = 1; break;
			case "daily"   : $period = date("Y-m-d"); $id = 2; break;
			case "weekly"  : $period = date("W"); $id = 3; break;
			default        : $period = "overall"; $id = 1; break; //domyślnie pobieramy ogólny licznik
		}
	
		$count = $wpdb->get_row("SELECT visits FROM $this->overall_counter_table WHERE period = '$period'");
		if (!$count){
			$wpdb->delete($this->overall_counter_table, array('id'=>$id));
			$wpdb->insert($this->overall_counter_table, array('id'=>$id, 'period'=>$period, 'visits'=>0));
			$result = 0;
		} else {
			$result = $count->visits;
		}
		return $result;
	}
	
	/**
	 * Method which check is it Bot or "normal" user on website
	 * @param: none
	 * @return: true or false
	 */
	private function isBot(){
		include_once 'visits_counter_uaList.php';
		$ua = $_SERVER['HTTP_USER_AGENT'];
		foreach($uaList as $agent){
			if (strstr($ua, $agent)){
				return True;
			}
		}
		return False;
	}
	
	/**
	 * Method which check is daily or weekly counter already setted for current day or weekly
	 * @param: $valueType (daily, weekly) to check
	 * @return: true or false
	 */
	private function isActualCounter($valueType){
		global $wpdb;
		switch ($valueType) {
			case "overall" : $period = "overall"; $id = 1; break;
			case "daily"   : $period = date("Y-m-d"); $id = 2; break;
			case "weekly"  : $period = date("W"); $id = 3; break;
			default        : $period = "overall"; $id = 1; break;
		}
		$count = $wpdb->get_row("SELECT period FROM $this->overall_counter_table WHERE period = '$period'");
		if (!$count) {
			$wpdb->query("DELETE FROM $this->overall_counter_table WHERE id=$id;");
			$wpdb->insert($this->overall_counter_table, array('id'=>$id, 'period'=>$period, 'visits'=>1));
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	/**
	 * Method which increase one counter
	 * @param: $counterType
	 * @return: none
	 */
	private function increase_counter($counterType){
		global $wpdb;
	
		switch ($counterType) {
			case "overall" : $period = "overall"; $id = 1; break;
			case "daily"   : $period = date("Y-m-d"); $id = 2; $current_date = date("Y-m-d"); break;
			case "weekly"  : $period = date("W"); $id = 3; $current_date = date("W"); break;
			default        : $period = "overall"; $id = 1; break; //domyślnie pobieramy ogólny licznik
		}
	
		if ($this->isActualCounter($counterType))
			$wpdb->query("UPDATE $this->overall_counter_table SET visits = visits+1 WHERE id = $id");
		else
			$wpdb->query("UPDATE $this->overall_counter_table SET visits = 1 AND period = '$current_date' WHERE id = $id");
	}
	
	/**
	 * Method which check should bot be counted and is it bot user or not
	 * @param: none
	 * @return: True if user is not bot or bots should be also counted
	 *          False if user is bot and bot shouldn't be counted
	 */
	private function checkCountBotUser(){
		if ($this->settings->countBots_value == 1 || $this->isBot() == false)
			$result = TRUE;
		else
			$result = FALSE;
	
		return $result;
	}
	
	/**
	 * Method which check should admin user be counted and is it admin user or not
	 * @param: none
	 * @return: True if user is not admin or admins should be also counted
	 *          False if user is admin and admins shouldn't be counted
	 */
	private function checkCountCurrentUser(){
		if ($this->settings->countAdmins_value == 1 || current_user_can('administrator') == false)
			$result = TRUE;
		else
			$result = FALSE;
	
		return $result;
	}

}
