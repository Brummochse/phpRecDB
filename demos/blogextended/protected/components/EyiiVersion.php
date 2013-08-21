<?php
// @version $Id: YiiBase.php
class EyiiVersion {

	public static function getVersion()
	{
		$file=Yii::app()->basePath.'/../../../framework/YiiBase.php';
		$fh = fopen($file, 'r');
		$flag = true;
		while(($rec = fgets($fh)) && $flag) {
			if (strpos($rec, '$Id:')) {
				$tok = explode(' ', $rec);
				$value = $tok[5];
				$flag = false;
			}
		}
		fclose($fh);
		return $value;
	}
}
