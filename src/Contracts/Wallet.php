<?php

namespace Pashkevich\Wallet\Contracts;

interface Wallet
{
    public function createPass(Pass $pass): void;
}
