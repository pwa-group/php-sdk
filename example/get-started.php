<?php
require_once('../vendor/autoload.php');

$apiKey = 'xxxxxxxxxxxxxxxx';
$auth = new \PWAGroup\Auth($apiKey);
$pages = new \PWAGroup\PWAs\Pages($auth);
$pwas = $pages->getPage();
foreach ($pwas as $pwa) {
    var_dump($pwa->getLogo() . ' ' . $pwa->getAlias());
}
$pages->setFilter('tags', 'test');
$pwas = $pages->getPage();
foreach ($pwas as $pwa) {
    var_dump($pwa->getLogo() . ' ' . $pwa->getAlias());
}
$pages->unsetFilter('tags');
$pages->setFilter('status', \PWAGroup\PWAs\PWA::STATUS_STOP);
$pwas = $pages->getPage();
foreach ($pwas as $pwa) {
    var_dump($pwa->getLogo() . ' ' . $pwa->getAlias());
}
