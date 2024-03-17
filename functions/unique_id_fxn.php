<?php

function unique_id()
{
   $str = implode('', range('a', 'z')) . implode('', range('A', 'Z')) . implode('', range(0, 9));
   $ran = array(); 
   $len = strlen($str) - 1; 

   // Loop to generate random characters
   for ($i = 0; $i < 65; $i++) {
      $n = mt_rand(0, $len); 
      $ran[] = $str[$n]; 
   }

   return implode($ran);
}
