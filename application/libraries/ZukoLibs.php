<?php 
	class ZukoLibs {
	
		private $config = array(
			'host' => 'http://zuko.stiki.ac.id/index.php',
			'app_id' => 'f66836379a71c630',
			'private_token' => '3e7ee668ee5b9c3defaff097089bfe94',
			'public_token' => 'dad71643a48c2b'
		);
		
		function connect(){
			$conf = $this->config;
			$data = array(
				'app' => base64_encode(base64_encode($conf['app_id'])),
				'device' => base64_encode(base64_encode($_SERVER['SERVER_ADDR'])),
				'data' => urlencode($this->aes_encode($conf['public_token'],$conf['private_token'])),
			);
			$res = $this->curl_request($this->config['host'].'/connect',$data);
			if($res['isOk']){
				$res['data'] = array(
					'session_token' => $this->aes_decode($res['data']['data'],$conf['private_token']).$this->aes_decode($res['data']['ack'],$conf['private_token']),
				);
			}else{
				$res['data'] = array();
			}
			return $res;
		}
		
		function get_mahasiswa($token,$par){
			$data = array(
				'token' => $this->myBase64encode($token),
				'data' => json_encode($par),
			);
			$res = $this->curl_request($this->config['host'].'/get_mahasiswa',$data);
			return $res;
		}
		function get_unit($token,$par){
			$data = array(
				'token' => $this->myBase64encode($token),
				'data' => json_encode($par),
			);
			$res = $this->curl_request($this->config['host'].'/get_unit',$data);
			return $res;
		}
		function get_pegawai($token,$par){
			$data = array(
				'token' => $this->myBase64encode($token),
				'data' => json_encode($par),
			);
			$res = $this->curl_request($this->config['host'].'/get_pegawai',$data);
			return $res;
		}
		function get_ruang($token,$par){
			$data = array(
				'token' => $this->myBase64encode($token),
				'data' => json_encode($par),
			);
			$res = $this->curl_request($this->config['host'].'/get_ruang',$data);
			return $res;
		}
		function get_aset_router($token,$par){
			$data = array(
				'token' => $this->myBase64encode($token),
				'data' => json_encode($par),
			);
			$res = $this->curl_request($this->config['host'].'/get_aset_router',$data);
			return $res;
		}
		function curl_request($url,$data){
			$ch = curl_init();

			// set url
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

			//return the transfer as a string
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			// $output contains the output string
			$output = curl_exec($ch);
			//echo 'output:'.$output; die;
			$output = json_decode($output,true);

			// close curl resource to free up system resources
			curl_close($ch);    

			return $output;
		}
		
		function aes_encode($text,$key){
			$cipher = "aes-256-cbc";
			$ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
			$iv = openssl_random_pseudo_bytes($ivlen);
			$ciphertext_raw = openssl_encrypt($text, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
			$hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
			$ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
			return $ciphertext;
		}
		function aes_decode($text,$key){
			$cipher = "aes-256-cbc";
			$c = base64_decode($text);
			$ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
			$iv = substr($c, 0, $ivlen);
			$hmac = substr($c, $ivlen, $sha2len=32);
			$text = substr($c, $ivlen+$sha2len);
			$original_plaintext = openssl_decrypt($text, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
			$calcmac = hash_hmac('sha256', $text, $key, $as_binary=true);
			if (hash_equals($hmac, $calcmac))
			{
				return $original_plaintext;
			}
		}
		function myBase64encode($text){
			$ciph = base64_encode($text);
			$ciph = $ciph.base64_encode("55d691297914ce1a60e044f6fae674d6");
			$ciph = base64_encode($ciph);
			return $ciph;
		}
	}
?>
