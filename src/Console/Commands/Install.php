<?php

namespace Merlion\Console\Commands;

use Context;
use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'merlion:install {admin_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install merlion admin panel';

    public function handle()
    {
        Context::add('admin_id', $this->argument('admin_id') ?? 'admin');
        $this->info(admin()->getBrandName());
    }
}
