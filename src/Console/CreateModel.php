<?php

namespace Ashrul\Generator\Console;

use Illuminate\Http\Request;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\ServiceProvider;
use DB;
use Config;
use View;

class CreateModel extends \App\Http\Controllers\Controller
{
    public static function GetColumns($tables)
    {
        foreach ($tables as $key => $table) {
            $q = 'exec sp_columns ' . $table;
            $getColumns[$key] = [
                'table' => $table,
                'columns' => DB::select($q)
            ];
        }

        $newStruc = [];
        foreach ($getColumns as $k => $column) {
            foreach ($column['columns'] as $y => $value) {
                $newStruc[$column['table']][] = $value->COLUMN_NAME;
            }
        }

        self::CreateModel($newStruc);
    }


    public static function CreateModel($table)
    {

        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, count($table));

        $progressBar->setBarCharacter('=');
        $progressBar->setProgressCharacter('⏳');
        $progressBar->setEmptyBarCharacter(' ');

        $progressBar->setMessage('Starting...');
        $progressBar->start();

        foreach ($table as $key => $value) {
            sleep(1);

            $set = array_diff($value, [
                "ServerName",
                "HostName",
                "DaftarOleh",
                "KemaskiniOleh",
                "KemaskiniPada",
                "HapusOleh",
                "HapusPada",
            ]);

            $model = self::model($value, $key);
            $controller = self::controller($set, $key);
            $req = self::req($set, $key);
            $form = self::form($set, $key);
            $index = self::index($set, $key);
            $js = self::js($set, $key);

            dump($model, $controller, $req, $form, $index, $js);

            $progressBar->setProgressCharacter("\xF0\x9F\x8D\xAA");
            $progressBar->advance();
        }
        $progressBar->finish();
    }

    public static function model($set, $table)
    {
        $content = view('views::_model_template', ['set' => $set, 'table' => $table]);
        $path = base_path();
        $modelFile = $path . '/app/' . $table . '.php';
        if (file_put_contents($modelFile, $content) !== false) {
            return ['success' => "Model created (" . basename($modelFile) . ")"];
        }
    }

    public static function controller($set, $table)
    {
        $content = view('views::_controller_template', ['set' => $set, 'table' => $table]);
        $path = base_path() . '/app/Http/Controllers/Tetapan';
        $modelFile = $path . "/" . $table . 'Controller.php';
        if(!file_exists($path)) {
            $path = base_path() . '/app/Http/Controllers/' . 'Tetapan';
            mkdir($path, 0777, true);
        }

        // if (!file_exists($modelFile)){
        if (file_put_contents($modelFile, $content) !== false) {
            return ['success' => "Controller (" . basename($modelFile) . ")"];
        }
        // }
    }

    public static function req($set, $table)
    {
        $content = view('views::_request_template', ['set' => $set, 'table' => $table]);
        $path = base_path() . '/app/Http/Requests/Tetapan';
        $modelFile = $path . "/" . $table . 'Requests.php';

        if(!file_exists($path)) {
            $path = base_path() . "/app/Http/" . 'Requests/Tetapan';
            mkdir($path, 0777, true);
        }

        // if (!file_exists($modelFile)){
        if (file_put_contents($modelFile, $content) !== false) {
            return ['success' => "requests (" . basename($modelFile) . ")"];
        }
        // }
    }

    public static function form($set, $table)
    {
        $content = view('views::_form_template', ['set' => $set, 'table' => $table]);
        $convert = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $table));
        $path = Config::get('view.paths');
        $newPath = $path[0] . "/tetapan/" . $convert;
        
        if (!file_exists($newPath)) {
            mkdir($newPath, 0777, true);
            $modelFile = $newPath . "/" . "_form_" . $convert . '.blade.php';
            if (file_put_contents($modelFile, $content) !== false) {
                return ['success' => "form (" . basename($modelFile) . ")"];
            }
        }
    }

    public static function index($set, $table)
    {
        $content = view('views::_index_template', ['set' => $set, 'table' => $table]);
        $convert = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $table));
        $path = Config::get('view.paths');
        // $newPath = $path[0].'/tetapan'.'/'.$convert;
        $newPath = $path[0] . '/tetapan/' . $convert;
        if (file_exists($newPath)) {
            $modelFile = $newPath . "/" . 'index.blade.php';
            if (!file_exists($modelFile)) {
                if (file_put_contents($modelFile, $content) !== false) {
                    return ['success' => "index (" . basename($modelFile) . ")"];
                }
            }
        }
    }

    public static function js($column, $table)
    {
        $set = array_diff($column, ['Papar']);
        $content = view('views::_js_template', ['set' => $set, 'table' => $table]);
        $convert = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $table));
        $path = resource_path();
        $newPath = $path . "/js/tetapan";
        
        if(!file_exists($newPath)) {
            $path = resource_path() . "/js/"."tetapan";
            mkdir($path, 0777, true);
        }
        
        // $path = "/Users/pocketdata/Desktop/docker-webstack/projects/"."spr/src/resources/spr/js/tetapan";
        // $newPath = $path.'/'.$convert;
        if (file_exists($newPath)) {
            $modelFile = $newPath . "/" . substr($convert, 4) . '.js';
            if (!file_exists($modelFile)) {
                if (file_put_contents($modelFile, $content) !== false) {
                    return ['success' => "js (" . basename($modelFile) . ")"];
                }
            }
        }
    }

    public static function web($tables)
    {
        $content = view('views::_web_template', ['tables' => $tables]);
        $path = base_path('routes');
        if (file_exists($path)) {
            $modelFile = $path . "/" . "generated-routes.php";
            if (file_put_contents($modelFile, $content) !== false) {
                return ['success' => "web (" . basename($modelFile) . ")"];
            }
        }
    }
}
