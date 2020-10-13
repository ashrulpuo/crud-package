<?=
"
<?php

namespace App\Http\Controllers\\Tetapan;

use App\Http\Controllers\Controller;
use App\\$table;
use Illuminate\Http\Request;
use App\Http\Requests\Tetapan\\". $table ."Requests;
use Illuminate\Pagination\Paginator;
use DB;

class ". $table ."Controller extends Controller
{
    protected \$fieldSearchable = [
"?>
<?php
    foreach ($set as $i => $column) { 
        if($column != $table.'Id'){
            if($column != 'DaftarPada'){
                if($column != 'Papar'){
                    echo "\n\t\t'" . $column . "',";
                }
            }
        }
    } 
?>
<?="
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request \$request)
    {
        if(\$request->ajax()){
            \$input = \$request->all();

            Paginator::currentPageResolver(function () use (\$input) {
                return (\$input['start'] / \$input['length'] + 1);
            });
    
            \$model = new ". $table ."();

            if (!empty(\$input['search']['value'])) {
                foreach (\$this->fieldSearchable as \$column) {
                    \$model = \$model->whereLike(\$column, \$input['search']['value']);
                }
            }

            \$model = \$model->paginate(\$input['length']);
            \$output = \$model->toArray();

            \$response = [
                \"draw\"            => \$input['draw'],
                \"recordsTotal\"    => intval(\$output['total']),
                \"recordsFiltered\" => intval(\$output['total']),
                \"data\"            => \$output['data']
            ];

            return response()->json(\$response, 200);
        }

        return view('tetapan.". strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $table)) .".index');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  \$request
     * @return \Illuminate\Http\Response
     */
    public function store(". $table ."Requests \$request)
    {
        \$input = \$request->all();
"?>
<?php
    foreach ($set as $i => $column) { 
        if($column == 'Papar'){
            echo "\t\t(\$request->has('papar')) ?  \$input['Papar'] = 1 :  \$input['Papar'] = 0;\n";
        }
    } 
?>
<?="
        DB::beginTransaction();
        try {
            ". $table ."::create(\$input);
            DB::commit();
            return response()->json([
                'type' => 'success',
                'code' => 200,
                'message' => 'Tetapan Berjaya Disimpan'
            ]);
        } catch (Exception \$e) {
            DB::rollback();
            throw \$e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  \$id
     * @return \Illuminate\Http\Response
     */
    public function edit(\$id)
    {
        try {
            \$". $table ." = ". $table ."::where('". $table.'Id' ."', \$id)->get()->first();
            return response()->json([
                'type' => 'success',
                'code' => 200,
                'data' => \$". $table ."
            ]);
        } catch (\Throwable \$th) {
            throw \$th;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  \$request
     * @param  int  \$id
     * @return \Illuminate\Http\Response
     */
    public function update(". $table ."Requests \$request, \$id)
    {
        \$input = \$request->all();
        "?>
<?php
    foreach ($set as $i => $column) { 
        if($column == 'Papar'){
            echo "(\$request->has('papar')) ?  \$input['Papar'] = 1 :  \$input['Papar'] = 0;\n";
        }
    } 
?>
<?="
        try {
            \$". $table ." = ". $table ."::where('". $table.'Id' ."',\$id)->get()->first();
            \$". $table ."->update(\$input);
            return response()->json([
                'type' => 'success',
                'code' => 200,
                'message' => 'Kemaskini tetapan berjaya'
            ]);
        } catch (\Throwable \$th) {
            throw \$th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  \$id
     * @return \Illuminate\Http\Response
     */
    public function destroy(\$id)
    {   
        try {
            ". $table ."::destroy(\$id);
            return response()->json([
                'type' => 'success',
                'code' => 200,
                'message' => 'Tetapan berjaya dipadam'
            ]);
        } catch (\Throwable \$th) {
            throw \$th;
        }
    }

    /*
    public function filter(\$val)
    {
        try {
            \$.'". $table ."' = '". $table.'Id' ."'::orderBy('DaftarPada', 'asc')
                ->where('KodAgama', 'LIKE', '%' . \$val . '%')
                ->orWhere('Penerangan', 'LIKE', '%' . \$val . '%')
                ->get();
        
          return \$agama;
        } catch (\Throwable \$th) {
            throw \$th;
           return ['agama' => 'ralat di filter function'];
       }  
    }
    */
}
"
?>