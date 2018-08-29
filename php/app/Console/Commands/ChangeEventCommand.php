<?php

namespace App\Console\Commands;

use Mail;
use App\Order;
use App\Mail\EventChange;
use Illuminate\Console\Command;

class ChangeEventCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:change {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email to notify location changed.';

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
            ->whereIn('status', [Order::PAID, Order::CONFIRM])
            ->get();

        foreach ($orders as $order) {
            $email = $order->email;

            Mail::to($email)->queue(new EventChange($order));
        }
    }
}
