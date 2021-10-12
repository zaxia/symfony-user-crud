<?php
namespace App\Command;

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use App\Websocket\MessageHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WebsocketServerCommand extends Command {
    protected static $defaultName = "run:symfony-5-websocket-server";

    protected function execute(InputInterface $input, OutputInterface $output) {
        $port = 3210;
        $output->writeln("");
        $output->writeln("Symfony 5");
        $output->writeln(date("H:i:s. d.m.Y"));
        $output->writeln("Starting chat server on port " . $port . "..");
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new MessageHandler()
                )
            ),
            $port
        );
        $server->run();
        return 0;
    }
}