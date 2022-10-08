const form = document.querySelector("form.message-form");
let inputText = document.getElementById('text')


form.addEventListener("submit", function(event){
    event.preventDefault();
    let xhr = new XMLHttpRequest();
    let message = form.firstElementChild.value;
    let Jsondata = JSON.stringify(message);
    xhr.open("post", `/message/newMessages/1`, true);
    xhr.onreadystatechange = function(){
        if(this.readyState == 4){
            if(this.status == 200){
                data = (this.response)
            }
        }
    }
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send(Jsondata);
})