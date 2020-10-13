<?=
"
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

  
class " . $table . " extends Model
{
    // use \OwenIt\Auditing\Auditable;
    
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected \$table = '". $table ."';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected \$primaryKey = '". $table.'Id' ."';

    /**
    * auto generate UUID
    */
    public static function boot()
    {
        parent::boot();
        self::creating(function (\$model) {
            \$model->". $table.'Id' ." = Str::uuid();
            \$model->DaftarOleh = Auth::check() ? Auth::user()->id : (string) Str::uuid();
            \$model->ServerName = gethostname();
            \$model->HostName = gethostname();

        });
        self::updating(function (\$model) {
            \$model->KemaskiniOleh = Auth::check() ? Auth::user()->id : (string) Str::uuid();
        });
    }

    /**
     * The \"type\" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected \$keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public \$incrementing = false;

    /**
    * The name of the 'created at' column.
    *
    * @var string
    */
    const CREATED_AT = 'DaftarPada';

    /**
    * The name of the 'updated at' column.
    *
    * @var string
    */
    const UPDATED_AT = 'KemaskiniPada';

    /**
     * @var array
     */
    protected \$fillable = [
"?>
<?php
    foreach ($set as $i => $column) { 
        echo "\n\t\t'" . $column . "',";
    } 
?>
<?="
    ];

}

"
?>