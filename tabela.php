<!DOCTYPE html>
<html lang="pt">
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
    </style>
</head>
<body>

    <h2 style="text-align:center;">Tabela de Dados da Base de Dados</h2>

    <table>
        <thead>
            <tr>
                <th>Coluna 1</th>
                <th>Coluna 2</th>
                <th>Coluna 3</th>
                <th>Coluna 4</th>
                <th>Coluna 5</th>
                <th>Coluna 6</th>
            </tr>
        </thead>
        <tbody>

            <?php 
            include("config.php");

            // Query SQL para buscar dados da tabela
            $consulta = "SELECT * 
            FROM tbl_aluno_ano AS tbano
            Left JOIN tbl_alunos AS tbu ON tbano.id_aluno = tbu.id_aluno
            Left JOIN tbl_ano_turma AS ats ON ats.idat = tbano.idat
            Left JOIN tbl_user_aluno AS tpw ON tpw.email_aluno = tbu.email_aluno;";

            $resultado=mysqli_query($ligaDB,$consulta);
            $nregistos=mysqli_num_rows($resultado);
            echo"<h3> Foram encontrados $nregistos registos </h3>";

            

            while($registos = mysqli_fetch_assoc($resultado)) {
                echo "<tr>";
                echo "<td>" . $registos["ano"] . "</td>";
                echo "<td>" . $registos["turma"] . "</td>";
                echo "<td>" . $registos["nome_aluno"] . "</td>";
                echo "<td>" . $registos["user_aluno"] . "</td>";
                echo "<td>" . $registos["email_aluno"] . "</td>";
                echo "<td>" . $registos["aluno_pw"] . "</td>";
                echo "</tr>";
                }

            ?>
        </tbody>
    </table>

</body>
</html>
