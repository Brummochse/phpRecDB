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
header('Content-Type:text/html; charset=UTF-8');
include_once "phpRecDB/phpRecDB.php";
$prdb = new phpRecDB();
$prdb->startInternalSite();
?>
