<?php

require __DIR__ . '/../vendor/autoload.php';

use Campanda\Prometheus\CollectorRegistry;
use Campanda\Prometheus\Storage\Redis;

error_log('c='. $_GET['c']);

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

$histogram = $registry->registerHistogram('test', 'some_histogram', 'it observes', ['type'], [0.1, 1, 2, 3.5, 4, 5, 6, 7, 8, 9]);
$histogram->observe($_GET['c'], ['blue']);

echo "OK\n";
