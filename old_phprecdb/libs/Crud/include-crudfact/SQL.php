<?php /* SCRIPT DA INCLUDERE PER CONNESSIONI MYSQL con <? require_once("../include/config.php"); ?>*/
if(!isset($include_sql_php)): ?>
<?php
/***************************/
/***************************/
/*
$CONFIG["mysql_server"] = 0 ; // 0=ec.it   1=rev.it   2=eurosteve.net
$CONFIG["database"] = 3 ;     // se con numero finale, crea automaticamente nome db aruba
$CONFIG["log"] = "../logs/log_query.log" ; // percorso file di log ERRORI query (da proteggere), VUOTO => niente log
$CONFIG["nome_db_locale"] = "test"; //nome db se il sito gira in locale localhost/root
*/
/***************************/
/***************************/



//classe per elenco rows, se passi select 
class SQL
{
	var $result;
	//var $table;
	var $row;
	var $dbname;
	var $conn; //importo da fuori
	var $logfile;
	var $array_info_tabelle;
    var $SLOTS;
  //var $CODIFICA_UTF_BEFORE_OUTPUT;
	
	
	
	
  function __construct($_CONFIG )
	{
		$this->SQL($_CONFIG );
	}
	
  //array("host" => "localhost", "user" => "root", "pass" => "", "db" => "fanoinforma")
  
	function SQL($_CONFIG ) //function SQL($_CONFIG ) per PHP4
	{
	  /* $host == "" ? $GLOBALS['_CONFIG']['host'] : $host;
	  $user  == "" ? $GLOBALS['_CONFIG']['user'] : $user;
	  $password == "" ? $GLOBALS['_CONFIG']['pass'] :  $password;
	  $nomedb == "" ? $GLOBALS['_CONFIG']['db'] : $nomedb;*/
	  
	  //$this->CODIFICA_UTF_BEFORE_OUTPUT = false;

      $this->result = array();
	  $this->conn = @mysql_pconnect( $_CONFIG['host'],   $_CONFIG['user'],  $_CONFIG['pass']  ); 
      $this->dbname = $_CONFIG['db'];
      
      if (!$this->conn)
        $this->errore("Database non disponibile" );
      else
        mysql_select_db($this->dbname, $this->conn);
      //$this->logfile = "/var/www/vhosts/assurancebroker.it/httpdocs/tmp/sqlerrors.log";
      $this->SLOTS = array();
  }
  
  function codifica($s)
  {
    if (is_array($s))
    {
      $s = array_map("utf8_encode", $s);
      //$s = array_map("htmlentities", $s);
    }
    else
    {
      $s = utf8_encode($s);
      //$s = htmlentities($s);
    }      
    return $s;  
  }
  
  function set_log($lf)
  {
   	$this->logfile = $lf;
  }

 
  function query($query, $position=1) //salva result dentro la classe e lo d� in Return
	{
    	if (!is_int($position))
            exit("2nd par query must be int");


        //$this->SLOTS[$position]=1;

        if (!$this->conn)
    		{ $this->errore("Database non disponibile" ); return 0; }
    
    	//$query = mysql_escape_string($query);
		$this->result[$position] = mysql_query($query, $this->conn);
		if (!$this->result[$position])
		{
		  $this->errore( sprintf("[$%s][%s]", mysql_error(), $query ) );
		}
		return $this->result[$position];
	}

    function querySingle($query) //salva result dentro la classe e lo d� in Return
	{

        if (!$this->conn)
    		{ $this->errore("Database non disponibile" ); return 0; }

    	//$query = mysql_escape_string($query);
		$result = mysql_query($query, $this->conn);
		if (!$result)
		{
		  $this->errore( sprintf("[$%s][%s]", mysql_error(), $query ) );
		}
		return $result;
	}

    function mysql_error()
    {
        return mysql_error();
    }

    
    
	//non avanza puntatore interno. Se non passi wheres, considero $table come stringa
	function query_n_fetch($tableOrQuery, $wheres=0)
	{
		
	echo "--$tableOrQuery--";
        //check mistakes with query(), by checking 2nd parameter
		if (is_int($wheres) && $wheres>0)
        exit("secondo par di query_n_fetch must be array OR nothing ");

        if (!$this->conn)
    		{ $this->errore("Database non disponibile" ); return false; }
		//$query = mysql_escape_string($query);
		
		if ($wheres)
			$query = $this->makequerysel($tableOrQuery, $wheres);//print $query;
		else
			$query = $tableOrQuery;
		$result = mysql_query($query, $this->conn);
		if (!$result)
		{
		  $this->errore( sprintf("[$%s][%s]", mysql_error(), $query ) );
		}

		$row = mysql_fetch_assoc($result);
		return $row;
	}
	
