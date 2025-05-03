<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Borrow;
use App\Notifications\BorrowDueSoonNotification;
use App\Notifications\BorrowOverdueNotification;
use Carbon\Carbon;

class SendBorrowNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:send-borrow-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications for borrows that are due soon or overdue.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Sending borrow notifications...');

        $today = Carbon::today();
        $dueSoonDate = $today->addDays(2)->toDateString();

        // Find active borrows due in the next two days
        $dueSoonBorrows = Borrow::where('status', \App\Enums\BorrowStatus::ACTIVE)
            ->whereNotNull('due_date')
            ->whereDate('due_date', '=', $dueSoonDate)
            ->get();

        $this->info('Found ' . $dueSoonBorrows->count() . ' borrows due soon.');

        foreach ($dueSoonBorrows as $borrow) {
            // Ensure the user relationship is loaded before notifying
            if ($borrow->user) {
                $borrow->user->notify(new BorrowDueSoonNotification($borrow));
                $this->info('Sent due soon notification for borrow ID: ' . $borrow->id_pret);
            }
        }

        // Find active overdue borrows
        $overdueBorrows = Borrow::where('status', \App\Enums\BorrowStatus::ACTIVE)
            ->whereNotNull('due_date')
            ->whereDate('due_date', '<', $today->toDateString())
            ->get();

        $this->info('Found ' . $overdueBorrows->count() . ' overdue borrows.');

        foreach ($overdueBorrows as $borrow) {
             // Ensure the user relationship is loaded before notifying
            if ($borrow->user) {
                $borrow->user->notify(new BorrowOverdueNotification($borrow));
                $this->info('Sent overdue notification for borrow ID: ' . $borrow->id_pret);
            }
        }

        $this->info('Borrow notifications sent successfully.');
    }
}
