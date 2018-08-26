<?php

namespace App\Console\Commands;

use App\Event;
use Illuminate\Console\Command;

class CreateEventCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:create {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create event template from command line.';

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
        $name           = $this->argument('name');
        $templatePath   = base_path('events/'.date('Y_m_d_His').'_'.$name);
        $information    = <<<EOD
{
    "name": "",
    "address": "",
    "place": "",
    "start_at": "",
    "end_at": "",
    "max": 0,
    "price": 0,
    "poster": ""
}
EOD;
        mkdir($templatePath, 0777, true);
        file_put_contents($templatePath.'/information.json', $information);
        touch($templatePath.'/description.md');
    }
}
