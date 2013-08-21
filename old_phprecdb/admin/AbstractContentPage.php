<?php
interface IContentPage {
	function chargeSmarty($smarty,$linky);
}

abstract class ContentPageSmarty implements IContentPage {

	public function chargeSmarty($smarty,$linky) {
		$this->execute($smarty,$linky);
		$smarty->assign('contentPageTemplate',$this->getPageTemplateFileName());
	}
	abstract function getPageTemplateFileName();

	abstract function execute($smarty,$linky);
}

abstract class ContentPageEcho implements IContentPage {

	public function chargeSmarty($smarty,$linky) {
		ob_start();
		$this->execute($smarty,$linky);
		$content = ob_get_contents();
		$smarty->assign('content', $content);
		ob_end_clean();
	}

	abstract function execute($smarty,$linky);
}
?>