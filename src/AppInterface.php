<?php declare(strict_types = 1);

namespace Feather;

interface AppInterface
{
    public function setup(): void;
    public function run(): void;
}