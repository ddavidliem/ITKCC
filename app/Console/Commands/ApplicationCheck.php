<?php

namespace App\Console\Commands;

use App\Mail\ApplicationNotification;
use App\Models\Application;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ApplicationCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'application:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pemeriksaan Lamaran Kerja Yang Belum Di Proses';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $applications = Application::where('status', 'on process')->whereHas('loker', function ($query) {
            $query->where('deadline', '<=', now()->subWeek());
        })->get();

        try {
            foreach ($applications as $item) {
                $item->update(['status' => 'declined']);
                Mail::to($item->user->alamat_email)->send(new ApplicationNotification($item, 'employer.mail.declined'));
            }
            Log::info($applications->count() . ' Lamaran Berhasil Diperiksa dan Diproses' . $applications->pluck('id')->implode(', '));
            $this->info($applications->count() . ' Lamaran Berhasil Diperiksa dan Diproses');
        } catch (\Exception $e) {
            Log::error('Terjadi Kesalahan:' . $e->getMessage());
            $this->error('Terjadi kesalahan: ' . $e->getMessage());
            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }
}
