<?php

class CssSection extends CWidget {

    public $tagName = 'div';
    public $id;
    public $cssFile;

    public function init() {
        parent::init();
        $this->publishCssFile();
        echo CHtml::openTag($this->tagName, array('id' => $this->id));
    }

    private function publishCssFile() {
        //path stuff
        $cssPathParts = pathinfo($this->cssFile);
        $cssFileName = $this->id . '_' . $cssPathParts['filename'];
        $cssSourceDir = $cssPathParts['dirname'];
        $cssRuntimeDir = Yii::app()->getRuntimePath() . DIRECTORY_SEPARATOR . $cssFileName;

        //only process css stuff when folder does not exist or in debug mode
        $refresh = !is_dir($cssRuntimeDir) || YII_DEBUG == TRUE;

        //TODO REMOVE:
        //$refresh=FALSE;

        if ($refresh) {
            Yii::import('application.vendors.*');

            require_once('Sabberworm/CSS/Parser.php');


            //autoloader for the use-statements in Sabberworm
            spl_autoload_register(function($class) {
                        $path = str_replace('\\', '/', $class) . '.php';
                        require_once ($path);
                    });
            $cssParser = new Sabberworm\CSS\Parser(file_get_contents($this->cssFile));
            $cssDocument = $cssParser->parse();

            $this->setPrefixIdsToCssBlocks($cssDocument, $this->id);
            $urls = $this->substituteUrlsInCss($cssDocument);

            //create dir if not exist
            if (!is_dir($cssRuntimeDir)) {
                mkdir($cssRuntimeDir);
            }

            //save css document ot file
            $cssFileContent = $cssDocument->__toString();
            file_put_contents($cssRuntimeDir . DIRECTORY_SEPARATOR . $cssFileName . ".css", $cssFileContent);

            //copy linked resources to runtime folder
            foreach ($urls as $url => $newUrlId) {
                copy($cssSourceDir . DIRECTORY_SEPARATOR . $url, $cssRuntimeDir . DIRECTORY_SEPARATOR . $newUrlId);
            }

            //spl_autoload_register(array('YiiBase', 'autoload'));
        }

        //publish css and linked resources
        $cssAssetPath = Yii::app()->assetManager->publish($cssRuntimeDir, true, -1, $refresh);

        //
        Yii::app()->clientScript->registerCssFile($cssAssetPath . '/' . $cssFileName . '.css');
    }

    /**
     * adds a prefix before to every css block
     * 
     * @param type $cssDocument css documnt
     * @param type $prefixId prefix
     */
    private function setPrefixIdsToCssBlocks($cssDocument, $prefixId) {
        //add #id to all css blocks
        foreach ($cssDocument->getAllDeclarationBlocks() as $oBlock) {
            foreach ($oBlock->getSelectors() as $oSelector) {
                $oSelector->setSelector('#' . $prefixId . ' ' . $oSelector->getSelector());
            }
        }
    }

    /**
     * @param type $cssDocument css document
     * @return array (key = old url, value = new url id)
     */
    private function substituteUrlsInCss($cssDocument) {
        $urls = array();
        $urlId = 0;

        foreach ($cssDocument->getAllValues() as $value) {
            if ($value instanceof Sabberworm\CSS\Value\URL) {
                $url = $value->getURL();

                //remove quotes from url
                $url = str_replace('"', "", $url);
                $url = str_replace("'", "", $url);

                //evaluate new url id
                if (array_key_exists($url, $urls)) {
                    $newUrlId = $urls[$url];
                } else {
                    $urlPathParts = pathinfo($url);
                    $urlExtension = $urlPathParts['extension'];
                    $newUrlId = $urls[$url] = $urlId . '.' . $urlExtension;
                    $urlId++;
                }

                //change url to new url id
                $value->setURL(new Sabberworm\CSS\Value\String($newUrlId));
            }
        }
        return $urls;
    }

    public function run() {
        parent::run();
        echo CHtml::closeTag($this->tagName);
    }

}

?>
