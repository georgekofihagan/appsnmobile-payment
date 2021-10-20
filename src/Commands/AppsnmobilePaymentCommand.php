<?php

namespace Mobiverse\AppsnmobilePayment\Commands;

use Illuminate\Console\Command;

class AppsnmobilePaymentCommand extends Command
{
    public $signature = 'appsnmobile-payment';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