	function fetch($position=1)//fetcha e salva in $this->row che Restistuisce. Poi usa get_col
	{
		return mysql_fetch_assoc($this->result[$position]);
	}
  
  
	//php4: togliere &
	function col($col, $tables, $wheres="", $q="") //passa nome_colonna, nome_tabella, array col=>values in $wheres
	{
		//print $q;
		if (!strpos($col, "(")!=false)
		  $col = "`".$col."`";
	    //
		if ( is_array($tables) )
	      $tables = implode("`, `", $tables);
	    //  
		$query = "SELECT ".$col." as csqlcolret FROM `".$tables."` ";
		
		//se passo array delle where ...
		if ( is_array($wheres) )
		{
			$wheres2 = array();
			foreach($wheres as $k => $v)
			  $wheres2[] = " `".$k."` = \"".str_replace('"', '\"', $v)."\" ";
			$query .= " WHERE ".implode(" AND ", $wheres2);  
		}
	    else
	    {
	      $query .= $wheres; 
	    }
		

		$q = $query;
    	//print $query ;
		$res = mysql_query($query, $this->conn);
		if (!$res) /**/ { $this->errore( mysql_error()." (".$query.")"); }
		
		$row = mysql_fetch_assoc($res);
		//$n = mysql_affected_rows($this->conn);
		//if ($n != 1)
    	//  $this->errore("Attenzione (".$query."): funzione col: affected rows = ".$n);
		//print "[$query]";
		@mysql_free_result($res);
		
	    //if ($this->CODIFICA_UTF_BEFORE_OUTPUT)
	    //  return $this->codifica($row['csqlcolret']);
	    //else  
      return $row['csqlcolret'];
	}
	
	function count_rows($tab)
	{
		$query = "SELECT COUNT(*) as csqlcolret FROM `".$tab."` ";
		$row = mysql_fetch_assoc( mysql_query($query, $this->conn) );
		return $row['csqlcolret'];
	}

	//funzione indipendente, nn usa il $result interno
	function arrayColsId($query, $col) // d� array con i valori delle righe relative alla colonna
	{
		$cols = array();
		$res = mysql_query($query, $this->conn);
		if (!$res) /**/ { $this->errore( mysql_error()." (".$query.")"); }
		
		while ($row = mysql_fetch_assoc($res))
		  $cols[$row['id']] = $row[$col];

    //if ($this->CODIFICA_UTF_BEFORE_OUTPUT)
    //  $cols = $this->codifica($cols);
      
		@mysql_free_result($res);
		return $cols;  
	}
  
  
  //cols_keys_from_ids("select id, nome from persone", "id", "nome") d� array 1=>elvis  3=>giulio dove 1,3 sono ids della tabella
	function cols_keys_from_ids($query, $chiave, $col) // d� coppie id->col
	{
		$cols = array();
		$res = mysql_query($query, $this->conn);
		if (!$res) /**/ { $this->errore( mysql_error()." (".$query.")"); }
		
		while ($row = mysql_fetch_assoc($res))
		  $cols[$row[$chiave]] = $row[$col]; // $cols[1] = "elvis"
		  
		@mysql_free_result($res);
		return $cols;  
	}

  // DA FARE : meglio chiamare la 
  
  
  
  function makequeryins($TABELLA, $ARRAY_CAMPI_VALORI, $IS_ARRAY_FROM_POST = true) //passa array id=>value
  {
      
   $q = "INSERT INTO `".$TABELLA."` ";
   $array_campi_ws = array();
   $array_valori_ws = array();
   $i=0;
   
   
   foreach($ARRAY_CAMPI_VALORI as $campo => $value) // es: nome => Elvis
   {
         //CAMPI (KIAVI)
         $array_campi_ws[] = "`".$campo."`"; //con carattere speciale mysql
         
         ///VALORI
         //value con eventuale strip
          $value = ($IS_ARRAY_FROM_POST && get_magic_quotes_gpc()) ? stripslashes( $value) : $value; 
          $value = $this->escape($value);  
         $array_valori_ws[] = "'".$value."'";
     }       
     $q .= "(".implode(", ", $array_campi_ws).") VALUES ( ".implode(", ", $array_valori_ws)." ) ";
		 
     return $q;
  }
  
  
  function makequeryinsold($table, $campi_values) //passa array id=>value
  {
  		//print_r($campi_values);
		$campi = array();
		foreach($campi_values as $k => $v)
		  $campi[] = " `".$k."` ";
		//print_r($campi);
		
		$values = array();
		foreach($campi_values as $k => $v)
		  $values[] = " \"".str_replace('"', '\"', $v)."\" ";
		//print_r($values);
		
		$q = "INSERT INTO `".$table."` (".implode(", ", $campi).") VALUES (".implode(", ", $values).") ";
		return $q;
  }
  
  
  
  
  function makequeryupd($table, $campi_values, $id, $idval) //passa array id=>value e chiave, val
  {
  		//print_r($campi_values);
		$campi_values2 = array();
		foreach($campi_values as $k => $v)
		  $campi_values2[] = " `".$k."` = \"".str_replace('"', '\"', $v)."\" ";

		$q = "UPDATE `".$table."` SET ".implode(", ", $campi_values2)." WHERE `".$id."` = \"".$idval."\" LIMIT 1 ";
		return $q;
  }
  
  
  //select * from $table where key1=value1 AND key2=value2
  function makequerysel($table, $wheres=1) //passa array id=>value
  {
  	
   $query = "SELECT * FROM `".$table."` ";
		
		//se passo array delle where ...
		if ( is_array($wheres) )
		{
			$wheres2 = array();
			foreach($wheres as $k => $v)
			  $wheres2[] = " `".$k."` = \"".str_replace('"', '\"', $v)."\" ";
			$query .= " WHERE ".implode(" AND ", $wheres2);  
		}
    return $query;
  }
  
  
  
  
  function get_fields($position=1)
  {
    $campi = array();
    $nc = mysql_num_fields($this->result[$position]);
    for( $i=0; $i < $nc ;$i++)
    {
       $meta = mysql_fetch_field($this->result[$position]);
       $campi[] =  $meta->name;
    }
    return $campi;
  }
  
	
  function get_last_id() //mysql_insert_id($this->conn);
  {
    return mysql_insert_id($this->conn);
  }
  
