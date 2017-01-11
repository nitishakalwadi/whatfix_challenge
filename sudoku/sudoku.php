<?php

if( isset($argv[1]) ){
    $filename = $argv[1];
    $fp = fopen($filename, 'r');
    if( $fp ){
        while( !feof($fp) ){
            $line = trim(fgets($fp));
            $sudoku = [];
            $sudoku_transpose = [];
            
            if($line){
                $line_arr = explode(";", $line);
                
                $size = $line_arr[0];
                $block_size = sqrt($size);
                
                $data = $line_arr[1];
                $data_arr = explode(",", $data);
                
                $total_sum = 0;
                foreach( range(0,$size) as $val ){
                    $total_sum += $val;
                }
                
                //populate matrix and transpose of the matrix
                $i=0;$j=0;
                foreach($data_arr as $val){
                    $sudoku[$i][$j] = $val;
                    $sudoku_transpose[$j][$i] = $val;
                    $j++;
                    if($j == $size){
                        $j=0;
                        $i++;
                    }
                }
                
                $valid = true;
                //check unique values in rows and columns
                for($i=0; $i<$size; $i++){
                    //check if row is valid
                    $sudoku_row = $sudoku[$i];
                    if( array_sum(array_unique($sudoku_row)) != $total_sum ){
                        $valid = false;
                        break;
                    }
                    
                    //check if column is valid
                    $sudoku_column = $sudoku_transpose[$i];
                    if( array_sum(array_unique($sudoku_column)) != $total_sum ){
                        $valid = false;
                        break;
                    }
                }
                
                //skip next steps if valid flag is set to false
                if( !$valid ){
                    echo "False"."\r\n";
                    continue;
                }
                
                //create blocks of sqrt(size) size each
                $blocks = [];
                $zx = 0;    //x co-ordinate of block
                $zy = 0;    //y co-ordinate of block
                
                //fill each block
                for($i=0; $i<$size; $i++){
                    if($i%$block_size == 0){
                        $zx++;
                        $zy=0;
                    }
                    
                    for($j=0; $j<$size; $j++){
                        if($j%$block_size == 0){
                            $zy++;
                        }
                        
                        $blocks[$zx][$zy][] = $sudoku[$i][$j];
                    }
                    $zy = 0;
                }
                
                for($i=1; $i<=$block_size; $i++){
                    for($j=1; $j<=$block_size; $j++){
                        $single_block = $blocks[$i][$j];
                        if( array_sum(array_unique($single_block)) != $total_sum ){
                            $valid = false;
                            break;
                        }
                    }
                }
                
                echo ( $valid ? 'True' : 'False' ) ."\r\n";
                
            }
        }
    }
}
else{
    echo "No filename passed";
}

