token = document.getElementsByName("_token")[0].value;
function getFolders(folderName) {
    var xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        folders = JSON.parse(xhttp.response);
        //console.log(JSON.parse(xhttp.response));
        placeFolders(folders);
        //console.log(folderName);
    };

    xhttp.open("POST", "/dicle.ai/public/listFolders");
    xhttp.setRequestHeader("X-CSRF-TOKEN", token);
    xhttp.setRequestHeader("Content-Type", "application/json; charset=UTF-8");
    xhttp.send(JSON.stringify({ directory: folderName, onlyFolders: 0 }));
}

function initFolderDiv(folderDivID) {
    folderDiv = document.getElementById(folderDivID);
}

function goIntoFolder(event) {
    console.log("test");
}

function placeFolders(folders) {
    newDiv = document.createElement("div");

    folders.forEach((element) => {
        subDiv = document.createElement("div");
        subDiv.className = "folder";
        subDiv.setAttribute("name", element["path"]);
        //subDiv.setAttribute("onclick", goIntoFolder);
        //subDiv.addEventListener('onclick')
        //subDiv.onclick = goIntoFolder;

        folderIcon = document.createElement("span");
        folderIcon.className = "folder-icon";
        folderIcon.innerHTML = "icon";

        folderName = document.createElement("span");
        folderName.className = "folder-name";
        folderName.innerHTML = element["name"];
        folderName.onclick = goIntoFolder;
        subDiv.appendChild(folderIcon);
        subDiv.appendChild(folderName);

        newDiv.appendChild(subDiv);

        console.log(element["name"]);
    });
    folderDiv.innerHTML = newDiv.innerHTML;
    console.log(folders);
}
