const linkSports = document.querySelectorAll('a.js-sport-group')
let gallery = document.querySelector('.gallery')
let isActive = document.querySelector(".active")

for(let linksport of linkSports){
    linksport.addEventListener("click", function(e){
        e.preventDefault();
        gallery.innerHTML=""
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if(this.readyState == 4){
                if(this.status == 200){
                    let groups = JSON.parse(this.response)
                    for(const group of groups){
                        gallery.innerHTML =
                            `
                            <div class="bloc-user-link">
                            <a href="/team/${group.id}">
                            <div class="row">
                                <img class="profil" src="/profil/${group.imagesProfiles.name}" alt="">
                                ${group.name}
                            </div>
                                          <p>${group.teamMembers.length} membres</p>
                            </a>
                            </div>
                                `
                        + gallery.innerHTML
                    }
                    }
                }
            }
        xhr.open("get", `/search/team/${this.dataset.id}`, true)
        xhr.send();
    })
}
