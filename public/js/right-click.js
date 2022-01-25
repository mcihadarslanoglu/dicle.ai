clicked = 0;
console.log("test");
function setTargetDiv(divID) {
    targetDiv = document.getElementById(divID);
}

function setContextMenu(contextmenuID) {
    contextmenu = document.getElementById(contextmenuID);
}

function defaultContextMenuFunction(event) {
    event.preventDefault();
    clicked = 1;
    contextmenu.style.display = "block";
    const { clientX: mouseX, clientY: mouseY } = event;

    contextmenu.style.top = event.pageY - 70 + "px";
    contextmenu.style.left = event.pageX - 240 + "px";
    console.log(event.pageX);
    //contextmenu.classList.remove("hide-contextmenu");
    console.log(event);
}

function defaultOnclickEvent(event) {
    if (clicked) {
        contextmenu.style.display = "none";
        //contextmenu.classList.add("hide-contextmenu");
        console.log("left-click");
        clicked = 0;
    }
}
function setContextMenuFunction(func = null) {
    if (!func) {
        targetDiv.oncontextmenu = defaultContextMenuFunction;
        targetDiv.onclick = defaultOnclickEvent;
    } else {
        targetDiv.oncontextmenu = func;
    }
}
//targetDiv.oncontextmenu = setContextMenuFunction();
