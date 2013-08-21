<?php
/*
    This file is part of phpRecDB.

    phpRecDB is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    phpRecDB is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<?php
class Constants {

    public static function getCsvImportPath() {
       return dirname(__FILE__) . "/temp/csvimport.csv";
    }

    public static function getSignatureFileName() {
        return "/temp/dynamic_signature.png";
    }

    public static function getDynamicSignatureName() {
        return "/misc/signatur.png";
    }

    public static function getScriptVersion() {
        return "Version 0.8 Test 1";
    }

    public static function getThumbnaiWith() {
        return 250;
    }
    //////////////////////////////////////
    //////////Folders/////////////////////
    //////////////////////////////////////
    public static function getAdminFolder() {
        return dirname(__FILE__) . "/admin/";
    }
    public static function getSettingsFolder() {
        return dirname(__FILE__) . "/settings/";
    }
    public static function getScreenshotsFolder() {
        return dirname(__FILE__) . "/screenshots/";
    }
    public static function getLibsFolder() {
        return dirname(__FILE__) . "/libs/";
    }
    public static function getFunctionsFolder() {
        return dirname(__FILE__) . "/functions/";
    }
    public static function getTemplateFolder() {
        return dirname(__FILE__) . "/templates/";
    }
    public static function getCompileFolder() {
        return dirname(__FILE__) . "/templates_c/";
    }
    public static function getClassFolder() {
        return dirname(__FILE__) . "/classes/";
    }
    public static function getRootFolder() {
        return dirname(__FILE__) . "/";
    }
    //////////////////////////////////////
    //////////get Parameters/////////////////////
    //////////////////////////////////////
    public static function getParamAdminMenuIndex() {
        return 'lid';
    }

    public static function getParamArtistId() {
        return 'artistid';
    }

    public static function getParamYear() {
        return 'year';
    }

    public static function getParamRecordId() {
        return 'recId';
    }
}
?>