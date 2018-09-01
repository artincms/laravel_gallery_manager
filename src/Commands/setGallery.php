<?php

namespace ArtinCMS\LGS\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class setGallery extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lgs:install {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $force = $this->option('force');
        $exitCode = Artisan::call('vendor:publish', [
            '--provider' => "ArtinCMS\LGS\LGSServiceProvider", '--force' => $force
        ]);
        $exitCode = Artisan::call('vendor:publish', [
            '--provider' => "ArtinCMS\LFM\LFMServiceProvider", '--force' => $force
        ]);
        $exitCode = Artisan::call('vendor:publish', [
            '--provider' => "ArtinCMS\LCS\LCSServiceProvider", '--force' => $force
        ]);
        $exitCode = Artisan::call('vendor:publish', [
            '--provider' => "ArtinCMS\LLS\LLSServiceProvider", '--force' => $force
        ]);
        $exitCode = Artisan::call('vendor:publish', [
            '--provider' => "ArtinCMS\LVS\LVSServiceProvider", '--force' => $force
        ]);


    }
}
