<?php

class FragebogenController extends CController {

    public $layout = '';
    private $checkboxCounter = 0;
    private $textfieldCounter = 0;
    private $radiobuttons = array();
    private $resultsTextfield = array();
    private $resultsRadiobutton = array();
    private $resultsCheckbox = array();
    private $activeUser;
    private $isAdmin = FALSE;

    const USER_ID = 'u';
    const USER_PASS = 'k';
    const ADMIN_ID = 'ak';
    const ADMIN_PASS = 4456;

    public function actionIndex() {

//        $this->createUsers();
//        $this->createUserLinks();

        $adminPass = Helper::decodeIntParam(self::ADMIN_ID, $_GET);
        $userId = Helper::decodeIntParam(self::USER_ID, $_GET);
        $userKey = Helper::decodeIntParam(self::USER_PASS, $_GET);

        if ($adminPass != NULL) {
            $this->isAdmin = $adminPass == self::ADMIN_PASS;
        }

        if ($userId == NULL || $userKey == NULL) {
            $this->renderWithLayout('error', 'message');
            return;
        }

        $this->activeUser = User::model()->findByAttributes(array('random_id' => $userId, 'random_key' => $userKey));

        if ($this->activeUser == NULL) {
            $this->renderWithLayout('error', 'message');
            return;
        }

        if ($this->activeUser->done == TRUE) {
            if ($this->isAdmin) {
                $this->fetchResults();
                $this->render('form');
            } else {
                $this->renderWithLayout('alreadyDone', 'message');
                return;
            }
        } else { // $this->activeUser->done == FALSE
            if (empty($this->activeUser->open_time) && !$this->isAdmin) {
                $this->activeUser->open_time = date('Y-m-d H:i:s');
                $this->activeUser->save();
            }
            $this->render('form');
        }
    }

    private function createUserLinks() {
        $users = User::model()->findAll();

        foreach ($users as $user) {
            echo $user->email . '<br>';
            $link = 'http://ratmbootlegs.bplaced.net/fragebogeninfo/index.php?u=' . $user->random_id . '&k=' . $user->random_key;
            echo CHtml::link($link, $link) . '<br><br>';
        }
    }

    private function createUsers() {
        //wirtschatfshispnisten
//        $emails = array('Diana.Bluttner@fh-zwickau.de',
//            'Elisa.Petermann@fh-zwickau.de',
//            'Eva.Maria.Schedl@fh-zwickau.de',
//            'Felix.Doberenz@fh-zwickau.de',
//            'Friederike.Otte@fh-zwickau.de',
//            'Ina.Duennebier@fh-zwickau.de',
//            'Julia.Kiesshauer@fh-zwickau.de',
//            'Jennifer.Ziegner@fh-zwickau.de',
//            'Katja.Rehor@fh-zwickau.de',
//            'Katrina.Haupt@fh-zwickau.de',
//            'Kristin.Gutmann@fh-zwickau.de',
//            'Kristin.Soke@fh-zwickau.de',
//            'Lisa.Regner@fh-zwickau.de',
//            'Luise.Hesse@fh-zwickau.de',
//            'Marcel.Fritzsche@fh-zwickau.de',
//            'Melissa.Otto@fh-zwickau.de',
//            'Nancy.Hoerdler@fh-zwickau.de',
//            'Nathalie.Brunel@fh-zwickau.de',
//            'Pia.Froehlich@fh-zwickau.de',
//            'Sandra.Gutmann@fh-zwickau.de',
//            'SarahJohanna.Engling@fh-zwickau.de',
//            'Sarah.Waechter@fh-zwickau.de',
//            'Tatjana.Wolf@fh-zwickau.de',
//            'Tom.Walter@fh-zwickau.de',
//            'Ulrike.Bardel@fh-zwickau.de',
//            'Luisa.Majewski@fh-zwickau.de');

        $emails = array('Alexander.Loos.c5m@fh-zwickau.de',
            'Andreas.Kretzschmar.c3p@fh-zwickau.de',
            'Andy.Hermann@fh-zwickau.de',
            'Anne.Fischer.bq6@fh-zwickau.de',
            'Antony.Muindi.c76@fh-zwickau.de',
            'Astrid.Schindler.c59@fh-zwickau.de',
            'Benjamin.Mueller.byw@fh-zwickau.de',
            'Benjamin.Oeser.buq@fh-zwickau.de',
            'Christian.Fiedler.bnj@fh-zwickau.de',
            'Christian.Klein.ca0@fh-zwickau.de',
            'Christoph.Zelinski.bt7@fh-zwickau.de',
            'Enrico.Gruendig.bxt@fh-zwickau.de',
            'Enrico.Schirmer.0kp@fh-zwickau.de',
            'Florian.Schoenfelder.bpc@fh-zwickau.de',
            'Heinrich.Herzog.br0@fh-zwickau.de',
            'Immanuel.Hartung.c41@fh-zwickau.de',
            'Kevin.Lederer.bra@fh-zwickau.de',
            'Marcel.Freund.bq7@fh-zwickau.de',
            'Marcel.Liebl.c9x@fh-zwickau.de',
            'Marco.Hethke.c74@fh-zwickau.de',
            'Mathias.Grunert.cc5@fh-zwickau.de',
            'Max.Barth.bu9@fh-zwickau.de',
            'Moritz.Gebhardt.c4s@fh-zwickau.de',
            'Patrick.Nausch.c7p@fh-zwickau.de',
            'Sebastian.Knopp.ci3@fh-zwickau.de',
            'Sissy.Krause.c75@fh-zwickau.de',
            'Sven.Mueller.c9q@fh-zwickau.de',
            'Thomas.Schlott.btx@fh-zwickau.de',
            'Ursula.Reithofer.c88@fh-zwickau.de',
            'mikl@fh-zwickau.de');


        foreach ($emails as $email) {
            $name = substr($email, 0, strrpos($email, '@'));

            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->random_id = rand(1000000, 9999999);
            $user->random_key = rand(1000000, 9999999);
            $user->done = 0;
            if (!$user->save()) {
                echo "<br> error:";
                print_r($user->getErrors());
            }
            echo $user->name . ' ' . $user->email . ' ' . $user->random_id . ' ' . $user->random_key . '<br>';
        }
    }

