token = document.querySelector('meta[name="csrf-token"]').content;
//token = document.getElementsByName("_token")[0].value;
function showTab(currentTab) {
    var tab = document.getElementsByClassName("tab-content");
    tab[currentTab].style.display = "block";

    if (currentTab == 0) {
        document.getElementById("prevBtn").style.display = "none";
    } else {
        document.getElementById("prevBtn").style.display = "inline";
    }
    console.log(currentTab);
    console.log(tab.length);
    if (currentTab == tab.length - 1) {
        document.getElementById("nextBtn").style.display = "None";
    } else {
        document.getElementById("nextBtn").style.innerHTML = "Next";
        document.getElementById("nextBtn").style.display = "block";
    }
    fixStepIndicator(currentTab);
}
function initWizard() {
    currentTab = 0;
    showTab(currentTab);
}

function nextPrev(n) {
    var x = document.getElementsByClassName("tab-content");
    //if (n == 1 && !validateForm()) return false;
    x[currentTab].style.display = "none";
    currentTab = currentTab + n;
    if (currentTab >= x.length) {
        console.log("bitti");
        document.getElementById("nextBtn").disabled = true;
        //document.getElementById("regForm").submit();
        return false;
    }

    showTab(currentTab);
    //fixStepIndicator(n);
}

function validateForm() {
    // This function deals with validation of the form fields
    var x,
        y,
        i,
        valid = true;
    x = document.getElementsByClassName("tab");
    y = x[currentTab].getElementsByTagName("input");
    // A loop that checks every input field in the current tab:
    for (i = 0; i < y.length; i++) {
        // If a field is empty...
        if (y[i].value == "") {
            // add an "invalid" class to the field:
            y[i].className += " invalid";
            // and set the current valid status to false:
            valid = false;
        }
    }
    // If the valid status is true, mark the step as finished and valid:
    if (valid) {
        document.getElementsByClassName("step")[currentTab].className +=
            " finish";
    }
    return valid; // return the valid status
}

function fixStepIndicator(n) {
    // This function removes the "active" class of all steps...
    var i,
        x = document.getElementsByClassName("step");
    for (i = 0; i < x.length; i++) {
        x[i].className = x[i].className.replace(" active", "");
    }
    //... and adds the "active" class to the current step:
    x[n].className += " active";
}

initWizard();

function run() {
    xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        console.log(this.responseText);
    };

    getParameters();
    xhttp.open("POST", "./train");
    xhttp.setRequestHeader("Content-Type", "application/json; charset=UTF-8");
    xhttp.setRequestHeader("X-CSRF-TOKEN", token);
    xhttp.send(JSON.stringify(parameters));
}
function getAugmentationParameters() {
    augmentationParameters = {};
    if (document.getElementsByName("rotateCheck")[0].checked) {
        rotateAngle = document.getElementsByName("rotateAngle")[0].value;
        rotateDirectories = "left;right";
        rotate = { angle: rotateAngle, rotateDirectories: rotateDirectories };
        augmentationParameters["rotate"] = rotate;
    }

    if (document.getElementsByName("zoomCheck")[0].checked) {
        zoomFactor = document.getElementsByName("zoomFactor")[0].value;
        zoomDirectories = "in";
        zoomInterpolation = "cubic";
        zoom = {
            zoomFactor: zoomFactor,
            zoomDirectories: zoomDirectories,
            zoomInterpolation: zoomInterpolation,
        };
        augmentationParameters["zoom"] = zoom;
    }

    if (document.getElementsByName("reshapeCheck")[0].checked) {
        reshapeSize = document.getElementsByName("reshapeSize")[0].value;
        reshapeInterpolation = "cubic";

        reshape = {
            new_width: reshapeSize,
            new_height: reshapeSize,
            interpoaltion: reshapeInterpolation,
        };
        augmentationParameters["reshape"] = reshape;
    }
    return augmentationParameters;
    //parameters["augmentation"] = augmentationParameters;
    //console.log(parameters);
}

function getTrainingParameters() {
    var trainingParameters = {};
    var model = document.getElementsByName("model")[0].value;
    var epochs = document.getElementsByName("epochs")[0].value;
    var batchSize = document.getElementsByName("batchSize")[0].value;
    var metrics = document.getElementsByName("metrics")[0].value;
    var optimizer = document.getElementsByName("optimizer")[0].value;
    var learningRate = document.getElementsByName("learningRate")[0].value;
    var loss = document.getElementsByName("loss")[0].value;

    trainingParameters["model"] = model;
    trainingParameters["epochs"] = epochs;
    trainingParameters["batch_size"] = batchSize;
    trainingParameters["metrics"] = {};
    trainingParameters["metrics"]["name"] = metrics;
    trainingParameters["optimizer"] = {};
    trainingParameters["optimizer"]["learning_rate"] = learningRate;
    trainingParameters["optimizer"]["name"] = optimizer;
    trainingParameters["loss"] = {};
    trainingParameters["loss"]["name"] = loss;

    return trainingParameters;
}
function getSaveParameters() {
    var saveParameters = {};
    var saveName = document.getElementsByName("saveName")[0].value;
    saveParameters["name"] = saveName;
    //saveParameters["save"]["name"] = saveName;

    return saveParameters;
}

function getDatasetParameters() {
    datasetParameters = {};

    var dataset = document.getElementsByName("dataset")[0].value;
    var colorMode = document.getElementsByName("colorMode")[0].value;
    var validation = document.getElementsByName("validation_split")[0].value;
    var validation = document.getElementsByName("test_split")[0].value;

    datasetParameters["path"] = dataset;
    datasetParameters["color_mode"] = colorMode;
    datasetParameters["validation_split"] = validation / 100;
    datasetParameters["shuffle"] = 1;
    datasetParameters["test_split"] = validation / 100;

    return datasetParameters;
}
function getParameters() {
    parameters = {};
    parameters["augmentation"] = getAugmentationParameters();
    parameters["trainingParameters"] = getTrainingParameters();
    parameters["save"] = getSaveParameters();
    parameters["dataset"] = getDatasetParameters();
    console.log(parameters);
}
