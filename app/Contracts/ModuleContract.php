<?php

namespace App\Contracts;

/**
 * Module Contract
 * 
 * Defines the interface for pluggable modules
 * Each module MUST implement this contract to be loaded by ModuleServiceProvider
 * 
 * Layer A: Module runtime foundation
 */
interface ModuleContract
{
    /**
     * Get the module name
     * 
     * @return string
     */
    public function getName(): string;

    /**
     * Get the module version
     * 
     * @return string
     */
    public function getVersion(): string;

    /**
     * Register module services
     * 
     * Called during service provider registration phase
     * 
     * @return void
     */
    public function register(): void;

    /**
     * Boot module services
     * 
     * Called during service provider boot phase
     * Use this to register routes, views, migrations, etc.
     * 
     * @return void
     */
    public function boot(): void;

    /**
     * Get module dependencies
     * 
     * @return array Module names that this module depends on
     */
    public function getDependencies(): array;

    /**
     * Check if module is enabled
     * 
     * @return bool
     */
    public function isEnabled(): bool;
}
