<?php

namespace BugJumper;

class Factory
{
    /**
     * url  地址
     * time 超时时间
     * @var array 配置文件
     */
    private $config = [];
    private static $instance;

    /**
     * @var  array 错误消息
     */
    private $error;

    /**
     * 构造函数
     * Factory constructor.
     */
    private function __construct()
    {

    }

    public function setConfig($config)
    {
        $this->config = $config;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public static function create()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    

    /**
     * @param ErrorModel $errorModel
     * @param \Error $error
     * @return bool
     */
    public function setError(ErrorModel $errorModel, $error)
    {
        $handler = new HandlerError();
        if (isset($this->config['type'])) {
            if (function_exists($handler->$this->config['type'])) {
                $func = $handler->$this->config['type']($error);
            } else {
                $func = $handler->page($error);
            }
        } else {
            $func = $handler->page($error);
        }
        $errorModel->setResponse($func);
        return true;
    }

    public function cache()
    {
        
    }
    /**
     * 发送
     */
    public function sending()
    {

    }
}