<?

/*if ($REMOTE_ADDR=="127.0.0.1")
{
  $bsp = $DTMCONF["dtmconf"]["upload"]["baseSitePath"] = "E:/SITI/farmacia_monastero/";
  $bsu = $DTMCONF["dtmconf"]["upload"]["baseSiteUrl"] = "http://localhost:8080/SITI/farmacia_monastero/";
}
else
{*/
 ///web/htdocs/www.farmaciamonastero.it/home/

  $bsp = $DTMCONF["dtmconf"]["upload"]["baseSitePath"] = $_SERVER['DOCUMENT_ROOT']."/band db 2/concertdb/recdb/" ;
  $bsu = $DTMCONF["dtmconf"]["upload"]["baseSiteUrl"] = $_SERVER['DOCUMENT_ROOT']."/band db 2/concertdb/recdb/" ;
//}



$DTMCONF["dtmconf"]["upload"]["uploadPath"] = $bsp."screenshots/"; //slash finale !!!!
$DTMCONF["dtmconf"]["upload"]["uploadUrl"] = $bsu."screenshots/"; //slash finale !!!!
$DTMCONF["dtmconf"]["upload"]["table"] = "uploads";  //tabella (vedi fanoinforma.uploads)

$DTMCONF["dtmconf"]["upload"]["dtmUrl"] = $bsu."include/dtm/";
$DTMCONF["dtmconf"]["js"]["ajax"] = $bsu."include/dtm/ajax.js";
$DTMCONF["dtmconf"]["js"]["cal2"] = $bsu."include/dtm/cal2.js";
       

$DTMCONF["dtmconf"]["upload"]["formati"] = array(
								"800" =>   array("c" => "800",  "q" => "90"), //anteprime rubriche
								"400" =>    array("c" => "400",  "q" => "85"),
								"300" =>  array("c" => "300",  "q" => "85") ,
								"200" =>  array("c" => "200",  "q" => "85") ,
								"100" =>  array("c" => "100",  "q" => "80") ,
								"1024" =>   array("c" => "1024",  "q" => "85", "ifgtonly" => true)  	);
          


//$DTMCONF["utenti"]['nome']['rename'] = "mostra ai clienti registrati";



if (0)
{

          $bsp = $DTMCONF["dtmconf"]["upload"]["baseSitePath"] = "/var/www/vhosts/[TODO].it/httpdocs/";
          $bsu = $DTMCONF["dtmconf"]["upload"]["baseSiteUrl"] = "http://www.[TODO].it/";



          if ($_SESSION['config_archivio'] == "collab" || $CONFIG_ARCHIVIO == "collab")
          {
            $DTMCONF["dtmconf"]["upload"]["uploadPath"] = $bsp."documenti_collaboratori/"; //slash finale !!!!
            $DTMCONF["dtmconf"]["upload"]["uploadUrl"] = $bsu."documenti_collaboratori/"; //slash finale !!!!
            $DTMCONF["dtmconf"]["upload"]["table"] = "documenti_collaboratori"; 

          }

          if ($_SESSION['config_archivio'] == "clienti" || $CONFIG_ARCHIVIO == "clienti")
          {
            $DTMCONF["dtmconf"]["upload"]["uploadPath"] = $bsp."documenti_clienti/"; //slash finale !!!!
            $DTMCONF["dtmconf"]["upload"]["uploadUrl"] = $bsu."documenti_clienti/"; //slash finale !!!!
            $DTMCONF["dtmconf"]["upload"]["table"] = "documenti_clienti";
          }

          $DTMCONF["dtmconf"]["upload"]["dtmUrl"] = $bsu."include/dtm/";
           //configurazione javascript/css
          
            
}

?>
