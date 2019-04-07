<?php

require __DIR__ . '/../vendor/autoload.php';

use Campanda\Prometheus\CollectorRegistry;
use Campanda\Prometheus\RenderTextFormat;
use Campanda\Prometheus\Storage\Redis;

$adapter = $_GET['adapter'];

if ($adapter === 'redis') {
    Redis::setDefaultOptions(array('host' => isset($_SERVER['REDIS_HOST']) ? $_SERVER['REDIS_HOST'] : '127.0.0.1'));
    $adapter = new Campanda\Prometheus\Storage\Redis();
} elseif ($adapter === 'apc') {
    $adapter = new Campanda\Prometheus\Storage\APC();
} elseif ($adapter === 'in-memory') {
    $adapter = new Campanda\Prometheus\Storage\InMemory();
}
$registry = new CollectorRegistry($adapter);
$renderer = new RenderTextFormat();
$result = $renderer->render($registry->getMetricFamilySamples());

header('Content-type: ' . RenderTextFormat::MIME_TYPE);
echo $result;
