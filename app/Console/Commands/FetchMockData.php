<?php

namespace App\Console\Commands;

use App\Services\FetchMockDataService;
use Illuminate\Console\Command;

class FetchMockData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:mock-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fetch mock data';

    /**
     * Execute the console command.
     */
    public function handle(FetchMockDataService $fetchMockDataService): void
    {
        $fetchMockDataService->fetch();

        $this->info('The command was successful!');
    }
}
