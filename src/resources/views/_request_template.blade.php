<?=
"
<?php

namespace App\Http\Requests\Tetapan;

use Illuminate\Foundation\Http\FormRequest;

class ". $table.'Requests' ." extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //check request for unique value
        return [
"?>
<?php
    foreach ($set as $i => $column) {
        if($column != 'DaftarPada'){
            if ($column != $table.'Id') {
                if($column == "Papar"){
                echo "\n\t\t\t'$column' => '',";
            }else{
                echo "\n\t\t\t'$column' => !empty(\$this->".$table.'Id'.") ? 'required|unique:$table,$column,' . \$this->".$table.'Id'." . ',".$table.'Id'."' : 'required|unique:$table,$column',";
            }
            }
        }
    } 
?>
<?="
        ];
    }
}
"
?>