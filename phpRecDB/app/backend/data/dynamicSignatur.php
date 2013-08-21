<?php
Header("Expires: -1");
Header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
Header("Pragma: no-cache");
Header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
Header("Content-type: image/png");
readfile("sig.png");
?>