<?
function convert_resize_jpg($orig, $dest, $cornice_massima, $filtro_veloce=0, $quality=45) //senza uscire da cornice massima
{
  	$size=getimagesize($orig);
	if (!size) return "<font color=red>ERRORE lettura foto. file non valido !</font><p>";

	if ($size[0] >= $size[1]) //larghezza > larghezza, cioè foto standard orizzontale => dimensione massima è la larghezza
	  $opzione_resize = "-resize ".$cornice_massima;
    else
      $opzione_resize = "-resize x".$cornice_massima;	//foto verticale => dimensione massima è l'altezza

    if ($filtro_veloce)
     $filtro = '-filter Quadratic';
    else
      $filtro = '-filter Cubic';

	$eseguo_convert= 'convert '.$orig.' -strip '.$filtro.'  '.$opzione_resize.' -quality '.$quality.' '.$dest; //oppure Quadratic
	passthru ($eseguo_convert);

	 if ( !getimagesize($dest))
       errore("<font color=red>ERRORE: [<br>".$orig."->".$dest."].<br>comando convert [".$eseguo_convert."] non funzionante:<br> contattare webmaster o riprovare</font><p>","jebn");
     

}
?>