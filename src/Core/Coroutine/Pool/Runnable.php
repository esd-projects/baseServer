<?php
/**
 * Created by PhpStorm.
 * User: 白猫
 * Date: 2019/4/17
 * Time: 13:44
 */

namespace Core\Coroutine\Pool;


use Core\Coroutine\Channel;

abstract class Runnable
{
    /**
     * @var Channel
     */
    private $channel;

    /**
     * @var mixed
     */
    private $result;

    public function __construct(bool $needResult = false)
    {
        if ($needResult) {
            $this->channel = new Channel();
        }
    }

    /**
     * 获取结果
     * @param float $timeOut
     * @return mixed
     */
    public function getResult(float $timeOut = 0)
    {
        if ($this->channel == null) return null;
        if ($this->result == null) {
            $this->result = $this->channel->pop($timeOut);
        }
        $this->channel->close();
        return $this->result;
    }

    /**
     * 发送结果
     * @param $result
     */
    public function sendResult($result)
    {
        if ($this->channel == null) {
            return;
        }
        $this->channel->push($result);
    }

    abstract function run();
}