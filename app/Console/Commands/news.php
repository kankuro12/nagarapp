<?php

namespace App\Console\Commands;

use App\Models\News as ModelsNews;
use Illuminate\Console\Command;

class news extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $news=ModelsNews::first();
        for ($i=0; $i < 100; $i++) {
            $n=new ModelsNews();
            $n->title=$news->title;
            $n->content=$news->content;
            $n->image=$news->image;
            $n->user_id=$news->user_id;
            $n->nagarcode=$news->nagarcode;
            $n->save();
        }
        return Command::SUCCESS;
    }




}
