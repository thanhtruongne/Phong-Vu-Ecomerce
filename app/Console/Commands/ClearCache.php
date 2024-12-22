<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearCache extends Command
{   
    protected $signature = 'cacheclear:run';
    protected $description = 'Xóa cache chạy 1 ngày 1 lần (0 1 * * *)';
    protected $expression ='0 1 * * *';
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        \Artisan::call('cache:clear');
    }
}
