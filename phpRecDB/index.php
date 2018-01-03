<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
?>
    
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
 * @link http://www.phprecdb.de.vu
 * @copyright 2009-2013 <the-patient@gmx.de>
 * @license http://www.gnu.org/licenses/
 */
include_once "phpRecDB.php";
$prdb = new phpRecDB();
$prdb->adminPanel();
?>

<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
//echo 'Page generated in '.$total_time.' seconds.';
?>