<?php

namespace allbertss\psittacorum\console\command;

interface CommandInterface
{
    public function execute(array $parameters = []): int;
}