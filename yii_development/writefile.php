<?php

  ob_start();
                            var_dump($this->image);
                            $result = ob_get_clean();
                            $datei_handle=fopen("testout.txt","w");
                            fwrite($datei_handle,$result);
                            fclose($datei_handle);
?>
