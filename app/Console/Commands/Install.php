<?php

namespace App\Console\Commands;

use Encore\Admin\Auth\Database\Administrator;
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
            $this->error(__('install.env_not_exist'));
            goto stop_inst;
        }
        try {
            $tables=Schema::getAllTables();
        } catch (Exception $e) {
            $this->warn(__('install.database_connect_fail'));
            goto stop_inst;
        }
        if (!empty($tables) && !$this->confirm(__('install.exist_tables'))) goto stop_inst;
        $this->info(__('install.admin_config_tip'));
        $admin_username = $this->ask(__('install.admin_username_tip'),'admin');
        while (empty($admin_password = $this->secret(__('install.admin_password_tip'))))
            $this->warn(__('install.password_empty'));
        if ($this->confirm(__('install.recommend_webadmin'))) {
            $webadmin_username = $this->ask(__('install.webadmin_username_tip'),'webadmin');
             while (empty($webadmin_password = $this->secret(__('install.webadmin_password_tip'))))
                $this->warn(__('install.password_empty'));
        }
        if (!$this->confirm(__('install.ready'))) goto stop_inst;
        $this->call('migrate');
        $this->call('db:seed');
        Administrator::truncate();
        Administrator::create([
            'username' => $admin_username,
            'password' => bcrypt($admin_password),
            'name'     => '超级管理员',
        ]);
        if (isset($webadmin_username) && isset($webadmin_password)) {
            Administrator::create([
                'username' => $webadmin_username,
                'password' => bcrypt($webadmin_password),
                'name'     => '网站管理员',
            ]);
        }
        $this->info(__('install.success',['url'=>config('app.url')]));
        return 0;
        stop_inst:
        $this->error(__('install.exit'));
        return 1;
    }
}