    private function renderWithLayout($view, $layout) {
        $this->layout = $layout;
        $this->render($view);
    }

    private function fetchResults() {
        $checkboxes = Checkbox::model()->findAllByAttributes(array('users_id' => $this->activeUser->id));
        foreach ($checkboxes as $checkbox) {
            $_POST[$checkbox->element_id] = $checkbox->value;
        }

        $radiobuttons = Radiobutton::model()->findAllByAttributes(array('users_id' => $this->activeUser->id));
        foreach ($radiobuttons as $radiobutton) {
            $_POST[$radiobutton->element_id] = $radiobutton->value;
        }

        $textfields = Textfield::model()->findAllByAttributes(array('users_id' => $this->activeUser->id));
        foreach ($textfields as $textfield) {
            $_POST[$textfield->element_id] = $textfield->value;
        }
    }

    public function getRadioButton($name) {
        $name = 'radiobutton' . $name;
        $selected = false;

        if (array_key_exists($name, $this->radiobuttons)) {
            $id = $this->radiobuttons[$name] + 1;
        } else {
            $id = 0;
        }
        $this->radiobuttons[$name] = $id;

        if (isset($_POST[$name])) {
            $selected = $_POST[$name] == $id;
            $this->resultsRadiobutton[$name] = $_POST[$name];
        } else {
            $this->resultsRadiobutton[$name] = -1;
        }
        //        
        return CHtml::radioButton($name, $selected, array('value' => $id));
    }

    public function getCheckbox() {
        $this->checkboxCounter++;
        $selected = false;
        $name = 'checkbox' . $this->checkboxCounter;

        if (isset($_POST[$name])) {
            $selected = $_POST[$name];
        }
        //
        $this->resultsCheckbox[$name] = $selected;
        //
        return CHtml::checkBox($name, $selected);
    }

    public function getTextField($width = NULL) {
        $this->textfieldCounter++;
        $text = '';
        $name = 'textfield' . $this->textfieldCounter;

        if (isset($_POST[$name])) {
            $text = $_POST[$name];
        }

        $style = array();
        if ($width != NULL) {
            $style["style"] = "width: " . $width . "px;";
        }
        //
        $this->resultsTextfield[$name] = $text;
        //
        return CHtml::textField($name, $text, $style);
    }

    public function eventFormRenderFinished() {
        if (isset($_POST['sent'])) {
            ob_end_clean();
            $this->saveResults();
            $this->render('finished');
        }
    }

    private function saveResults() {
        foreach ($this->resultsTextfield as $elementId => $value) {
            $textField = new Textfield();
            $textField->element_id = $elementId;
            $textField->value = $value;
            $textField->users_id = $this->activeUser->id;
            if (!$textField->save()) {
                //error 
            }
        }

        foreach ($this->resultsRadiobutton as $elementId => $value) {
            $radioButton = new Radiobutton();
            $radioButton->element_id = $elementId;
            $radioButton->value = $value;
            $radioButton->users_id = $this->activeUser->id;
            if (!$radioButton->save()) {
                //error
            }
        }

        foreach ($this->resultsCheckbox as $elementId => $value) {
            $checkBox = new Checkbox();
            $checkBox->element_id = $elementId;
            $checkBox->value = $value;
            $checkBox->users_id = $this->activeUser->id;
            if (!$checkBox->save()) {
                //error
            }
        }

        $this->activeUser->done = TRUE;
        $this->activeUser->finish_time = date('Y-m-d H:i:s');

        $this->activeUser->save();
    }

    public function renderSendButton() {
        if (!$this->isAdmin)
            return CHtml::submitButton('Senden');
        else
            return '';
    }

}

?>
