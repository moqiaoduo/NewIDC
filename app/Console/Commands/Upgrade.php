<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;

class Upgrade extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upgrade {commit?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upgrade helper';

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
        if ($this->confirm(__('upgrade.welcome'))) {
            $this->info(__('upgrade.analyze'));
            Storage::disk('upgrades')->allFiles();
        }
        return 0;
    }
}
