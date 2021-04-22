<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Statistic_Model extends CI_Model {

    function getTrafficDashboard($interface){
        // $this->db->where('interface',$interface);
        // $this->db->order_by('id', 'desc');
        // $this->db->limit(10);
        // $this->db->order_by('time', 'asc');
        // // $this->db->limit(2000);
        // $data = $this->db->get('network_log');
        $data = $this->db->query( "SELECT * FROM (SELECT * FROM network_log WHERE interface = '".$interface."'
        ORDER BY time DESC LIMIT 120 ) as ether order by id ASC "
        );
        return $data->result();
    }
    
    function getDataInterface($interface){
        $this->db->where('interface',$interface['interface']);
        $this->db->where('time >=',$interface['first_date']);
        $this->db->where('time <=',$interface['last_date']);
        $data = $this->db->get('network_log');
        return $data->result();
    }

    function getStatisticInterface($interface){
        $this->db->select('max(tx) as MaxTx, min(tx) as MinTx, avg(tx) as AvgTx, max(rx) as MaxRx, min(rx) as MinRx, avg(rx) as AvgRx');
        $this->db->where('interface',$interface['interface']);
        $this->db->where('time >=',$interface['first_date']);
        $this->db->where('time <=',$interface['last_date']);
        $data = $this->db->get('network_log');
        return $data->row_array();
    }

    function getQuality($interface){
        $this->db->where('interface',$interface['interface']);
        $this->db->where('time >=',$interface['first_date']);
        $this->db->where('time <=',$interface['last_date']);
        $data = $this->db->get('network_quality_log');
        return $data->result();
    }

    function getBandwidthInterfaceSeries($p){
		$sql = "SELECT DISTINCT interface FROM network_log WHERE time>='".$p['time']['start']."' AND time <= '".$p['time']['end']."' ORDER BY interface ";
		$db = $this->db->query($sql)->result_array();
		
		$res = array();
		foreach($db as $row){
			$res[] = array(
				'name'=>$row['interface'].' Download',
				'data'=>array(),
				'type'=>'areaspline',
				'yAxis' => 1,
				'tooltip'=> array('valueSuffix' => ' Mb'),
			);
			$res[] = array(
				'name'=>$row['interface'].' Upload',
				'data'=>array(),
				'type'=>'areaspline',
				'yAxis' => 0,
				'tooltip'=> array('valueSuffix' => ' Mb')
			);
		}
		return $res;
	}

	function getPingInterfaceSeries($p){
		$sql = "SELECT DISTINCT interface FROM network_quality_log WHERE time>='".$p['time']['start']."' AND time <= '".$p['time']['end']."' ORDER BY interface ";
		$db = $this->db->query($sql)->result_array();
		
		$res = array();
		foreach($db as $row){
			$res[] = array(
				'name'=>$row['interface'].' Loss',
				'data'=>array(),
				'type'=>'column',
				'yAxis' => 1,
				'tooltip'=> array('valueSuffix' => ' %'),
			);
			$res[] = array(
				'name'=>$row['interface'].' Ping Time',
				'data'=>array(),
				'type'=>'spline',
				'yAxis' => 0,
				'tooltip'=> array('valueSuffix' => ' ms')
			);
		}
		return $res;
	}

	function getPingInterfaceDashboard($p){
		$sql = "SELECT DISTINCT interface FROM network_quality_log WHERE time>='".$p['time']['start']."' AND time <= '".$p['time']['end']."' AND interface IN ('indosat', 'iForte') ORDER BY interface ";
		$db = $this->db->query($sql)->result_array();
		
		$res = array();
		foreach($db as $row){
			$res[] = array(
				'name'=>$row['interface'].' Loss',
				'data'=>array(),
				'type'=>'column',
				'yAxis' => 1,
				'tooltip'=> array('valueSuffix' => ' %'),
			);
			$res[] = array(
				'name'=>$row['interface'].' Ping Time',
				'data'=>array(),
				'type'=>'spline',
				'yAxis' => 0,
				'tooltip'=> array('valueSuffix' => ' ms')
			);
		}
		return $res;
	}
	
	function getBandwidthData($p){
		$interval = null;
		// cari selisih tanggal
		$diff = intval($this->__getDateDiff($p));
		
		// IF rentang antara 12-24 jam
		if($diff >= 12*60 && $diff <= 24*60) $interval = 5*60; // 5 menit
		// IF rentang antara 1-7 hari
		else if($diff >= 24*60 && $diff <= 7*24*60) $interval = 30*60; // 30 menit
		// IF rentang antara 7-30 hari
		else if($diff >= 7*24*60 && $diff <= 30*24*60) $interval = 60*60; // 1 jam
		// IF rentang antara 30-60 hari
		else if($diff >= 30*24*60 && $diff <= 60*24*60) $interval = 2*60*60; // 2 jam
		// IF rentang antara 60-90 hari
		else if($diff >= 60*24*60 && $diff <= 90*24*60) $interval = 3*60*60; // 3 jam
		else $interval = 6*60*60;
		
		// IF rentang LAST 3 HOURS
		if(substr($p['time']['start'],-6)=='111111' && substr($p['time']['end'],-6)=='111111'){ // LAST 3 HOURS
				if(substr($p['intf'],-6) == 'Upload')
				return array(
					'subtitle' => 'Last 3 hours - '.$this->getBandwidthData_subLast3Hours(),
					'data' => $this->getBandwidthDataUpload_Last3Hours($p),
				); else
				if(substr($p['intf'],-8) == 'Download')
				return array(
					'subtitle' => 'Last 3 hours - '.$this->getBandwidthData_subLast3Hours(),
					'data' => $this->getBandwidthDataDownload_Last3Hours($p),
				);
			else return false;	
		}else // IF rentang LAST 6 HOURS
		if(substr($p['time']['start'],-6)=='222222' && substr($p['time']['end'],-6)=='222222'){ // LAST 6 HOURS
				if(substr($p['intf'],-6) == 'Upload')
				return array(
					'subtitle' => 'Last 6 hours - '.$this->getBandwidthData_subLast6Hours(),
					'data' => $this->getBandwidthDataUpload_Last6Hours($p),
				); else
				if(substr($p['intf'],-8) == 'Download')
				return array(
					'subtitle' => 'Last 6 hours - '.$this->getBandwidthData_subLast6Hours(),
					'data' => $this->getBandwidthDataDownload_Last6Hours($p),
				);
			else return false;
		}
		else if(!empty($interval)){
				if(substr($p['intf'],-6) == 'Upload')
				return array(
					'subtitle' => $this->getBandwidthData_sub($p),
					'data' => $this->getBandwidthDataUpload_Interval($p,$interval),
				); else
				if(substr($p['intf'],-8) == 'Download')
				return array(
					'subtitle' => $this->getBandwidthData_sub($p),
					'data' => $this->getBandwidthDataDownload_Interval($p,$interval),
				);
			else return false;

		}else{ 
				if(substr($p['intf'],-6) == 'Upload')
				return array(
					'subtitle' => $this->getBandwidthData_sub($p),
					'data' => $this->getBandwidthDataUpload($p),
				); else
				if(substr($p['intf'],-8) == 'Download')
				return array(
					'subtitle' => $this->getBandwidthData_sub($p),
					'data' => $this->getBandwidthDataDownload($p),
				);
			else return false;

		}
	}

	//Bandwidth Upload
	function getBandwidthDataUpload($p){
		$sql = "
			SELECT
				UNIX_TIMESTAMP(DATE_FORMAT(time,'%Y-%m-%d %H:%i:00')) * 1000 AS 'x', 
				-- DATE_FORMAT(time,'%Y-%m-%d %H:%i:00') AS 'x',
				DATE_FORMAT(time,'%Y-%m-%d %H:%i') AS `name`,
				tx AS `y`
				
			FROM 
				network_log 
			WHERE 
				interface = '".substr($p['intf'],0,-6)."' 
				AND time>='".$p['time']['start']."' 
				AND time <= '".$p['time']['end']."' ";
		$_db = $this->db->query($sql)->result_array();
		$res = array();

		foreach($_db as $_row){
			$_row['x'] = intval($_row['x']);
			$_row['y'] = doubleval(number_format((double)$_row['y'] / 1000000, 2, '.', ''));
			$res[] = $_row;
		}
		return $res;
	}

	function getBandwidthDataUpload_Last3Hours($p){
		$sql = "
			SELECT
				UNIX_TIMESTAMP(DATE_FORMAT(time,'%Y-%m-%d %H:%i:00')) * 1000 AS 'x',
				DATE_FORMAT(time,'%Y-%m-%d %H:%i') AS `name`,
				tx AS `y`
				
			FROM 
				network_log 
			WHERE 
				interface = '".substr($p['intf'],0,-6)."' 
				AND time >= DATE_ADD(NOW(), INTERVAL - 3 HOUR)";
		$_db = $this->db->query($sql)->result_array();
		$res = array();
		foreach($_db as $_row){
			//$res[] = array($_row['y'],intval($_row['x']));
			$_row['x'] = intval($_row['x']);
			$_row['y'] = doubleval(number_format((double)$_row['y'] / 1000000, 2, '.', ''));
			$res[] = $_row;
		}
		return $res;
	}

	function getBandwidthDataUpload_Last6Hours($p){
		$sql = "
			SELECT
				UNIX_TIMESTAMP(DATE_FORMAT(time,'%Y-%m-%d %H:%i:00')) * 1000 AS 'x',
				DATE_FORMAT(time,'%Y-%m-%d %H:%i') AS `name`,
				tx AS `y`
				
			FROM 
				network_log 
			WHERE 
				interface = '".substr($p['intf'],0,-6)."' 
				AND time >= DATE_ADD(NOW(), INTERVAL - 6 HOUR)";
		$_db = $this->db->query($sql)->result_array();
		$res = array();
		foreach($_db as $_row){
			//$res[] = array($_row['y'],intval($_row['x']));
			$_row['x'] = intval($_row['x']);
			$_row['y'] = doubleval(number_format((double)$_row['y'] / 1000000, 2, '.', ''));
			$res[] = $_row;
		}
		return $res;
	}

	function getBandwidthDataUpload_Interval($p,$interval){
		$sql = "
			SELECT
				UNIX_TIMESTAMP(DATE_FORMAT(time,'%Y-%m-%d %H:%i:00')) * 1000 AS 'x',
				DATE_FORMAT(AVG(time),'%Y-%m-%d %H:%i') AS `name`,
				AVG(tx) AS `y`
			FROM 
				network_log 
			WHERE 
				interface = '".substr($p['intf'],0,-6)."' 
				AND time>='".$p['time']['start']."' 
				AND time <= '".$p['time']['end']."' 
			GROUP BY
				UNIX_TIMESTAMP(DATE_FORMAT(time,'%Y-%m-%d %H:%i:00')) DIV ".$interval;
		$_db = $this->db->query($sql)->result_array();
		$res = array();
		foreach($_db as $_row){
			//$res[] = array($_row['y'],intval($_row['x']));
			$_row['x'] = intval($_row['x']);
			$_row['y'] = doubleval(number_format((double)$_row['y'] / 1000000, 2, '.', ''));
			$res[] = $_row;
		}
		return $res;
	}

	//Bandwidth Download
	function getBandwidthDataDownload($p){
		$sql = "
			SELECT
				UNIX_TIMESTAMP(DATE_FORMAT(time,'%Y-%m-%d %H:%i:00')) * 1000 AS 'x', 
				-- DATE_FORMAT(time,'%Y-%m-%d %H:%i:00') AS 'x',
				DATE_FORMAT(time,'%Y-%m-%d %H:%i') AS `name`,
				rx AS `y`
				
			FROM 
				network_log 
			WHERE 
				interface = '".substr($p['intf'],0,-8)."' 
				AND time>='".$p['time']['start']."' 
				AND time <= '".$p['time']['end']."' ";
		$_db = $this->db->query($sql)->result_array();
		$res = array();

		foreach($_db as $_row){
			$_row['x'] = intval($_row['x']);
			$_row['y'] = doubleval(number_format((double)$_row['y'] / 1000000, 2, '.', ''));
			$res[] = $_row;
		}
		return $res;
	}

	function getBandwidthDataDownload_Last3Hours($p){
		$sql = "
			SELECT
				UNIX_TIMESTAMP(DATE_FORMAT(time,'%Y-%m-%d %H:%i:00')) * 1000 AS 'x',
				DATE_FORMAT(time,'%Y-%m-%d %H:%i') AS `name`,
				rx AS `y`
				
			FROM 
				network_log 
			WHERE 
				interface = '".substr($p['intf'],0,-8)."' 
				AND time >= DATE_ADD(NOW(), INTERVAL - 3 HOUR)";
		$_db = $this->db->query($sql)->result_array();
		$res = array();
		foreach($_db as $_row){
			//$res[] = array($_row['y'],intval($_row['x']));
			$_row['x'] = intval($_row['x']);
			$_row['y'] = doubleval(number_format((double)$_row['y'] / 1000000, 2, '.', ''));
			$res[] = $_row;
		}
		return $res;
	}

	function getBandwidthDataDownload_Last6Hours($p){
		$sql = "
			SELECT
				UNIX_TIMESTAMP(DATE_FORMAT(time,'%Y-%m-%d %H:%i:00')) * 1000 AS 'x',
				DATE_FORMAT(time,'%Y-%m-%d %H:%i') AS `name`,
				rx AS `y`
				
			FROM 
				network_log 
			WHERE 
				interface = '".substr($p['intf'],0,-8)."' 
				AND time >= DATE_ADD(NOW(), INTERVAL - 6 HOUR)";
		$_db = $this->db->query($sql)->result_array();
		$res = array();
		foreach($_db as $_row){
			//$res[] = array($_row['y'],intval($_row['x']));
			$_row['x'] = intval($_row['x']);
			$_row['y'] = doubleval(number_format((double)$_row['y'] / 1000000, 2, '.', ''));
			$res[] = $_row;
		}
		return $res;
	}

	function getBandwidthDataDownload_Interval($p,$interval){
		$sql = "
			SELECT
				UNIX_TIMESTAMP(DATE_FORMAT(time,'%Y-%m-%d %H:%i:00')) * 1000 AS 'x',
				DATE_FORMAT(AVG(time),'%Y-%m-%d %H:%i') AS `name`,
				AVG(rx) AS `y`
			FROM 
				network_log 
			WHERE 
				interface = '".substr($p['intf'],0,-8)."' 
				AND time>='".$p['time']['start']."' 
				AND time <= '".$p['time']['end']."' 
			GROUP BY
				UNIX_TIMESTAMP(DATE_FORMAT(time,'%Y-%m-%d %H:%i:00')) DIV ".$interval;
		$_db = $this->db->query($sql)->result_array();
		$res = array();
		foreach($_db as $_row){
			//$res[] = array($_row['y'],intval($_row['x']));
			$_row['x'] = intval($_row['x']);
			$_row['y'] = doubleval(number_format((double)$_row['y'] / 1000000, 2, '.', ''));
			$res[] = $_row;
		}
		return $res;
	}

	function getBandwidthData_subLast3Hours(){
		$sql = "SELECT
		CONCAT(
			DATE_FORMAT(
				DATE_ADD(NOW(), INTERVAL - 3 HOUR),
				'%d %M %Y %H:%i:%s'
			),
			' s/d ',
			DATE_FORMAT(NOW(), '%d %M %Y %H:%i:%s')
		) AS `subtitle`";
		$res = $this->db->query($sql)->row_array();
		return $res['subtitle'];
	}

	function getBandwidthData_subLast6Hours(){
		$sql = "SELECT
		CONCAT(
			DATE_FORMAT(
				DATE_ADD(NOW(), INTERVAL - 6 HOUR),
				'%d %M %Y %H:%i:%s'
			),
			' s/d ',
			DATE_FORMAT(NOW(), '%d %M %Y %H:%i:%s')
		) AS `subtitle`";
		$res = $this->db->query($sql)->row_array();
		return $res['subtitle'];
	}

	function getBandwidthData_sub($p){
		$sql = "SELECT
		CONCAT(
			DATE_FORMAT(
				'".$p['time']['start']."',
				'%d %M %Y %H:%i:%s'
			),
			' s/d ',
			DATE_FORMAT(
				'".$p['time']['end']."',
				'%d %M %Y %H:%i:%s'
			)
		) AS `subtitle`";
		$res = $this->db->query($sql)->row_array();
		return $res['subtitle'];
	}

	function getPingData($p){
		$interval = null;
		// cari selisih tanggal
		$diff = intval($this->__getDateDiff($p));
		
		// IF rentang antara 12-24 jam
		if($diff >= 12*60 && $diff <= 24*60) $interval = 5*60; // 5 menit
		// IF rentang antara 1-7 hari
		else if($diff >= 24*60 && $diff <= 7*24*60) $interval = 30*60; // 30 menit
		// IF rentang antara 7-30 hari
		else if($diff >= 7*24*60 && $diff <= 30*24*60) $interval = 60*60; // 1 jam
		// IF rentang antara 30-60 hari
		else if($diff >= 30*24*60 && $diff <= 60*24*60) $interval = 2*60*60; // 2 jam
		// IF rentang antara 60-90 hari
		else if($diff >= 60*24*60 && $diff <= 90*24*60) $interval = 3*60*60; // 3 jam
		else $interval = 6*60*60;
		
		// IF rentang LAST 3 HOURS
		if(substr($p['time']['start'],-6)=='111111' && substr($p['time']['end'],-6)=='111111'){ // LAST 3 HOURS
			if(substr($p['intf'],-9) == 'Ping Time')
				return array(
					'subtitle' => 'Last 3 hours - '.$this->getPingData_subLast3Hours(),
					'data' => $this->getPingDataTime_Last3Hours($p),
				);
			else if(substr($p['intf'],-4) == 'Loss')
				return array(
					'subtitle' => 'Last 3 hours - '.$this->getPingData_subLast3Hours(),
					'data' => $this->getPingDataLoss_Last3Hours($p),
				);
			else return false;	
		}else // IF rentang LAST 6 HOURS
		if(substr($p['time']['start'],-6)=='222222' && substr($p['time']['end'],-6)=='222222'){ // LAST 6 HOURS
			if(substr($p['intf'],-9) == 'Ping Time')
				return array(
					'subtitle' => 'Last 6 hours - '.$this->getPingData_subLast6Hours(),
					'data' => $this->getPingDataTime_Last6Hours($p),
				);
			else if(substr($p['intf'],-4) == 'Loss')
				return array(
					'subtitle' => 'Last 6 hours - '.$this->getPingData_subLast6Hours(),
					'data' => $this->getPingDataLoss_Last6Hours($p),
				);
			else return false;	
		}
		else if(!empty($interval)){
			if(substr($p['intf'],-9) == 'Ping Time')
				return array(
					'subtitle' => $this->getPingData_sub($p),
					'data' => $this->getPingDataTime_Interval($p,$interval),
				);
			else if(substr($p['intf'],-4) == 'Loss')
				return array(
					'subtitle' => $this->getPingData_sub($p),
					'data' => $this->getPingDataLoss_Interval($p,$interval),
				);
			else return false;
		}else{
			if(substr($p['intf'],-9) == 'Ping Time')
				return array(
					'subtitle' => $this->getPingData_sub($p),
					'data' => $this->getPingDataTime($p),
				);
			else if(substr($p['intf'],-4) == 'Loss')
				return array(
					'subtitle' => $this->getPingData_sub($p),
					'data' => $this->getPingDataLoss($p),
				);
			else return false;
		}
	}
	
	function getPingDataTime($p){
		//CASE 
		//	WHEN loss > 75 THEN '#ff0000'
		//	ELSE '#00ff00'
		//END AS `color`
		$sql = "
			SELECT
				UNIX_TIMESTAMP(DATE_FORMAT(time,'%Y-%m-%d %H:%i:00')) * 1000 AS 'x', 
				-- DATE_FORMAT(time,'%Y-%m-%d %H:%i:00') AS 'x', 
				DATE_FORMAT(time,'%Y-%m-%d %H:%i') AS `name`,
				ping_avg AS `y`
			FROM 
				network_quality_log 
			WHERE 
				interface = '".substr($p['intf'],0,-9)."' 
				AND time>='".$p['time']['start']."' 
				AND time <= '".$p['time']['end']."' ";
		$_db = $this->db->query($sql)->result_array();
		$res = array();
		foreach($_db as $_row){
			//$res[] = array($_row['y'],intval($_row['x']));
			$_row['x'] = intval($_row['x']);
			$_row['y'] = intval($_row['y']);
			$res[] = $_row;
		}
		return $res;
	}

	function getPingDataTime_Last3Hours($p){
		$sql = "
			SELECT
				UNIX_TIMESTAMP(DATE_FORMAT(time,'%Y-%m-%d %H:%i:00')) * 1000 AS 'x', 
				-- DATE_FORMAT(time,'%Y-%m-%d %H:%i:00') AS 'x', 
				DATE_FORMAT(time,'%Y-%m-%d %H:%i') AS `name`,
				ping_avg AS `y`
			FROM 
				network_quality_log 
			WHERE 
				interface = '".substr($p['intf'],0,-9)."' 
				AND time>=DATE_ADD(NOW(), INTERVAL - 3 HOUR)";
		$_db = $this->db->query($sql)->result_array();
		$res = array();
		foreach($_db as $_row){
			//$res[] = array($_row['y'],intval($_row['x']));
			$_row['x'] = intval($_row['x']);
			$_row['y'] = intval($_row['y']);
			$res[] = $_row;
		}
		return $res;
	}

	function getPingDataTime_Last6Hours($p){
		$sql = "
			SELECT
				UNIX_TIMESTAMP(DATE_FORMAT(time,'%Y-%m-%d %H:%i:00')) * 1000 AS 'x', 
				-- DATE_FORMAT(time,'%Y-%m-%d %H:%i:00') AS 'x', 
				DATE_FORMAT(time,'%Y-%m-%d %H:%i') AS `name`,
				ping_avg AS `y`
			FROM 
				network_quality_log 
			WHERE 
				interface = '".substr($p['intf'],0,-9)."' 
				AND time>=DATE_ADD(NOW(), INTERVAL - 6 HOUR)";
		$_db = $this->db->query($sql)->result_array();
		$res = array();
		foreach($_db as $_row){
			//$res[] = array($_row['y'],intval($_row['x']));
			$_row['x'] = intval($_row['x']);
			$_row['y'] = intval($_row['y']);
			$res[] = $_row;
		}
		return $res;
	}

	function getPingDataTime_Interval($p,$interval){
		$sql = "
			SELECT
				UNIX_TIMESTAMP(DATE_FORMAT(time,'%Y-%m-%d %H:%i:00')) * 1000 AS 'x', 
				DATE_FORMAT(AVG(time),'%Y-%m-%d %H:%i') AS `name`,
				AVG(ping_avg)  AS `y`
			FROM 
				network_quality_log
			WHERE
				interface = '".substr($p['intf'],0,-9)."' 
				AND time>='".$p['time']['start']."' 
				AND time <= '".$p['time']['end']."'
			GROUP BY
				UNIX_TIMESTAMP(DATE_FORMAT(time,'%Y-%m-%d %H:%i:00')) DIV ".$interval;
		$_db = $this->db->query($sql)->result_array();
		$res = array();
		foreach($_db as $_row){
			$_row['x'] = intval($_row['x']);
			$_row['y'] = intval($_row['y']);
			$res[] = $_row;
		}
		return $res;
	}

	function getPingDataLoss($p){
		$sql = "
			SELECT
				UNIX_TIMESTAMP(DATE_FORMAT(time,'%Y-%m-%d %H:%i:00')) * 1000 AS 'x', 
				-- DATE_FORMAT(time,'%Y-%m-%d %H:%i:00') AS 'x',
				DATE_FORMAT(time,'%Y-%m-%d %H:%i') AS `name`,
				loss AS `y`
				
			FROM 
				network_quality_log 
			WHERE 
				interface = '".substr($p['intf'],0,-4)."' 
				AND time>='".$p['time']['start']."' 
				AND time <= '".$p['time']['end']."' ";
		$_db = $this->db->query($sql)->result_array();
		$res = array();
		foreach($_db as $_row){
			$_row['x'] = intval($_row['x']);
			$_row['y'] = intval($_row['y']);
			$res[] = $_row;
		}
		return $res;
	}

	function getPingDataLoss_Last3Hours($p){
		$sql = "
			SELECT
				UNIX_TIMESTAMP(DATE_FORMAT(time,'%Y-%m-%d %H:%i:00')) * 1000 AS 'x',
				DATE_FORMAT(time,'%Y-%m-%d %H:%i') AS `name`,
				loss AS `y`
				
			FROM 
				network_quality_log 
			WHERE 
				interface = '".substr($p['intf'],0,-4)."' 
				AND time >= DATE_ADD(NOW(), INTERVAL - 3 HOUR)";
		$_db = $this->db->query($sql)->result_array();
		$res = array();
		foreach($_db as $_row){
			//$res[] = array($_row['y'],intval($_row['x']));
			$_row['x'] = intval($_row['x']);
			$_row['y'] = intval($_row['y']);
			$res[] = $_row;
		}
		return $res;
	}

	function getPingDataLoss_Last6Hours($p){
		$sql = "
			SELECT
				UNIX_TIMESTAMP(DATE_FORMAT(time,'%Y-%m-%d %H:%i:00')) * 1000 AS 'x',
				DATE_FORMAT(time,'%Y-%m-%d %H:%i') AS `name`,
				loss AS `y`
				
			FROM 
				network_quality_log 
			WHERE 
				interface = '".substr($p['intf'],0,-4)."' 
				AND time >= DATE_ADD(NOW(), INTERVAL - 6 HOUR)";
		$_db = $this->db->query($sql)->result_array();
		$res = array();
		foreach($_db as $_row){
			//$res[] = array($_row['y'],intval($_row['x']));
			$_row['x'] = intval($_row['x']);
			$_row['y'] = intval($_row['y']);
			$res[] = $_row;
		}
		return $res;
	}

	function getPingDataLoss_Interval($p,$interval){
		$sql = "
			SELECT
				UNIX_TIMESTAMP(DATE_FORMAT(time,'%Y-%m-%d %H:%i:00')) * 1000 AS 'x',
				DATE_FORMAT(AVG(time),'%Y-%m-%d %H:%i') AS `name`,
				AVG(loss) AS `y`
			FROM 
				network_quality_log 
			WHERE 
				interface = '".substr($p['intf'],0,-4)."' 
				AND time>='".$p['time']['start']."' 
				AND time <= '".$p['time']['end']."' 
			GROUP BY
				UNIX_TIMESTAMP(DATE_FORMAT(time,'%Y-%m-%d %H:%i:00')) DIV ".$interval;
		$_db = $this->db->query($sql)->result_array();
		$res = array();
		foreach($_db as $_row){
			//$res[] = array($_row['y'],intval($_row['x']));
			$_row['x'] = intval($_row['x']);
			$_row['y'] = intval($_row['y']);
			$res[] = $_row;
		}
		return $res;
	}

	function getPingData_subLast3Hours(){
		$sql = "SELECT
		CONCAT(
			DATE_FORMAT(
				DATE_ADD(NOW(), INTERVAL - 3 HOUR),
				'%d %M %Y %H:%i:%s'
			),
			' s/d ',
			DATE_FORMAT(NOW(), '%d %M %Y %H:%i:%s')
		) AS `subtitle`";
		$res = $this->db->query($sql)->row_array();
		return $res['subtitle'];
	}

	function getPingData_subLast6Hours(){
		$sql = "SELECT
		CONCAT(
			DATE_FORMAT(
				DATE_ADD(NOW(), INTERVAL - 6 HOUR),
				'%d %M %Y %H:%i:%s'
			),
			' s/d ',
			DATE_FORMAT(NOW(), '%d %M %Y %H:%i:%s')
		) AS `subtitle`";
		$res = $this->db->query($sql)->row_array();
		return $res['subtitle'];
	}

	function getPingData_sub($p){
		$sql = "SELECT
		CONCAT(
			DATE_FORMAT(
				'".$p['time']['start']."',
				'%d %M %Y %H:%i:%s'
			),
			' s/d ',
			DATE_FORMAT(
				'".$p['time']['end']."',
				'%d %M %Y %H:%i:%s'
			)
		) AS `subtitle`";
		$res = $this->db->query($sql)->row_array();
		return $res['subtitle'];
	}
	
	function __getDateDiff($p){
		$sql = "SELECT TIMESTAMPDIFF(MINUTE, '".$p['time']['start']."','".$p['time']['end']."') AS `diff`";
		$res = $this->db->query($sql)->row_array();
		return $res['diff'];
	}
	
    function getStatisticQuality($interface){
        $this->db->select('max(ping_avg) as MaxPing, min(ping_avg) as MinPing, avg(ping_avg) as AvgPing, max(jitter) as MaxJitter, min(jitter) as MinJitter, avg(jitter) as AvgJitter, max(loss) as MaxLoss, min(loss) as MinLoss, avg(loss) as AvgLoss');
        $this->db->where('interface',$interface['interface']);
        $this->db->where('time >=',$interface['first_date']);
        $this->db->where('time <=',$interface['last_date']);
        $data = $this->db->get('network_quality_log');
        return $data->row_array();
    }

    function getDataResource($interface){
        $this->db->where('time >=',$interface['first_date']);
        $this->db->where('time <=',$interface['last_date']);
        // $this->db->order_by('time', 'desc');
        // $this->db->limit(2000);
        // $this->db->limit(10);
        $data = $this->db->get('resource_log');
        return $data->result();
    }

    function getStatisticResource($interface){
        $this->db->select('max(cpu) as MaxCPU, min(cpu) as MinCPU, avg(cpu) as AvgCPU, max((memory/memory_capacity)*100) as MaxMemory, min((memory/memory_capacity)*100) as MinMemory, avg((memory/memory_capacity)*100) as AvgMemory');
        $this->db->where('time >=',$interface['first_date']);
        $this->db->where('time <=',$interface['last_date']);
        // $this->db->order_by('time', 'desc');
        // $this->db->limit(2000);
        // $this->db->limit(10);
        $data = $this->db->get('resource_log');
        return $data->row_array();
    }
}

/* End of file Statistic_Model.php */
