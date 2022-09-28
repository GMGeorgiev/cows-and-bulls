<?php

function ruleOne(int $elementA, array $arrayB){
  $result = false;
  if(($elementA == 1 || $elementA == 8) && (in_array(1, $arrayB) || in_array(8, $arrayB))){
    $result = true;
  }
  return $result;
}

function ruleTwo (int $digit, int $pos){
  $result = false;
  if (($digit == 4 || $digit == 5) && $pos % 2 == 0 ) {
    $result = true;
  }
  return $result;
}

function generate_num(){
  $digits = [0,1,2,3,4,5,6,7,8,9];
  shuffle($digits);
  $randomizedArray = array();
  $i = 0;
  $j = 0;
  while(count($randomizedArray) < 4){
    if(ruleOne($digits[$i], $randomizedArray)){
            $pos = null;
            if(in_array(1, $randomizedArray)){
              $pos =  array_search(1, $randomizedArray);
            } else { 
              $pos =  array_search(8, $randomizedArray);
            }
            array_splice($randomizedArray, $pos, 0, $digits[$i]);
    } else if (ruleTwo($digits[$i], $i)) {
      $i++;
      continue;
    } else {
        $randomizedArray[$j] = $digits[$i];
        $j++;
    }
    $i++;
  }
  return $randomizedArray;
}

function getCulls($userInput, $generatedArray){
  $culls = ['bulls'=>0, 'cows'=>0];
  $userInput = str_split($userInput);
    for($j = 0; $j < count($userInput); $j++){
      if(in_array($userInput[$j], $generatedArray)){
        if(array_search($userInput[$j], $generatedArray) == $j){
          $culls['bulls'] ++;
        }else {
          $culls['cows'] ++;
        }
      }
    }
  return $culls;
}
