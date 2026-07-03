<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

#[Signature('make:dto {name : The name of the dto class}')]
#[Description('Create a new dto class')]
class MakeDtoCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = Str::studly($this->argument('name'));

        if (! Str::endsWith($name, 'DTO')) {
            $name .= 'DTO';
        }

        $directory = app_path('DTO');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $path = "{$directory}/{$name}.php";

        if (file_exists($path)) {
            $this->error("{$name} already exists!");
            return self::FAILURE;
        }

        $modelName = Str::replaceLast('DTO', '', $name);

        $stub = <<<PHP
<?php

namespace App\DTOs;

use App\Models\\{$modelName};

class {$name}
{
    //
}

PHP;

        file_put_contents($path, $stub);

        $this->info("DTO created successfully: app/DTOs/{$name}.php");

        return self::SUCCESS;
    }
}
