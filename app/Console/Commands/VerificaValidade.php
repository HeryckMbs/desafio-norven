<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class VerificaValidade extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verifica:validade';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica validade dos produtos em estoque';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('asdasd');
        return Command::SUCCESS;
    }
}
