let linkFollowing = document.getElementById('js-following')
var closeBtn = document.getElementsByClassName("close")

linkFollowing.addEventListener("click", function(event){
    event.preventDefault();

    let url = this.href;
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(this.readyState == 4){
            if(this.status == 200){
                var modal = document.getElementById("modal")
                var modalContent = document.querySelector(".modal-content")
                modalContent.innerHTML=""

                let users = JSON.parse(this.response)
                modalContent.innerHTML += `
                <h4 class="bloc-title-abs">${users[0].follower.name} suis :</h4>
                `
                for(let user of users){
                    modal.classList.remove("hidden")
                    modalContent.innerHTML = 
                    `
                            <div class="bloc-user-link">
                            <a href="/user/${user.following.id}">
                            <div class="row">
                            <img class="profil" src="/profil/${user.following.imagesProfiles.name}" alt="">
                            ${user.following.name}
                            </div>
                            </a>
                        </div>
                                `
                    + modalContent.innerHTML
                }
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