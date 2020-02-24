<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Schema;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the installation of NewIDC';

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
        $this->line(__('install.welcome'));
        if (!file_exists('.env')) {
            $this->error("env文件不存在，请将.env.example复制一份并重命名为.env");
            goto stop_inst;
        }
        try {
            $tables=Schema::getAllTables();
        }catch (Exception $e) {
            $this->warn('检测到数据库未连接成功，请先修改.env中数据库信息');
            goto stop_inst;
        }
        if (!empty($tables) && !$this->confirm(__('install.exist_tables'))) goto stop_inst;
        $name = $this->ask('');
        stop_inst:
        $this->error("已退出安装");
        return 1;
    }
}
