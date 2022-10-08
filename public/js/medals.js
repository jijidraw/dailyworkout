const MedalsLink = document.querySelectorAll(".js-medals");
const DropDown = document.querySelectorAll(".dropdown-content")

for(let medalLink of MedalsLink){
    medalLink.addEventListener("click", function(e){
        e.preventDefault();
        let medalType = medalLink.id
        let SuppressMedal = document.querySelectorAll("." + medalType)
        const url = this.href;
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if(this.readyState == 4){
                if(this.status == 200){
                    let message = document.createElement('message');
                    message.innerHTML = '<p class="flash-message">Trophé donné</p>'
                    document.body.appendChild(message);
                    for(let medal of SuppressMedal){
                        medal.classList.toggle('hidden')
                    }
                }
            }
        }
        xhr.open("GET", url, true);
        xhr.send();
    })
}