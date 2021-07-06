<?php

namespace App\Console\Commands;
use App\Models\Kode;
use Illuminate\Console\Command;

class DailyReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset all status in kodes tabel to 0';

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
        $status = Kode::where('status_kode', '=', 1)->update(array('status_kode' => 0));
    }
}
