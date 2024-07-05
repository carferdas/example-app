<?php

namespace App\Core\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use ReflectionClass;

abstract class BaseServiceProvider extends ServiceProvider
{
    private string $migrationsPath = '../Database/Migration';

    private string $routesPath = '../Http/Routes';

    private array $routeFiles = [];

    private string $viewsPath = '../Resources/Views';

    private string $viewsNamespace = '';

    public function boot(): void
    {
        Model::shouldBeStrict();

        $this->loadMigrationsFrom($this->basePath()."/$this->migrationsPath");

        $this->loadViewsFrom($this->basePath()."/$this->viewsPath", $this->getViewsNamespace());

        $this->bootRoutes();
    }

    protected function basePath(): string
    {
        $reflection = new ReflectionClass($this);

        return dirname($reflection->getFileName());
    }

    public function bootRoutes(): void
    {
        $files = blank($this->routeFiles)
            ? glob($this->basePath()."/$this->routesPath/*.php")
            : $this->routeFiles;

        foreach ($files as $file) {
            require $file;
        }
    }

    public function setMigrationsPath(string $path): self
    {
        $this->migrationsPath = $path;

        return $this;
    }

    public function setRoutesPath(string $path): self
    {
        $this->routesPath = $path;

        return $this;
    }

    public function setRouteFiles(array $routeFiles): self
    {
        $this->routeFiles = $routeFiles;

        return $this;
    }

    public function setViewsPath(string $path, string $namespace = ''): self
    {
        $this->viewsPath = $path;
        $this->viewsNamespace = $namespace;

        return $this;
    }

    public function setViewsNamespace(string $namespace): self
    {
        $this->viewsNamespace = $namespace;

        return $this;
    }

    private function getViewsNamespace(): string
    {
        if ($this->viewsNamespace) {
            return $this->viewsNamespace;
        }

        $folderName = basename(dirname($this->basePath()));

        return str($folderName)->snake()->value();
    }
}
