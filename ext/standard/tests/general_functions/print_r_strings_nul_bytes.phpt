--TEST--
Test print_r() function with strings containing nul bytes
--INI--
precision=14
--FILE--
<?php

function check_printr( $variables ) {
    $counter = 1;
    foreach( $variables as $variable ) {
        echo "\n-- Iteration $counter --\n";
        print_r($variable, false);
        // $return=TRUE, print_r() will return its output, instead of printing it
        $ret_string = print_r($variable, true); //$ret_string captures the output
        echo "\n$ret_string\n";
        $counter++;
    }
}

$strings = [
  "\0",
  "abcd\x0n1234\x0005678\x0000efgh\xijkl", // strings with hexadecimal NULL
  "abcd\0efgh\0ijkl\x00mnop\x000qrst\00uvwx\0000yz", // strings with octal NULL
];

check_printr($strings);

?>
--EXPECT--
-- Iteration 1 --
 
 

-- Iteration 2 --
abcd n1234 05678 00efgh\xijkl
abcd n1234 05678 00efgh\xijkl

-- Iteration 3 --
abcd efgh ijkl mnop 0qrst uvwx 0yz
abcd efgh ijkl mnop 0qrst uvwx 0yz
