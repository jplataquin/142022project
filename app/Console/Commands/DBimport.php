<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DBimport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import sql files into database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {   
        $files = Storage::disk('local')->files('sql');

        foreach($files as $file){
            $data = Storage::disk('local')->get($file);
            echo $file."\n";
            DB::unprepared($data);
        }

        //DB::unprepared(file_get_contents('full/path/to/dump.sql'));
        return Command::SUCCESS;
    }
}
