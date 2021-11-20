<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class admin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'creates a new admin';

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
        $user=new User();
        $user->email='cms@gmail.com';
        $user->password=bcrypt('admin123');
        $user->phone='9800916365';
        $user->name='chhatraman shretha';
        $user->nagarcode='00:00';
        $user->save();
        return Command::SUCCESS;
    }
}
