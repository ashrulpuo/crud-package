<?=
"
<form class=\"form\" method=\"POST\" id=".'"'. 'tetapan'.substr($table, 3) .'"'.">
    @csrf
"?>
<?php
    foreach ($set as $i => $column) {
        if($column != 'DaftarPada'){
            if($column == $table."Id"){
                echo "\t<input type=\"text\" hidden class=\"form-control\" id=".'"'. $column .'"'." name=".'"'. $column .'"'."  /> ";
            }else{
                if ($column != "Papar") {
                    echo "\n\t<div class=\"form-group\">
        <label>". preg_replace('/([a-z])([A-Z])/s','$1 $2', $column) ."</label>
        <input type=\"text\" class=\"form-control\" id=".'"'. $column .'"'." name=".'"'. $column .'"'." placeholder=\"Contoh\" />
    </div> ";
                }else{
                    echo "\n\t<div class=\"form-group row\">
        <label class=\"col-2 col-form-label\">Papar</label>
        <div class=\"col-10\">
            <span class=\"switch\">
                <label>
                    <input type=\"checkbox\" id=".'"'. $column .'"'." checked=\"checked\" name=".'"'. $column .'"'." />
                    <span></span>
                </label>
            </span>
        </div>
    </div>";
                }
            }
        }
    } 
?>
<?="
</form>
"
?>