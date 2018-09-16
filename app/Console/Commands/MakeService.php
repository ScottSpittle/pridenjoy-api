<?php

namespace App\Console\Commands;

use App\Traits\GeneratorTrait;
use Illuminate\Console\Command;

class MakeService extends Command
{
    use GeneratorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

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
     * @return mixed
     */
    public function handle()
    {
        $this->generate(
            base_path("app/Services"),
            "Service",
            $this->arguments(),
            $this->options()
        );
    }
}
