<?php

namespace App\Console\Commands;

use App\Traits\GeneratorTrait;
use Illuminate\Console\Command;

class MakeRepository extends Command
{
    use GeneratorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';

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
            base_path("app/Repositories"),
            "Repository",
            $this->arguments(),
            $this->options()
        );
    }
}
