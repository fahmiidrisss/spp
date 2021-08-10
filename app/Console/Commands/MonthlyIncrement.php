<?php

namespace App\Console\Commands;

use App\Models\Santri;
use Illuminate\Console\Command;

class MonthlyIncrement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'increment:monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Penambahan Jumlah Tunggakan Setiap Awal Bulan';

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
        $tunggakan = Santri::all();
        foreach($tunggakan as $data)
        {
            $data->update([
                'jumlah_tunggakan' => $data->jumlah_tunggakan+1
            ]);
        }
    }
}
