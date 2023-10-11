<?php

namespace App\Console\Commands;


class CreateServiceClass extends FileFactoryCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {classname}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command for create service class pattern';

    /**
     * Execute the console command.
     *
     * @return int
     */
     function setStubName():string
     {
         return "servicepattern";
     }
     function setArgument():string
     {
         return "classname";
     }
     function setFilePath():string
     {
         return "App\\Services\\";
     }
     function setSuffix():string
     {
         return "Service";
     }

}
