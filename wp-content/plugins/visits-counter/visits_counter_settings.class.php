<?php

class vs_settings {

	public static $oInstance = null;
	
	public $online_offset;
	public $overall_offset;
	public $startTime;
	public $startTimeFormat;
	public $disconnectTime;
	public $countBots;
	public $countAdmins;
	public $displayTotalValue;
	public $displayCurrentValue;
	public $displayDailyValue;
	public $displayWeeklyValue;
	public $options_page_name;
	
	public static function getInstance(){
		if (self::$oInstance == null)
			self::$oInstance = new vs_settings();
		
		return self::$oInstance;
	}
	
	
	private function __construct($time = 120){
		global $wpdb;
		global $table_prefix;
	
		load_plugin_textdomain('visits_counter', false, basename( dirname( __FILE__ ) ) . '/languages/');
	
		$this->online_offset_default_value = 0;
		$this->overall_offset_default_value = 0;
		$this->startTime_default_value = time();
		$this->startTimeFormat_default_value = "Y-m-d H:s";
		$this->disconnectTime_default_value = 300; // in seconds
		$this->countBots_default_value = 0; //false
		$this->countAdmins_default_value = 1; //true
		$this->displayTotalValue_default_value = 1; //true
		$this->displayCurrentValue_default_value = 1; //true
		$this->displayDailyValue_default_value = 0; //false
		$this->displayWeeklyValue_default_value = 0; //false
		$this->widgetTitle_default_value =	__('Thống kê truy cập', 'visits_counter');
		$this->widgetNowOnlineLabel_default_value = __('Đang truy cập','visits_counter');
        $this->widgetOverallLabel_default_value= __('Tất cả', 'visits_counter');
        $this->widgetDailyLabel_default_value = __('Hôm nay', 'visits_counter');
        $this->widgetWeeklyLabel_default_value = __('Tuần này', 'visits_counter');

		$this->online_offset = new vs_option('vs_online_offset', 'vs_online_offset', 'text', $this->online_offset_default_value);
		$this->overall_offset = new vs_option('vs_overall_offset', 'vs_overall_offset', 'text', $this->overall_offset_default_value);
		$this->startTime = new vs_option('vs_startUnixTimeStamp', 'vs_startUnixTimeStamp', 'text', $this->startTime_default_value, "Y-m-d H:s");
		$this->startTimeFormat = new vs_option('vs_startTimeFormat', 'vs_startTimeFormat', 'text', $this->startTimeFormat_default_value);
		$this->disconnectTime = new vs_option('vs_disconnectTime', 'vs_disconnectTime', 'text', $this->disconnectTime_default_value);
		$this->countBots = new vs_option('vs_countBots', 'vs_countBots', 'bool', $this->countBots_default_value);
		$this->countAdmins = new vs_option('vs_countAdmins', 'vs_countAdmins', 'bool', $this->countAdmins_default_value);
		$this->displayTotalValue = new vs_option('vs_displayTotal','vs_displayTotal', 'bool', $this->displayTotalValue_default_value);
		$this->displayCurrentValue = new vs_option('vs_displayCurrent', 'vs_displayCurrent', 'bool', $this->displayCurrentValue_default_value);
		$this->displayDailyValue = new vs_option('vs_displayDaily', 'vs_displayDaily', 'bool', $this->displayDailyValue_default_value);
		$this->displayWeeklyValue = new vs_option('vs_displayWeekly', 'vs_displayWeekly', 'bool', $this->displayWeeklyValue_default_value);
		$this->widgetTitle = new vs_option('vs_widgetTitle', 'vs_widgetTitle', 'text', $this->widgetTitle_default_value);
		$this->widgetNowOnlineLabel = new vs_option('vs_widgetNowOnlineLabel', 'vs_widgetNowOnlineLabel', 'text', $this->widgetNowOnlineLabel_default_value);
		$this->widgetOverallLabel = new vs_option('vs_widgetOverallLabel', 'vs_widgetOverallLabel', 'text', $this->widgetOverallLabel_default_value);
		$this->widgetDailyLabel = new vs_option('vs_widgetDailyLabel', 'vs_widgetDailyLabel', 'text', $this->widgetDailyLabel_default_value);
		$this->widgetWeeklyLabel = new vs_option('vs_widgetWeeklyLabel', 'vs_widgetWeeklyLabel', 'text', $this->widgetWeeklyLabel_default_value);
		
	}
	
