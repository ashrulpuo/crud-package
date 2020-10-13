<?php

namespace Ashrul\Generator\Console;
use Illuminate\Console\Command;
use DB;

class GenerateCommand extends Command {

    protected $signature = 'ashrul:generate';

    protected $description = 'crud generator';

    public function __construct() {
        parent::__construct();
    }

    public function handle() {
        $getTables = DB::select("SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME LIKE 'Ref%'");
        $tables = [];
        foreach ($getTables as $key => $value) {
            $tables[] = $value->TABLE_NAME;
        }
        CreateModel::web($tables);
        CreateModel::GetColumns($tables);
    }

}