<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Activity;
use Carbon\Carbon;

class CleanActivityLogs extends Command
{
    // Terminalda işlediljek buýruk ady
    protected $signature = 'logs:clean';

    // Buýrugyň düşündirişi
    protected $description = '60 günden köne bolan Activity loglaryny bazadan pozýar';

    public function handle()
    {
        Activity::truncate();

        $this->info("Arassalaýyş tamamlandy: Ähli loglar pozuldy.");
    }
}
