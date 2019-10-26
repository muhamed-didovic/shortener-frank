<?php

namespace MuhamedDidovic\Shortener\Console;

use DB;
use Illuminate\Console\Command;
use MuhamedDidovic\Shortener\Models\Link;

/**
 * Class Shortener.
 */
class ShortenerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shortener:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete rows where column "code" is null';

    public function handle()
    {
        DB::beginTransaction();
        try {
            $links = Link::whereNull('code')->delete();
            $this->info('Deleted rows:'.$links);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->error($e);
        }
    }
}
