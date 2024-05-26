<?php

namespace App\Core\SharedKernel\Component\Request;

interface RequestInterface
{
    public function accept(): void;

    public function reject(int $rejectReasonCode, string $rejectMessage): void;

    public function getContent(): array;
}