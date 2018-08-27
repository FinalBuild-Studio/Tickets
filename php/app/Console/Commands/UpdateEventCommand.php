<?php

namespace App\Console\Commands;

use Parsedown;
use App\Event;
use Illuminate\Console\Command;

class UpdateEventCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:update {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update event via template';

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
        $name = $this->argument('name');
        $mark = new Parsedown();

        $templatePath = base_path('events/'.$name);
        if (is_dir($templatePath)) {
            $information = file_get_contents($templatePath.'/information.json');
            $information = json_decode($information, true);
            $description = file_get_contents($templatePath.'/description.md');
            $description = $mark->text($description);
            $template    = basename($templatePath);

            Event::where('template', $name)->update($information + compact('description', 'template'));
            $this->info($template.' is updated');
        }
    }
}
