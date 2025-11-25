<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemIterator;

class MakeCustomCommand extends Command
{
    protected $signature = 'make:custom
        {module : Nombre del módulo}
        {name : Nombre del modelo/controlador}';

    protected $description = 'Crea un modelo y controlador dentro de app/Modules con estructura organizada (Models y Controllers)';

    public function handle()
    {
        $fs = new Filesystem();

        $argModule = $this->argument('module');

        // Verificar si el módulo existe
        $iterator = new \FilesystemIterator(app_path("Modules"));
        $existFolderModule = false;
        foreach ($iterator as $directory) {
            if ($directory->isDir()) {
                $folder = $directory->getFilename();
                if ($folder === $argModule) {
                    $existFolderModule = true;
                    break;
                }
            }
        }

        if (!$existFolderModule) {
            $this->error("❌ El módulo '{$argModule}' no hace parte del proyecto.");
            return Command::FAILURE;
        }
        
        $moduleBasePath = app_path("Modules/{$argModule}");
        $module = Str::studly($argModule);
        $name   = Str::studly($this->argument('name'));

        // Carpetas base
        $modelPath       = "{$moduleBasePath}/Models";
        $controllerPath  = "{$moduleBasePath}/Controllers";

        // Crear las carpetas si no existen
        $fs->ensureDirectoryExists($modelPath);
        $fs->ensureDirectoryExists($controllerPath);

        $this->info("🚀 Creando modelo y controlador '{$name}' en el módulo '{$module}'...");
        // Crear el modelo (sin controlador automático)
        Artisan::call("make:model 'App/Modules/{$module}/Models/{$name}'");


        // Crear la migración dentro de una subcarpeta del módulo
        $migrationsPath = database_path("migrations/{$module}");
        $fs->ensureDirectoryExists($migrationsPath);

        $migrationNameFile = "create_" . Str::snake(Str::pluralStudly($name)) . "_table";
        Artisan::call("make:migration {$migrationNameFile} --path=database/migrations/{$module}");

        // Crear el controlador manualmente dentro de la carpeta Controllers
        $controllerNamespace = "App\\Modules\\{$module}\\Controllers";
        $param = Str::lower($this->argument('name'));
        $controllerStub = <<<PHP
        <?php

        namespace {$controllerNamespace};

        use App\Modules\\{$module}\Models\\{$name};
        use App\Http\Controllers\Controller;
        use Illuminate\Http\Request;

        class {$name}Controller extends Controller
        {
            /**
             * Display a listing of the resource.
             */
            public function index()
            {
                return view("modules.{$module}.index");
            }

            /**
             * Show the form for creating a new resource.
             */
            public function create()
            {
                //
            }

            /**
             * Store a newly created resource in storage.
             */
            public function store(Request \$request)
            {
                //
            }

            /**
             * Display the specified resource.
             */
            public function show({$name} \${$param})
            {
                //
            }

            /**
             * Show the form for editing the specified resource.
             */
            public function edit({$name} \${$param})
            {
                //
            }

            /**
             * Update the specified resource in storage.
             */
            public function update(Request \$request, {$name} \${$param})
            {
                //
            }

            /**
             * Remove the specified resource from storage.
             */
            public function destroy({$name} \${$param})
            {
                //
            }
        }
        PHP;

        $controllerFilePath = "{$controllerPath}/{$name}Controller.php";
        $fs->put($controllerFilePath, trim($controllerStub));


        $this->info("✅ Estructura creada en app/Modules/{$module}/");
        $this->line("📁 Modelo: app/Modules/{$module}/Models/{$name}.php");
        $this->line("📁 Migración: database/migrations/{$module}/{$migrationNameFile}");
        $this->line("📁 Controlador: app/Modules/{$module}/Controllers/{$name}Controller.php");
        
        $routeFilePath = "{$moduleBasePath}/routes.php";
        if (!$fs->exists($routeFilePath)) {
            $routeURL = Str::kebab($module);
            $routeInternal = Str::snake($module,".");
            $routeStub = <<<PHP
            <?php

            use Illuminate\Support\Facades\Route;
            use App\Modules\\{$module}\Controllers\\{$name}Controller;

            Route::prefix('{$routeURL}')->name('{$routeInternal}')->group(function () {
                Route::get('/', [{$name}Controller::class, 'index'])->name('index');
            });
            PHP;

            $fs->put($routeFilePath, trim($routeStub));

            $this->line("📄 Archivo routes.php creado en app/Modules/{$module}/");
        }
        else {
            $lines = $fs->lines($routeFilePath);
            $linesArray = $lines->toArray();
            
            $addUseController = "use App\Modules\\{$module}\Controllers\\{$name}Controller;";
            array_splice($linesArray,3,0,$addUseController);
            $fs->put($routeFilePath, implode(PHP_EOL, $linesArray));

            $this->line("📝 Archivo routes.php actualizado, app/Modules/{$module}/");
        }

        return Command::SUCCESS;
    }
}