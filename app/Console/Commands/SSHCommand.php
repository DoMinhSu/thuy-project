<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class SSHCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ssh:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ssh:command';

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
     * @return int
     */
    public function handle()
    {
        // Log::alert("message from ssh command");
        // Đã success
        exec('php vendor/bin/envoy run deploy --domain=master --branch=master');
        return 0;
    }
}
