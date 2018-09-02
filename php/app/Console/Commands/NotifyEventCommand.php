<?php

namespace App\Console\Commands;

use Mail;
use App\Order;
use App\Mail\EventNotify;
use Illuminate\Console\Command;

class NotifyEventCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:notify {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify Event By Mail';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $id = $this->argument('id');

        $orders = Order::where('event_id', $id)
            ->whereIn('status', [Order::CONFIRM, Order::PAID])
            ->get();

        foreach ($orders as $order) {
            Mail::to($order->email)->queue(new EventNotify($order));
        }
    }
}
