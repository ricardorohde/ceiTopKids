<?php 
include "../classes/conexao.php";


backup_bd($host,$usuario,$senha,$banco);
 
/* Fazer Backup da BD ou só de uma Tabela */
function backup_bd($host,$utilizador,$password,$nome,$tabelas = '*')
{
 
    $link = mysql_connect($host,$utilizador,$password);
    mysql_select_db($nome,$link);
 
    //obter todas as tabelas
    if($tabelas == '*')
    {
        $tabelas = array();
        $resultado = mysql_query('SHOW TABLES');
        while($coluna = mysql_fetch_row($resultado))
        {
            $tabelas[] = $coluna[0];
        }
    }
    else
    {
        $tabelas = is_array($tabelas) ? $tabelas: explode(',',$tabelas);
    }
 
    foreach($tabelas as $tabelas)
    {
        $resultado = mysql_query('SELECT * FROM '.$tabelas);
        $num_campos = mysql_num_fields($resultado);
 
        $return.= 'DROP TABLE '.$tabelas.';';
        $coluna2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$tabelas));
        $return.= "\n\n".$coluna2[1].";\n\n";
 
        for ($i = 0; $i < $num_campos; $i++)
        {
            while($coluna = mysql_fetch_row($resultado))
            {
                $return.= 'INSERT INTO '.$tabelas.' VALUES(';
                for($j=0; $j<$num_campos; $j++)
                {
                    $coluna[$j] = addslashes($coluna[$j]);
                    $coluna[$j] = ereg_replace("\n","\\n",$coluna[$j]);
                    if (isset($coluna[$j])) { $return.= '"'.$coluna[$j].'"' ; } else { $return.= '""'; }
                    if ($j<($num_campos-1)) { $return.= ','; }
                }
                $return.= ");\n";
            }
        }
        $return.="\n\n\n";
    }
 
    //guarda ficheiro
	$data = date("d-m-Y - H.m.s");
    $ficheiro = fopen('backup-'.$data.'.sql','w+');
    fwrite($ficheiro,$return);
    fclose($ficheiro);
}

/* 	print "
	<META HTTP-EQUIV=REFRESH CONTENT='0; URL=../inicio.php'>
	<script type=\"text/javascript\">
	alert(\"Backup da base de dados feito com sucesso.\");
	</script>";
 */

?>