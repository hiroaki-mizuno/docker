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

// runkit_function_redefine("setDGF", '$key, $id = 0', 'return "MY_DG_CODE";');
// runkit_function_redefine("getDGF", '$key, $id = 0', 'return "MY_DG_CODE";');
// runkit_function_redefine("setDGB", '$key, $id = 0', 'return "MY_DG_CODE";');
// runkit_function_redefine("getDGB", '$key, $id = 0', 'return "MY_DG_CODE";');

require_once(LIB_PATH."/modules/login/class/Login.php");

class MyRCMSLoginChallenger extends RCMSLoginChallenger {
    public function challenge() {
        global $cn;

        // DB読込み(メンバーテーブルから認証)
        $strSQL =
                "select a.member_id, a.login_pwd as pass, a.login_pwd_md5 as hashed_pass, a.pass_salt, a.name1, a.name2, a.disp_name, a.email, a.nickname, a.api_key, a.force_chpwd, a.login_ok_ymd " .
                "from v_member_header a " .
                "where login_id = 'diverta' ";
        $result = selectQuery($cn, $strSQL);

        if ($row = getRow($result)) {

            RCMSUser::setLogin($row, $_REQUEST['login_save']);

            LoginHistory::write($cn, RCMSUser::getUser());
            $_SESSION["password_inputted"] = 1;
            return array(true, ($_REQUEST['login_save'] == 1));
        }
        return array(true, ($_REQUEST['login_save'] == 1));
    }
}