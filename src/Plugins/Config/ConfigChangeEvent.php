<?php
/**
 * Created by PhpStorm.
 * User: 白猫
 * Date: 2019/4/29
 * Time: 18:35
 */

namespace ESD\BaseServer\Plugins\Config;


use ESD\BaseServer\Plugins\Event\Event;

class ConfigChangeEvent extends Event
{
    const ConfigChangeEvent = "ConfigChangeEvent";

    public function __construct()
    {
        parent::__construct(self::ConfigChangeEvent, null);
    }
}