<?
class ContentPage extends ContentPageEcho {

    public function execute($smarty,$linky) {
        ?>

<link rel="stylesheet" type="text/css" href="cruds/style.css" />
        <?
        $table="lists";
        include_once dirname(__FILE__) . '/../../constants.php';
        include  Constants::getLibsFolder()."Crud/simpleCrudSelect.php";
    }
}
?>
