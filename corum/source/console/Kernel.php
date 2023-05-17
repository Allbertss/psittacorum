<?php

namespace allbertss\psittacorum\console;

final class Kernel
{
    /*
     * Statuses
     * 0 - The application completed successfully.
     * 1 - The application encountered an error or invalid input.
     * 2 - The application was unable to find the specified file.
     * 3 - The application encountered a runtime error.
     * 4 - The application ran out of memory.
     * 5 - The user cancelled the application.
     * 6 - The application attempted to access a resource it was not authorized to use.
     * 7 - The application encountered an internal error or crash.
     * 8 - The application encountered a network error.
     * 9 - The application was terminated by a signal.
     */
    public function handle(): int
    {


        return 0;
    }
}