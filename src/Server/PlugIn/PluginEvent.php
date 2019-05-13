<?php
/**
 * Created by PhpStorm.
 * User: 白猫
 * Date: 2019/4/19
 * Time: 16:12
 */

namespace ESD\BaseServer\Server\PlugIn;


use ESD\BaseServer\Plugins\Event\Event;

class PluginEvent extends Event
{
    const PlugSuccessEvent = "PlugSuccessEvent";
    const PlugFailEvent = "PlugFailEvent";
    const PlugReady = "PlugReady";
}