let linkFollowers = document.getElementById('js-follower')
var closeBtn = document.getElementsByClassName("close")

console.log(linkFollowers)
linkFollowers.addEventListener("click", function(event){
    event.preventDefault();

    let url = this.href;
    console.log(url)
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(this.readyState == 4){
            if(this.status == 200){
                var modal = document.getElementById("modal")
                var modalContent = document.querySelector(".modal-content")
                modalContent.innerHTML=""

                let users = JSON.parse(this.response)

                
                for(let user of users){
                    console.log(user)
                    modal.classList.remove("hidden")
                    modalContent.innerHTML = 
                    `
                            <div class="bloc-user-link">
                            <a href="/user/${user.follower.id}">
                            <div class="row">
                            <img class="profil" src="/profil/${user.follower.imagesProfiles.name}" alt="">
                            ${user.follower.name}
                            </div>
                            </a>
                        </div>
                                `
                    + modalContent.innerHTML
                    
                }
                modalContent.innerHTML += `
                <h4 class="bloc-title-abs">${users[0].following.name} est suivie par :</h4>
                `
            }
        }
    }
    xhr.open("get", url, true)
    xhr.send();
    closeBtn.onclick = function() {
        modal.classList.add("hidden");
    }
    window.onclick = function(event) {
        if(event.target == modal){
            modal.classList.add("hidden");
        }
    }
})