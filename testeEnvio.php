


    <?php
        require_once("db/dbh.php");
        
        // Separando os serviços em um array separado
        $services = [];
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'srv') === 0) {
                $services[$key] = $value;
            }
        }

        // Excluindo os serviços do array original
        foreach ($services as $key => $value) {
            unset($_POST[$key]);
        }

        // Imprimindo os arrays separados para verificação
        
        function insertRegistro004($mysqli_conection) {
            global $services;
            $tipo_limpeza = "";
        
            $id_usuario = $_POST["idCriador"];
            $setor = $_POST["setor"];
            $area_adm = $_POST["area-adm"];
            $data_exec = $_POST["dtexec"];
            $periodo = $_POST["periodo"];
            $responsavel = $_POST["responsavel"];
        
            foreach ($services as $key) {
                $tipo_limpeza .= $key . "\n";
            }
        
            // Prepare the SQL query
            $sql = "INSERT INTO form_inf_003 (setor, area_adm, data, periodo, responsavel, id_user_criador, tipo_limpeza) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
        
            if ($stmt = mysqli_prepare($mysqli_conection, $sql)) {
                // Bind the parameters to the SQL query
                mysqli_stmt_bind_param($stmt, "sssssis", $setor, $area_adm, $data_exec, $periodo, $responsavel, $id_usuario, $tipo_limpeza);
        
                // Execute the query
                if (mysqli_stmt_execute($stmt)) {
                    echo "Record inserted successfully";
                } else {
                    echo "Error: " . mysqli_stmt_error($stmt);
                }
        
                // Close the statement
                mysqli_stmt_close($stmt);
            } else {
                echo "Error preparing statement: " . mysqli_error($mysqli_conection);
            }
        
            // Debug output
            echo $id_usuario . "\n" . $setor . "\n" . $area_adm . "\n" . $data_exec . "\n" . $periodo . "\n" . $responsavel . "\n" . $tipo_limpeza;
        }
        function showRegistrosLimpeza($mysqli_conection) {
            // SQL query to select all records from form_inf_003
            $sql = "SELECT * FROM form_inf_003 LIMIT 1";
        
            // Execute the query
            if ($result = mysqli_query($mysqli_conection, $sql)) {
                // Check if there are any records
                if (mysqli_num_rows($result) > 0) {
                    // Start table
                    echo '<table border="1">';
                    
                    // Table header
                    echo '<tr>';
                    echo '<th>ID</th>';
                    echo '<th>Setor</th>';
                    echo '<th>Área Administrativa</th>';
                    echo '<th>Data</th>';
                    echo '<th>Período</th>';
                    echo '<th>Responsável</th>';
                    echo '<th>ID Usuário Criador</th>';
                    echo '<th>Tipo de Limpeza</th>';
                    echo '<th>Conferido</th>';
                    echo '<th>Data de Publicação</th>';
                    echo '<th>Data de Validade</th>';
                    echo '</tr>';
        
                    // Table rows
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . $row["id"] . '</td>';
                        echo '<td>' . $row["setor"] . '</td>';
                        echo '<td>' . $row["area_adm"] . '</td>';
                        echo '<td>' . $row["data"] . '</td>';
                        echo '<td>' . $row["periodo"] . '</td>';
                        echo '<td>' . $row["responsavel"] . '</td>';
                        echo '<td>' . $row["id_user_criador"] . '</td>';
                        echo '<td>' . nl2br($row["tipo_limpeza"]) . '</td>';
                        echo '<td>' . $row["conferido"] . '</td>';
                        echo '<td>' . $row["form_data_publicacao"] . '</td>';
                        echo '<td>' . $row["form_data_validade"] . '</td>';
                        echo '</tr>';
                    }
        
                    // End table
                    echo '</table>';
                } else {
                    echo "No records found.";
                }
                // Free result set
                mysqli_free_result($result);
            } else {
                echo "Error: " . mysqli_error($mysqli_conection);
            }
        }


        function showRegistrosLimpeza2($mysqli_conection) {
            // SQL query to select all records from form_inf_003
            $sql = "SELECT * FROM form_inf_003 LIMIT 1";
        
            // Array para armazenar os dados
            $records = array();
        
            // Execute a consulta
            if ($result = mysqli_query($mysqli_conection, $sql)) {
                // Verifica se há registros
                if (mysqli_num_rows($result) > 0) {
                    // Itera sobre os resultados e adiciona ao array
                    while ($row = mysqli_fetch_assoc($result)) {
                        $records[] = $row;
                    }
        
                    // Libera o resultado
                    mysqli_free_result($result);
        
                    // Retorna os registros como JSON
                    header('Content-Type: application/json');
                    echo json_encode($records, JSON_PRETTY_PRINT);
                } else {
                    echo json_encode(array('message' => 'No records found.'));
                }
            } else {
                echo json_encode(array('error' => mysqli_error($mysqli_conection)));
            }
        }
        


        //insertRegistro004($conn);
        
        showRegistrosLimpeza2($conn);


    ?>
