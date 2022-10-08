const contactLists = document.querySelectorAll('a.contact');
const messageview = document.querySelector("#message-list");
const formMessage = document.querySelector("#message-form");


for(let contactList of contactLists){
    contactList.addEventListener("click", function(event){
        event.preventDefault();
        const convId = contactList.dataset.conv
        form.setAttribute("id", convId)
        const url = this.href;
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if(this.readyState == 4){
                if(this.status == 200){
                    const messagesZone = document.querySelector("#message-list")
                    let messages = JSON.parse(this.response)
                    for(const message of messages.messages){
                        // const userId = contactList.dataset.id
                        let dateMessage = new Date(message.created_at)
                        messagesZone.innerHTML = 
                            `
                            <a class="comment_user" href="user/${message.user.id}">
                            <img class="profil" src="../profil/${message.user.imgName}" alt="">
                            </a>
                            <p class="message-right"> ${message.content}</p>
                            <p class="comment-date"> ${dateMessage}</p>
                            `
                            + messagesZone.innerHTML
                    }

                }
            }
        }
        xhr.open("get", url, true)
        xhr.send();
        form.classList.remove("hidden")
        // if(messageview.childNodes.length === 0){

        // }else{
        //     messageview.innerHTML="";
        // }
    })
}
