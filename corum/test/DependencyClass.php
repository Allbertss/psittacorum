<?php

namespace allbertss\psittacorum\test;

class DependencyClass
{
    public function __construct(
        private SubDependencyClass $subDependencyClass
    )
    {
    }

    public function getSubDependencyClass(): SubDependencyClass
    {
        return $this->subDependencyClass;
    }
}