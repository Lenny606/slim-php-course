<?php
// $app->verb('url', callback/class/controller class)----------------------------------------------------------------
$app->get('/', function () {
    return 'response';
});
$app->get('/home', 'MyHomeClass');

$app->get('/page', 'MyController');
