<?php
$this->widget('bootstrap.widgets.TbModal', array(
    'id' => 'modal2014_07_10',
    'header' => '2014-07-10',
    'content' => "<h2> Version 1.1 released</h2>".
    "<p>Another year went past and it's time for another public release. Most changes happened in the Administration panel.<br>".
    "I removed all the PHP 5.3 specific code from Version 1.0. This means the script should work again on PHP 5.1.<br>".
    "<p><em>changes:</em></p>".
    "<ul><li>added: backend lists collapseable option</li>".
    "<li>added: new theme 'NewWay'</li>".
    "<li>added: record count per artist in artistmenu</li>".
    "<li>added: submenus in artist menu</li>".
    "<li>added: handling for user defined record information fields</li>".
    "<li>added: backup/restore database</li>".
    "<li>added: visitor record statistics</li>".
    "<li>added: visit counter for detail pages of records</li>".
    "<li>added: column management for lists</li>".
    "<li>added: signature text size is now changeable</li>".
    "<li>added: php extension/library check for GD and FreeType</li>".
    "<li>changed: naming conventions for list cell classes, example: 'location-col' -> 'cLocation'</li>".
    "<li>changed: fixed some english translations</li>".
    "<li>changed: notification handler in backend is now based on flash messages</li>".
    "<li>bugfixing: length limitation in backend views for list preset forms</li>".
    "<li>bugfixing: newslist/signature shows form same artists are now sorted chronologic (and not longer for daytime when they were added)</li>".
    "<li>bugfixing: signature list supports now full utf8 charset</li>".
    "<li>bugfixing: when a concert has several records, the different versions are sorted now alphabetical</li></ul>",
));
?>