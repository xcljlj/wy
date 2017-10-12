<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/12
 * Time: 16:22
 */
namespace Server;

use Workerman\Worker;
class httpServer
{
    //配置文件
    public static $config;

    public function __construct(string $config)
    {
        if (!is_file($config)){
            exit("不存在该配置文件！\r\n");
        }
        $server_config=parse_ini_file($config,true);
        if (!$server_config){
            exit("配置文件加载错误\r\n");
        }
        self::$config = $server_config;
    }

    protected function _initWorker($cofing){
        isset($cofing['daemonize']) && Worker::$daemonize = $cofing['daemonize'];
        isset($cofing['stdoutFile']) && Worker::$daemonize = $cofing['stdoutFile'];
        isset($cofing['pidFile ']) && Worker::$daemonize = $cofing['pidFile'];
        isset($cofing['logFile  ']) && Worker::$daemonize = $cofing['logFile'];
        isset($cofing['pidFile ']) && Worker::$daemonize = $cofing['pidFile'];
    }
    public function start(){
        $server_config = self::$config["HTTP_SERVER"];
        $this->_initWorker($server_config);
        $http_server = new Worker("http://".$server_config['host'].":".$server_config['port']);
        $http_server->name = $server_config["server_name"];
        $http_server->count =$server_config["count"];
        isset($server_config["user"]) && $http_server->user = $server_config['user'];


    }

}