<?php
function bit_format($size, $decimals = 0){
        // funtion untuk mengkonversi data menjadi bit / second
        $unit = array(
        '0' => 'bps',
        '1' => 'kbps',
        '2' => 'Mbps',
        '3' => 'Gbps',
        '4' => 'Tbps',
        '5' => 'Pbps',
        '6' => 'Ebps',
        '7' => 'Zbps',
        '8' => 'Ybps'
        );
        
        for($i = 0; $size >= 1000 && $i <= count($unit); $i++){
        $size = $size/1000;
        }
        
        return round($size, $decimals).' '.$unit[$i];
    }
    ?>