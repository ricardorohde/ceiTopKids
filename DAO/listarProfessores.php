<?php

function listaDeProfessores($v) {    
     $query = mysql_query("SELECT professores.nome, professores.id, professores.id_endereco, professores.funcao, professores.rg, professores.cpf, professores.estadoCivil, professores.dataNascimento, professores.formacao, professores.anoConclusao "
            . " FROM professores") or die(mysql_error());
    return $query;
}

?>