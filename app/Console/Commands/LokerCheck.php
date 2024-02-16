<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use App\Models\Loker;
use Illuminate\Support\Facades\Log;

class LokerCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loker:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pemeriksaan Lowongan Kerja Yang Telah Melewati Deadline';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currentDate = Carbon::now();
        $loker = Loker::where('deadline', '>', $currentDate->toDateString())->get();
        try {
            foreach ($loker as $item) {
                $item->update(['status' => 'Closed']);
            }
            Log::info($loker->count() . ' Lowongan Kerja Berhasil Diperiksa dan Diproses' . $loker->pluck('id')->implode(', '));
            $this->info($loker->count() . ' Lowongan Kerja Berhasil Diperiksa dan Diproses');
        } catch (\Exception $e) {
            Log::error('Terjadi Kesalahan:' . $e->getMessage());
            $this->error('Terjadi kesalahan: ' . $e->getMessage());
            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }
}
