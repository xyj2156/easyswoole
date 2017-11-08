<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2017/1/23
 * Time: 上午12:06
 */

namespace Conf;


use Core\AbstractInterface\AbstractEvent;
use Core\Component\Di;
use Core\Component\Version\Control;
use Core\Core;
use Core\Http\Request;
use Core\Http\Response;
use Core\Component\Logger;

class Event extends AbstractEvent
{
    function frameInitialize()
    {
        // TODO: Implement frameInitialize() method.
        date_default_timezone_set('Asia/Shanghai');
    }

    function frameInitialized()
    {
        // TODO: Implement frameInitialized() method.
    }


    function beforeWorkerStart(\swoole_server $server)
    {
        // TODO: Implement beforeWorkerStart() method.
        $conf = \Conf\Config::getInstance();
        if($conf -> getConf('SERVER.SERVER_TYPE') == \Core\Swoole\Config::SERVER_TYPE_WEB_SOCKET)
            $server -> on('message', array($this, 'onMessage'));
    }

    function onStart(\swoole_server $server)
    {
        // TODO: Implement onStart() method.
    }

    function onShutdown(\swoole_server $server)
    {
        // TODO: Implement onShutdown() method.
    }

    function onWorkerStart(\swoole_server $server, $workerId)
    {
        // TODO: Implement onWorkerStart() method.
    }

    function onWorkerStop(\swoole_server $server, $workerId)
    {
        // TODO: Implement onWorkerStop() method.
    }

    function onRequest(Request $request, Response $response)
    {
        // TODO: Implement onRequest() method.
    }

    function onDispatcher(Request $request, Response $response, $targetControllerClass, $targetAction)
    {
        // TODO: Implement onDispatcher() method.
    }

    function onResponse(Request $request,Response $response)
    {
        // TODO: Implement afterResponse() method.
    }

    function onTask(\swoole_server $server, $taskId, $workerId, $taskObj)
    {
        // TODO: Implement onTask() method.
    }

    function onFinish(\swoole_server $server, $taskId, $taskObj)
    {
        // TODO: Implement onFinish() method.
    }

    function onWorkerError(\swoole_server $server, $worker_id, $worker_pid, $exit_code)
    {
        // TODO: Implement onWorkerError() method.
    }

    function onMessage (\swoole_websocket_server $server, \swoole_websocket_frame $frame){
        // TODO： 接受 web socket 传过来的 信息
        Logger::getInstance()->console("receive data ".$frame->data);
        $json = json_decode($frame->data,1);
        if(is_array($json)){
            if($json['action'] == 'who'){
                //可以获取bind后的uid
                //var_dump($server->connection_info($frame->fd));
                $server->push($frame->fd,"your fd is ".$frame->fd);
            }else{
                $server->push($frame->fd,"this is server and you say :".$json['content']);
            }
        }else{
            $server->push($frame->fd,"command error");
        }
    }
}
