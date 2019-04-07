<?php
namespace Campanda\Prometheus\Storage;

use Campanda\Prometheus\Collector;
use Campanda\Prometheus\MetricFamilySamples;
use Campanda\Prometheus\Sample;

interface Adapter
{
    const COMMAND_INCREMENT_INTEGER = 1;
    const COMMAND_INCREMENT_FLOAT = 2;
    const COMMAND_SET = 3;

    /**
     * @return MetricFamilySamples[]
     */
    public function collect();

    public function updateHistogram(array $data);

    public function updateGauge(array $data);

    public function updateCounter(array $data);

    public function clear();
}
