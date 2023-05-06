<?php

namespace allbertss\psittacorum\test;

class DependantClass
{
    public function __construct(
        private DependencyClass $dependency,
    )
    {
    }

    public function getDependency(): DependencyClass
    {
        return $this->dependency;
    }
}