<?php
class ShowManager {


    public static function insertConcertWithTextAndGetId($artist, $date, $country, $city, $venue, $supplement, $miscBoolean) {
        $artist=mysql_real_escape_string(trim($artist));
        $date=mysql_real_escape_string(trim($date));
        $country=mysql_real_escape_string(trim($country));
        $city=mysql_real_escape_string(trim($city));
        $venue=mysql_real_escape_string(trim($venue));
        $supplement=mysql_real_escape_string(trim($supplement));

        $id_artist=ShowManager::getArtistId($artist);
        $id_country=ShowManager::getCountryId($country);
        $id_city=ShowManager::getCityId($city, $id_country);
        $id_venue=ShowManager::getVenueId($venue, $id_city);
        return ShowManager::insertConcertAndGetId($id_artist, $date, $id_country, $id_city, $id_venue, $supplement, $miscBoolean);
    }

    public static function insertConcertAndGetId($id_artist, $c_date, $id_country, $id_city, $id_venue, $c_supplement, $miscBoolean) {
        $sqlInsertNewConcert = "INSERT INTO concerts (artists_id,date,misc) VALUES (" . $id_artist . ",'" . $c_date . "'," . $miscBoolean . ");";
        mysql_query($sqlInsertNewConcert) or die("MySQL-Error: " . mysql_error());
        $concertId = mysql_insert_id();
        if (!empty ($id_country))
            mysql_query($sqlInsertCountry = "UPDATE concerts SET countrys_id=" . $id_country . " WHERE concerts.id=" . $concertId) or die("MySQL-Error: " . mysql_error());
        if (!empty ($id_city))
            mysql_query($sqlInsertCountry = "UPDATE concerts SET citys_id=" . $id_city . " WHERE concerts.id=" . $concertId) or die("MySQL-Error: " . mysql_error());
        if (!empty ($id_venue))
            mysql_query($sqlInsertCountry = "UPDATE concerts SET venues_id=" . $id_venue . " WHERE concerts.id=" . $concertId) or die("MySQL-Error: " . mysql_error());
        if (!empty ($c_supplement))
            mysql_query($sqlInsertCountry = "UPDATE concerts SET supplement='" . $c_supplement . "' WHERE concerts.id=" . $concertId) or die("MySQL-Error: " . mysql_error());
        return $concertId;
    }

    public static function getArtistId($c_artist) {
        $sqlSelectQuery = "SELECT id FROM artists WHERE name='" . $c_artist . "'";
        $sqlInsertQuery = "INSERT INTO artists (name) VALUES ('" . $c_artist . "');";
        return ShowManager::getId($sqlSelectQuery, $sqlInsertQuery, $c_artist);
    }

    public static function getCountryId($c_country) {
        $sqlSelectQuery = "SELECT id FROM countrys WHERE name='" . $c_country . "'";
        $sqlInsertQuery = "INSERT INTO countrys (name) VALUES ('" . $c_country . "');";
        return ShowManager::getId($sqlSelectQuery, $sqlInsertQuery, $c_country);
    }

    public static function getCityId($c_city, $id_country) {
        if (empty ($id_country)) { //kein land angegeben aber eine stadt ist bekannt
            $sqlSelectQuery = "SELECT id FROM citys WHERE name='" . $c_city . "' AND countrys_id is null";
            $sqlInsertQuery = "INSERT INTO citys (name) VALUES ('" . $c_city . "');";
        } else {
            $sqlSelectQuery = "SELECT id FROM citys WHERE name='" . $c_city . "' AND countrys_id=" . $id_country;
            $sqlInsertQuery = "INSERT INTO citys (name,countrys_id) VALUES ('" . $c_city . "'," . $id_country . ");";
        }
        return ShowManager::getId($sqlSelectQuery, $sqlInsertQuery, $c_city);
    }

    public static function getVenueId($c_venue, $id_city) {
        if (empty ($id_city)) { //keine stadt angegeben aber eine venue ist bekannt
            $sqlSelectQuery = "SELECT id FROM venues WHERE name='" . $c_venue . "' AND citys_id is null";
            $sqlInsertQuery = "INSERT INTO venues (name) VALUES ('" . $c_venue . "');";
        } else {
            $sqlSelectQuery = "SELECT id FROM venues WHERE name='" . $c_venue . "' AND citys_id=" . $id_city;
            $sqlInsertQuery = "INSERT INTO venues (name,citys_id) VALUES ('" . $c_venue . "'," . $id_city . ");";
        }
        return ShowManager::getId($sqlSelectQuery, $sqlInsertQuery, $c_venue);
    }

    private static function getId($sqlSelectQuery, $sqlInsertQuery, $value) {
        if (strlen($value) == 0)
            return null;
        $queryResults = mysql_query($sqlSelectQuery) or die("MySQL-Error: " . mysql_error());
        $firstRow = mysql_fetch_row($queryResults);
        if (!empty ($firstRow)) {
            return $firstRow[0];
        } else {
            mysql_query($sqlInsertQuery) or die("MySQL-Error: " . mysql_error());
            return ShowManager::getId($sqlSelectQuery, $sqlInsertQuery, $value);
        }
    }
}
?>
