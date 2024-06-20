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
                    header("location: showForm003Pendentes");
                } else {
                    echo "Error: " . mysqli_stmt_error($stmt);
                }
        
                // Close the statement
                mysqli_stmt_close($stmt);
            } else {
                echo "Error preparing statement: " . mysqli_error($mysqli_conection);
            }
        
            // Debug output
            //echo $id_usuario . "\n" . $setor . "\n" . $area_adm . "\n" . $data_exec . "\n" . $periodo . "\n" . $responsavel . "\n" . $tipo_limpeza;
        }
        
        insertRegistro004($conn);
