<?php

namespace App\Console\Commands;

use App\Parser\Parser;
use Illuminate\Console\Command;

class ParseCommand extends Command {

    protected $signature = 'parse';

    public function handle() {

        $parser = new Parser();
        $parser->parsePage();

    }

}
