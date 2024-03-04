<?php

namespace Pashkevich\Wallet\Contracts;

interface Pass
{
    public function getId(): string;

    public function getTitle(): string;

    public function getDescription(): string;
}
