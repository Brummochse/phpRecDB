<?php
  // @version $Id: Clock.php 72 2010-08-20 10:06:30Z mocapapa@g.pugpug.org $
class Clock extends CPortlet
{
  public $title='Clock';

  protected function renderContent()
  {
    $this->render('analog-clock');
  }
}
