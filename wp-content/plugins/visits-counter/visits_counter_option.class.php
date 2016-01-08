<?php

class vs_option {
    
    private $_id;
    private $_title;
    private $_callback;
    private $_value;
    private $_default_value;
    private $_field_type;
    private $_time_format;
    
    public function __construct($id, $name, $field_type, $default_value='', $time_format =  "") {
        $this->_id = $id;
        $this->_title = $name;
        $this->_field_type = $field_type;
        $this->_default_value = $default_value;
        $this->_callback = array($this, 'drawField');
        $this->_time_format = $time_format;
    }
    
    
    public function addOption(){
        if ($this->_id != null)                                                                                                                                                     
            add_option($this->_id, $this->_default_value, null, false);                                                                                                             
        else                                                                                                                                                                        
            throw new UnexpectedValueException("Field ID can not be null");                                                                                                         
    }                                                                                                                                                                               
                                                                                                                                                                                    
                                                                                                                                                                                    
    public function drawField(){                                                                                                                                                    
        switch ($this->_field_type){                                                                                                                                                
            case 'text'         : $this->drawTextField(); break;                                                                                                                    
            case 'longtext'     : $this->drawTextAreaField(); break;      
            case 'bool'         : $this->drawBoolField(); break;                                                                                                                    
        }                                                                                                                                                                           
    }                                                                                                                                                                               
    
    
    public function updateOption($value){
        if ($value == '')
            $value = 0;
       
        update_option($this->_title, $value);
    }
    
    public function getOption(){
        $value = get_option($this->_title);
        if ($value == NULL){
            $this->addOption();
            $value = $this->_default_value;
        }
        return $value;
    }
    
    public function getFieldId(){
                return $this->_id;
    }
    
    public function getFieldName(){
                return $this->_title;
    }
    
    private function drawTextField(){
        $value = get_option($this->_id);
        if ($this->_time_format != ''){
            $value = date($this->_time_format, $value);
        }
        echo "<input type=\"text\" id=\"$this->_id\" name=\"$this->_id\" value=\"$value\" /><br />";
    }
    
    private function drawTextAreaField(){
        $value = get_option($this->_id);
        echo "<textarea id=\"$this->_id\" name=\"$this->_id\">$value</textarea><br />";
    }
    
    private function drawBoolField(){
        $value = get_option($this->_id);
        $check_value = "";
        if ($value)
            $check_value = 'checked="checked"';
        
        echo "<input type=\"checkbox\" id=\"$this->_id\" name=\"$this->_id\" value=\"true\" $check_value /><br />";
    }
    
}
?>
