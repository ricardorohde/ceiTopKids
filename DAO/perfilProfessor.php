<?php

function perfilDatalhe($id) {
    $query = mysql_query("SELECT * FROM professores LEFT JOIN endereco_professor ON professores.id_endereco = endereco_professor.id  where professores.id = $id") or die(mysql_error());
    return $query;
}


function listaObs($id){
    $query = mysql_query("SELECT o.obs, o.data FROM professores a, observacao_professor o where a.id = o.id_professor and a.id = $id");
    return $query;
}


?>