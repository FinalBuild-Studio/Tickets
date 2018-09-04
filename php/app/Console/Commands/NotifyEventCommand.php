<?php

namespace App\Console\Commands;

use Mail;
use App\Order;
use App\Mail\{EventNotify, EventWarn, EventChange};
use Illuminate\Console\Command;

class NotifyEventCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:notify {type} {id}';

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
        $id   = $this->argument('id');
        $type = $this->argument('type');

        $orders = Order::where('event_id', $id)
            ->whereIn('status', [Order::CONFIRM, Order::PAID])
            ->get();

        $types = [
            'change' => EventChange::class,
            'notify' => EventNotify::class,
            'warn'   => EventWarn::class,
        ];
        $mail = $types[$type] ?? null;

        if ($mail) {
            foreach ($orders as $order) {
                $this->info($order->email.' has been sent, type: '.$mail);
                Mail::to($order->email)->queue(new $mail($order));
            }
        }
    }
}
