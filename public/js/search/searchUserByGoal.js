const linkGoalsUser = document.querySelectorAll('a.js-goal-user')

for(let linkgoal of linkGoalsUser){
    linkgoal.addEventListener("click", function(e){
        e.preventDefault();
        gallery.innerHTML=""
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if(this.readyState == 4){
                if(this.status == 200){
                    let groups = JSON.parse(this.response)
                    for(let group of groups){
                        gallery.innerHTML =
                            `
                            <div class="bloc-user-link">
                            <a href="/user/${group.id}">
                            <div class="row">
                            <img class="profil" src="/profil/${group.imagesProfiles.name}" alt="">
                            ${group.name}
                            </div>
                            </a>
                            </div>
                            `
                        + gallery.innerHTML
                    }
                    }
                }
            }
        xhr.open("get", `/search/user/goal/${this.dataset.id}`, true)
        xhr.send();
    })
}