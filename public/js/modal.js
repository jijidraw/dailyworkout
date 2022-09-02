var modal = document.getElementById("modal")
var btn = document.getElementById("BtnModal")
var closeBtn = document.getElementById("close")

btn.onclick = function() {
    modal.classList.remove("hidden"); 
}

closeBtn.onclick = function() {
    modal.classList.add("hidden");
}
window.onclick = function(event) {
    if(event.target == modal){
        modal.classList.add("hidden");
    }
}