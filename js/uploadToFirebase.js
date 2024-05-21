const app = firebase.initializeApp(firebaseConfig);

const storage = firebase.storage();


const progressbar = document.querySelector(".progress");

const fileData = document.querySelector(".filedata");
const loading = document.querySelector(".loading");
const urlThrowback = document.querySelector(".urlThrowback");
let file;
let fileName;
let progress;
let isLoading = false;
let uploadedFileName;
const selectImage = () => {
    inp.click();
};
const getImageData = (e) => {
    file = e.target.files[0];
    fileName = Math.round(Math.random() * 9999) + file.name;
    
    fileData.innerHTML = fileName;
    console.log(file, fileName);

    uploadImage();
};

const uploadImage = () => {

    const loteElement = document.getElementById("lote");
    // Obter o valor do número do lote
    const lote = loteElement.value;

    if (!lote) {
        alert("Número do lote não fornecido!");
        document.getElementById("formFile").value = "";
        return;
    }

    loading.style.display = "block";
    
    // Referência ao armazenamento no Firebase
    const storageRef = storage.ref();
    
    // Criar referência para a pasta do lote dentro de "arquivosOS"
    const loteFolderRef = storageRef.child(`arquivosOS/${lote}`);
    // const storageRef = storage.ref().child("myimages");
    const folderRef = loteFolderRef.child(fileName);
    const uploadtask = folderRef.put(file);
    
    

    uploadtask.on(
        "state_changed",
        (snapshot) => {
            // console.log("Snapshot", snapshot.ref.name);
            progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
            progress = Math.round(progress);
            progressbar.style.width = progress + "%";
            progressbar.innerHTML = progress + "%";
            uploadedFileName = snapshot.ref.name;
        },
        (error) => {
            console.log(error);
        },
        () => {
            storage
                .ref(`arquivosOS/${lote}`)
                .child(uploadedFileName)
                .getDownloadURL()
                .then((url) => {
                    // console.log("URL", url);
                    if (!url) {
                        // img.style.display = "none";
                    } else {
                        // img.style.display = "block";
                        loading.style.display = "none";
                    }
                    // img.setAttribute("src", url);
                    urlThrowback.value = url;

                });
                // console.log("File Uploaded Successfully");
                document.getElementById('submit').disabled = false;
        }
    );
};