<?php

class vs_adminPage {
    
    private $online_counter_table;
    private $overall_counter_table;
    private $options_table;
    private $time_range;
    
    private $settings;
    
    private $section_name;
    private $section_title;
    private $section_callback;
    private $section_page;
        
    /*
     * Class constructor
     * @params: $time = 120 - time range within user is online on page [in seconds]
     * @return: WP Error if time is less than 0 or none if everything is ok
     */
    public function __construct($time = 120){
        global $wpdb;
        global $table_prefix;
        
        load_plugin_textdomain('visits_counter', false, basename( dirname( __FILE__ ) ) . '/languages/');
        
        $this->settings = vs_settings::getInstance();
        
        $this->online_counter_table = $table_prefix."vs_current_online_users";
        $this->overall_counter_table = $table_prefix."vs_overall_counter";
        
        $this->section_name = 'visits-counter';
        
        if ($time < 0)
            return new WP_Error('wrong_time', "I can't check users from future. Parameter time range can't be less than 0 in visits counter plugin.");
        else
            $this->time_range = $time;
    }
   

    /*
     * Installation function, it creates requires db tables if no exists
     * @params: none
     * @return: none
     */
    public function installation(){
        $this->create_all_tables();
        $this->settings->create();
    }
    
    /**
     * Method called when admin panel is initialized
     */
    public function adminInit(){
    	$this->settings->register($this->section_name);
    }
    
    
    /**
     * Method which display plugin's options page
     */
    public function dislay_options_page(){
    	$ipsList = $this->get_list_of_ips();
        include_once 'views/visits_counter_configPage.php';
    }
    
    /**
     * Method which get list of IPs which are currently on webpage
     */
    private function get_list_of_ips(){
    	global $wpdb;
    	$ipsList = $wpdb->get_results("SELECT * FROM `".$this->online_counter_table."`");
    	return $ipsList;
    }
    
	/**
     * Method which creates tables for all multisite blogs 
     */
    private function create_all_tables(){
        global $wpdb;
        if (function_exists('is_multisite') && is_multisite()) {
            // check if it is a network activation - if so, run the activation function for each blog id
            if (isset($_GET['networkwide']) && ($_GET['networkwide'] == 1)) {
                // Get all blog ids
                $blogids = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs"));
                foreach ($blogids as $blog_id) {
                    if ($blog_id != 1){
                        $online_table = $wpdb->prefix.$blog_id."_".substr($this->online_counter_table, strlen($wpdb->prefix));
                        $overall_table = $wpdb->prefix.$blog_id."_".substr($this->overall_counter_table, strlen($wpdb->prefix));
                    } else {
                        $online_table = $this->online_counter_table;
                        $overall_table = $this->overall_counter_table;
                    }
                    $this->create_tables($online_table, $overall_table);
                }
                return;
            }   
        }
        $this->create_tables($this->online_counter_table, $this->overall_counter_table);
    }

    /**
     * Method which create new tables in wp db (if it is neccessary)
     * @params: none
     * @return: none
     */
    private function create_tables($online_counter_table, $overall_counter_table){
        global $wpdb;
        if ($wpdb->get_var("show tables like '$online_counter_table'") != $online_counter_table){
            $wpdb->query("CREATE TABLE IF NOT EXISTS `$online_counter_table` (
                                    `IP` varchar(15) NOT NULL COMMENT 'IP of user which enters page',
                                    `time` varchar(255) NOT NULL COMMENT 'time when user enters page (unix timestamp)',
                                PRIMARY KEY (`IP`)
                                ) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
        }
        if ($wpdb->get_var("show tables like '$overall_counter_table'") != $overall_counter_table){
            $wpdb->query("CREATE TABLE IF NOT EXISTS `$overall_counter_table`(
                                    `id` int NOT NULL AUTO_INCREMENT,
                                    `period` varchar(255) NULL COMMENT 'period from which this record handle value: overall = NULL, weekly = weekn_number, daily = current_day',
                                    `visits` int NULL,
                                PRIMARY KEY (`id`)
                                ) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
            $wpdb->insert($this->overall_counter_table, array('id'=>1, 'period'=>'overall', 'visits'=>0));
            $wpdb->insert($this->overall_counter_table, array('id'=>2, 'period'=>date("Y-m-d"), 'visits'=>0));
            $wpdb->insert($this->overall_counter_table, array('id'=>3, 'period'=>date("W"), 'visits'=>0));
        } else {
            //sprawdzamy czy tabela nie jest w starej wersji z mniejszą ilością kolumn
            if ($wpdb->query("DESCRIBE $overall_counter_table;") != 3) { 
                $wpdb->query("ALTER TABLE $overall_counter_table ADD period varchar(255) NULL COMMENT 'period from which this record handle value: overall = NULL, weekly = weekn_number, daily = current_day' AFTER `id`;");
                
                $wpdb->update($overall_counter_table, array('period'=>'overall'), array('id'=>1));
                $wpdb->update($overall_counter_table, array('period'=>date("Y-m-d")), array('id'=>2));
                $wpdb->update($overall_counter_table, array('period'=>date("W")), array('id'=>3));
            }
            
        }
    }

    /*
     * Method which draw one option field on admin page
     * @params: $field, $label - label of field 
     */
    private function drawOptionsField($field, $label){
        ?>
        <tr valign="top">
            <th scope="row">
                <label for="<?php echo $field->getFieldId(); ?>"><?php _e($label, "visits_counter");?></label>
            </th>
            <td>
                <?php $field->drawField(); ?>
            </td>
        </tr>
        <?php
    }    
}
