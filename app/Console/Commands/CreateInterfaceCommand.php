<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateInterfaceCommand extends FileFactoryCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:interface {classname}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command for make interface';

    /**
     * Execute the console command.
     *
     * @return int
     */
    function setStubName():string
    {
        return "interface";
    }
    function setArgument():string
    {
        return "classname";
    }
    function setFilePath():string
    {
        return "App\\Interfaces\\";
    }
    function setSuffix():string
    {
        return "Interface";
    }
}
