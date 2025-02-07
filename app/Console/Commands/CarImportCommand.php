<?php

namespace App\Console\Commands;

use App\Services\CarService;
use Illuminate\Console\Command;

class CarImportCommand extends Command
{

    public function __construct(
        private readonly CarService $carService
    ) {
        parent::__construct();
    }

    public const SIGNATURE = 'app:car-import-command';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:car-import-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import cars data from api';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Starting import cars data');
        $this->carService->import();
        $this->info('Finished import cars data');
    }
}
