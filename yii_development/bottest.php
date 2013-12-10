<?php

 function botDetect() {
        $bots_list = array(
            "Google" => "Googlebot",
            "Yahoo" => "Slurp",
            "Bing" => "bingbot"
                /* You can add more bot here */
        );
        $regexp = '/' . implode("|", $bots_list) . '/';
        $ua = 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)';//$_SERVER['HTTP_USER_AGENT'];
        if (preg_match($regexp, $ua, $matches)) {
            $bot = array_search($matches[0], $bots_list);
            return $bot;
        } else {
            return false;
        }
    }
    
    echo botDetect();
?>
