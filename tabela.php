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

            $page = $_GET['page'] ? intval($_GET['page']) : 1;
            $limit = 10;  // Número de registos por página
            $offset = ($page - 1) * $limit;  // Calcular o deslocamento da tabela que vai aparecer sem isso os registos da tabela só se repetem(OFFSET)

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
            include("paginacao.php");
            echo "<h3> Foram encontrados $total_registos registos </h3>";
            echo "Número de páginas: $total_paginas";
    
            ?>