  function get_ar() //mysql_affected_rows($this->conn); 
  {
    return mysql_affected_rows($this->conn); 
  }
  
  function escape($string)
  {
    return mysql_real_escape_string($string, $this->conn);
  }
  
  
  function array_struttura_tabella($tabella, &$chiave) //array superglobale con [nomecampo] => [type][len][flags][comment][default]
  {
      //if ($tabella=="")
     //  { print "passa tabella in parametro !<p>"; return ( $this->array_tabelle() ); }
      
      $chiave="";
      $campi = mysql_list_fields($this->dbname, $tabella, $this->conn);
	  
      $num_fields = mysql_num_fields($campi);
      $campi_ar = array();
      for ($i = 0; $i < $num_fields; $i++)
      {
          $ar_desc_colonna = array(
                                    "type" => mysql_field_type($campi, $i),
                                    "len"  => mysql_field_len($campi, $i),
                                    "flags"=> mysql_field_flags($campi, $i),
                                    //"comment" => "", //disattivo TEMP, per dtmconf !!!
                                    "default" => ""
                                  );
          $campi_ar[mysql_field_name($campi, $i)] = $ar_desc_colonna;
          if (strstr(mysql_field_flags($campi, $i), "primary_key"))
            $chiave = mysql_field_name($campi, $i); 
            
      }
      
      
      //aggiungo info sui campi
      $res = mysql_query ("SHOW FULL COLUMNS FROM ".$tabella, $this->conn);
      while ( $row = mysql_fetch_assoc( $res ) )
        if (array_key_exists ( $row['Field'], $campi_ar))    
        {
          //$campi_ar[$row['Field']]["comment"] = $row['Comment'];//disattivo TEMP, per dtmconf !!!
          $campi_ar[$row['Field']]["default"] = $row['Default'];
        }
      
      
      return $campi_ar;
  }
  


  
  
  function get_array_tabelle() //mette nomi tabelle in array
  {
    //elenco tabelle
    $result = mysql_list_tables($this->dbname);
    $tabelle = array();
    while ($row = mysql_fetch_array($result))
      $tabelle[] = $row[0];
    return $tabelle;  
  
  }
  
  //stampa errore e tabelle/campi, poi scrive in log, 
  //se la usano utenti, manda mail ad admin o segna in log
  function errore($s="") 
  {
    if (   stristr( $s, "duplicate entry" ) != false   )
		$dupli = "campo ripetuto. ";
	
	
	print "<h4 style=\"color:#FF0000\">ERRORE QUERY DATABASE: $dupli</h4>$s<br />";

    //mail("elvisciotti@gmail.com","errore sql pr", $s  );
	
    //print "<pre>"; print_r($this->array_struttura_tabella()); print "</pre>";
    if  ($s != "" && $this->logfile)
    {
      $file = fopen($this->logfile, "a");
      fwrite($file, date("ymd-G:i:s")." (IP=".$GLOBALS['REMOTE_ADDR'].") : ".$s."\n");
      fclose($file);
    }
  }
  
	function free($p=1)
	{
		@mysql_free_result($this->result[$p]);
	}
	
	function get_nr($p=1)
	{
		return mysql_num_rows($this->result[$p]);
	}

    function last_id($p=1)
    {
        return mysql_insert_id();
    }

}


/*

*/




?><?php
//$sql = new SQL( array("host" => "localhost", "user" => "root", "pass" => "", "db" => "fanoinforma")  );
//print $sql->makequeryins("tab", array("id"=> 3, "testo" => 'ciao l"aquila'));

//ENDIF
$include_sql_php = 1;  //dichiara var, cos� non lo includi +
endif; ?>