<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Bookings\Domain\Repository\BookingRepository;
use Src\Bookings\Infrastructure\Repository\EloquentRepository\EloquentBookingRepository;
use Src\Hotels\Hotels\Domain\Repository\HotelRepository;
use Src\Hotels\Hotels\Infrastructure\Repository\Eloquent\EloquentHotelRepository;
use Src\Hotels\Rooms\Domain\Repository\RoomRepository;
use Src\Hotels\Rooms\Infrastructure\Repository\Eloquent\EloquentRoomRepository;
use Src\Shared\Common\Domain\Service\UuidGenerator\UuidGenerator;
use Src\Shared\Common\Domain\Transaction\TransactionManager;
use Src\Shared\Common\Infrastructure\Service\UuidGenerator\LaravelUuidGenerator;
use Src\Shared\Common\Infrastructure\Transaction\LaravelTransactionManager;

/**
 * Application Service Provider.
 * 
 * This class is responsible for binding interfaces to their concrete implementations
 * in the application. It manages dependency injection for repositories and services.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * The application's interface bindings.
     * 
     * Maps domain interfaces to their infrastructure implementations.
     * 
     * @var array<class-string, class-string>
     */
    public array $bindings = [
        HotelRepository::class => EloquentHotelRepository::class,
        RoomRepository::class => EloquentRoomRepository::class,
        BookingRepository::class => EloquentBookingRepository::class,
        TransactionManager::class => LaravelTransactionManager::class,
        UuidGenerator::class => LaravelUuidGenerator::class,
    ];

    /**
     * Register any application services.
     * 
     * This method is called during the service container binding phase.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     * 
     * This method is called after all other service providers have been registered.
     */
    public function boot(): void
    {
        //
    }
}
