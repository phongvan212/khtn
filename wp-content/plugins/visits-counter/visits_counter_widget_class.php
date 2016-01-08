<?php


class visits_counter_widget {
    
    private $counter = null;
    private $settings = null;
    private $title;
    
    public function __construct() {
        $this->counter = new vs_counter();
        $this->settings = vs_settings::getInstance();
        $this->labels = $this->settings->get_display_labels();
        
        $this->count_values = $this->counter->vc_count_users();
        $this->displayOptions = $this->settings->get_display_options();
        
        $this->title = $this->labels['widgetTitle'];
        $this->onlineUsersLabel = $this->labels['nowOnlineLabel'];
        $this->overallUsersLabel = $this->labels['overallLabel'];
        $this->dailyUsersLabel = $this->labels['dailyLabel'];
        $this->weeklyUsersLabel = $this->labels['weeklyLabel'];
    }
    
    public function drawWidget($args){
        extract($args);
    ?>
        <?php echo $before_widget; ?>
            <?php echo $before_title
                . $this->title
                . $after_title; ?>
            <?php echo $this->_prepareContent(); ?>
        <?php echo $after_widget; ?>
    <?php
    }
    
    public function displayWidgetContent(){
        return $this->_prepareContent(True);
    }
    
    private function _prepareContent($displayTitle = False){
        if ($displayTitle == False)
            $content = "";
        else
            $content = "<h3>".$this->title."</h3>";

        if ($this->displayOptions['displayCurrent'])
            $content .= "<span class='fa fa-users'></span> ".$this->onlineUsersLabel.": ".$this->count_values['online_users']."<br />";
        if ($this->displayOptions['displayDaily'])
            $content .= "<span class='fa fa-calendar-check-o'></span> ".$this->dailyUsersLabel.": ".$this->count_values['daily_counter']."<br />";
        if ($this->displayOptions['displayWeekly'])
            $content .= "<span class='fa fa-calendar'></span> ".$this->weeklyUsersLabel.": ".$this->count_values['weekly_counter']."<br />";
        if ($this->displayOptions['displayOverall'])
            $content .= "<span class='fa fa-bar-chart'></span> ".$this->overallUsersLabel.": ".$this->count_values['overall_counter']."<br />";
        
        //cut last <br /> tag in $content:
        $content = substr($content, 0, -6);
        
        return $content;
    }
    
}
?>
