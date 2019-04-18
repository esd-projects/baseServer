<?php
/**
 * Created by PhpStorm.
 * User: 白猫
 * Date: 2019/4/18
 * Time: 12:24
 */

namespace GoSwoole\BaseServer\Server\Plug;

use GoSwoole\BaseServer\Exception;
use GoSwoole\BaseServer\Server\Context;

/**
 * 插件管理器
 * Class PlugManager
 * @package GoSwoole\BaseServer\Server\Plug
 */
class PlugManager implements Plug
{
    /**
     * @var Plug[]
     */
    private $plugs = [];

    /**
     * @var Plug[]
     */
    private $plugClasses = [];

    /**
     * @var bool
     */
    private $fixed = false;

    /**
     * 添加插件
     * @param Plug $plug
     * @throws Exception
     */
    public function addPlug(Plug $plug)
    {
        if ($this->fixed) {
            throw new Exception("已经锁定不能添加插件");
        }
        $this->plugs[] = $plug;
        $this->plugClasses[get_class($plug)] = $plug;
    }

    public function beforeServerStart(Context $context)
    {
        foreach ($this->plugs as $plug) {
            $plug->beforeServerStart($context);
        }
    }

    public function beforeProcessStart(Context $context)
    {
        foreach ($this->plugs as $plug) {
            $plug->beforeProcessStart($context);
        }
    }

    /**
     * 插件排序
     */
    public function order()
    {
        foreach ($this->plugs as $plug) {
            if ($this->getPlugAfterClass($plug) != null) {
                $plug->setAfterPlug($this->getPlugAfterClass($plug));
            }
        }
        usort($this->plugs, function ($a, $b) {
            if ($a->getOrderIndex() > $b->getOrderIndex()) {
                return 1;
            } else {
                return -1;
            }
        });
        $this->fixed = true;
    }

    /**
     * @param Plug $plug
     * @return Plug|null
     */
    private function getPlugAfterClass(Plug $plug)
    {
        if ($plug->getAfterClass() == null) return null;
        return $this->plugClasses[$plug->getAfterClass()] ?? null;
    }


    /**
     * 获取插件名字
     * @return string
     */
    public function getName(): string
    {
        return "PlugManager";
    }

    /**
     * @param int $index
     * @return mixed
     */
    public function setOrderIndex(int $index)
    {
        return;
    }

    /**
     * @return int
     */
    public function getOrderIndex(): int
    {
        return 0;
    }

    /**
     * @return mixed
     */
    public function getBeforeClass()
    {
        return null;
    }

    /**
     * @return mixed
     */
    public function getAfterClass()
    {
        return null;
    }

    /**
     * @param mixed $afterPlug
     */
    public function setAfterPlug($afterPlug)
    {
        return;
    }
}