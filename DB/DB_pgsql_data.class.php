<?php
ini_set('include_path', ".:".ini_get('include_path'));
ini_set('register_globals', 0);
ini_set('magic_quotes_gpc', 0);
ini_set("mbstring.internal_encoding","utf-8");
ini_set("memory_limit","-1");
ini_set("max_execution_time","-1");
ini_set("display_errors",0);

/*    
if (!get_magic_quotes_gpc()) 
  {
	$_REQUEST['sql'] = stripslashes($_REQUEST['sql']);
  }
*/

define('POSTGRESQL_DSN','pgsql://user:@localhost/database1');

class DB_pgsql_data
{
  var $case;
  function set_case($case)
  {
    $this->case = $case;
  }
  var $sql = null;
  function set_sql($sql)
  {
    $this->sql = $sql;
  }
  function get_sql()
  {
    return $this->sql;
  }
  var $result = array();

  
  private $common_conid;

  function do_connect()
  {
    require_once("DB.php");
    $this->common_conid = DB::connect(POSTGRESQL_DSN);
    if ( DB::isError($this->common_conid) )
      {
        die ($this->common_conid->getMessage());
      }
  }

  function do_query(){
	$result = $this->common_conid->getAll($this->sql,DB_FETCHMODE_ASSOC);
	//DB_FETCHMODE_ASSOC,DB_FETCHMODE_ORDERED
	if (DB::isError($result))
	  {
		die ($result->getDebugInfo($result));
	  }
	$this->result = $result;
  }
  function get_result()
  {
    return $this->result;
  }

   function __destruct() {
	 $this->common_conid->disconnect();
   }
}





if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) {

  //echo get_magic_quotes_gpc();        // 1
  $sql = "select 1;";

  $o = new DB_pgsql_data;
  $o->do_connect();
  $o->set_sql($sql);
  $o->do_query();
  $sql = $o->get_sql();
  $db_data = $o->get_result();
  print_r($db_data);

}