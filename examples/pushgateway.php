<?php
require __DIR__ . '/../vendor/autoload.php';

use Campanda\Prometheus\Storage\Redis;
use Campanda\Prometheus\CollectorRegistry;

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

$counter = $registry->registerCounter('test', 'some_counter', 'it increases', ['type']);
$counter->incBy(6, ['blue']);

$pushGateway = new \Prometheus\PushGateway('192.168.59.100:9091');
$pushGateway->push($registry, 'my_job', array('instance'=>'foo'));
