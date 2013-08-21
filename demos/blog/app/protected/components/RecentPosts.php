<?php
  // @version $Id: RecentPosts.php 68 2010-08-20 09:43:02Z mocapapa@g.pugpug.org $

class RecentPosts extends CPortlet
{
  public $title='Recent Posts';
  public $maxPosts=10;

  public function getRecentPosts()
  {
    return Post::model()->findRecentPosts($this->maxPosts);
  }

  protected function renderContent()
  {
    $this->render('recentPosts');
  }
}