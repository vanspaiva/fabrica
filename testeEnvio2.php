<pre>
    <?php     
    require_once("db/dbh.php");
    
        print_r($_GET['id']);
    
        $services = [];
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'srv') === 0) {
                $services[$key] = $value;
            }
        }
        foreach ($services as $key => $value) {
            unset($_POST[$key]);
        }
        function UpdateRegistro004($mysqli_conection) {
            global $services;
        
            $id_usuario = $_GET['id'];
            $setor = $_POST["setor"];
            $area_adm = $_POST["area-adm"];
            $data_exec = $_POST["dtexec"];
            $periodo = $_POST["periodo"];
            $responsavel = $_POST["responsavel"];
        
            $tipo_limpeza = implode("\n", $services);
        
            $sql = "UPDATE form_inf_003 SET setor = ?, area_adm = ?, data = ?, periodo = ?, responsavel = ?, tipo_limpeza = ? WHERE id = ?"; 
        
            if ($stmt = mysqli_prepare($mysqli_conection, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssssssi", $setor, $area_adm, $data_exec, $periodo, $responsavel, $tipo_limpeza, $id_usuario);
        
                if (mysqli_stmt_execute($stmt)) {
                    echo "Record updated successfully";
                    header("Location: showForm003");
                    exit;
                } else {
                    echo "Error: " . mysqli_stmt_error($stmt);
                }
                
                mysqli_stmt_close($stmt);
            } else {
                echo "Error preparing statement: " . mysqli_error($mysqli_conection);
            }
        }
        
        UpdateRegistro004($conn);
    ?>

    
</pre>