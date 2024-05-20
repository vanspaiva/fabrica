const firebaseConfig = {
    apiKey: "AIzaSyBaPWP2pYjLgwmlfhq0SrsYjOw1357rAuE",
    authDomain: "sistemas-fabrica.firebaseapp.com",
    projectId: "sistemas-fabrica",
    storageBucket: "sistemas-fabrica.appspot.com",
    messagingSenderId: "78657540180",
    appId: "1:78657540180:web:cecadacad95a6a664e1dc1"
};

const app = firebase.initializeApp(firebaseConfig);

const storage = firebase.storage();

// const inp = document.querySelector(".inp");
// const progressbar = document.querySelector(".progress");
// const img = document.querySelector(".img");
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
    // if (fileName) {
    //     fileData.style.display = "block";
    // }
    fileData.innerHTML = fileName;
    console.log(file, fileName);

    uploadImage();
};

const uploadImage = () => {
    loading.style.display = "block";
    const storageRef = storage.ref().child("myimages");
    const folderRef = storageRef.child(fileName);
    const uploadtask = folderRef.put(file);
    uploadtask.on(
        "state_changed",
        (snapshot) => {
            console.log("Snapshot", snapshot.ref.name);
            // progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
            // progress = Math.round(progress);
            // progressbar.style.width = progress + "%";
            // progressbar.innerHTML = progress + "%";
            uploadedFileName = snapshot.ref.name;
        },
        (error) => {
            console.log(error);
        },
        () => {
            storage
                .ref("myimages")
                .child(uploadedFileName)
                .getDownloadURL()
                .then((url) => {
                    console.log("URL", url);
                    if (!url) {
                        // img.style.display = "none";
                    } else {
                        // img.style.display = "block";
                        loading.style.display = "none";
                    }
                    // img.setAttribute("src", url);
                    urlThrowback.value = url;
                });
            console.log("File Uploaded Successfully");
        }
    );
};