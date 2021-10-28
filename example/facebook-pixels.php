<?php
require_once('../vendor/autoload.php');

$apiKey = 'hs2hzLYx8fKn9qDE';
$auth = new \PWAGroup\Auth($apiKey);
$PWA = new \PWAGroup\PWAs\PWA($auth);
$pwa = $PWA->read('Z7wb_NdSX');
$FBPs = $pwa->getFBPs();
$FBPs[] = new \PWAGroup\Models\FBP(['id' => 12345678, 'lead' => 'install']);
$pwa->setFBPs($FBPs);
$PWA->update($pwa);

$pwa = $PWA->read('Z7wb_NdSX');
$FBPs = $pwa->getFBPs();
var_dump($FBPs);

$pwa->setFBPs([]);
$PWA->update($pwa);

$pwa = $PWA->read('Z7wb_NdSX');
$FBPs = $pwa->getFBPs();
var_dump($FBPs);
