<?php
include_once "ListBuilderPro.php";

class PublicList extends ListBuilderPro {

	function PublicList($data) {
		parent :: ListBuilderPro($data);
	}

	function getInfoLink($recordingId) {
		$url = Helper::makeUrl(array (
			Constants::getParamRecordId() => $recordingId
		));
		$link = "<a href='$url'>info</a>";
		return $link;
	}

	protected function getButtons($recordingId,$artistsId) {
		return $this->getInfoLink($recordingId);
	}

         protected function getArtistHtml($artistId) {
             return "";
         }

}
?>
