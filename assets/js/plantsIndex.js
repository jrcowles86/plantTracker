
window.onload = function() {

    let insertButton = document.querySelector(".plants-insert-btn");
    let insertDiv = document.querySelector(".insert-div-outer");
    let insertCloseBtn = document.querySelector(".insert-cancel-btn");
    let insertCloseX = document.querySelector(".insert-cntnr-close");

    insertButton.addEventListener('click', () => {
        if (insertDiv.style.visibility === "hidden") {
            insertDiv.style.visibility = "visible";
        } else {
            insertDiv.style.visibility = "hidden";
    }});

    insertCloseBtn.addEventListener('click', () => {
        if (insertDiv.style.visibility === "visible") {
            insertDiv.style.visibility = "hidden";
        } else {
            insertDiv.style.visibility = "visible";
    }});

    insertCloseX.addEventListener('click', () => {
        if (insertDiv.style.visibility === "visible") {
            insertDiv.style.visibility = "hidden";
        } else {
            insertDiv.style.visibility = "visible";
    }});

}
