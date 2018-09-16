<?php

namespace App\Traits;

use Exception;
use Illuminate\Filesystem\Filesystem;

trait GeneratorTrait
{
    public function generate($target, $stub, $arguments, $options)
    {
        $target = "{$target}/{$arguments['name']}.php";

        if (file_exists($target)) {
            $this->error("{$stub} already exists!");
            exit();
        }

        app('view')->addLocation(base_path('resources/stubs'));

        try {
            (new Filesystem)->put(
                $target,
                app('view')->make($stub, $arguments)
            );

            $this->info($stub ." created successfully.");
        } catch (Exception $e) {
            $this->error("Could not create {$stub} !");

            if ($this->option('verbose')) {
                echo $e->getMessage();
            }
            exit();
        }
    }
}
