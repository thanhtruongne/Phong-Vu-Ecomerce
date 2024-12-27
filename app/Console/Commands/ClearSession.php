<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearSession extends Command
{
    protected $signature = 'clear:session';
    protected $description = 'Xóa session (dev)';
    // protected $expression ='0 1 * * *';
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
    {   //dùng redis
        \Cache::store('redis')->flush();
        session()->flush();
        $this->info('Redis sessions cleared');
    }
}
