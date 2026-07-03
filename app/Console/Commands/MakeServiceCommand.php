<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

#[Signature('make:service {name : The name of the service class}')]
#[Description('Create a new service class')]
class MakeServiceCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = Str::studly($this->argument('name'));

        if (! Str::endsWith($name, 'Service')) {
            $name .= 'Service';
        }

        $directory = app_path('Services');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $path = "{$directory}/{$name}.php";

        if (file_exists($path)) {
            $this->error("{$name} already exists!");
            return self::FAILURE;
        }

        $modelName = Str::replaceLast('Service', '', $name);

        $stub = <<<PHP
<?php

namespace App\Services;

use App\Models\\{$modelName};

class {$name}
{
    //
}

PHP;

        file_put_contents($path, $stub);

        $this->info("Service created successfully: app/Services/{$name}.php");

        return self::SUCCESS;
    }
}
