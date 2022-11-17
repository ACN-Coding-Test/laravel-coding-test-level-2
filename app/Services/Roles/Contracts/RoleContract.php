<?php
namespace App\Services\Roles\Contracts;

interface RoleContract
{
    public function label(): string;
    public function value(): string;
    public function permissions(): array;
}
