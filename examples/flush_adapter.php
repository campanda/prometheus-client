<?php
require __DIR__ . '/../vendor/autoload.php';

$adapter = $_GET['adapter'];

if ($adapter === 'redis') {
    define('REDIS_HOST', isset($_SERVER['REDIS_HOST']) ? $_SERVER['REDIS_HOST'] : '127.0.0.1');

    $redisAdapter = new Campanda\Prometheus\Storage\Redis(array('host' => REDIS_HOST));
    $redisAdapter->flushRedis();
} elseif ($adapter === 'apc') {
    $apcAdapter = new Campanda\Prometheus\Storage\APC();
    $apcAdapter->flushAPC();
} elseif ($adapter === 'in-memory') {
    $inMemoryAdapter = new Campanda\Prometheus\Storage\InMemory();
    $inMemoryAdapter->flushMemory();
}