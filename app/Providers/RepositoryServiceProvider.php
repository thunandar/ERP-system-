<?php
namespace App\Providers;

use App\Interfaces\EmployeeInterface;
use App\Repositories\EmployeeRepositry;
use App\Interfaces\EmployeeUploadInterface;
use App\Repositories\EmployeeUploadRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public $bindings = [
        EmployeeInterface::class => EmployeeRepositry::class,
        EmployeeUploadInterface::class => EmployeeUploadRepository::class
    ];
    public function register() {
        $this->app->bind(EmployeeInterface::class,EmployeeRepositry::class);
        $this->app->bind(EmployeeUploadInterface::class,EmployeeUploadRepository::class);
    }
}
