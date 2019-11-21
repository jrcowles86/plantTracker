
window.onload = function() {

    let deleteDivOuter = document.querySelector('.delete-popup-outer');

    document.querySelector('#delete-icon').addEventListener("click", () => {
        if (deleteDivOuter.style.visibility === "hidden") {
            deleteDivOuter.style.visibility = "visible";
        } else {
            deleteDivOuter.style.visibility = "hidden";
    }});

    document.querySelector('.delete-cancel-btn').addEventListener("click", () => {
        if (deleteDivOuter.style.visibility === "visible") {
            deleteDivOuter.style.visibility = "hidden";
        } else {
            deleteDivOuter.style.visibility = "visible";
    }});

    document.querySelector('.delete-close-span').addEventListener("click", () => {
        if (deleteDivOuter.style.visibility === "visible") {
            deleteDivOuter.style.visibility = "hidden";
        } else {
            deleteDivOuter.style.visibility = "visible";
        }});

}