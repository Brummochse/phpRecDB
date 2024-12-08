<?php

return array(
    'user' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'can manage shows',
        'bizRule' => '',
        'data' => ''
    ),
    'admin' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'full access with user management',
        'children' => array(
            'demo', 'user'
        ),
        'bizRule' => '',
        'data' => ''
    ),
    'demo' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'for demonstration',
        'bizRule' => '',
        'data' => ''
    ),
);
?>
