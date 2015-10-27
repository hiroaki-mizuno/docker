<?php

function dump(){
  header("Content-Type: text/plain");
  foreach(func_get_args() as $a){
    var_dump($a);
  }
  exit;
}

function mark($exit = false){
  $stack = debug_backtrace();
  $cur = $stack[0];
  $upper = $stack[1];
  echo sprintf("marked:%s:%s:%d\n", $cur["file"], $upper["function"], $cur["line"]);

  if($exit){
    exit;
  }

}

runkit_function_redefine("setDGF", '$key, $id = 0', 'return "MY_DG_CODE";');
runkit_function_redefine("getDGF", '$key, $id = 0', 'return "MY_DG_CODE";');
runkit_function_redefine("setDGB", '$key, $id = 0', 'return "MY_DG_CODE";');
runkit_function_redefine("getDGB", '$key, $id = 0', 'return "MY_DG_CODE";');
