<?php
class ContentPage extends ContentPageSmarty {

	public function getPageTemplateFileName() {
		return "editConcert.tpl";
	}

	public function execute($smarty,$linky) {
		$smarty->assign('audioOrVideoSelection', 'true');
		$smarty->assign("relativeTemplatesPath", getRelativePathTo(Constants :: getTemplateFolder()));
		$smarty->assign('addConcertLink', $linky->encryptName('Add Concert'));
	}

}
?>