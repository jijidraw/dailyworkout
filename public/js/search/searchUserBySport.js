const linkSportsUser = document.querySelectorAll('a.js-sport-user')

for(let linksport of linkSportsUser){
    linksport.addEventListener("click", function(e){
        e.preventDefault();
        gallery.innerHTML=""
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if(this.readyState == 4){
                if(this.status == 200){
                    let groups = JSON.parse(this.response)
                    console.log(groups)
                    

                    for(const group of groups){
                        console.log(group)
                        gallery.innerHTML =
                            `
                            <a class="bloc-user-link" href="/user/${group.id}">
                            <div class="row">
                            <img class="profil" src="/profil/${group.imagesProfiles.name}" alt="">
                            ${group.name}
                            </div>
                            </a>
                                `
                        + gallery.innerHTML
                    }
                    
                    }
                }
            }
        xhr.open("get", `/search/user/sport/${this.dataset.id}`, true)
        xhr.send();
    })
}