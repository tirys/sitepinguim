<?php	
  /// DADOS DE ACESSO AO SERVIDOR MySQL LOCALHOST
  $host_db = "localhost";
  $user_db = "root";
  $pass_db = "";
  $my_db   = "prospectacms";
	
  /// REALIZA A CONEXÃO
  $conect = mysql_connect($host_db,$user_db ,$pass_db);
            mysql_select_db($my_db, $conect);
?>
