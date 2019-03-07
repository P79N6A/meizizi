<?php

class Dama2Web {
	const APP_ID = '40838';
	const APP_KEY = 'ca9507e17e8d5ddf7c57cd18d8d33010';
	const HOST = 'http://api.dama2.com:7766/app/';
	
	public function __construct($username,$password) {
		$this->username = $username;
		$this->password = $password;
	}
	
	/*
		sign�ļ���
	*/
	private function getSign($pram='',$ck='') {
		return substr(md5(self::APP_KEY . $this->username . $pram . $ck),0,8);
	}
	/*
		pwd�ļ���
	*/
	private function getPwd() {
		return md5(self::APP_KEY . md5(md5($this->username) . md5($this->password)));
	}
		
	private function get($path,$param=array()) {
		$ch = curl_init();
    	$request = http_build_query($param);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch, CURLOPT_URL, self::HOST . $path . '?' .$request);
    	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);  
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	
	private function post($path,$param=array()) {
		$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, self::HOST . $path);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 		curl_setopt($ch, CURLOPT_POST, 1);
    	curl_setopt($ch, CURLOPT_TIMEOUT, 45);     	
    	curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);   	
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $param);

		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	
	/*
		��ѯ���
	*/
	public function getBalance() {
		$param = array(
			'appID' => self::APP_ID,
			'user' => $this->username,
			'pwd' => $this->getPwd(),
			'sign' => $this->getSign(),
		);
		return json_decode($this->get('d2Balance',$param),true);
		
	}
	/*
		�ϴ�ͼƬ��ͼƬ16���ƴ���
		@param string file ͼƬ·��
		@param int type ��֤������
		@return array		
	*/
	
	public function decodeHex($file,$type) {
		$data = file_get_contents($file);
		$filedata = bin2hex($data);
		$param = array(
			'appID' => self::APP_ID,
			'user' => $this->username,
			'pwd' => $this->getPwd(),
			'fileData' => $filedata,
			'type' => $type,
			'sign' => $this->getSign($data),
		);
		$param = http_build_query($param);
		return json_decode($this->post('d2File',$param),true);
	}
	/*
		�ϴ�ͼƬ��ͼƬbase64����
		@param string file ͼƬ·��
		@param int type ��֤������
		@return array		
	*/
	public function decodeBase64($file,$type) {
		$data = file_get_contents($file);
		$fileDataBase64 = base64_encode($data);
		$param = array(
			'appID' => self::APP_ID,
			'user' => $this->username,
			'pwd' => $this->getPwd(),
			'fileDataBase64' => $fileDataBase64,
			'type' => $type,
			'sign' => $this->getSign($data),
		);
		$param = http_build_query($param);
		return json_decode($this->post('d2File',$param),true);
	}	
	/*
		�ϴ�ͼƬ��ͼƬmultipart/form-data����
		@param string file ͼƬ·��
		@param int type ��֤������
		@return array		
	*/
	public function decode($file,$type) {
		$data = file_get_contents($file);
		$param = array(
			'appID' => self::APP_ID,
			'user' => $this->username,
			'pwd' => $this->getPwd(),
			'�ļ�����' => '@' . realpath($file),
			'type' => $type,
			'sign' => $this->getSign($data),
		);
		
		return json_decode($this->post('d2File',$param),true);
	}	
	
	/*
		�ϴ�ͼƬurl����
		@param string url ͼƬurl��ַ
		@param int type ��֤������
		@param string cookieֵ [��ѡ]
		@param string referer [��ѡ]
		@param int len [��ѡ]	
		@return array		
	*/
	public function decodeUrl($url,$type,$cookie='',$referer='',$len='') {
		$param = array(
			'appID' => self::APP_ID,
			'user' => $this->username,
			'pwd' => $this->getPwd(),
			'url' => urlencode($url),
			'type' => $type,
			'sign' => $this->getSign($url,$cookie),
		);
		$cookie?$param['cookie'] = urlencode($cookie):'';
		$referer?$param['referer'] = $referer:'';
		$len?$param['len'] = $len:'';
		$param = http_build_query($param);
		return json_decode($this->post('d2Url',$param),true);
	}
	
	/*
		�ϱ�����
		@param int id  �ϴ���֤�뷵�ص�id
	*/
	public function reportError($id) {
		$param = array(
			'appID' => self::APP_ID,
			'user' => $this->username,
			'pwd' => $this->getPwd(),
			'id' => $id,
			'sign' => $this->getSign($id),
		);
		return json_decode($this->get('d2ReportError',$param),true);		
	} 
	
	
	
}






















?>