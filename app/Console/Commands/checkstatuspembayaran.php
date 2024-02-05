<?php

namespace App\Console\Commands;

use App\Models\Cart;
use App\Models\CheckOut;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule; // Import kelas Schedule

class checkstatuspembayaran extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:checkstatuspembayaran';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $checkouts = CheckOut::whereNotNull('snap_token')->where('status', 'belum bayar')->get();

        foreach ($checkouts as $item) {
            $created_at = Carbon::parse($item->created_at);
            $now = Carbon::now();
            $deadline = $created_at->addMinutes(1);

            if ($now->greaterThanOrEqualTo($deadline)) {
                $item->update([
                    'status' => 'belum bayar',
                ]);
            }

            // Tambahkan logika untuk menghapus entri jika statusnya tetap "belum bayar" setelah jangka waktu tertentu
            $deleteDeadline = $created_at->addMinutes(1); // Misalnya, setelah 24 jam
            if ($now->greaterThanOrEqualTo($deleteDeadline) && $item->status === 'belum bayar') {
                $item->delete(); // Hapus entri

                // Hapus entri di tabel order yang memiliki status 'belum bayar' dan user_id yang sesuai
                Order::where('user_id', $item->user_id)->where('status', 'belum bayar')->delete();

                // Hapus entri di tabel cart yang memiliki user_id yang sama
                Cart::where('user_id', $item->user_id)->delete();
            }
        }
    }


    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('app:checkstatuspembayaran')->everyMinute(); // Menggunakan method command() untuk menjadwalkan command
    }
}
