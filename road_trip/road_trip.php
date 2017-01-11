<?php

if( isset($argv[1]) ){
    $filename = $argv[1];
    $fp = fopen($filename, 'r');
    if( $fp ){
        while( !feof($fp) ){
            $line = trim(fgets($fp));
            if($line){
                $cities_distance = [];
                $cities_distance_pairs_arr = explode(";", $line);
                foreach($cities_distance_pairs_arr as $city_distance_pair){
                    if( !empty($city_distance_pair) ){
                        $city_distance_pair_arr = explode(",", $city_distance_pair);
                        $cities_distance[] = $city_distance_pair_arr[1];
                    }
                }
                sort($cities_distance);
                
                $current_position = 0;
                $result = [];
                foreach($cities_distance as $city_distance){
                    $result[] = $city_distance - $current_position;
                    $current_position = $city_distance;
                }
                
                echo implode(',',$result)."\r\n";
            }
        }
    }
}
else{
    echo "No filename passed";
}