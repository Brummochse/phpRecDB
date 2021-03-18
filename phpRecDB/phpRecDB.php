<?php
/*
 * This file is part of phpRecDB.
 *
 * phpRecDB is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License.
 *
 * phpRecDB is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with phpRecDB. If not, see <http://www.gnu.org/licenses/>.
 * 
 * @author <the-patient@gmx.de>
 * @link http://www.phprecdb.com
 * @copyright 2009-2013 <the-patient@gmx.de>
 * @license http://www.gnu.org/licenses/
 */

header('Content-Type:text/html; charset=UTF-8');

//defined('YII_DEBUG') or define('YII_DEBUG', true);


//only for deprecated message
define("LAST_RECORDS_PER_DAY", 3);

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'PrdServiceProvider.php');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'yiiframework' . DIRECTORY_SEPARATOR . 'yii.php');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'settings' . DIRECTORY_SEPARATOR . 'dbConfig.php');

class phpRecDB implements PrdServiceProvider {

    private $theme = "";

    public function setTheme($theme) {
        $this->theme = $theme;
    }

    public function printNavigationBar() {
        echo "[ERROR: The method <b>printNavigationBar</b> is not longer supported by phpRecDB. Please remove the method-call.]";
    }

    /**
     * public methods from PrdServiceProvider
     */
    public function printVideoList($collapsed = true) {
        $this->doPrintList($collapsed, ListActionMap::RECORDS_Video);
    }

    public function printAudioList($collapsed = true) {
        $this->doPrintList($collapsed, ListActionMap::RECORDS_Audio);
    }

    public function printVideoNews($newsCount = 5, $newsType = LAST_DAYS) {
        $this->doPrintNews($newsCount, $newsType, ListActionMap::NEWS_Video);
    }

    public function printAudioNews($newsCount = 5, $newsType = LAST_DAYS) {
        $this->doPrintNews($newsCount, $newsType, ListActionMap::NEWS_Audio);
    }

    public function printNews($newsCount = 5, $newsType = LAST_DAYS) {
        $this->doPrintNews($newsCount, $newsType, ListActionMap::NEWS);
    }

    public function printStatistics() {
        $config = $this->getFrontendExternalConfig('statistics');
        Yii::createWebApplication($config)->run();
    }

    public function printList($collapsed = true) {
        $this->doPrintList($collapsed, ListActionMap::RECORDS);
    }

    public function printSubList($sublistName, $collapsed = true) {
        $config = $this->getFrontendExternalConfig(ListActionMap::SUBLIST);
        $config['params']['sublistName'] = $sublistName;
        $config['params']['collapsed'] = $collapsed;
        Yii::createWebApplication($config)->run();
    }

    public function printArtistList($artistName) {
        $config = $this->getFrontendExternalConfig(ListActionMap::ARTIST);
        $config['params']['artistName'] = $artistName;
        Yii::createWebApplication($config)->run();
    }

    public function adminPanel() {
        if (isset($_GET['mode']) && $_GET['mode'] == 'suggest') {  //param 'mode=suggest' forces to start light weight backend for autocomple suggestion
            $config = $this->getBackendSuggestConfig();
        } else {
            $config = $this->getBackendConfig();
        }

        Yii::createWebApplication($config)->run();
    }

    public function startInternalSite() {
        $config = $this->getFrontendInternalConfig();
        Yii::createWebApplication($config)->run();
    }

    private function doPrintNews($newsCount, $newsType, $action) {
        //check old deprecated news type LAST_RECORDS_PER_DAY
        if ($newsType == LAST_RECORDS_PER_DAY) {
            echo "[ERROR: news type <b>LAST_RECORDS_PER_DAY</b> is not longer supported by phpRecDB. Please change it.]";
            return;
        }
        $config = $this->getFrontendExternalConfig($action);
        $config['params']['newsCount'] = $newsCount;
        $config['params']['newsType'] = $newsType;
        Yii::createWebApplication($config)->run();
    }

    private function doPrintList($collapsed, $action) {
        $config = $this->getFrontendExternalConfig($action);
        $config['params']['collapsed'] = $collapsed;
        Yii::createWebApplication($config)->run();
    }

    /**
     * yii startups configs
     */
    private function getBackendConfig() {
        $dbSettings = $this->getDbSettings();
        $backendConfig = require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'backend.php');
        $commonConfig = require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'common.php');

        return array_merge_recursive($backendConfig, $commonConfig, $dbSettings);
    }

    private function getBackendSuggestConfig() {
        $dbSettings = $this->getDbSettings();
        $backendConfig = require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'suggest.php');

        return array_merge_recursive($backendConfig, $dbSettings);
    }

    private function getFrontendInternalConfig() {
        $dbSettings = $this->getDbSettings();
        $frontendConfig = require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'frontend.php');
        $commonConfig = require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'common.php');

        $config = array_merge_recursive($frontendConfig, $commonConfig, $dbSettings);

        //set theme
        if (strlen($this->theme) > 0)
            $config['theme'] = $this->theme;

        return $config;
    }

    private function getFrontendExternalConfig($defaultAction) {
        $config = $this->getFrontendInternalConfig();

        //set default action
        $config['params']['defaultAction'] = $defaultAction;

        return $config;
    }

    private function getDbSettings() {

        $dbConfig = new DbConfig();

        $dbSettings = array(
            'components' => array(
                'db' => array(
                    'connectionString' => 'mysql:host=' . $dbConfig->getHost() . ';dbname=' . $dbConfig->getDb(),
                    'emulatePrepare' => true,
                    'username' => $dbConfig->getUser(),
                    'password' => $dbConfig->getPass(),
                    'charset' => 'UTF8',
                    'tablePrefix' => '',
                )
            )
        );
        return $dbSettings;
    }

}

?>
