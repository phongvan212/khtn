<?php

class vs_whoisdata {
	
	private $_ip = "";
	private $_service_default_url = "http://whoiz.herokuapp.com/lookup.json?";
	private $_service_specified_url = "";
	private $_data = "";
	
	public function __construct($ip = "")
	{
		$this->setIP($ip);
	}
	
	public function setIP($ip)
	{
		if ( $this->_isValidIPAddress($ip))
			$this->_ip = $ip;
	}
	
	public function getIPData()
	{
		if (!$this->_isValidIPAddress($this->_ip))
			throw new Exception("Wrong IP address given. It should be Sting in format AAA.BBB.CCC.DDD");
		
		$this->_prepareUrl();
		$this->_getData();
		$this->_convertToHtml();
		return $this->_data;
	}
	
	
	private function _prepareUrl()
	{
		$this->_service_specified_url = $this->_service_default_url."url=".$this->_ip;
	}
	
	private function _getData()
	{
		$this->_data = file_get_contents($this->_service_specified_url);
	}
	
	private function _convertToHtml()
	{
		$this->_data = json_decode($this->_data);
		$this->_data = str_replace("\n", "<br />", $this->_data);
	}
	
	private function _isValidIPAddress($ip)
	{
		return preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/', $ip);
	}
}