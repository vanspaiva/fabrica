<html lang="en">
 <head>
   <!-- Includes all JS & CSS for the JavaScript Data Grid -->
   <script src="https://cdn.jsdelivr.net/npm/ag-grid-community/dist/ag-grid-community.min.js"></script>
 </head>
 <body>
   <!-- Your grid container -->
   <div id="myGrid" class="ag-theme-quartz" style="height: 500px"></div>
 </body>
 <script>

    var xhttp = new XMLHttpRequest();

    xhttp.onload = function(){

        var receiveRequest = JSON.parse(this.responseText);
        

        console.log(receiveRequest);

        // Atualize o gridOptions.rowData com os dados recebidos
        gridOptions.api.setRowData(receiveRequest);
        
    }
    xhttp.open('GET','testeEnvio.php',true);
    xhttp.send();



    // Grid Options: Contains all of the data grid configurations
    const gridOptions = {
    // Row Data: The data to be displayed.
    rowData: [],
    // Column Definitions: Defines the columns to be displayed.
    columnDefs: [

        { field: "id", headerName:"ID", flex: 1 },
        { field: "setor", headerName:"Setor", flex: 1 },
        { field: "areaAdministrativa", headerName:"Área Administrativa", flex: 1 },
        { field: "data", headerName:"Data", flex: 1 },
        { field: "periodo", headerName:"Período", flex: 1 },
        { field: "responsavel", headerName:"Responsável", flex: 1 },
        { field: "idUser", headerName:"ID Usuário Criador", flex: 1 },
        { field: "tipoLimpeza", headerName:"Tipo de Limpeza", flex: 1 },
        { field: "conferido", headerName:"Conferido", flex: 1 },
        { field: "dataPublicacao", headerName:"Data de Publicação", flex: 1 },
        { field: "dataValidade", headerName:"Data de Validade", flex: 1 },

    ]
    };

    // Your Javascript code to create the data grid
    const myGridElement = document.querySelector('#myGrid');
    agGrid.createGrid(myGridElement, gridOptions);

 </script>
</html>

