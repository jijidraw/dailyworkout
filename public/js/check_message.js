setInterval(checkMessage, 10000)
function checkMessage(){
    const messageIcon = document.querySelector('.message-icon')
    let xhr = new XMLHttpRequest();
    let url = `/message/checkConversation`;
    xhr.onreadystatechange = function(){
        if(this.readyState == 4 ){
            if(this.status == 200){
                let response = JSON.parse(this.response)
                console.log(response)
                if(response.response == true){
                    messageIcon.classList.add("unread")
                }else{
                    messageIcon.classList.value = "svg-menu message-icon"
                }
            }
        }
    }
    xhr.open("get", url, true)
    xhr.send();
}
checkMessage();