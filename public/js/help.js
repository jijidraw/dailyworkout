var helpWindow = document.getElementById("help")
var helpbtn = document.getElementById("help-toggle")
var closeHelp = document.getElementById("close-help")
var helpContent = document.querySelector(".help-content")

helpbtn.onclick = function() {
    helpWindow.classList.toggle("hidden"); 
}

closeHelp.onclick = function() {
    helpWindow.classList.add("hidden");
}
helpWindow.onclick = function(event) {
    if(event.target == helpContent){}else{
        helpWindow.classList.toggle("hidden");
    }
}