	/**
	 * Admin options initialization
	 * @params: none
	 * @return: none
	 */
	public function register($section_name){
		register_setting($section_name, $this->online_offset->getFieldName());
		register_setting($section_name, $this->overall_offset->getFieldName());
		register_setting($section_name, $this->startTime->getFieldName(), array($this, 'prepare_startTime_value'));
		register_setting($section_name, $this->startTimeFormat->getFieldName());
		register_setting($section_name, $this->disconnectTime->getFieldName());
		register_setting($section_name, $this->countBots->getFieldName(), array($this, 'prepare_boolean_value'));
		register_setting($section_name, $this->countAdmins->getFieldName(), array($this, 'prepare_boolean_value'));
		register_setting($section_name, $this->displayTotalValue->getFieldName(), array($this, 'prepare_boolean_value'));
		register_setting($section_name, $this->displayCurrentValue->getFieldName(), array($this, 'prepare_boolean_value'));
		register_setting($section_name, $this->displayDailyValue->getFieldName(), array($this, 'prepare_boolean_value'));
		register_setting($section_name, $this->displayWeeklyValue->getFieldName(), array($this, 'prepare_boolean_value'));
		register_setting($section_name, $this->widgetTitle->getFieldName());
		register_setting($section_name, $this->widgetNowOnlineLabel->getFieldName());
		register_setting($section_name, $this->widgetOverallLabel->getFieldName());
		register_setting($section_name, $this->widgetDailyLabel->getFieldName());
		register_setting($section_name, $this->widgetWeeklyLabel->getFieldName());
	}
		
	/**
	 * Method which create options records in wp_options table
	 * @param: none;
	 * @return: none
	 */
	public function create(){
		$this->online_offset->addOption();
		$this->overall_offset->addOption();
		$this->startTime->addOption();
		$this->startTimeFormat->addOption();
		$this->disconnectTime->addOption();
		$this->countBots->addOption();
		$this->countAdmins->addOption();
		$this->displayTotalValue->addOption();
		$this->displayCurrentValue->addOption();
		$this->displayDailyValue->addOption();
		$this->displayWeeklyValue->addOption();
		$this->widgetTitle->addOption();
		$this->widgetNowOnlineLabel->addOption();
		$this->widgetOverallLabel->addOption();
		$this->widgetDailyLabel->addOption();
		$this->widgetWeeklyLabel->addOption();
	}
	
	/**
	 * Method which prepare start time to store in database in correct format
	 * @params: $inputData - String with date in format "Y-m-d H:s"
	 * @return: $new_date - unix timestamp
	 */
	public function prepare_startTime_value($inputData){
		if(!$inputData){
			$new_date = time();
		} else {
			$inputData = explode(" ", $inputData);
			$day = explode("-", $inputData[0]);
			$time = explode(":", $inputData[1]);
			$new_date = mktime($time[0], $time[1], 0, $day[1], $day[2], $day[0]);
		}
		return $new_date;
	}
	
	/*
	 * Method which prepare boolean value to store in db
	 * @params: $inputData - boolean
	 * @return: $new_data - String
	 */
	public function prepare_boolean_value($inputData){
		if (!$inputData)
			$new_data = 0;
		else
			$new_data = 1;
		return $new_data;
	}
	
	/**
	 * Method which get options values from db
	 * @params: none
	 * @return: none
	 */
	public function get_option_values(){
		$this->online_offset_value = $this->online_offset->getOption();
		$this->overall_offset_value = $this->overall_offset->getOption();
		$this->startTime_value = $this->startTime->getOption();
		$this->startTimeFormat_value = $this->startTimeFormat->getOption();
		$this->disconnectTime_value = $this->disconnectTime->getOption();
		$this->countBots_value = $this->countBots->getOption();
		$this->countAdmins_value = $this->countAdmins->getOption();
		$this->displayTotalValue_value = $this->displayTotalValue->getOption();
		$this->displayCurrentValue_value = $this->displayCurrentValue->getOption();
		$this->displayDailyValue_value = $this->displayDailyValue->getOption();
		$this->displayWeeklyValue_value = $this->displayWeeklyValue->getOption();
		$this->widgetTitle_value = $this->widgetTitle->getOption();
		$this->widgetNowOnlineLabel_value = $this->widgetNowOnlineLabel->getOption();
		$this->widgetOverallLabel_value = $this->widgetOverallLabel->getOption();
		$this->widgetDailyLabel_value = $this->widgetDailyLabel->getOption();
		$this->widgetWeeklyLabel_value = $this->widgetWeeklyLabel->getOption();
	}
	
	/**
	 * Method which get widget display values options
	 * @param: none
	 * @return: array($displayTotal, $current, $displayDaily, $displayWeekly)
	 */
	public function get_display_options(){
		return array('displayOverall' => $this->displayTotalValue->getOption(),
				'displayCurrent' => $this->displayCurrentValue->getOption(),
				'displayDaily'   => $this->displayDailyValue->getOption(),
				'displayWeekly'  => $this->displayWeeklyValue->getOption());
	}

	/**
	 * Method which get widget labels
	 * @param: none
	 * @return: array($widgetTitle, $nowOnlineLabel, $overallLabel, $dailyLabel, $weeklyLabel)
	 */
	public function get_display_labels(){
		return array('widgetTitle' => $this->widgetTitle->getOption(),
					 'nowOnlineLabel' => $this->widgetNowOnlineLabel->getOption(),
					 'overallLabel' => $this->widgetOverallLabel->getOption(),
					 'dailyLabel' => $this->widgetDailyLabel->getOption(),
					 'weeklyLabel' => $this->widgetWeeklyLabel->getOption());
	}
}
