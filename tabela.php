<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabela de Dados</title>
    <style>
        /* Estilos para a tabela */
        table {
            width: 60%;
            margin: 50px auto; /* Centraliza a tabela na página */
            border-collapse: collapse;
            border: 2px solid #D8BFD8; /* Borda roxo claro */
        }

        th, td {
            border: 2px solid #D8BFD8;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #D8BFD8; /* Fundo roxo claro */
        }
        div{
            text-align: center; /* para centralizar a div que tem o número de páginas */
        }
    </style>
</head>
<body>

    <h2 style="text-align:center;">Tabela de Dados da Base de Dados</h2>

    <table>
        <thead>
            <tr>
                <th>Ano</th>
                <th>Turma</th>
                <th>Nome</th>
                <th>User</th>
                <th>Email</th>
                <th>Password</th>
            </tr>
        </thead>
        <tbody>

            <?php 
            include("config.php");
            

// Parâmetros de paginação
$page = $_GET['page'] ? intval($_GET['page']) : 1; // Página atual (padrão: 1)
$limit = 10;  // Número de registos por página
$offset = ($page - 1) * $limit;  // Calcular o deslocamento da tabela que vai aparecer sem isso os registos da tabela só se repetem(OFFSET)
$page_intervalo = 3; //O intervalo de páginas que vai aparecer

//Consulta para contar o número total de registos (sem LIMIT)
$count_query = "SELECT COUNT(*) AS total_registos 
                FROM tbl_aluno_ano AS tbano
                INNER JOIN tbl_alunos AS tbu ON tbano.id_aluno = tbu.id_aluno
                INNER JOIN tbl_ano_turma AS ats ON ats.idat = tbano.idat
                INNER JOIN tbl_user_aluno AS tpw ON tpw.email_aluno = tbu.email_aluno";

$result_count = mysqli_query($ligaDB, $count_query);
$total_registos = mysqli_fetch_assoc($result_count)['total_registos'];//Para dizer quantos registos foram criados e coloca num alias 

// Calcular o número total de páginas
$total_paginas = ceil($total_registos / $limit);

//Consulta para buscar os registos com o LIMIT e OFFSET
$consulta = "SELECT * 
            FROM tbl_aluno_ano AS tbano
            INNER JOIN tbl_alunos AS tbu ON tbano.id_aluno = tbu.id_aluno
            INNER JOIN tbl_ano_turma AS ats ON ats.idat = tbano.idat
            INNER JOIN tbl_user_aluno AS tpw ON tpw.email_aluno = tbu.email_aluno
            LIMIT $limit OFFSET $offset";

$resultado = mysqli_query($ligaDB, $consulta);

//Tabela de registos
while ($registos = mysqli_fetch_assoc($resultado)) {
    echo "<tr>";
    echo "<td>" . $registos["ano"] . "</td>";
    echo "<td>" . $registos["turma"] . "</td>";
    echo "<td>" . $registos["nome_aluno"] . "</td>";
    echo "<td>" . $registos["user_aluno"] . "</td>";
    echo "<td>" . $registos["email_aluno"] . "</td>";
    echo "<td>" . $registos["aluno_pw"] . "</td>";
    echo "</tr>";
}
echo "</tbody></table>";

echo "<div>"; // Uma div para depois centralizar tudo
echo "<a href='?page=1'>Primeira</a>&nbsp;&nbsp;&nbsp;"; // Para ir direto para a primeira página

$last_page = $page > 1 ? $page - 1 : 1; //Função para voltar uma página
echo "<a href='?page=$last_page'><<</a> ";  //Para onde a função de voltar uma página foi

$prim_page = max($page - $page_intervalo,1); //Para que o intervalo de páginas não crie páginas negativas
$ult_page = min ($total_paginas, $page + $page_intervalo); //Para que o intervalo de páginas não crie páginas a mais 
for ($p = $prim_page; $p <= $ult_page; $p++) { //Para navegar entre as páginas
    if ($p == $page) {
        echo "<b>$p</b> "; // Página atual destacada em bold
    } else {
        echo "<a href='?page=$p'>$p</a> ";
    }
}

$next_page = $page < $total_paginas ? $page + 1 : $total_paginas; //Função para avançar uma página
echo "<a href='?page=$next_page'>>></a>&nbsp;&nbsp;&nbsp;";  // Para onde a função avançar foi

echo "<a href='?page=$total_paginas'>Última</a>"; //Para ir direto para a ultima pagina
echo "</div>";
echo "<h3> Foram encontrados $total_registos registos </h3>";
echo "Número de páginas: $total_paginas";

?>
