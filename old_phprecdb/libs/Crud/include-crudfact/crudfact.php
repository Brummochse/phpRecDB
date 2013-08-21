<?

//DAFARE
// quando un campo è 'hide', in post devi resettare il valore, altrimenti è insicuro
// (es: un non-admin può postare il campo 'livello' modificndo la pagina localmente)
// - check se hide e altra cosa => conflittoe"
//-lunghezza minima campo javacript+server
//validazione javascript email (stessa di server)
//ORDER BY
// -


$DTM_OPTIONS = array();


if (0) {
/*STARTDOC*/
/*
COME FUNZIONA
istanzia un oggetto di questa classe PER OGNI tabella ! puoi usarne pi� istanze nella stessa pagina
se not_null viene richiesto in posting, anche con javascript
se auto_increment, viene calcolato un valore automatico x nuovo inserimento
ci vuole almeno una chiave primaria, anche testualem usa ID per evitare problemi
*/


/*FILE UPLOAD !!*/



  $CRUDCONF['clienti']['elenco_societa']['upload'] = true;
  //non mostra archivio files
  $CRUDCONF['clienti']['elenco_societa']['upload']['no_archive'] = true;

  //configurare anche
  //configurazione upload
  $bsp = $CRUDCONF["CRUDCONF"]['upload']["baseSitePath"] = "/var/www/vhosts/assurancebroker.it/httpdocs/";
  $bsu = $CRUDCONF["CRUDCONF"]['upload']["baseSiteUrl"] = "http://www.assurancebroker.it/";
  $CRUDCONF["CRUDCONF"]['upload']["uploadPath"] = $bsp."documenti_clienti/"; //slash finale !!!!
  $CRUDCONF["CRUDCONF"]['upload']["uploadUrl"] = $bsu."documenti_clienti/"; //slash finale !!!!
  $CRUDCONF["CRUDCONF"]['upload']["table"] = "documenti_clienti";  //tabella (vedi fanoinforma.uploads)
  $CRUDCONF["CRUDCONF"]['upload']["dtmUrl"] = $bsu."include/dtm/";


///new
//campo di conferma con controllo in posting
 $CRUDCONF['<NomeTab>']['<nomeCampo>']["conferma"]=true;


/*piccole personalizazioni*/
  //rimpiazza virgole con punti,in qualsiasi tipo di campo
  $CRUDCONF['clienti']['elenco_societa']["comma_replace"] = true;
  $CRUDCONF['clienti']['testo']["oldval"] = "testo che verr&agrave; inserito di default in INSERT";

/*funzioni personalizzate di stampa cella o campo form*/
  /*RENAME */
  //scrive "inserisci ciao" invece del nome del campo prima di stampare il campo nel form
  $CRUDCONF['<NomeTab>']['<nomeCampo>']['rename'] = 'nuovo nome per il campo';
  $CRUDCONF['<NomeTab>']['<nomeCampo>']['rename_table_only'] = 'nuovo nome per il campo';

  //stampa tabella: chiama una funzione(in input l'id della cella) personalizzata che stampa la cella
  $CRUDCONF['clienti']['elenco_societa']["cell_table_func"] = "stampaes";
  function stampaes($row)
  {
    //print $value;

    $sql = $GLOBALS['sql'];
      $rp = $sql->query_n_fetch("select * from tab2
      WHERE
      thistab.id = '".$r['id']."'",3);
      $sql->query("...",3);
      while ($r = $sql->fetch(3))
      {
          print $r['col'];
      }
      //oppure


      //print_r($rp);
    //query con altra roa su riga con id=$id
  }

  //stampa tabella: chiama una funzione(in input l'id della cella) personalizzata che stampa la cella
  $CRUDCONF['clienti']['elenco_societa']["form_func"] = "stampaesedit";



/*select sul valore*/
  
  //// nn crea input, ma la select di n righe, chiave, campo from tabella , poi <option value=$chiave>$nome</option> 
  //il campo corrente importa la chiave primaria da tabella.chiave, il cui nome (mostrato in select) � tabella.nome
  $CRUDCONF['<NomeTab>']['<nomeCampo>']["importa_select2"] = array("tabella" => "t", "campo" => "nome", "chiave" => "id");
  //come sopra ma crea la select singola senza personalizzazione campo a sx
  $CRUDCONF['<NomeTab>']['<nomeCampo>']["import_values"] = array("tabella" => "t", "campo" => "nome", "chiave" => "id", /*filtra elenco select*/ "suffisso_query"=>" WHERE mostra=1");
  //per creare categoria a N livelli
  $CRUDCONF['<NomeTab>']['<nomeCampo>']["importa_select_hierchical"] = array("tabella" => "t", "campo" => "nome", "chiave" => "id", "chiave_ricorsiva"=>"id_tabella");

  $CRUDCONF['<NomeTab>']['<nomeCampo>']["radio"] = array(1 => "si", 0 => "no");
  //mette select a fianco con valori esistenti
  $CRUDCONF['<NomeTab>']['<nomeCampo>']["select"] = true;
  //presi in automatico il campo dalla tabella
  $CRUDCONF['<NomeTab>']['<nomeCampo>']["select"]["query"] = "select nomecampo from nometab order by 1 desc"; 
  $CRUDCONF['<NomeTab>']['<nomeCampo>']["select"]["size"] = 0;
  $CRUDCONF['<NomeTab>']['<nomeCampo>']["select"]["fontsize"] = 0;
  $CRUDCONF['<NomeTab>']['<nomeCampo>']["select"]["textinto"] = 0;
  
  $CRUDCONF['<NomeTab>']['<nomeCampo>']['select-items'] = array(1 => "Amministratore", 2 => "2-Redattore", 4 => "4-giornalista", "3" => "3-giornalista rubrica" );
  $CRUDCONF['<NomeTab>']['<nomeCampo>']['select-items'] = array(1 => "si", 0 => "no");
  $CRUDCONF['<NomeTab>']['<nomeCampo>']['select-items'] = array("Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre");
  
  
  $CRUDCONF['prodotti']['mostra']['select-items'] = array(/*...*/);
  //mostra la select anche sulla tabella di stampa, SOLO per SELECT al momento
  $CRUDCONF['prodotti']['mostra']['change_in_table'] = true;

  
  //stampa select con query personalizzata (opt e val), variabile DA INSTANZIARE PRIMA di oggetto DTM ! import references
  $CRUDCONF['<NomeTab>']['<nomeCampo>']['query_select']['q'] = "select sottocategoria as opt, sottocategoria as val from categorie where categoria=1";
   // es: "select id as opt, CONCAT(`cognome`,' ',`nome`,'(',`username`,')') as val from clienti ORDER BY cognome, nome";



//controlla mail quando posti form
$CRUDCONF['<NomeTab>']['<nomeCampo>']['check_mail']  = true;
$CRUDCONF['<NomeTab>']['<nomeCampo>']['range']  = array("min"=>0, "max"=>100); //es: percentuale
$CRUDCONF['<NomeTab>']['<nomeCampo>']['rangelen']  = array("min"=>0, "max"=>100); //es: percentuale



//altezza larghezza textarea
$CRUDCONF['<NomeTab>']['<nomeCampo>']["rows"] = 15;
$CRUDCONF['<NomeTab>']['<nomeCampo>']["cols"] = 50;

$CRUDCONF['<NomeTab>']['<nomeCampo>']["text"] = "testo ke verr&agrave; scritto dopo campo (<br>>span class=desc></span>";
$CRUDCONF['<NomeTab>']['<nomeCampo>']["suffisso"] = "testo ke verr&agrave; scritto SUBITO dopo il campo nel form di input";
$CRUDCONF['<NomeTab>']['<nomeCampo>']["suffisso"] = " <b>%</b>"; //percentuali
$CRUDCONF['<NomeTab>']['<nomeCampo>']["suffisso"] = " <b>&euro;</b>"; //euri

//aggiunge controllo di inserimento mail valida (se il campo � not null)
$CRUDCONF['<NomeTab>']['<nomeCampo>']["check_mail"] = true; //controllo mail in posting

//per inserire il valore cifrato della password (es: pippo) scrivi md5:pippo
$CRUDCONF['<NomeTab>']['<nomeCampo>']['md5_pass'] = true;
//$CRUDCONF['<NomeTab>']['<nomeCampo>']['text'] = "per inserire il valore cifrato della password inserita (es: pippo) scrivi md5:pippo";



//stampa plugin calendario per scelta data. metti cal2.js in ../include
//$CRUDCONF['<NomeTab>']['<nomeCampo>']["cal"] = true; //STAMPA Calendario con sola data
$CRUDCONF['<NomeTab>']['<nomeCampo>']["cal"]["timestamp"] = true; //per calendario timestamp. Questo implica il precedente
$CRUDCONF['<NomeTab>']['<nomeCampo>']["cal"]["notimestamp"]= true; //solo Ymd, no H:i

//spiega come inserire, stampato dopo l'input del campo nel form
$CRUDCONF['<NomeTab>']['<nomeCampo>']["text"] = "es: 2007-12-31 17:58"; 


$CRUDCONF['<NomeTab>']['<nomeCampo>']["fulltext"] = true; 
$CRUDCONF['<NomeTab>']['<nomeCampo>']["limit"] = 250; //limita stampa campo in stampa_tabella() a 250 chars (dopo htmlentities) 


/*attiva fck editor, se non vuoi opzioni, $CRUDCONF['<NomeTab>']['<nomeCampo>']["fck"] = true;
Ai campi string e blob applicaci htmlentities quando si stampano su pagina web e in campi
personalizza con direcytory assoluta (ricava con pwd) per upload files
la dir parte GIA' da home del server, poi dagli 777
..\include\fckeditor\editor\filemanager\connectors\php\config.php
oppure riga qua dentro
$oFCKeditor->Config['UserFilesPath'] = "/img/upload"; 
personalizza anche ..\include\fckeditor\fckconfig.js con toolbars*/
$CRUDCONF['<NomeTab>']['<nomeCampo>']["fck"]  = array(); //facoltativo se ci sono quelli dopo
$CRUDCONF['<NomeTab>']['<nomeCampo>']["fck"]["w"]  = 600;
$CRUDCONF['<NomeTab>']['<nomeCampo>']["fck"]["h"]  = 500;
$CRUDCONF['<NomeTab>']['<nomeCampo>']["fck"]["toolbar"] = "personal";

//non mostra  NEL form (in insert prende default value, in update lascia valore preced)
$CRUDCONF['<NomeTab>']['<nomeCampo>']["hide"] = true;
//non mostra NELLA tabella
$CRUDCONF['<NomeTab>']['<nomeCampo>']["hide_tab"] = true;


//outdated
$CRUDCONF['<NomeTab>']['<nomeCampo>']["hide_form_only"] = true;
$CRUDCONF['<NomeTab>']['<nomeCampo>']["hide_table_only"] = true;



//in modalit� update, i campi TIMESTAMP sono riempiti NOn con vechio valore ma con data aggiornata
$CRUDCONF['<NomeTab>']['<nomeCampo>']["update_always_data"] = true;

//In insert setta questo valore fisso input type=hidden. In update lo mantiene hidden (come not_show, rimane lo stesso)
// da usare se una tabella va popolata da due pagine diverse (in sto caso fixali a valori diversi)
$CRUDCONF['<NomeTab>']['categoria']['fixedhiddenvalue'] = 1;

//imposta valore dafault
$CRUDCONF['<NomeTab>']['anno']['default'] = date("Y");

//configurazione geenrale dtm
 //labels pulsanti
 $CRUDCONF['<NomeTab>']["CRUDCONF"]['labelsubmit'] = array( "ins" => "salva bozza articolo", "upd" => "modifica bozza articolo");


//In insert, riempi il campo con la time()
$CRUDCONF['<NomeTab>']['time']["time"] = true;


//come effettuare readonly
$D['name']['form_func'] = "areaspopupnamef"; //form_func (table_func)
function areaspopupnamef($r) { print $r['name']; }

/*poco usati || obsoleti*/
  //il campo viene settato HIDDEN con value = cookie[username]
  $CRUDCONF['<NomeTab>']['<nomeCampo>']['from_cookie"'] = "nomecookie";
  //non stampa la riga del campo nel form, (prendo default in insert, non toccato in update. Se � chiave needs auto_increment !!)

  //meglio nn usare in nuova lib
  $CRUDCONF['<NomeTab>']['<nomeCampo>']['automatic'] = true;
  $CRUDCONF['<NomeTab>']['hide'] = array("id","timestamp"); // non stampa colonne in stampa_tabella() (non influenza genera_form()

  
  $CRUDCONF['<NomeTab>']['time']["time"] = true;

/*ENDDOC*/
}

//unset( $CRUDCONF['<NomeTab>'] )
?>

<?

Class CRUDFACT
{
    var $TABELLA;
    var $SQL; // devi includere sql.php PRIMA! con require_once("include/SQL.php");
    
    //usate in modulo insert/edit
    var $AST;
	  var $CRUDCONF;
	  var $DTM_GLOBAL_CONF;
    var $input_max_lenght;
    var $SCRIPT_RICHIAMANTE;
    var $UPDATE;
    var $INSERT;
    var $INSERT_FORM;
    //var $fck_path;
	
    //usate in ricezione dati, quindi query insert/edit
    var $CHIAVE; //nome del campo con la chiave (id), serve per capire la chiave quando inserisco/edito
    var $chiave_get; //valore della chiave passato in get nelle modifiche, serve per capire la chiave quando inserisco/edito
    var $TABLE_VALGET;
    var $POST;
    var $GET;
    var $files;
    var $elenco_errori; //inseriti dalle varie operazioni, un inserimento ad ogni caricamento pagina, quindi nn serve azzerarlo
    //var $MULTIPART_FORM;
    //var $MULTIPART_NECESSARIO;
    
    var $NOMEFORM;
	
	  var $LAST_QUERY;
    var $REFERER; 
	  var $SCRIPT_CAL_INSERTED;
    
    var $OLD_ROW;
    var $POPUP_MODE;
    var $NOREDIRECT;
	 // var $DECODIFICA_UTF_BEFORE_INSERT;
	
	//var $CAMPI_FORCE_INSERT;
	
	
    /********************/
    /*   CONSTRUCTOR    */
    /********************/
    function dynamic_manage($oggetto_SQL, $tab, $CRUDCONF = array() ) //function dynamic_manage($oggetto_SQL, $tab)
    {
          //$this->DECODIFICA_UTF_BEFORE_INSERT = false;
          
          
          if (isset ($GLOBALS["_GET"]) && isset($GLOBALS["_GET"]["imgdel"]))
          {
            unlink($GLOBALS["_GET"]["imgdel"]);
            unlink($GLOBALS["_GET"]["imgdel2"]);
          }  

          
           $this->SQL = $oggetto_SQL;
           $this->CHIAVE="";
           //chiave settata per riferimento
           //salvo tabella in campo $tab
           $this->TABELLA = $tab;
           $this->AST = $this->SQL->array_struttura_tabella($tab /*$this->TABELLA*/, $this->CHIAVE /*SCRIVO QUA*/);
           //conf tabella
           if (isset ($CRUDCONF[$tab])) $this->CRUDCONF = $CRUDCONF[$tab]; 
           if (isset ($CRUDCONF["CRUDCONF"])) $this->DTM_GLOBAL_CONF = $CRUDCONF["CRUDCONF"]; 
            
            
            


          //VARIABILI DERIVATE SCORCIATOIA
           $this->POST = $GLOBALS['_POST'];
           $this->GET = $GLOBALS['_GET']; 
           $this->files = $GLOBALS['_FILES'];
           
           $this->SCRIPT_RICHIAMANTE = basename($GLOBALS['_SERVER']['PHP_SELF']); //."?".$GLOBALS['_SERVER']['QUERY_STRING'];
           $this->REFERER = $this->POST ? $this->POST["_dtm_referer_"] : $GLOBALS['_SERVER']['HTTP_REFERER'];
           
           
           //es: p.php?id=45 => chave="id" chiave_get=45
           
           $this->TABLE_VALGET = isset ($GLOBALS['_GET']["table"])?$GLOBALS['_GET']["table"]:$tab;
           
           $this->NOMEFORM = "form_".$this->TABELLA;
            if (isset ($CRUDCONF['popup_mode'])) $this->POPUP_MODE = $CRUDCONF['popup_mode'];
           
           //setto la modalit� UPDATE set la chiave � passata in get o ricevo campi in post per l'update
           $this->UPDATE = 0;
           if (isset ($this->POST["_dtm_mode_"]) && $this->POST["_dtm_mode_"] == "UPD"  )
            $this->UPDATE = 1;
           
           //setto la modalit� INSERT in RICEZIONE se la chiave � passata in POST

           $this->INSERT = 0;
           if (/*$this->POST[$this->CHIAVE] &&*/ isset ($this->POST["_dtm_mode_"]) && $this->POST["_dtm_mode_"]=="INS")
            $this->INSERT = 1;
				
					 $this->INSERT_FORM = isset($this->GET["insert"]) ? 1:0;
					 
           //VArIABILI SETTATE A VALORE FISSO DEFAULT
           $this->input_max_lenght = 55; //massima lunghezza dei campi di testo string nel form
           //$this->fck_path = "../include/fckeditor/"; //con slash finale    
           $this->elenco_errori = array(); //frsoe nn serve
           $this->SCRIPT_CAL_INSERTED = false;
              
              
           //attivo cancellazione simulando POSTING, se ne occuper� scrivi_record()
           if (isset($this->GET['cancella']) && $this->GET[$this->CHIAVE])
            {
              $this->POST["_dtm_cancella_record_"] = "cancella";
              $this->POST[$this->CHIAVE] = $this->GET[$this->CHIAVE];
              $this->POST["_dtm_table_"] = $this->TABELLA; //altrimenti esce
              //$this->afterDelete();
              $this->scrivi_record();
              
              
            }
            //se ricevo dati in post validi (e per l'oggetto di questa classe corrente), chiamo la funzione di scrittura    
            else if (/*$this->POST[$this->CHIAVE] &&*/ isset ($this->POST["_dtm_mode_"]) && $this->POST["_dtm_mode_"] && $this->POST['_dtm_table_']==$tab)
            {
                //$this->TABELLA = $GLOBALS['_GET']['table'];
                $this->scrivi_record(); //f� la query se ci sono dati in post
            }  


            
		   
    }/*******************************************************************/
    function afterDelete()
    {
        /* cancella i record dipendenti che importano questo record
         * l'id lo prendi da $_POST['id']
         if ($this->GET['cancella'] && $this->GET[$this->CHIAVE])
		{
		  $TABELLA_CHILD = "models_subareas";
          $NAME_COL_KEY = "id_models";
         $q = "DELETE FROM models_subareas
           WHERE id_models = '".$this->POST['id']."'";
		   ?><script language="javascript">alert('<?=$q?>')</script><?
		   $this->SQL->query($q );
		}
         */
    }


    //per php5
    function __construct($oggetto_SQL, $tab, $CRUDCONF = array())
    {
      $this->dynamic_manage($oggetto_SQL, $tab, $CRUDCONF);
    }
   
   
    
    /**********************************************************/
    /**********************************************************/
    /**********************************************************/
    /*******   ESECUZIONE INSERT/EDIT RICEVENDO POSTING  ******/
    /**********************************************************/
    /**********************************************************/
    /**********************************************************/
    function scrivi_record()
    {
      
      //la tabella da usare in posting � quella che ha fatto il post
      $this->TABELLA = $this->POST["_dtm_table_"];
      
      //chiamo la funzione che controlla i tipi
      if ( $this->POST["_dtm_cancella_record_"] != "cancella" && $this->controllo_inputs() ) return; // errori => inutile continuare, modulo
          
      $bf = $this->before_insert();
        
      
      //caso DELETE
		  if ($this->POST["_dtm_cancella_record_"] == "cancella")
		  {  
			 $this->afterDelete();
              $q = 'DELETE FROM `'.$this->TABELLA.'` WHERE `'.$this->CHIAVE.'` = "'.$this->POST[$this->CHIAVE].'" LIMIT 1';
			  $this->GET['cancella']=0;
        $GLOBALS['GET']['cancella']=0; //teoricamente nn serve o potrebbe essere pericoloso
        //print "Cancellazione record [$q]";
		  } 
		  //caso UPDATE
		  else if ($this->UPDATE) 
      {
             $q = "UPDATE `".$this->TABELLA."` SET ";
             
             $array_modifiche = array();
             foreach($this->POST as $campo => $value)
             {
                 if ($campo != $this->CHIAVE &&  strncmp($campo,"_dtm_", 5)!=0 &&  ( !$this->CRUDCONF[$campo]['md5_pass'] || $value )  )
                 {
                      $value = (get_magic_quotes_gpc()) ? stripslashes( $value) : $value; 
                      //conversione virgole in punti. ESEGUITA ANCHE SOTTO
                      if (($this->AST[$campo]['type']=="real" && strpos($value, ",")!=false) || $this->CRUDCONF[$campo]['comma_replace'])
                        $value = str_replace(",",".",  $value);
                      //

                      //cifratura pass. ESEGUITA ANCHE SOTTO
                      if ( $value && $this->CRUDCONF[$campo]['md5_pass']	/*&& strtolower(substr($value, 0, 4)) == "md5:"*/  )
                      {
                        $value = md5(	$value );
                      }	
				
                      $value = $this->SQL->escape($value);
                      
                      //aggiungo se non � password, oppure ha un valore (altrimenti � password vuota !)
                      //if ( !$this->CRUDCONF[$campo]['md5_pass'] || $value)
                      $array_modifiche[] = "`".$campo."` = '". $value."'";
                  }    
  
             }
             
             $q .= implode(", ", $array_modifiche);
             $q .= " WHERE ".$this->CHIAVE." = '".$this->POST[$this->CHIAVE]."' LIMIT 1"; //limit=1 evita che la where sia errata e modifichi tutto
      }
  //CASO INSERT
      else if ($this->INSERT) // insert
      {
             $q = "INSERT INTO `".$this->TABELLA."` ";
             //array con campi e valori da inserire
             $array_campi = array();
             $array_valori = array();
			 
			//print_r($this->DTM_GLOBAL_CONF['campiForcePostRead'] ); //temp
			 
             $i=0;
             foreach($this->POST as $campo => $value) // es: nome => Elvis
             {
               
							  //last
							 $GLOBALS['_SESSION']['LAST'][$this->TABELLA][$campo] = $value;
							 
							 // if ($this->DTM_GLOBAL_CONF['campiForcePostRead'])
               //$isForced = in_array( $campo, $this->DTM_GLOBAL_CONF['campiForcePostRead'] );
               //print $campo.":";//temp
               //print $isForced?"forzato":"non forzato";//temp
               //SALTO I VALORI post che iniziano con _dtm_ (nn sono campi tabella !)
               //DAFARE versioni successive: prova con isset($value), cos� prende gli zero
               if (  isset($value) && strncmp($campo,"_dtm_", 5)!=0  &&  ( !$this->CRUDCONF[$campo]['md5_pass'] || $value )  )
               {
							 
							 
							
							 
							 
                 //forzato e nn c'� valore => ZERO !!!!
                 // if (/*$isForced  && !*/isset($value))  $value = 0;
                 //campo
                 $array_campi[$i] = "`".$campo."`"; //con carattere speciale mysql
                 //value con eventuale strip
                 $value = (get_magic_quotes_gpc()) ? stripslashes( $value) : $value; 
                 
                 //sostituzione virgole con punti se il campo � decimal/real oppure � forzata da conf
                 if (($this->AST[$campo]['type']=="real" && strpos($value, ",")!=false) || $this->CRUDCONF[$campo]['comma_replace'])
                  $value = str_replace(",",".",  $value);

                 //cifratura pass. ESEGUITA ANCHE SOPRA
                 if (	$value && $this->CRUDCONF[$campo]['md5_pass'] /*	&& strtolower(substr($value, 0, 4)) == "md5:" */ )
                 {
                   $value = md5(	$value );
                 }		
                 
                 /*****		ESCAPE 		****/
                 $value = $this->SQL->escape($value);  
                 
                 $array_valori[$i] = "'".$value."'";
                 $i++;
               }
			   
			  
			   
             }
             
             $q .= "(".implode(", ", $array_campi).") VALUES ( ".implode(", ", $array_valori)." ) ";
			 
            $this->LAST_QUERY = $q;
             
      }

       /**/
		  $operaz = "Inserimento";
		  if ($this->POST["_dtm_cancella_record_"] == "cancella") $operaz = "Cancellazione";
		  if ($this->UPDATE) $operaz = "Aggiornamento";
		  
      //insert: ok solo se tocca UNA riga ?
      if ( $bf && $this->SQL->query($q) &&  ($this->UPDATE || $this->INSERT && $this->SQL->get_ar()==1) )
      {
        $this->scrittura_ok($operaz."<!--$q-->"); // ."<!--$q-->" x debug
      }
		  else     
        $this->scrittura_errore($operaz."<!--$q-->");
			   
		 	   
    }/*******************************************************************/
    
    /*************************/
    /*    TABLE LISTING NUOVA  */
    /*************************/
   

    function printRecordsList( $PAR=array() ) //stampa table campi order by chiave desc. PER ADMIN
    {
         //$PAR= array("q"=>"", "table" =>"",/*, "order"=> "nome", "orderv" => "desc",*/ "nodel"=>0)
         
         //altri parametri
         // "campi" = array("id", "nome");
         // "noedit" = true;
         // "noid" = true;
         // "rows" = 20;
         // "hide_fields"=> array("level","show")// hide fields in table (also in manual query)

         if ($this->POPUP_MODE)
         {
            print "Visualizzazione records non permessa in modalita' popup";
            return;
         }

         if (isset ( $PAR['q'])) $q = $PAR['q']; else $q="";
         $table = isset($PAR['table']) ? $PAR['table'] : $this->TABELLA;
         $rowsXpage = isset($PAR['rows']) ? $PAR['rows'] : 30;
         //$q;
         //DEPRECATO
         //vedo se esistnono campi
         $campiExists = false;
         if (isset ($PAR['campi']) &&  is_array($PAR['campi']))
         {
           $campiArray = $PAR['campi'];
           //aggiungo la chiave nei campi qualora manki
           if (!in_array($this->CHIAVE, $campiArray))
              $campiArray[] = $this->CHIAVE;
           $campiExists = true;   
         }
               
         //$wheresArray = is_array($PAR['wheres']) ? $PAR['wheres'] : array();
         //$otherWheres = $PAR['other_wheres'] ? $PAR['other_wheres'] : "";
         
          //nome del get per indicare pagina
         $NOME_GET_PAGE = 'pag';
        //query automatica (cio� nn specificata) ?         
    	   $AUTOMATIC_QUERY = $q=="" ? true : false;
    	   $limiteDefault = 250;
          
         //se c'� order dal GET
         if (isset( $this->GET['order']))
         {	
            $CURR_ORDER = $this->GET['order'];
            $CURR_ORDER_V = ($this->GET['orderv']=="asc") ? "desc" : "asc";
         }
         //altrimenti prendo order default (se c'�)
         else if ( isset($PAR['order']) )
         {
            $CURR_ORDER = $PAR['order'];
            $CURR_ORDER_V = $PAR['orderv'];//$PAR['order'][$CURR_ORDER]; //desc
         }
         //altrimenti niente
          ///////////////////////////////////////////////
          /////  COUNT ROWS   ///////
          ///////////////////////////////////////////////
          if ($AUTOMATIC_QUERY)
          {
         	  //CONTO TOTALI
          	$qCount = sprintf("SELECT count(*) as c FROM `%s`",
          				$this->TABELLA);	
          	$this->SQL->query($qCount);
          	$rct = $this->SQL->fetch();	
          	$TOTAL_ROWS = $rct['c'];	
          }
          else
          {
            $this->SQL->query($q);
         	  $TOTAL_ROWS = $this->SQL->get_ar();				
          }
          
         //CHECK NUMBER
        if ($TOTAL_ROWS==0)
        {
           //print "nessun record";
           $NO_RECORDS=1;
        };
		 
        ///////////////////////////////////////////////
        /////  NAVBAR    ///////
        ///////////////////////////////////////////////
        $CUR_PAGE = isset($this->GET[$NOME_GET_PAGE]) ? $this->GET[$NOME_GET_PAGE] : 1;
            
      	//$TOTAL_ROWS = $this->SQL->count_rows( $this->TABELLA );
        $TOTAL_PAGES = ceil($TOTAL_ROWS / $rowsXpage);
       
      	$start = intval (($CUR_PAGE - 1) * $rowsXpage) ;
      	$stop = min ($start + $rowsXpage, $TOTAL_ROWS);
      	$addStart = 1;
      	$NAVBAR = "<b>".($start+$addStart)."</b> - <b>".($stop)."</b> di <b>".$TOTAL_ROWS."</b>";
	    
      	if ($TOTAL_ROWS > $rowsXpage)
        {
          $NAVBAR .= ' - ';
          $NAVBAR .= $CUR_PAGE==1 ? ' [ inizio ] ' : ' [ <a href="'.$this->makeUrl(array("order"=>$CURR_ORDER, $NOME_GET_PAGE =>1)).'"><b>inizio</b></a> ]';
          $NAVBAR .= $CUR_PAGE==1 ? ' [ indietro ] ' : ' [ <a href="'.$this->makeUrl(array("order"=>$CURR_ORDER, $NOME_GET_PAGE =>$CUR_PAGE-1)).'"><b>indietro</b></a> ]';
          $NAVBAR .= $CUR_PAGE==$TOTAL_PAGES ? ' [ avanti ] ' : ' [ <a href="'.$this->makeUrl(array("order"=>$CURR_ORDER, $NOME_GET_PAGE =>$CUR_PAGE+1)).'"><b>avanti</b></a> ]';
          $NAVBAR .= $CUR_PAGE==$TOTAL_PAGES ? ' [ fine ] ' : ' [ <a href="'.$this->makeUrl(array("order"=>$CURR_ORDER, $NOME_GET_PAGE =>$TOTAL_PAGES)).'"><b>fine</b></a> ]';
        }
        
        //clausola ORDER
        $orderByQ =  isset($CURR_ORDER) ? ' ORDER BY `'.$CURR_ORDER.'` ' .$CURR_ORDER_V: '';
        
        ///////////////////////////////////////////////
        /////  QUERY !    ///////
        ///////////////////////////////////////////////
        if ($AUTOMATIC_QUERY)
        {	
          //COSTRUISCO QUERY
          	$q = sprintf("SELECT %s FROM %s %s LIMIT %s,%s",
          				$campiExists ?  "`".implode("`, `", $campiArray)."`" :"*",
          				$table,
                  $orderByQ,
          				$start,
          				$rowsXpage);
                  //print "<!-- $q -->";
        }
        else //query personalizzata e c'è GET => tronco ORDER e lo rimetto
        {
          if ($this->GET['order'])
          {
            if (  strstr(strtolower($q), "order") != false  )
                $q = substr($q, 0, strpos(strtolower($q),"order"));

            $q = sprintf("%s  %s LIMIT %s,%s",
          				$q,
                        $orderByQ,
          				$start,
          				$rowsXpage);
          }
          else
          {
             $q = sprintf("%s LIMIT %s,%s",
          				$q,
          				$start,
          				$rowsXpage);
          }
        }
         
        //QUERY !!!!!!!!!!

        $this->SQL->query(isset($NO_RECORDS) ? ("select * from ".$this->TABELLA." LIMIT 1") : $q);

        ///////////////////////////////////////////////
        ///////////////////////////////////////////////
        /////  CICLO STAMPA TABELLA IN FETCH    ///////
        ///////////////////////////////////////////////
        ///////////////////////////////////////////////
        $i = 0;
        //$stampaColonnaEdit = true;
        while ( $row = $this->SQL->fetch() )
        {
          $keyValue = $row[$this->CHIAVE];

          //removing fields (with 'hide_tab') from each row
           foreach($this->AST as $campo => $attr)
           {
              if ( $this->CRUDCONF[$campo]['hide_tab'] )
              {
                  unset($row[$campo]);
              }
           }

          /*********************/
          /** PRIMA RIGA*****/
          /*********************/
          if ($i==0)
          {
              ?>
              <script language="javascript" >
              function cancella<?=$this->TABELLA?>(id)
              {
               if (confirm('Do you really want to delete this record?'))
                <?
                
                $urlDel = $this->makeUrl( array ($this->CHIAVE => $keyValue, "table"=>$this->TABELLA, "cancella"=>1, "id"=>0 ) );
                //nn serve ke sovrascrivo id, tanto quando sono in UPDATe non ho l'ID in GET
                
                /*location.href = '<?= $this->SCRIPT_RICHIAMANTE ?>?cancella=1&table=<?= $this->TABELLA ?>&<?=$this->CHIAVE?>='+id;*/
                
                ?>
                location.href = '<?= $urlDel ?>&<?=$this->CHIAVE?>='+id;

              }
              </script>
              <?
              
              print '<table border=0 cellpadding=0 cellspacing=0 class="tab_res_ext" ><tr><td align="right">'.$NAVBAR.'</td></tr><tr><td>';
              print '<table border=0 cellpadding=0 cellspacing=0 width="90%" class="tab_res" id="'.$this->TABELLA.'">';
              
              /*1ND ROW*/
              print '<tr>';
              
              //leggo chiavi $ROW
              $nomiCampi = array_keys($row);
                
              foreach($nomiCampi as $campoCorr) // 0 => "id", 1 => "titolo"
              {
                //se è ammesso in campi
                if (!$campiExists || in_array($campoCorr, $campiArray) )
                {
                  if (!isset ($PAR['noid']) || $campoCorr!=$this->CHIAVE)
                  {
                    //rinominato ?
                    $ren = $this->CRUDCONF[$campoCorr]['rename_table_only'] ? $this->CRUDCONF[$campoCorr]['rename_table_only'] : $this->CRUDCONF[$campoCorr]['rename'] ;
                    $campoCorrRenamed = $ren ? $ren : ucfirst(str_replace("_", " ",$campoCorr));
                    $currentOrderText = (isset($CURR_ORDER_V) && $CURR_ORDER_V=="desc") ? "discendente":"ascendente";
                    print '<th><a href="'.$this->makeUrl(array('order' => $campoCorr, 'orderv' =>$CURR_ORDER_V)).'" title="clicca per ordinare in modo '.$currentOrderText.' secondo questa colonna">'.$campoCorrRenamed.'</a>';

                    /*STAMPA SELECT FILTRO !!!*/
                    if ( $this->CRUDCONF[$campoCorr]['filter'] /*&& $this->CRUDCONF[$campoCorr]["select-items"]*/ )
                    {

                      $actionFormUrl = $this->SCRIPT_RICHIAMANTE; //$this->makeUrl( /*array ("table"=>$this->TABELLA )*/ );
                      $nomeForm = "filtro".$this->TABELLA.$campoCorr;

                      if ($this->CRUDCONF[$campoCorr]["select-items"])
                      {  $corrisp = $this->CRUDCONF[$campoCorr]["select-items"]; }
                      else if ($this->CRUDCONF[$campoCorr]["query_select"]['q'])
                      {
                         $corrisp = array();
                         $this->SQL->query($this->CRUDCONF[$campoCorr]["query_select"]['q'],2);
                         while ($r = $this->SQL->fetch(2))
                         {
                            $corrisp[$r['opt']] = $r['val'];
                         }
                      }

                      $html = '<form action="'.$actionFormUrl.'" method="get" name="'.$nomeForm.'">';
                      /*foreach($this->GET as $k => $v)
                      { 
                          if ($k!=$campoCorr)
                           $html .= '<input type="hidden" name="'.$k.'" value="'.$v.'">';
                      }*/
                      $html .= ' <select class="selfilter" name="'.$campoCorr.'" onchange="this.form.submit()" >';
                      $html .= '<option value="" '.(($this->GET[$campoCorr]!='')?' selected = "selected" ':'').' >[Show All]</option>';
                      foreach ($corrisp as $k => $v)
                      {
                         $html .= sprintf('<option value="%s" %s >%s</option>',
                              $k,
                              ( $this->GET[$campoCorr]!='' && $this->GET[$campoCorr]==$k  )? ' selected = "selected" ':'',
                              $v
                              );

                      }
                      //$html .=  '<option value="" >[Mostra tutto]</option></select></form>';
                      print $html;
                    }
                    print '</th>';
                  }
                }
              }
              if (!$PAR['noedit'] || !$PAR['nodel'])
                  print '<th align="center"><!--OPERATIONS--></th>';
              print '</tr>';

              

          }
          $i++;
        
          if ($NO_RECORDS) { continue; }
          /*********************/
          /** ALTRE RIGHE stampa righe  *****/
          /*********************/
          print '<tr onMouseOver="this.bgColor = \'#FFFFCC\'"
    onMouseOut ="this.bgColor = \'#FFFFFF\'" bgcolor=\'#FFFFFF\' >';
          foreach($row as $nomeCampo => $valoreCampo)
          {
             if (!$campiExists || in_array($nomeCampo, $campiArray) )
             {
               if (!$PAR['noid'] || $nomeCampo!=$this->CHIAVE)
               {
                  $CRUDCONFCampo = $this->CRUDCONF[$nomeCampo];
                  
                  $valoreCampoHTML = $CRUDCONFCampo["nostriptags"] ? $valoreCampo : strip_tags($valoreCampo);
                  
              
                  if ($this->AST[$nomeCampo]['type']=="real" && strpos($valoreCampo, ".")!=false)
                    $valoreCampoHTML = str_replace(".",",",  $valoreCampoHTML);
              
                  if ( $CRUDCONFCampo["md5_pass"] )
                  {
                    $valoreCampoHTML = (strlen($valoreCampo)==32) ? "[inserita]":"[<b>NON VALIDA</b>]";
                  }

                  if ( $CRUDCONFCampo["suffisso"] )
                  {
                    $valoreCampoHTML .= $CRUDCONFCampo["suffisso"];
                  }

                  if (!$CRUDCONFCampo['fulltext'])
                  {
                    //accorcio se troppo lungo e nn ho settato campo
                    $limite = $CRUDCONFCampo['limit'] ? $CRUDCONFCampo['limit'] : 250;
                    if (strlen($valoreCampoHTML) > $limite )
                      $valoreCampoHTML = substr($valoreCampoHTML, 0, $limite-1)." ... ";
                  }
                  
                  //recupero valore da tabella
                  if ( $CRUDCONFCampo["import_values"] )
                  {
                    $ar = $CRUDCONFCampo["import_values"];
                    
                    $nometabella = $ar["tabella"]; // sw_cat
                    $nomecampo = $ar["campo"]; // categoria - campo con cui riempire valore leggibile di option
                    $nomechiave = $ar["chiave"]; // id - valore del campo <select> nascosto, per il post
                    // id - valore del campo <select> nascosto, per il post
                     
                    $rC = $this->SQL->query_n_fetch( "select * FROM `$nometabella` WHERE `$nomechiave`='$valoreCampo' " );
                    $valoreCampoHTML = $rC[$nomecampo];
                  }
                  
                  if ($CRUDCONFCampo['query_select']) //<!--2 tabella campo chiave-->
                  {
                    
                      //qUERY MIGLIORATA, considera solo
                      $q = $CRUDCONFCampo['query_select']['q'];
                      //print "<hr>";
                     
                      $this->SQL->query( $q,2 );
                      while ( $r = $this->SQL->fetch(2) )
                      {
                         if ($r['opt']==$valoreCampo)
                          $valoreCampoHTML = htmlentities($r['val']);
                      }
                  } 
                  
                  //recupero valore da tabella
                  if ( $CRUDCONFCampo["importa_select_hierchical"] )
                  {
                    $ar = $CRUDCONFCampo["importa_select_hierchical"];
                    
                    $nometabella = $ar["tabella"]; // sw_cat
                    $nomecampo = $ar["campo"]; // categoria - campo con cui riempire valore leggibile di option
                    $nomechiave = $ar["chiave"]; // id - valore del campo <select> nascosto, per il post
                     
                    $rC = $this->SQL->query_n_fetch("select * FROM `$nometabella` WHERE `$nomechiave`='$valoreCampo'");
                    $valoreCampoHTML = $rC[$nomecampo];
                  
                  }
                  if ( $CRUDCONFCampo['select-items']  )
                  {
                    if ($CRUDCONFCampo['change_in_table'])
                    {
                         $corrisp = $CRUDCONFCampo['select-items'];
                          
                         $valoreCampoHTML = $this->HtmlFormChange($keyValue, $nomeCampo, $valoreCampo, $corrisp);
                    }
                    else
                      $valoreCampoHTML = $this->CRUDCONF[$nomeCampo]['select-items'][$valoreCampoHTML];
                    
                  }
                  if ($CRUDCONFCampo['radio'])
                  {
                    $valoreCampoHTML = $this->CRUDCONF[$nomeCampo]['radio'][$valoreCampoHTML];
                  }
                  if ($CRUDCONFCampo['upload_image'] && $valoreCampo )
                  {
                    $t = $this->DTM_GLOBAL_CONF['upload']["table"];
                    //$valoreCampoHTML =  $t.$valoreCampo;
                    
                    $rUpload = $this->SQL->query_n_fetch($t, array("id" => $valoreCampo) );
                    if ($rUpload)
                    {
                      $pathImg = $this->DTM_GLOBAL_CONF['upload']["uploadUrl"].$rUpload ['prefisso_path_imgs'].$this->DTM_GLOBAL_CONF['upload']["formatoThumb"].".jpg";
                      $valoreCampoHTML = '<img src="'.$pathImg.'" />';
                    }
                    else
                      $valoreCampoHTML  = 'nd';
                  }
                  if ($CRUDCONFCampo['upload'] )
                  {
                    if ($valoreCampo)
                    {
                      $t = $this->DTM_GLOBAL_CONF['upload']["table"];
                      //$valoreCampoHTML =  $t.$valoreCampo;
//                      echo "+$t+$valoreCampo+";
//                      $rUpload = $this->SQL->query_n_fetch($t, array("id" => $valoreCampo) );
//                      if ($rUpload)
//                      {
//                        $pathFile = $this->DTM_GLOBAL_CONF['upload']["uploadUrl"].$rUpload['rel_path_file'];
//                        $descrizione = $r['descriz'] ? $r['descriz'] : $rUpload['descriz'];
//                        //non stampo $rUpload['rel_path_file'].'<br>'.s
//                        $valoreCampoHTML = '<br><a href="'.$pathFile.'" target="_blank">'.$descrizione.'.'.substr($pathFile,-3).'</a>';
//                      }
//                      else
						global $screenshotpath;
                        $valoreCampoHTML  = "<img src='$screenshotpath/$valoreCampo' height='50' />";
                    }
                    else
                      $valoreCampoHTML  = 'nessun file';
                  }
                  
                  if ($CRUDCONFCampo['cell_table_func'])
                  {
                    print '<td valign="top">';
                    call_user_func($CRUDCONFCampo['cell_table_func'], $row);
                    print '</td>';
                  }  
                  else
                    print '<td valign="top" >'.$valoreCampoHTML.'</td>';
               }
             }     
          }
          /********* OPERAZIONI - ULTIMA COLONNA *********/
          
          if (!$PAR['noedit'] ||!$PAR['nodel'])
          {
                print '<td >'; //nowrap="nowrap"
                if ($PAR['ROW_BUTTON']) {
                	$my_caption=$PAR['ROW_BUTTON']['CAPTION'];
                	$my_url=$PAR['ROW_BUTTON']['URL'];
                	$my_id=$keyValue;
                	$my_targetfk=$PAR['ROW_BUTTON']['TARGETFK'];
                	print sprintf("<a href=\"%s\">$my_caption</a> | ","$my_url" .
                			"targetfk=$my_targetfk&targetid=$my_id");
 
                }
                
                if (!$PAR['noedit'])
                {
                  print sprintf("<img src=\"images/edit16.gif\" border=0 align=absmiddle><a href=\"%s\" %s title=\"record editing\">edit</a> | ",
                  $this->makeUrl(  array($this->CHIAVE => $keyValue, "table"=>$table, "cancella"=>0)  ),
                  $blank ? " \"target=_blank\" ":"");	  
                }
                
                if (!$PAR["nodel"])
                  print '<img src="images/delete16.gif" border=0 align=absmiddle><a href="javascript:cancella'.$this->TABELLA.'('.$keyValue.')" title="Delete record from this table">delete</a>';
                print '</td>';
          }
          print '</tr>';
      }
      print $this->DTM_GLOBAL_CONF['last_tr'];
      print "</table>";
      print "</td></tr></table>";
      if ($NO_RECORDS) { print "<br>&nbsp;&nbsp;No records to show."; }
    }/*******************************************************************/
    
    //stampa form per cambio valore immediato
    function HtmlFormChange($keyValue, $nomeCampo, $valoreCampo, $corrisp, $actionFormUrl="", $stampaSubmit=false)
    {
       if (!$actionFormUrl)
          $actionFormUrl = $this->makeUrl( array ("table"=>$this->TABELLA ) );
       $nomeForm = "form".$this->TABELLA.$nomeCampo."cit".$keyValue;
       $valoreCampoHTML = '<form action="'.$actionFormUrl.'" method="post" name="'.$nomeForm.'">
        <br><input type="hidden" name="_dtm_mode_" value="UPD">
        <br><input type="hidden" name="'.$this->CHIAVE.'" value="'.$keyValue.'">
        <input type="hidden" name="_dtm_table_" value="'.$this->TABELLA.'">
        <select name="'.$nomeCampo.'"  class="intable" 
        onchange="this.form.submit()">'; //document.'.$nomeForm.' in caso di problemi
       // print '<option value="">Inserted Links (all users)</option>';
       foreach ($corrisp as $k => $v)
       {
            $valoreCampoHTML .= sprintf('<option value="%s" %s >%s</option>',
                $k,
                ($valoreCampo == $k ) ? ' selected="selected" ':'',
                $v
                );
        
        }
        $valoreCampoHTML .='</select>';
        
        if ($stampaSubmit)
        {
           $valoreCampoHTML .='<br /><input type="submit" value="cambia" class="intablesubmit">';
        }
        
        $valoreCampoHTML .='</form>';
        return $valoreCampoHTML;
    }
    
    
    /*sputa il link completo alla pagina che sovrascrive i prametri*/
    function makeUrl($overGet=array())
    {
      $get = $this->GET;
      
      // overWrite GET
      foreach($overGet as $k => $v)
      {
        $get[$k] = $v;
      }
      // make Url
      $ga = array();
      foreach($get as $k => $v)
      {
        $ga[] = urlencode($k)."=".urlencode($v);
      }
      //
      return $this->SCRIPT_RICHIAMANTE."?".implode("&", $ga);
    }
    
    
    function linksAggiornaAndStampa()
    {
      if (!$this->GET['insert'] && !$_GET['id'])
      {
        $agglink = $this->makeUrl( array("refresh"=>time(), "cancella"=>0) ); ?>
        <div align=right style="position:absolute; top:10px; right:30px">
        <a href="<?=$agglink?>" title="aggiorna"><img src="images/refresh.gif" border=0 hspace=4></a>
        <a href="<?=$agglink?>" title="aggiorna">aggiorna elenco</a> - 
        <a href="javascript:parent.print()" title="stampa"><img src="images/print.gif" border=0 hspace=4></a>
        <a href="javascript:parent.print()" title="stampa">stampa</a>
        </div><?
      };

    }
    
    function linkRitornoFormToElenco($linkRitorno = "torna all'elenco")
    {
       if (!$this->POPUP_MODE)
       print "<div align=right style=\"position:absolute; top:10px; right:200px\">
       <a href=\"".$this->makeUrl( array("insert"=>1, "id"=>0, "refresh"=>time()) )."\" >
       <img src=\"images/return.gif\" border=0 hspace=4></a>
       <a href=\"".$this->makeUrl( array("insert"=>0, "id"=>0, "refresh"=>time()) )."\" >".$linkRitorno."</a></div>";
    }
    
    function linkInsertSottoTabellaDinamico($titoloInserisci="Inserimento record", $titoloEdita="Editing record", $linkNuovoRecord="Inserisci nuovo record")
    {
      if (!$this->GET['id'] && !$this->GET['insert'])
        { ?><h3><img src="images/add.gif" width="48" height="48" hspace="10" align="absmiddle" />
        <a href="<?=$this->makeUrl( array("insert"=>1, "id"=>0) )?>">
        <?=$linkNuovoRecord?></a></h3><? }
    }
    
    function possoStampareTabella()
    {
       return (!$this->GET['id'] && !$this->GET['insert']);
    }
    
    
    function head($extraHead = "")
    {
          ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
          <html xmlns="http://www.w3.org/1999/xhtml">
          <head>
          <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
          <title>gestione <?=$tab?></title>
          <link href="stili.css" rel="stylesheet" type="text/css" />
          <script language="JavaScript"><!-- 
          function apri(str) 
          {
            var larghezza = 550;
            var altezza = 300;

            searchWin = window.open(str,"","scrollbars=yes,resizable=yes,status=no,location=no,toolbar=no,width="+larghezza+",height="+altezza+",left="+((screen.width-larghezza)/2)+",top="+((screen.height-altezza)/2)+"");
          }

          --></script>
          <?=$extraHead?>
          </head>

          <body >
          <script language="JavaScript"><!-- 
          <? if ($_POST): ?>
          if (opener)
          {
            opener.location.reload()
          }
          <? endif;?> 
          --></script><?
    }
    
    function stampaFormRicerca( $CAMPI_CONSIDERATI )
    {
      $actionFormUrl = $this->makeUrl( /*array ("table"=>$this->TABELLA )*/ );
      ?>
      <table border="0" cellspacing="2" class="ricerca"><tr>
       <td class="first"><b>Cerca:</b ></td>
       <form action="<?=$actionFormUrl?>" method="get" name="ricercatab">
       <td nowrap="nowrap"><input size="10" name="_dtm_q" value="<?=$this->GET['_dtm_q']?>">
       <input type="image" src="images/search16.png" width="16" alt="cerca">
       <? if ($this->GET['_dtm_q']): ?>
       <a href="<?=$this->makeUrl( array("_dtm_q"=>"") )?>">annulla ricerca</a> 
       <? endif; ?>
       </td>
       </form>
      </tr></table>

      <?
    }
    
    function radice_parola($str)
    {
      return (strlen($str)<6) ? $str : substr($str, 0, -1); 
    }
    
    function whereFromRicerca($CAMPI_RICERCA) //aggiungi where davanti, ritorna ()
    {
        if (!$this->GET['_dtm_q'])
          return "1";
        $parole = explode(" ",$this->GET['_dtm_q']);

        
        $wheres = array();
				 
         foreach($CAMPI_RICERCA as $campo)
         {
           foreach($parole as $p)
           {
            //if (strlen($p)>2)
              $wheres[] = " ".$campo." LIKE '%".$this->radice_parola($p)."%' ";
           }
         }
         //nessuna parola valida scritta ?
         if (!$wheres)
          return "1";

         return " ( ".implode(" OR ",$wheres)." ) ";
        
    }

    function getWhereFilters()
    {
        //ritorna elenco delle filters
        return "1";
    }

    function stampaFormFiltri( $FILTRI )
    {
      if (!$FILTRI) return;
        $pezziHtml = array();
      foreach ($FILTRI as $campo) //stato, pagato...
      {
          if ( $this->CRUDCONF[$campo]["select-items"] ) //<!--importa_select2 tabella campo chiave-->
          {
              $actionFormUrl = $this->SCRIPT_RICHIAMANTE; //$this->makeUrl( /*array ("table"=>$this->TABELLA )*/ );
              $nomeForm = "filtro".$this->TABELLA.$nomeCampo;
              $corrisp = $this->CRUDCONF[$campo]["select-items"];
              
              $html = "";
              $html .= '<form action="'.$actionFormUrl.'" method="get" name="'.$nomeForm.'">';
              foreach($this->GET as $k => $v)
              { $html .= '<input type="hidden" name="'.$k.'" value="'.$v.'">'; }
              $html .= "&nbsp;".$this->nomeCampoHtml($campo).' <select name="'.$campo.'" onchange="this.form.submit()" >';
              $html .= '<option value="" '.(($this->GET[$campo]!='')?' selected = "selected" ':'').'>TUTTI</option>';
              foreach ($corrisp as $k => $v)
              {
                 $html .= sprintf('<option value="%s" %s >%s</option>',
                      $k,
                      ( $this->GET[$campo]!='' && $this->GET[$campo]==$k  )? ' selected = "selected" ':'',
                      $v
                      );
              
              }
              $html .=  '</select></form>';
              array_push($pezziHtml, $html);
          }
      }
      
      print '<table border="0" cellspacing="2" class="filtri"><td class="first"><b>VISUALIZZA SOLO:</b </td><td>'.implode("</td><td>", $pezziHtml)."</td></table>";
      
    
    }
    
    function whereFromFiltri() //aggiungi where davanti, ritorna ()
    {
        $FILTRI = array();
        if ($this->CRUDCONF)
        foreach($this->CRUDCONF as $k=>$v)
        {
            if ($v["filter"] ) /*&& $v["select-items"]*/
                $FILTRI[] = $k;
        }

        $WHERES = array();
        foreach($FILTRI as $filtro)
        {
          if ($this->GET[$filtro]!='')
            $WHERES[] = " `$filtro` = \"".$this->GET[$filtro]."\" ";;
        }
        if (count($WHERES))
          $WHERES = " ( ".implode(" AND ", $WHERES)." ) ";
        else
          $WHERES = "1";
        return $WHERES;
    
    }
    
    
    
    function foot()
    {
      ?><p>
      </p>
      </body>
      </html><?
    }
    
 
    /**** STAMPA Albero gerarchia  importa_select_hierchical *******/
    function sa($tab="")
    {
      $tab = $tab ? $tab : $this->TABELLA;
      $alberoCats = array();
      $q = "select * FROM `$tab`";
      $this->SQL->query($q);
      $alberoCats = array();
      while ($row = $this->SQL->fetch())
      {
        $alberoCats[] = array($row["id"], $row["nome"], $row['categoria_madre']) ;
      }
      $alberoCats = $this->figli(0, 0, $alberoCats);
      //print '<ul class="albero_sa">';              
      print '<br><br><table border=0 cellpadding=2 cellspacing=0 style="margin:10px">';              
      foreach($alberoCats as $elemCorr)
      {
         list($valore_chiave, $nomecampo) = $elemCorr;
         //$nomecampo = str_replace("----","&nbsp;&nbsp;--",$nomecampo);
         $pl = 9 * substr_count ( $nomecampo, "-" );
         $nomecampo = str_replace("-", "",$nomecampo);
         if ($valore_chiave != 1)
            //print '<li>'.$fi.'<span style="margin-left: '.$pl.'px;font-size:15px;font-weight:bold; padding-right:40px"><img src="images/folder.gif" hspace=2>'.$nomecampo.'</span> <img src="images/edit16.gif" border=0 align=absmiddle><a href="categorie.php?id='.$valore_chiave.'&table=categorie" >modifica</a> - <img src="images/delete16.gif" border=0 align=absmiddle> <a href="javascript:cancella('.$valore_chiave.')">elimina</a></li>';
            print '<tr>
              <td style="border-bottom:#333333 1px dotted">
                <span style="margin-left: '.$pl.'px;font-size:15px;font-weight:bold; padding-right:40px"><img src="images/folder.gif" hspace=2>'.$nomecampo.'</span>
              </td>
              <td style="border-bottom:#333333 1px dotted">
                <img src="images/edit16.gif" border=0 align=absmiddle><a href="categorie.php?id='.$valore_chiave.'&table=categorie" >edit</a> - <img src="images/delete16.gif" border=0 align=absmiddle> <a href="javascript:cancella'.$this->TABELLA.'('.$valore_chiave.')">delete</a>
              </td>
            </tr>';
      }
      //print "</ul>"; 
      print "</table>"; 
    
    }
    
    
    
    
    /*********************************/
    /*   GENERAZIONE <FORM>          */
    /*********************************/
    function printCrudForm($title_ins = "Insert a new record", $title_upd = "Record editing", $mostra_riga_cancella=true)
    {
        if ($this->UPDATE && $this->TABLE_VALGET != $this->TABELLA) { print "<!--Ricevo dati in post da tabella non mia. esco da genera_form() ! -->"; return; }
        
        // se sono in modalit� modifica, devo riempire il form. Se il record nn esiste... stampo errore ed esco
         if ($this->UPDATE && $this->CHIAVE_VALGET && 
         $this->SQL->col("count(*)", $this->TABELLA, array ($this->CHIAVE => $this->CHIAVE_VALGET), $q) != 1
         )
              {  print "<h4>Record non esistente ".$q."!</h4>"; return; }
         
         //se passo titoli, li stampo
         if ($title_ins != "")
         {
             $title = ($this->UPDATE) ? $title_upd : $title_ins;
             print " <h2>". $title."</h2>";
         }
         //$enctype = $this->MULTIPART_FORM ? 'enctype="multipart/form-data"':'';
		 
      $labelsSubmit =  isset($this->CRUDCONF["CRUDCONF"]['labelsubmit']) ? ($this->CRUDCONF["CRUDCONF"]['labelsubmit']) : (array( "ins" => "Insert", "upd" => "Save"));

       $riga_submit = '<tr><td colspan=2><input type="submit" value="'.($this->UPDATE ? $labelsSubmit['upd']:$labelsSubmit['ins']).'" id="submit" class="tastosubmit" />';

       if (!$this->POPUP_MODE)
            $riga_submit .= ' or <a href="'.$this->makeUrl(array("insert" => 0,  $this->CHIAVE => 0)).'">Back to records list</a><br/><br/>Please fill in all required fields (<b>*</b>) in this form';

       $riga_submit .='</td></tr>';
       //<input type="button" value="Reset" id="reset" onclick="alert(\'aggiorna la pagina per resettare i campi\')" />
       //AJAX JAVACRIPT
       //print '<script language="javascript" src="'.$this->DTM_GLOBAL_CONF["js"]["ajax"].'"></script>';
		 
        ///// CONTROLLO JAVASCRIPT
		
        ?><script language="javascript" >
      
        //usata per descrizione immagini !
        function uploadrimuovi(nomecampoupload)
        {
          if (confirm('Do you really want to delete this record ?'))
          {
            if (document.getElementById('campo_d_' + nomecampoupload) )
            {
              
                document.getElementById('campo_d_' + nomecampoupload).value= '';
            }
            
            if (document.getElementById(nomecampoupload))
            {
                document.getElementById(nomecampoupload).innerHTML = "nessun file<input type=\"hidden\" name=\""+nomecampoupload+"\" value=\"\">";
            }
          }
          
        }
        <?
        /* <input type=hidden name=<?=$idDiv?> value=1> */
		
        print "function checkform".$this->TABELLA." ( form )
        {";
        
        if ($this->UPDATE && $mostra_riga_cancella)
          print "if (form._dtm_cancella_record_.value=='cancella') return true;\n";

          foreach($this->AST as $campo => $attr)
           {
             
             $campo_print = $this->nomeCampoHtml($campo);
             $CONF_CAMPO = $this->CRUDCONF[$campo];
             
             // print $campo."-".$attr['flags'];
              //se � not nul e nn � textarea fck
              if (  $campo !=$this->CHIAVE && 
                    strstr($attr['flags'], "not_null") &&
                    !$this->CRUDCONF[$campo]['fck'] &&
                    !isset($this->CRUDCONF[$campo]['hide']) &&
                    !isset($this->CRUDCONF[$campo]['hide_table_only']) &&
                    !isset($this->CRUDCONF[$campo]['desc_file_upload']) &&
                    !isset($this->CRUDCONF[$campo]['hide_form_only']) &&
                    !isset($this->CRUDCONF[$campo]['fixedhiddenvalue']) /* &&
                    !isset($this->CRUDCONF[$campo]['md5_pass'])*/
                )
              { 
                if (!(isset($CONF_CAMPO['md5_pass']) && $this->UPDATE))
                  print "\nif (!form.".$campo." || form.".$campo.".value == \"\" ) 
                        { alert( \"'".ucfirst(str_replace('_',' ',strip_tags($campo_print)))."' obbligatorio.\" );
                          if (form.".$campo.")
                          { form.".$campo.".focus(); }
                          return false ;
                        }";
                        
                  //controlli conferme se ci sono, oppure nuova password in insert
                  if (  isset($CONF_CAMPO['conferma']) || (isset($CONF_CAMPO['md5_pass']) && !$this->UPDATE)   )
                   {
                     print "\nif (form.".$campo.".value  != form._dtm_".$campo."_conferma.value ) 
                              { alert( \"'".ucfirst(str_replace('_',' ',strip_tags($campo_print)))."' non corrisponde.\" );
                                if (form.".$campo.")
                                { form.".$campo.".focus(); }
                                return false ;
                              }";
                   
                   }
                   
                   //controlli range. pass in update DA SALTARE !!!!!
                   if (!(isset($CONF_CAMPO['md5_pass']) && $this->UPDATE))
                   {
                     if (  isset($CONF_CAMPO['range']['min']) )
                     {
                       printf( "\nif ( form.".$campo.".value.replace(/\,/, \".\")  < %s ) 
                                { alert( \"'%s' deve essere maggiore o uguale a %s.\" );
                                  if (form.".$campo.")
                                  { form.".$campo.".focus(); }
                                  return false ;
                                }", 
                                  str_replace(",", ".", $CONF_CAMPO['range']['min']),
                                  ucfirst(str_replace('_',' ',strip_tags($campo_print))),
                                  str_replace(",", ".", $CONF_CAMPO['range']['min'])
                                );
                     }
                     
                     //controlli range
                     if (  isset($CONF_CAMPO['range']['max']) )
                     {
                       printf( "\nif (form.".$campo.".value  > '%s' ) 
                                { alert( \"'%s' deve essere minore o uguale a %s.\" );
                                  if (form.".$campo.")
                                  { form.".$campo.".focus(); }
                                  return false ;
                                }", 
                                  str_replace(",", ".", $CONF_CAMPO['range']['min']),
                                  ucfirst(str_replace('_',' ',strip_tags($campo_print))),
                                  str_replace(",", ".", $CONF_CAMPO['range']['max'])
                                );
                     } 
                     
                     
                     //controlli range
                     if (  isset($CONF_CAMPO['rangelen']['min']) )
                     {
                       printf( "\nif (form.".$campo.".value.length  < %s ) 
                                { alert( \"'%s' deve essere composto da almeno %s caratteri !\" );
                                  if (form.".$campo.")
                                  { form.".$campo.".focus(); }
                                  return false ;
                                }", 
                                  intval($CONF_CAMPO['rangelen']['min']),
                                  ucfirst(str_replace('_',' ',strip_tags($campo_print))),
                                  intval($CONF_CAMPO['rangelen']['min'])
                                );
                     }
                   }
                    
                       
                  
                  //controlli range
                   if (  isset($CONF_CAMPO['check_mail']) )
                   { 
                      // || form.".$campo.".value.search('.') == -1
                     printf( "\nif (form.".$campo.".value.search('@') == -1) 
                              { alert( \"'%s' : indirizzo e-mail non valido !\" );
                                if (form.".$campo.")
                                { form.".$campo.".focus(); }
                                return false ;
                              }", 
                                 ucfirst(str_replace('_',' ',strip_tags($campo_print)))
                              );
                   } 
                      
                      
                        
              }   

            
             
           }
           print "return true ;
        }
        </script>";
         
         $actionFormUrl = $this->makeUrl( array ("table"=>$this->TABELLA, $this->CHIAVE=>0 ) );
         print '<form name="'.$this->NOMEFORM.'" action="'.$actionFormUrl.'" method="post"  '.$enctype.' onSubmit="return checkform'.$this->TABELLA.'(this)" >';
         //print '<input value="test check form" type=button onClick="return checkform'.$this->TABELLA.'(this)" >';
         
         print '<table class="form_input" border="0" cellspacing="0" cellpadding="0">';
         print '<input type="hidden" name="_dtm_mode_" value="'.($this->UPDATE?"UPD":"INS").'">';
         print '<input type="hidden" name="_dtm_table_" value="'.$this->TABELLA.'">';
         
         print '<input type="hidden" name="_dtm_referer_" value="'.$GLOBALS['_SERVER']['HTTP_REFERER'].'">';
         
         //print  $riga_submit;
         if ($this->UPDATE)
          $this->OLD_ROW = $this->SQL->query_n_fetch($this->TABELLA, array( $this->CHIAVE => $this->CHIAVE_VALGET) );
         foreach($this->AST as $campo => $attr)
         {
         // if ($i++ % 5 == 4)  print  $riga_submit;
            $this->genera_form_campo($campo, $attr);
         }
         
		 
         /*if ($this->UPDATE && $mostra_riga_cancella)
          print '<tr><td></td><td align=right>Digita : <b>cancella</b> nel campo seguente per cancellare questo record invece di modificarlo <!--(chiave = '.$this->CHIAVE_VALGET.')-->
          <input type="text" name="_dtm_cancella_record_"></td></tr>';
         */
         print  $riga_submit;
         
         print "</table></form>";
    }/*******************************************************************/
    
    function nomeCampoHtml($campo)
    {
      //se � rinominato ritorno il rename, altrimenti tolgo _ e ucfirsto
      return ($this->CRUDCONF[$campo]['rename']) ? $this->CRUDCONF[$campo]['rename'] : ucfirst(str_replace("_"," ",$campo));
    }
    
 
    /******************************************/
    /*   GENERAZIONE RIGA <FORM> x ogni campo */
    /******************************************/
    function genera_form_campo($campo, $attr, $disabled = false)
    { 
         /*
          [type] => int | string |blob | date | timestamp | real
          [len] => 11 | 65535 | 65535
          [flags] => not_null primary_key auto_increment
          [default] => 
        */
        
      //campo not show => esco sempre !
      if ( $this->CRUDCONF[$campo]['hide'] ) 
      {
        //hide chiave in update ? lo DEVO stampare, ma in hidden mode
         if($this->UPDATE && $campo== $this->CHIAVE )
              print '<input type="hidden" name="'. $this->CHIAVE .'" value="'.$this->OLD_ROW[$campo].'">';
         //
         return;         
      }

      
      if ( $this->CRUDCONF[$campo]['hide_form_only'] ) 
        return;
      
      //valore fixed & hidden in INSERT => creo campo hidden e ci stampo il valore
      if ( isset($this->CRUDCONF[$campo]['fixedhiddenvalue']) )    
      {
        //print "<h1>settato$campo</h1>";//in insert
        //if (!$this->UPDATE)// non stampi i <li>
          print '<input type="hidden" name="'.$campo.'" value="'. $this->CRUDCONF[$campo]['fixedhiddenvalue'].'">';
        //in update esco subito
        return;
      }	
      
      
      //disabled ?
          $altri_attributi = $disabled ? ' disabled="disabled" ' : '';
          
      //rename ?
          //$campo_print = ($this->CRUDCONF[$campo]['rename']) ? ($this->CRUDCONF[$campo]['rename']) : ($campo);
      $campo_print = $this->nomeCampoHtml($campo);
      
      
          
      /** CALCOLO CAMPI MODULO DI DEFAULT **/
      if ($this->UPDATE)
      {
        //calcolo vecchio valore
        //$oldvalue = $this->SQL->col($campo,$this->TABELLA, array( $this->CHIAVE => $this->CHIAVE_VALGET) );
        $oldvalue = $this->OLD_ROW[$campo]; 
        if ( $this->CRUDCONF[$campo]['update_always_data'] )    
        {
          $oldvalue = date("Y-m-d H:i:s");
        }
        
        //modalit� upload: se c'� valore, non stampo campo descrizione (� incluso in ajax dentro)
        if ( $this->CRUDCONF[$campo]["desc_file_upload"] && !$oldvalue ) 
          return;	

          }
      else //INSERT
          { 
            // debug print $campo."\n\n\n"; print_r($attr);
            if ($attr['type']=="timestamp" && strstr($attr['flags'], "timestamp")   )
              $oldvalue = date("Y-m-d H:i:s");
            else if ($this->CRUDCONF[$campo]["time"])
              $oldvalue = time();
            else if ( $this->CRUDCONF[$campo]['oldval'])
              $oldvalue =  $this->CRUDCONF[$campo]['oldval'];  
            else if ($this->CRUDCONF[$campo]["default"]) 
              $oldvalue = $this->CRUDCONF[$campo]["default"];  
            else
               $oldvalue = $attr['default'];  //mysql
            
            //modalit� upload: non stampo campo descrizione (� incluso in ajax dentro)
            if ( $this->CRUDCONF[$campo]["desc_file_upload"]  ) 
            return;	
          }
      
      

      //da testare in nuova lib	
          if ( !$this->CRUDCONF[$campo]['automatic'] )    
          {   
            print  "<tr class=\"tr".$campo."\"><td><b>".str_replace("_"," ", ucfirst($campo_print))." ";
            print strstr($attr['flags'], "not_null") ? "*" : "" ;
            print "</b></td><td>".$this->CRUDCONF[$campo]['pretext'];
          }
      

          /****    MAIN SWITCH !!!! ************/
          /****    MAIN SWITCH !!!! ************/
          /****    MAIN SWITCH !!!! ************/
          // CAMPO con chiave primaria
          if ( $campo == $this->CHIAVE)
          {
                if ($this->UPDATE)
                {
                    print $this->CHIAVE_VALGET;
                    print '<input type="hidden" name="'.$campo.'" value="'.$this->CHIAVE_VALGET.'">';
       
                }
                else //INSERT
                {
                      //caso auto_increment => scrivo in campo HIDDEN
                      if ( strstr($this->AST[$campo]['flags'], "auto_increment") ) 
                      {
                        print "(automatically generated after inserting)";
                      }
                      else
                        print '<input type="text" name="'.$campo.'" size="'.$attr['len'].'" maxlength="'.$attr['len'].'" />';
                }
      
          }
      else if ( $this->CRUDCONF[$campo]["upload"] || $this->CRUDCONF[$campo]["upload_image"] ) //<!--importa _select2 tabella campo chiave-->
          {
        $image = $this->CRUDCONF[$campo]["upload_image"] ? 1 : 0;
        $modalitaUpdate = $oldvalue ? 1 : 0;
        print "<table border=0 ><tr>";
        print '<td><input type="text" name="'.$campo.'" size="55" maxlength="255" value="" readonly  /><div id="'.$campo.'" style="margin-right:50px">';
        if ($modalitaUpdate)
        {
          //se furl disabilitato, fallo con ajax
          //print file($this->DTM_GLOBAL_CONF['upload']["dtmUrl"]."ajax_component_upload.php?file=".$oldvalue);
          //$urlGet = $this->DTM_GLOBAL_CONF['upload']["dtmUrl"]."ajax_component_upload.php?iddiv=".$campo."&update=0&file=".$oldvalue."&table=".$this->DTM_GLOBAL_CONF['upload']["table"];
          $urlGet = $this->DTM_GLOBAL_CONF['upload']["dtmUrl"]."ajax_component_upload.php?iddiv=".$campo."&update=0&file=".$oldvalue."&config_archivio=".$this->DTM_GLOBAL_CONF['upload']["config_archivio"];
          //$urlGet = $this->DTM_GLOBAL_CONF['upload']["dtmUrl"]."ajax_component_upload.php?iddiv=".$campo."&update=0&file=".$oldvalue."&session=".urlencode(session_encode());
          print "<!-- inglobo [$urlGet] -->";
          
          $pezzi = @file("".$urlGet."");
          
          if ($pezzi)
            print join("", $pezzi);
          else
             print "<b>Immagine gi&amp; inserita. Vedi sul sito</b><br />"; 
          
          /*?><iframe width="300" height="200" src="<?=$urlGet?>" frameborder="0"></iframe><?*/
          
          
        }
        else
        {
          print 'Nessun file !';
        }	
        print'</div></td>';
        
        
        
        $iframeSize = $this->DTM_GLOBAL_CONF['upload']["iframeSize"];
        if (!$iframeSize)
          $iframeSize = array("w" => 600, "h" => 80);
        print '<td class="tdupload" valign=top>';
       	if ($this->CRUDCONF[$campo]["upload"]['customname']) {
               print '<iframe class=0 name="'.$campo.'" id="'.$campo.'" scrolling="auto" frameborder="0" width="'.$iframeSize['w'].'" height="'.$iframeSize['h'].'" src="'.$this->DTM_GLOBAL_CONF['upload']["dtmUrl"].'frame_gest_file.php?image='.$image.'&update='.$modalitaUpdate.'&included=1&iddiv='.$campo.'&imgfilename='.$this->CRUDCONF[$campo]["upload"]['customname'].'"></iframe>';
        } else {
               print '<iframe class=0 name="'.$campo.'" id="'.$campo.'" scrolling="auto" frameborder="0" width="'.$iframeSize['w'].'" height="'.$iframeSize['h'].'" src="'.$this->DTM_GLOBAL_CONF['upload']["dtmUrl"].'frame_gest_file.php?image='.$image.'&update='.$modalitaUpdate.'&included=1&iddiv='.$campo.'"></iframe>';
        }
        
        
        if (!$this->CRUDCONF[$campo]["upload"]['no_archive'])
        {
          print '<br>oppure '; 
          $labelPulsante = $image?'seleziona immagine dall\'archivio':'seleziona file dall\'archivio';
          
          print '<input type="button"  value="'.$labelPulsante.'" class="bold" onclick="window.open(\''.$this->DTM_GLOBAL_CONF['upload']["dtmUrl"].'frame_gest_file.php?image='.$image.'&update='.$modalitaUpdate.'&iddiv='.$campo.'\',\'sf\',\'scrollbars=yes,resizable=yes,status=yes,location=no,toolbar=no,width=700,height=500\')" />';
        }
        
        print '</td></tr></table>';
        }
          else if ( $this->CRUDCONF[$campo]["md5_pass"] )
          {
              // 24/06   ajax. v� anche senza js. a prova di idiota
              if ($this->UPDATE && $oldvalue)
              {
                $idDivCampo = "cambpass".$campo;
                ?>
                <script language="javascript">
                function tastocambia<?=$campo?>()
                {
                  return "Password gi&agrave; presente! <input type=button value=\"edit password\" onclick=\"document.getElementById('<?=$idDivCampo?>').innerHTML = forminonuovapass<?=$campo?>()\" >";
                }
                
                function forminonuovapass<?=$campo?>()
                {
                  return "<br><b>Nuova password:</b> <input type=\"password\" name=\"<?=$campo?>\" value=\"\"><br>Conferma nuova password: <input type=\"password\" name=\"_dtm_<?=$campo?>_conferma\" value=\"\">  <br /> <input type=button value=\"[ annulla (mantieni vecchia password) ]\" onclick=\"document.getElementById('<?=$idDivCampo?>').innerHTML = tastocambia<?=$campo?>()\">";
                }
                </script><?
                print '<div id="'.$idDivCampo.'" >';
                //se nn va javacript STAMPO MODULO COME INSERIMENTO, 
                print 'Insert : <input type=password name="'.$campo.'" value=""><br>Conferma : <input type="password" name="_dtm_'.$campo.'_conferma" value=""><br>Password gi&agrave; presente ! Lasciare VUOTI questi due campi per non modificarla! .';
                print ' </div>';
                //se abilitato javacript, scrivo il tasto CAMBIA
                ?>
                <script language="javascript">
                document.getElementById('<?=$idDivCampo ?>').innerHTML = tastocambia<?=$campo?>()
                 </script>
                <?
              }
              else
              {
                //insert
                print 'Insert: <input type=password name="'.$campo.'" value=""><br>Conferma : <input type="password" name="_dtm_'.$campo.'_conferma" value=""><br>';
             
              }
            
          }
          else if ( $this->CRUDCONF[$campo]["importa_select2"] ) //<!--importa_select2 tabella campo chiave-->
          {
               
              $ar = $this->CRUDCONF[$campo]["importa_select2"]; 
              //<!--dtm_<a tabella campo chiave-->
              //<!--importa_select2 sw_cat categoria id-->
            // nn crea input, ma la select chiave, campo from tabella , poi <option value=$chiave>$campo</option> 
              $nometabella = $ar["tabella"]; // sw_cat
              $nomecampo = $ar["campo"]; // categoria - campo con cui riempire valore leggibile di option
              $nomechiave = $ar["chiave"]; // id - valore del campo <select> nascosto, per il post
               
              //qUERY MIGLIORATA, considera solo
               $q = "select $nometabella.$nomechiave as $nomechiave, $nometabella.$nomecampo, count(".$this->TABELLA.".".$this->CHIAVE.") as countdtmimporta
              from 
              $nometabella LEFT JOIN ".$this->TABELLA." ON 
               $nometabella.$nomechiave = ".$this->TABELLA.".$campo
              group by 
              $nomecampo
              order by `$nomecampo` ASC, countdtmimporta DESC ";
              
              $this->SQL->query($q);
              print '<br><input type="text" name="'.$campo.'" size=12 '.$altri_attributi.' >';
              print ' - <select name="_dtm_'.$campo.'" onChange="'.$this->NOMEFORM.'.'.$campo.'.value = '.$this->NOMEFORM.'._dtm_'.$campo.'.value" size=5 '.$altri_attributi.' >';
              //print '<option value="">Inserted Links (all users)--&gt;</option>';
             
              while ($row = $this->SQL->fetch())
              {
                $valore_chiave = $row[  $nomechiave ];
                 printf('<option value="%s" %s >%s</option>',
                      $valore_chiave,
                      ($this->UPDATE && $oldvalue == $valore_chiave )? ' selected = "selected" ':'',
                      htmlentities($row[ $nomecampo ])." (".$row["countdtmimporta"].")"
                      );
              }
              print '</select>';
              ?>
              <?
        
          }
          else if ($this->CRUDCONF[$campo]["import_values"]) //<!--importa_select2 tabella campo chiave-->
          {
               
              $ar = $this->CRUDCONF[$campo]["import_values"];
              $nometabella = $ar["tabl"]; // sw_cat
              $nomecampo = $ar["campo"]; // categoria - campo con cui riempire valore leggibile di option
              $nomechiave = $ar["chiave"]; // id - valore del campo <select> nascosto, per il post
               
              //qUERY MIGLIORATA, considera solo
              /* $q = "select DISTINCT $nometabella.$nomechiave as $nomechiave, $nometabella.$nomecampo
              from 
              $nometabella LEFT JOIN ".$this->TABELLA." ON 
               $nometabella.$nomechiave = ".$this->TABELLA.".$campo."
                 ".suffisso_query."
              " order by  `$nometabella`.`$nomecampo` ASC";*/
              
              $q = "select * from $nometabella ".$ar['suffisso_query'];
              
              /* countdtmimporta DESC,
              group by 
              $nomecampo serve ? */
              //print_r($GLOBALS);
              $this->SQL->query($q);
              
              print '<select name="'.$campo.'" '.$altri_attributi.' >';
              print '<option value="">Choose one below ...</option>';
             
              while ($row = $this->SQL->fetch())
              {
                $valore_chiave = $row[  $nomechiave ];
                 printf('<option value="%s" %s >%s</option>',
                      $valore_chiave,
                      ($this->UPDATE && $oldvalue == $valore_chiave )? ' selected = "selected" ':'',
                      htmlentities($row[ $nomecampo ])
                      );
              }
              print '</select>';

        
          }
          else if ($this->CRUDCONF[$campo]["importa_select_hierchical"]) //<!--importa_select2 tabella campo chiave-->
          {
               
              $ar = $this->CRUDCONF[$campo]["importa_select_hierchical"]; 
              $nometabella = $ar["tabella"]; // sw_cat
              $nomecampo = $ar["campo"]; // categoria - campo con cui riempire valore leggibile di option
              $nomechiave = $ar["chiave"]; // id - valore del campo <select> nascosto, per il post
              $nomechiaveImp = $ar["chiave_ricorsiva"]; 
               
              //QUERY MIGLIORATA, considera solo
              
              $q = "select * FROM `$nometabella`";
              $this->SQL->query($q);
              $alberoCats = array();
              while ($row = $this->SQL->fetch())
              {
                $alberoCats[] = array($row[$nomechiave], $row[$nomecampo], $row[$nomechiaveImp]) ;
              }
              
              $alberoCats = $this->figli(0, 0, $alberoCats);
              
              print '<select name="'.$campo.'" '.$altri_attributi.' >';
              print '<option value="">Choose one below ...</option>';
              //
              foreach($alberoCats as $elemCorr) //while ($row = $this->SQL->fetch())
              {
                 list($valore_chiave, $nomecampo) = $elemCorr;
                 //if (substr($nomecampo, 3,1)!='-')
                 //   print "<option></option>";
                 //$valore_chiave = $row[  $nomechiave ];
                 printf('<option value="%s" %s >%s</option>',
                      $valore_chiave,
                      ($this->UPDATE && $oldvalue == $valore_chiave )? ' selected = "selected" ':'',
                      htmlentities( $nomecampo )
                      );
              }
              print '</select>';

        
          }     
          //DA TESTARE          
          else if ( $this->CRUDCONF[$campo]['form_func'])
          {
            //no fa niente ma evita continuazione switch
            /*if ($this->UPDATE)
              {} //a fine form
            else
              print "effettuare dopo l'inserimento"; //*/
          } 
          else if ($this->CRUDCONF[$campo]['query_select']) //<!--importa_select2 tabella campo chiave-->
          {
               
             //qUERY MIGLIORATA, considera solo
               $q = $this->CRUDCONF[$campo]['query_select']['q'];
        // print $q;
              /* countdtmimporta DESC,
              group by 
              $nomecampo serve ? */
             
              $this->SQL->query($q);
              
              print '<select name="'.$campo.'" '.$altri_attributi.' '.$this->CRUDCONF[$campo]['query_select']['onchange'].' >';
              print '<option value="">Choose one below ...</option>';
             
              while ( $r = $this->SQL->fetch() )
              {
                 printf('<option value="%s" %s >%s</option>',
                      $r['opt'],
                     ( ($this->UPDATE && $oldvalue == $r['opt'] ) ||
   										 ($this->INSERT_FORM && 
											   $GLOBALS['_SESSION']['LAST'][$this->TABELLA][$campo]== $r['opt'] )) ? ' selected = "selected" ':'',
                      $r['val']
                      );
              }
              print '</select>';
        
          } 
          else if ( $this->CRUDCONF[$campo]["select-items"] ) //<!--importa_select2 tabella campo chiave-->
          {
               
              $corrisp = $this->CRUDCONF[$campo]["select-items"];
              
              print '<br><select name="'.$campo.'" '.$altri_attributi.' >';
             print '<option value="">Choose one below</option>';
              foreach ($corrisp as $k => $v)
              {
                 printf('<option value="%s" %s >%s</option>',
                      $k,
                      ((($this->UPDATE && $oldvalue == $k )   || (!$this->UPDATE  && $attr['default']==$k)    )
											||
											($this->INSERT_FORM && 
											   $GLOBALS['_SESSION']['LAST'][$this->TABELLA][$campo]== $k && !isset($attr['default']) )
												 )? ' selected = "selected" ':'',
                      $v
                      );
              
              }
               print '</select>';
         
         
         
          }
          else if ($this->CRUDCONF[$campo]["radio"]) //<!--importa_select2 tabella campo chiave-->
          {
               
              $corrisp = $this->CRUDCONF[$campo]["radio"];
              //if (!is_array($corrisp))
              //  $corrisp = $this->CRUDCONF[$campo]["radio"];
        
              foreach ($corrisp as $k => $v)
              {
                 
           printf('<br><label><input type="radio" name="'.$campo.'" value="%s" %s  '.$altri_attributi.' />%s</label>',
                       $k, //trim necessario
                      ( ($this->UPDATE && $oldvalue == $k) || (!$this->UPDATE  && $attr['default']==$k) )? ' checked="checked" ':'',
                      $v
                      );
              
              }
               print '<br>';
          }         
          else if ($attr['type']=="int" || $attr['type']=="string" || $attr['type']=="real"  || $attr['type']=="timestamp")
          {
                
                if ($attr['type']=="string")
                  $oldvalue = htmlentities($oldvalue);
                
                $maxlen = $len = $attr['len'];//255
                if ( $len > $this->input_max_lenght )
                      $len = $this->input_max_lenght;
                      
                if ($this->CRUDCONF[$campo]["conferma"]      )
                {
                  print 'Insert: <input type="text" name="'.$campo.'" id="campo_'.$campo.'" size="'.$len.'" maxlength="'.$maxlen.'" value="'.$oldvalue.'" '.$altri_attributi.'  /><br>Conferma : <input type="text" name="_dtm_'.$campo.'_conferma" size="'.$len.'" maxlength="'.$maxlen.'" value="'.$oldvalue.'" '.$altri_attributi.'  />';
                }
                else
                {
                  print '<input type="text" name="'.$campo.'" id="campo_'.$campo.'" size="'.$len.'" maxlength="'.$maxlen.'" value="'.$oldvalue.'" '.$altri_attributi.'  />';
                }
                
                      
             
   
          }
          else if ($attr['type']=="blob")
          {
             if ($this->CRUDCONF[$campo]["fck"])
             {
                  $dtm_opt = $this->CRUDCONF[$campo]["fck"];
                  $dtmGlobalOpt = $this->DTM_GLOBAL_CONF["fck"];

          //$dtmGlobalOpt["basePath"] = "../include/fckeditor/";
          //$dtmGlobalOpt["SkinPath"] = '../editor/skins/office2003/';
          
          if (!$dtmGlobalOpt["basePath"])
            $dtmGlobalOpt["basePath"] = "include-crudfact/fckeditor251/";
            
          
          require_once($dtmGlobalOpt["basePath"]."fckeditor.php"); //$dtmGlobalOpt["basePath"]
				//
				$oFCKeditor = new FCKeditor($campo);
                $oFCKeditor->BasePath = $dtmGlobalOpt["basePath"] ;
			    $oFCKeditor->Config['SkinPath'] = '../editor/skins/office2003/' ; //okkio !
//				$oFCKeditor->Config['UserFilesPath'] = $dtmGlobalOpt["UploadPath"]; //'/export/home/admin.fstv.sm/img/upload' ;
          $oFCKeditor->Config['UserFilesPath']= $dtmGlobalOpt["UserFilesPath"] ? $dtmGlobalOpt["UserFilesPath"] : '/uploads/';
          $oFCKeditor->Config['UserFilesAbsolutePath']= $dtmGlobalOpt["UserFilesAbsolutePath"] ? $dtmGlobalOpt["UserFilesAbsolutePath"] : '/var/www/vhosts/[TODO].it/httpdocs/uploads/';
          
                $oFCKeditor->Config['Enabled'] = true ;
                $oFCKeditor->Config['DefaultLanguage'] = 'it' ; //okkio !
                $oFCKeditor->Config['DefaultLinkTarget'] = '_blank' ; //okkio !
				$oFCKeditor->Config['ForceStrongEm'] = true ; //okkio !
                $oFCKeditor->Width  = $dtm_opt["w"] ? $dtm_opt["w"] : '550' ;
                $oFCKeditor->Height = $dtm_opt["h"] ? $dtm_opt["h"] : '200' ;
                
                $oFCKeditor->ToolbarSet = $dtm_opt["toolbar"] ? $dtm_opt["toolbar"] : "Basic"; //usa  fckconfig.js in fondo a sto file
                $oFCKeditor->Value = $oldvalue;
                $oFCKeditor->Create();
                  
                  /*if ($this->UPDATE)
                  print '<input name="_dtm_disable_button" type="button" 
                  value="disabilita (evita che venga riscritto nel db in update) !"
                  onClick=" if (confirm(\'Disabilito textarea ? perderai modifiche fatte !\')) 
                  '.$this->NOMEFORM.'.'.$campo.'.name = \'_dtm_textarea_disabled\'">';*/
                       
               }
               else
               {
                  $oldvalue = htmlentities($oldvalue);
                  $sizeR = $this->CRUDCONF[$campo]["rows"] ? $this->CRUDCONF[$campo]["rows"] : 5;
                  $sizeC = $this->CRUDCONF[$campo]["cols"] ? $this->CRUDCONF[$campo]["cols"] : 50;
                  print "<br><textarea name=\"".$campo."\" cols=\"".$sizeC."\" rows=\"".$sizeR."\"  '.$altri_attributi.' >".$oldvalue."</textarea>";
               }
          
          }
          else if ($attr['type']=="date") // funzia ???
          {
                if ($this->UPDATE)
                  print '<input type="text" size="30" maxlength="30" name="'.$campo.'" value="'.$oldvalue.'"  '.$altri_attributi.' />';
                else
                  print '<input type="text" size="30" maxlength="30" name="'.$campo.'" value="'.date("Y-m-d").'"  '.$altri_attributi.' />';
                
               //print '<br><span class="desc"></span>';
          }
      
          /***************** FINE ELSE ********/

      
      
          /*******  COSE IN AGGIUNTA **/
          /*******/
      
      if ($this->CRUDCONF[$campo]["cal"])
        { 
          if (!$this->SCRIPT_CAL_INSERTED)
          {
            if (!$this->DTM_GLOBAL_CONF["js"]["cal2"])
              $this->DTM_GLOBAL_CONF["js"]["cal2"] = "include-crudfact/cal2.js";
            ?><script language="javascript" src="<?= $this->DTM_GLOBAL_CONF["js"]["cal2"]   ?>"></script><?
          $this->SCRIPT_CAL_INSERTED = true;
          }
          ?><script language="javascript">
           var aggiunta = '<?  if  ($this->CRUDCONF[$campo]["cal"]["timestamp"])  print date(" H:i:s");      ?>';
          addCalendar("Calendar<?=$campo?>", "choose", "<?=$campo?>", "<?=$this->NOMEFORM?>");
          </script>
          <a href="javascript:showCal('Calendar<?=$campo?>')">change</a><?
        }
       /***********/
       
       
          if ( isset($this->CRUDCONF[$campo]["select"]) )
          {
             $dtmOpt = $this->CRUDCONF[$campo]["select"];
             $size = $dtmOpt["size"] ? $dtmOpt["size"] : 5;
             $fontSize = $dtmOpt["fontsize"] ? $dtmOpt["fontsize"] : 10;
             print $this->CRUDCONF[$campo]["select"]["textinto"];
             print '<br /><select name="_dtm_'.$campo.'" onChange="'.$this->NOMEFORM.'.'.$campo.'.value = '.$this->NOMEFORM.'._dtm_'.$campo.'.value" size="'.$size.'" style="font-size:'.$fontSize.'px">';
             print '<option value=""> voci gi&agrave; presenti --&gt;</option>';
                
            $qGroup = "SELECT  `".$campo."`, count(`".$campo."`) as countcdtmelenca FROM `".$this->TABELLA."` group by `".$campo."` order by `countcdtmelenca` DESC ";
            
            $q = $dtmOpt["query"] ? $dtmOpt["query"] : $qGroup;
            //print $q;
            $cols = $this->SQL->query(	$q);
            
            while ($r = $this->SQL->fetch())
            {
              if ($r[$campo])
                print '<option value="'.$r[$campo].'">'.$r[$campo].'</option>';
            }
              
            print "</select>";
          
          }
          /***********/
           
           //chiamo funzione personalizzata in editing form (dentro poi switcha se sei in edit o insert)
          if ( $this->CRUDCONF[$campo]['form_func'] /*&& $this->UPDATE*/)
              call_user_func($this->CRUDCONF[$campo]['form_func'],  $this->OLD_ROW /*$this->CHIAVE_VALGET */ );
              
          if ($this->CRUDCONF[$campo]["euro"])
          {
           print " <b>&euro;</b>";
          }
        
          if ( $this->CRUDCONF[$campo]["suffisso"] )
              print $this->CRUDCONF[$campo]["suffisso"];

          if ( $this->CRUDCONF[$campo]["text"] )
              print '&nbsp;<span class="desc">'.$this->CRUDCONF[$campo]["text"].'</span>';
          
          
          
          
          print "</td></tr>";
          
         // print "<pre>"; print_r($attr); print "</pre>";
    }/*******************************************************************/
    
    
    //figli del padre
    function figli($padreCorr, $livCorr, $a)
    {
       $ret = array();
       $prefissiLivelli = array("","---","------","---------","------------","---------------");
       foreach($a as $v)
       {
          list($id, $nome, $genitore) = $v;
          //cerco i figli diretti
          //print "[$id, $nome, $genitore]";
          if ( $genitore == $padreCorr )
          {
            //metto il figlio diretto 
            $ret[ ] = array($id, $prefissiLivelli[$livCorr].$nome);
            
            //aggiungo sottoFigli della cat corrente
            $ret = array_merge($ret,  $this->figli($id, $livCorr+1, $a)   );
          }  
       }
       return $ret;
    }

    //Chiamata prima di fare query, deve ritornare 1
    function before_insert()
    {
    
      return 1;
    }

    
    /********************/
    /*   CONTROLLO COMPATIBILITA' INPUTS<->TABELLA MYSQL    */
    /*******************/
    function controllo_inputs() // if 
    {
        foreach($this->POST as $campo => $value)
        {
              $type = $this->AST[$campo]['type'];
              $len = $this->AST[$campo]['len'];
              $flags = $this->AST[$campo]['flags']; 
              $isNotNull = strstr($flags, "not_null");
              $isUnique = strstr($flags, "unique_key");
              
              if ($isUnique && $this->INSERT )
              {
                $value = (get_magic_quotes_gpc()) ? stripslashes( $value) : $value; 
                $value = $this->SQL->escape($value); 
		$q = sprintf("select count(*) as c from `%s` WHERE `%s`='%s' ", $this->TABELLA, $campo, $value);
                $giaEsR = $this->SQL->query_n_fetch( $q, array());
                $giaEs = $giaEsR["c"];
                if ($giaEs!=0)
                   /**/ $this->elenco_errori[$campo] .= "valore gi&agrave; esistente in un altro record";
              }
              
              //inserimento/update
              if ($campo == "_dtm_mode_" && ($value != "INS" && $value != "UPD"))/**/ $this->elenco_errori[$campo] .= "modalita' gestione tabella non valida.";
              //not null
              if ( $isNotNull && $value=="" && !$this->CRUDCONF[$campo]["md5_pass"]) /**/  $this->elenco_errori[$campo] .= "valore non specificato.";
              //pass vuota ?
              if ( $this->INSERT && $this->CRUDCONF[$campo]["md5_pass"] && !$value  ) /**/  $this->elenco_errori[$campo] .= "non inserita";
              //int
              if ( $type=="int" && !is_numeric($value) && $value!="" )  /**/ $this->elenco_errori[$campo] .= "valore non numerico.";
              //password
              if ( ($this->CRUDCONF[$campo]["md5_pass"] || $this->CRUDCONF[$campo]["conferma"])
                  && $this->POST[''.$campo] != $this->POST['_dtm_'.$campo.'_conferma'] ) 
              $this->elenco_errori[$campo] .= "valori $campo non concidenti.";
              //email
              if (0 &&  $this->CRUDCONF[$campo]["check_mail"] && !eregi("^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$", $value) )  /**/ $this->elenco_errori[$campo] .= "E-mail non valida";
              //out of range !
              if ( isset($this->CRUDCONF[$campo]["rangelen"]["min"]) &&  $this->CRUDCONF[$campo]["rangelen"]["min"] > strlen($value) )  /**/ $this->elenco_errori[$campo] .= "Valore [$value]troppo corto (almeno ".$this->CRUDCONF[$campo]["rangelen"]["min"]." caratteri)";
              if ( isset($this->CRUDCONF[$campo]["range"]["min"]) &&  $this->CRUDCONF[$campo]["range"]["min"] > $value )  /**/ $this->elenco_errori[$campo] .= "Valore troppo piccolo (minimo consentito: ".$this->CRUDCONF[$campo]["range"]["min"].")";
              if ( isset($this->CRUDCONF[$campo]["range"]["max"]) &&  $this->CRUDCONF[$campo]["range"]["max"] < $value )  /**/ $this->elenco_errori[$campo] .= "Valore troppo grande (massimo consentito: ".$this->CRUDCONF[$campo]["range"]["max"].")";
              //over len
              if ( ($type=="string" || $type=="blob" || $type=="int" ) && strlen($value)>$len && $len!=-1 ) /**/  $this->elenco_errori[$campo] .= "stringa inserita ($value) troppo lunga (".strlen($value)."). Massimo consentito: $len caratteri.";
              
        }
        
        if ( count($this->elenco_errori) )
            {  $this->modulo_errori(); return 1; } //lancio funzione personalizzata e ritorno 1 => nn faccio query
        else
            {  $this->modulo_ok(); return 0; } //lancio funzione personalizzata e ritorno 0 => faccio querye
      
    }/*******************************************************************/
    
    
    
    
    
    function modulo_errori() //eseguita quando ins/upd/del OK (mettici link per tornare), poi nn continua !
    {
          print "<h4>Rilevati ".count($this->elenco_errori)." errori nel modulo per tabella '".$this->TABELLA."'</h4><ul>";
          foreach($this->elenco_errori as $key => $val)
            print "<li>Campo <b>$key</b>: $val</li>";
          print "</ul><h4>Operazione NON effettuata</h4><br>";
          print '<h4><a href="javascript:history.go(-1)">Indietro</a></h4>';
          //$this->home();
          exit;  
    }
     
    function modulo_ok() //eseguita quando ins/upd/del OK (mettici link per tornare) !
    {
    	
    }
    
    function scrittura_ok($str = "") //eseguita quando ins/upd/del OK (mettici link per tornare) !
    {
          print "<h4>$str record: operazione eseguita correttamente</h4>";
          $this->home();
          
          /*$linkRet = $this->makeUrl(array("refresh"=>time(), "id"=>0, "ok"=>1,"insert"=>0, "cancella"=>0));
          ?><hr>
          <script language="javascript">location.href='<?=$linkRet?>'</script>
          <a href="<?=$linkRet?>">Ritorna</a>
          <?
          exit;
          $this->UPDATE = 0; //evita ristampa modulo*/
    }
    
    function scrittura_errore($str = "") //eseguita quando ins/upd/del ERRORE (mettici link per tornare) !
	  {
	  //if (   stristr( $str, "duplicate entry" ) != false   )
		//$dupli = "campo ripetuto. ";
	  print "<h4>$str record : <font color=red>ERRORE !  (operazione NON eseguita)</font></h4>";
	  ?>
	  <a href="javascript:history.go(-1)">Indietro</a>
	  <?
		 exit;
	 }
	/*********/
    
    function get_ast()
    {
          return $this->AST;
    }
	
	
	function help()
	{
	  print_r(get_class_methods("dynamic_manage"));
	  print "</pre>";
	
	}
	
	function home($str = "torna all'elenco") //stampa link con parametro refresh a 'sta pagina
	{
		 if ($this->POPUP_MODE)
         {
            ?><br />
            <input type=button onClick="window.close()" value="chiudi finestra"><br /><br />
            <a href="javascript:history.go(-1)">Indietro</a><br />
            <script language=javascript>window.opener.location.reload()</script>
            <? exit;
         }
         else
         {
             $urlRet = $this->makeUrl( array("table"=>$this->TABELLA, "id"=>0,"refresh"=>date("FjGis"), "insert"=>0,"cancella"=>0) );
             if (!$this->NOREDIRECT){ ?>
             <script language=javascript>location.href="<?=$urlRet?>"</script>
             <? } ?>
             <h4><a href="<?=$urlRet?>">Torna all'elenco</a></h4><?
             exit;
         }
	}
    
	
  

}
/*****/



/*************** fckeditor *******************/


/*** aggiungi a fckconfig.js


FCKConfig.ToolbarSets["Elvis"] = [
	['Cut','Copy','Paste','PasteText','PasteWord','-','Print','SpellCheck'],['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],['Source'],
	'/',
	['Bold','Italic','Underline','StrikeThrough','-','Subscript','Superscript'],
	['FontFormat','FontName','FontSize'],
	'/',
	['OrderedList','UnorderedList','-','Outdent','Indent'],
	['JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],
	['Link','Unlink','Anchor'],
	['Image','Flash','Table','Rule','Smiley','SpecialChar'],
	
	['TextColor'],
	['FitWindow','ShowBlocks']
] ;
*******************************************/

?>