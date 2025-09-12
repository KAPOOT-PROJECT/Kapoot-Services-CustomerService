<?php

namespace App\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Illuminate\Support\Facades\Log;
use App\Models\Customer;
use PhpAmqpLib\Channel\AMQPChannel;

class EventConsumer
{
    private static ?AMQPStreamConnection $connection = null;
    private static ?AMQPChannel $channel = null;

    private static string $host;
    private static int $port;
    private static string $user;
    private static string $password;
    private static string $exchange;
    private static string $exchangeType;
    private static string $queue;

    public function __construct()
    {
        self::initConfig();
    }

    private static function initConfig(): void
    {
        if (!isset(self::$host)) {
            $config = config('services.rabbitmq');
            self::$host = $config['host'];
            self::$port = $config['port'];
            self::$user = $config['user'];
            self::$password = $config['password'];
            self::$exchange = $config['exchange'];
            self::$exchangeType = $config['exchange_type'];
            self::$queue = $config['queue'];
        }
    }

    /**
     * Get the RabbitMQ connection (singleton pattern)
     */
    private static function getConnection(): AMQPStreamConnection
    {
        if (self::$connection === null || !self::$connection->isConnected()) {
            //TODO error handling
            self::$connection = new AMQPStreamConnection(self::$host, self::$port, self::$user, self::$password);
        }

        return self::$connection;
    }

    /**
     * Get the RabbitMQ channel (singleton pattern)
     */
    private static function getChannel(): AMQPChannel
    {
        if (self::$channel === null || !self::$channel->is_open()) {
            //TODO error handling
            $connection = self::getConnection();
            self::$channel = $connection->channel();
            //TODO declare exchange and binding
        }

        return self::$channel;
    }

    public function startListening()
    {
        echo "🎧 Start Listening ..." . PHP_EOL;

        try {
            $channel = self::getChannel();
            echo "✅ Channel Created." . PHP_EOL;

            $channel->basic_consume(
                self::$queue,
                '',
                false,
                false,
                false,
                false,
                [$this, 'processMessage']
            );

            while($channel->consume()) {
                $channel->wait();
            }

            self::resetConnection();

        } catch (\Throwable $e) {
            # code...
        }
    }

    public function processMessage(AMQPMessage $message)
    {
        try {
            $data = json_decode($message->getBody(), associative: true);

            echo "📥 Recieved message for user:[{$data['userId']}]." . PHP_EOL;

            switch ($data['event']) {
                case 'user_registered_event':
                    $this->handleUserRegistered($data);
                    break;
                case 'label':
                    # code...
                    break;
                default:
                    # code...
                    break;
            }

            $message->ack();
        } catch (\Throwable $e) {
            # code...
            $message->nack();
        }
    }

    private function handleUserRegistered($data)
    {
        $customer = Customer::query()->create([
            'user_id' => $data['userId'],
        ]);

        echo "🤵 Customer Created id[{$customer->_id}]." . PHP_EOL;
        $this->sendWelcomeMessage($data);
    }

    private function handleUserLoggedIn($data)
    {

    }

    private function handleUserProfileUpdated($data): void
    {

    }

    private function sendWelcomeMessage($data)
    {
        echo "📧 Email to ({$data['email']})." . PHP_EOL;
        echo "📲 SMS to ({$data['phone']})." . PHP_EOL;
    }

    private function sendSecurityAlert($data)
    {
    }

    private function sendProfileUpdateNotification($data)
    {
    }

    private static function resetConnection(): void
    {
        try {
            if (self::$channel !== null && self::$channel->is_open()) {
                self::$channel->close();
            }
        } catch (\Throwable $th) {
            //TODO Logging
        }

        try {
            if (self::$connection !== null && self::$connection->isConnected()) {
                self::$connection->close();
            }
        } catch (\Throwable $th) {
            //TODO Logging
        }

        self::$connection = null;
        self::$channel= null;
    }

    /**
     * Clean up connection when object is destroyed
     */
    public function __destruct()
    {
        self::resetConnection();
    }
}
