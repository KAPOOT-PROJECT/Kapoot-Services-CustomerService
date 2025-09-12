<?php

namespace App\Console\Commands;

use App\Services\EventConsumer;
use Illuminate\Console\Command;

class StartEventConsumer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:consume';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start Consume Worker For Events.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Start Consume From RabbitMQ ...');
        $this->info('For Close Prosses: Ctrl + C');
        $this->line('');

        $eventConsumer = new EventConsumer();
        $eventConsumer->startListening();
    }
}
