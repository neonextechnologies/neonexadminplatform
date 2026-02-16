<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * MakeCrudCommand
 * 
 * Phase 7: CRUD Generator (Blade + jQuery, No npm build)
 * 
 * Usage:
 *   php artisan neonex:make:crud Product --fields="name:string:required,price:integer:required,is_active:boolean:nullable"
 *   php artisan neonex:make:crud Product --schema=stubs/crud/product.json
 */
class MakeCrudCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'neonex:make:crud 
                            {name : The name of the model} 
                            {--fields= : Inline field definition (name:type:validation,...)}
                            {--schema= : Path to JSON schema file}
                            {--module= : Module name (optional, defaults to app/)}
                            {--prefix=admin : Route prefix (default: admin)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Blade + jQuery CRUD (tenant-aware, audit-first, no npm build)';

    /**
     * Parsed fields configuration
     */
    protected array $fields = [];

    /**
     * Model information
     */
    protected string $modelClass;
    protected string $modelVariable;
    protected string $modelKebab;
    protected string $modelPlural;
    protected string $table;
    protected string $routePrefix;
    protected string $permissionPrefix;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Phase 7: CRUD Generator (Blade + jQuery)');
        $this->info('');

        // Step 1: Parse model name
        $this->modelClass = $this->argument('name');
        $this->modelVariable = Str::camel($this->modelClass);
        $this->modelKebab = Str::kebab($this->modelClass);
        $this->modelPlural = Str::plural($this->modelClass);
        $this->table = Str::snake(Str::plural($this->modelClass));
        $this->routePrefix = $this->option('prefix');
        $this->permissionPrefix = $this->modelKebab;

        $this->info("Model: {$this->modelClass}");
        $this->info("Table: {$this->table}");
        $this->info("Route Prefix: {$this->routePrefix}");
        $this->info('');

        // Step 2: Parse fields
        if ($this->option('schema')) {
            $this->parseSchemaFile();
        } elseif ($this->option('fields')) {
            $this->parseInlineFields();
        } else {
            $this->error('❌ Please provide --fields or --schema option');
            return self::FAILURE;
        }

        if (empty($this->fields)) {
            $this->error('❌ No fields defined');
            return self::FAILURE;
        }

        $this->info('Fields: ' . count($this->fields));
        foreach ($this->fields as $field) {
            $this->line("  - {$field['name']} ({$field['type']}) [{$field['validation']}]");
        }
        $this->info('');

        // Step 3: Generate files
        $this->generateMigration();
        $this->generateModel();
        $this->generateRequest();
        $this->generateController();
        $this->generateViews();
        $this->generateRoutes();

        // Step 4: Success message
        $this->info('');
        $this->info('✅ CRUD generated successfully!');
        $this->info('');
        $this->info('Next steps:');
        $this->line('  1. Run migrations: php artisan migrate');
        $this->line("  2. Visit: /{$this->routePrefix}/{$this->modelKebab}");
        $this->line("  3. Register permissions in PermissionSeeder:");
        $this->line("     - {$this->permissionPrefix}.view");
        $this->line("     - {$this->permissionPrefix}.create");
        $this->line("     - {$this->permissionPrefix}.update");
        $this->line("     - {$this->permissionPrefix}.delete");
        $this->info('');

        return self::SUCCESS;
    }

    /**
     * Parse schema from JSON file
     */
    protected function parseSchemaFile(): void
    {
        $schemaPath = base_path($this->option('schema'));
        
        if (!File::exists($schemaPath)) {
            $this->error("❌ Schema file not found: {$schemaPath}");
            exit(1);
        }

        $schema = json_decode(File::get($schemaPath), true);

        if (isset($schema['fields'])) {
            foreach ($schema['fields'] as $name => $config) {
                $this->fields[] = [
                    'name' => $name,
                    'type' => $config['type'] ?? 'string',
                    'label' => $config['label'] ?? Str::title($name),
                    'validation' => $config['validation'] ?? 'nullable',
                ];
            }
        }

        // Override route prefix from schema if provided
        if (isset($schema['route']['prefix'])) {
            $this->routePrefix = $schema['route']['prefix'];
        }
    }

    /**
     * Parse inline fields (name:type:validation,...)
     */
    protected function parseInlineFields(): void
    {
        $fieldsStr = $this->option('fields');
        $fieldDefs = explode(',', $fieldsStr);

        foreach ($fieldDefs as $fieldDef) {
            $parts = explode(':', trim($fieldDef));
            
            $this->fields[] = [
                'name' => $parts[0],
                'type' => $parts[1] ?? 'string',
                'label' => Str::title($parts[0]),
                'validation' => $parts[2] ?? 'nullable',
            ];
        }
    }

    /**
     * Generate migration file
     */
    protected function generateMigration(): void
    {
        $stub = File::get(base_path('stubs/crud/migration.stub'));

        // Build migration fields
        $migrationFields = '';
        foreach ($this->fields as $field) {
            $migrationFields .= $this->getMigrationFieldLine($field);
        }

        $content = str_replace([
            '{{table}}',
            '{{fields}}',
        ], [
            $this->table,
            $migrationFields,
        ], $stub);

        $timestamp = date('Y_m_d_His');
        $filename = "{$timestamp}_create_{$this->table}_table.php";
        $path = database_path("migrations/{$filename}");

        File::put($path, $content);

        $this->info("✅ Migration: {$filename}");
    }

    /**
     * Generate model file
     */
    protected function generateModel(): void
    {
        $stub = File::get(base_path('stubs/crud/model.stub'));

        // Build fillable and casts
        $fillable = '';
        $casts = '';
        
        foreach ($this->fields as $field) {
            $fillable .= "        '{$field['name']}',\n";
            
            if ($cast = $this->getCastType($field['type'])) {
                $casts .= "        '{$field['name']}' => '{$cast}',\n";
            }
        }

        $content = str_replace([
            '{{namespace}}',
            '{{modelClass}}',
            '{{table}}',
            '{{fillable}}',
            '{{casts}}',
        ], [
            'App\\Models',
            $this->modelClass,
            $this->table,
            $fillable,
            $casts,
        ], $stub);

        $path = app_path("Models/{$this->modelClass}.php");

        File::put($path, $content);

        $this->info("✅ Model: app/Models/{$this->modelClass}.php");
    }

    /**
     * Generate request file
     */
    protected function generateRequest(): void
    {
        $stub = File::get(base_path('stubs/crud/request.stub'));

        // Build validation rules
        $rules = '';
        foreach ($this->fields as $field) {
            $rules .= $this->getValidationRule($field);
        }

        $content = str_replace([
            '{{namespace}}',
            '{{requestClass}}',
            '{{modelClass}}',
            '{{rules}}',
        ], [
            'App\\Http\\Requests\\' . ucfirst($this->routePrefix),
            "{$this->modelClass}Request",
            $this->modelClass,
            $rules,
        ], $stub);

        $dir = app_path('Http/Requests/' . ucfirst($this->routePrefix));
        if (!File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        $path = "{$dir}/{$this->modelClass}Request.php";

        File::put($path, $content);

        $this->info("✅ Request: app/Http/Requests/" . ucfirst($this->routePrefix) . "/{$this->modelClass}Request.php");
    }

    /**
     * Generate controller file
     */
    protected function generateController(): void
    {
        $stub = File::get(base_path('stubs/crud/controller.stub'));

        // Build search fields
        $searchFields = '';
        foreach ($this->fields as $field) {
            if (in_array($field['type'], ['string', 'text'])) {
                $searchFields .= "\n                  ->orWhere('{$field['name']}', 'like', \"%{\$search}%\")";
            }
        }

        $content = str_replace([
            '{{namespace}}',
            '{{requestNamespace}}',
            '{{requestClass}}',
            '{{modelNamespace}}',
            '{{modelClass}}',
            '{{modelVariable}}',
            '{{modelKebab}}',
            '{{viewPath}}',
            '{{routePrefix}}',
            '{{auditEvent}}',
            '{{searchFields}}',
        ], [
            'App\\Http\\Controllers\\' . ucfirst($this->routePrefix),
            'App\\Http\\Requests\\' . ucfirst($this->routePrefix),
            "{$this->modelClass}Request",
            'App\\Models',
            $this->modelClass,
            $this->modelVariable,
            $this->modelKebab,
            "{$this->routePrefix}.{$this->modelKebab}",
            $this->routePrefix,
            $this->modelKebab,
            $searchFields,
        ], $stub);

        $dir = app_path('Http/Controllers/' . ucfirst($this->routePrefix));
        if (!File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        $path = "{$dir}/{$this->modelClass}Controller.php";

        File::put($path, $content);

        $this->info("✅ Controller: app/Http/Controllers/" . ucfirst($this->routePrefix) . "/{$this->modelClass}Controller.php");
    }

    /**
     * Generate view files (index, create, edit)
     */
    protected function generateViews(): void
    {
        $dir = resource_path("views/{$this->routePrefix}/{$this->modelKebab}");
        if (!File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        // Index view
        $this->generateIndexView($dir);

        // Create view
        $this->generateCreateView($dir);

        // Edit view
        $this->generateEditView($dir);

        $this->info("✅ Views: resources/views/{$this->routePrefix}/{$this->modelKebab}/");
    }

    /**
     * Generate index view
     */
    protected function generateIndexView(string $dir): void
    {
        $stub = File::get(base_path('stubs/crud/views/index.stub'));

        // Build table headers
        $tableHeaders = '';
        foreach ($this->fields as $field) {
            $tableHeaders .= "                                    <th>{$field['label']}</th>\n";
        }

        // Build table columns
        $tableColumns = '';
        foreach ($this->fields as $field) {
            $tableColumns .= $this->getTableColumn($field);
        }

        $columnCount = count($this->fields) + 2; // +2 for ID and Actions

        $content = str_replace([
            '{{modelClass}}',
            '{{modelPlural}}',
            '{{modelVariable}}',
            '{{modelKebab}}',
            '{{routePrefix}}',
            '{{permissionPrefix}}',
            '{{tableHeaders}}',
            '{{tableColumns}}',
            '{{columnCount}}',
        ], [
            $this->modelClass,
            $this->modelPlural,
            $this->modelVariable,
            $this->modelKebab,
            $this->routePrefix,
            $this->permissionPrefix,
            $tableHeaders,
            $tableColumns,
            $columnCount,
        ], $stub);

        File::put("{$dir}/index.blade.php", $content);
    }

    /**
     * Generate create view
     */
    protected function generateCreateView(string $dir): void
    {
        $stub = File::get(base_path('stubs/crud/views/create.stub'));

        // Build form fields
        $formFields = '';
        foreach ($this->fields as $field) {
            $formFields .= $this->getFormField($field, 'create');
        }

        $content = str_replace([
            '{{modelClass}}',
            '{{modelVariable}}',
            '{{modelKebab}}',
            '{{routePrefix}}',
            '{{formFields}}',
        ], [
            $this->modelClass,
            $this->modelVariable,
            $this->modelKebab,
            $this->routePrefix,
            $formFields,
        ], $stub);

        File::put("{$dir}/create.blade.php", $content);
    }

    /**
     * Generate edit view
     */
    protected function generateEditView(string $dir): void
    {
        $stub = File::get(base_path('stubs/crud/views/edit.stub'));

        // Build form fields
        $formFields = '';
        foreach ($this->fields as $field) {
            $formFields .= $this->getFormField($field, 'edit');
        }

        $content = str_replace([
            '{{modelClass}}',
            '{{modelVariable}}',
            '{{modelKebab}}',
            '{{routePrefix}}',
            '{{formFields}}',
        ], [
            $this->modelClass,
            $this->modelVariable,
            $this->modelKebab,
            $this->routePrefix,
            $formFields,
        ], $stub);

        File::put("{$dir}/edit.blade.php", $content);
    }

    /**
     * Generate or append routes
     */
    protected function generateRoutes(): void
    {
        $routeFile = base_path("routes/{$this->routePrefix}.php");

        // Create route file if not exists
        if (!File::exists($routeFile)) {
            $template = "<?php\n\nuse Illuminate\Support\Facades\Route;\n\n// Generated routes\n";
            File::put($routeFile, $template);
            
            // Register in bootstrap/app.php if not already registered
            $this->info("ℹ️  Note: Register routes/{$this->routePrefix}.php in bootstrap/app.php or RouteServiceProvider");
        }

        // Append route resource
        $routeContent = "\n// {$this->modelClass} CRUD (generated by neonex:make:crud)\n";
        $routeContent .= "Route::middleware(['auth', 'tenant.selected'])\n";
        $routeContent .= "    ->prefix('{$this->routePrefix}')\n";
        $routeContent .= "    ->name('{$this->routePrefix}.')\n";
        $routeContent .= "    ->group(function () {\n";
        $routeContent .= "        Route::resource('{$this->modelKebab}', \\App\\Http\\Controllers\\" . ucfirst($this->routePrefix) . "\\{$this->modelClass}Controller::class);\n";
        $routeContent .= "    });\n";

        File::append($routeFile, $routeContent);

        $this->info("✅ Routes: routes/{$this->routePrefix}.php");
    }

    /**
     * Get migration field line
     */
    protected function getMigrationFieldLine(array $field): string
    {
        $type = $field['type'];
        $name = $field['name'];

        $line = match ($type) {
            'string' => "            \$table->string('{$name}');",
            'text' => "            \$table->text('{$name}');",
            'integer' => "            \$table->integer('{$name}');",
            'bigInteger' => "            \$table->bigInteger('{$name}');",
            'boolean' => "            \$table->boolean('{$name}')->default(false);",
            'date' => "            \$table->date('{$name}');",
            'datetime' => "            \$table->dateTime('{$name}');",
            'decimal' => "            \$table->decimal('{$name}', 10, 2);",
            'float' => "            \$table->float('{$name}');",
            'json' => "            \$table->json('{$name}');",
            default => "            \$table->string('{$name}');",
        };

        // Add nullable if not required
        if (str_contains($field['validation'], 'nullable')) {
            $line = rtrim($line, ';') . '->nullable();';
        }

        return $line . "\n";
    }

    /**
     * Get cast type for model
     */
    protected function getCastType(string $type): ?string
    {
        return match ($type) {
            'boolean' => 'boolean',
            'integer', 'bigInteger' => 'integer',
            'float', 'decimal' => 'float',
            'date' => 'date',
            'datetime' => 'datetime',
            'json' => 'array',
            default => null,
        };
    }

    /**
     * Get validation rule
     */
    protected function getValidationRule(array $field): string
    {
        $rules = explode('|', $field['validation']);
        $rulesArray = array_map(fn($r) => "'{$r}'", $rules);
        $rulesStr = implode(', ', $rulesArray);

        return "            '{$field['name']}' => [{$rulesStr}],\n";
    }

    /**
     * Get table column for index view
     */
    protected function getTableColumn(array $field): string
    {
        $name = $field['name'];
        $var = $this->modelVariable;

        if ($field['type'] === 'boolean') {
            return "                                        <td>\n" .
                   "                                            <span class=\"badge bg-{{ \${$var}->{$name} ? 'success' : 'secondary' }}\">\n" .
                   "                                                {{ \${$var}->{$name} ? 'Yes' : 'No' }}\n" .
                   "                                            </span>\n" .
                   "                                        </td>\n";
        }

        if ($field['type'] === 'date' || $field['type'] === 'datetime') {
            return "                                        <td>{{ \${$var}->{$name}?->format('Y-m-d H:i') ?? '-' }}</td>\n";
        }

        return "                                        <td>{{ \${$var}->{$name} }}</td>\n";
    }

    /**
     * Get form field for create/edit views
     */
    protected function getFormField(array $field, string $mode = 'create'): string
    {
        $name = $field['name'];
        $label = $field['label'];
        $type = $field['type'];
        $required = str_contains($field['validation'], 'required') ? 'required' : '';
        $var = $this->modelVariable;

        $oldValue = $mode === 'edit' ? "\$${var}->{$name}" : "old('{$name}')";

        if ($type === 'boolean') {
            return "                        <div class=\"mb-3\">\n" .
                   "                            <label class=\"form-label\" for=\"{$name}\">{$label}</label>\n" .
                   "                            <select class=\"form-select\" id=\"{$name}\" name=\"{$name}\" {$required}>\n" .
                   "                                <option value=\"1\" " . ($mode === 'edit' ? "{{ \${$var}->{$name} ? 'selected' : '' }}" : "") . ">Yes</option>\n" .
                   "                                <option value=\"0\" " . ($mode === 'edit' ? "{{ !\${$var}->{$name} ? 'selected' : '' }}" : "selected") . ">No</option>\n" .
                   "                            </select>\n" .
                   "                            @error('{$name}')<div class=\"text-danger small mt-1\">{{ \$message }}</div>@enderror\n" .
                   "                        </div>\n\n";
        }

        if ($type === 'text') {
            return "                        <div class=\"mb-3\">\n" .
                   "                            <label class=\"form-label\" for=\"{$name}\">{$label}</label>\n" .
                   "                            <textarea class=\"form-control\" id=\"{$name}\" name=\"{$name}\" rows=\"4\" {$required}>{{ {$oldValue} }}</textarea>\n" .
                   "                            @error('{$name}')<div class=\"text-danger small mt-1\">{{ \$message }}</div>@enderror\n" .
                   "                        </div>\n\n";
        }

        $inputType = match ($type) {
            'integer', 'bigInteger' => 'number',
            'float', 'decimal' => 'number',
            'date' => 'date',
            'datetime' => 'datetime-local',
            default => 'text',
        };

        $step = in_array($type, ['float', 'decimal']) ? ' step="0.01"' : '';

        return "                        <div class=\"mb-3\">\n" .
               "                            <label class=\"form-label\" for=\"{$name}\">{$label}</label>\n" .
               "                            <input type=\"{$inputType}\" class=\"form-control\" id=\"{$name}\" name=\"{$name}\" value=\"{{ {$oldValue} }}\"{$step} {$required}>\n" .
               "                            @error('{$name}')<div class=\"text-danger small mt-1\">{{ \$message }}</div>@enderror\n" .
               "                        </div>\n\n";
    }
}
