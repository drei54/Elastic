<?php

/**
* Fanspage analityc
* Ini hanya untuk menampilkan data elastic search.
*/
Class Fanspage_analityc{

	/**
	* convert date facebook
	*/
	public function set_date_fb($date){
		#2013-10-18T05:23:17+0000
		$dt1 = str_replace("T"," ",$date);
		$dt2 = str_replace("+0000","",$dt1);
		
		$ret = date('Y-m-d H:i:s', strtotime($dt2 . ' + 7 hour'));
		
		return $ret;
	}

	/**
    * CURL
    */
	public function get_curl($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		#curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-HTTP-Method-Override: PUT'));
		#curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$ce = curl_exec($ch);
		curl_close($ch);
		
		return $ce;
	}
	
	/**
    * elastic search host and query
    */
	public function elastic_search(){
		$url = "http://localhost:9700/fanspage_20131104/_search?fields=id,from,created_time,message,comments,meta&sort=meta.date:desc&size=100";
		#echo $url."<br>";
		$json = $this->get_curl($url);
		$res = json_decode($json, 1);
		
		return $res;
	}
	
	/**
    * main program
    */
	public function main($var){
		
		$data = $this->elastic_search();
		return $data;
	}

}

#assign variable
$var['sd'] = '20131029'; #start date
$var['ed'] = '20131104'; #end date


?>
