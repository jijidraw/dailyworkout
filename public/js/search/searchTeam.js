const searchInputTeam = document.querySelector("#search-team")


searchInputTeam.addEventListener('keyup', function(){
    gallery.innerHTML=""
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(this.readyState == 4){
            if(this.status == 200){
                const valueSearch = searchInputTeam.value;

                var users = JSON.parse(this.response)
                var result = users.filter(item => item.name.toLocaleLowerCase().includes(valueSearch.toLocaleLowerCase()));
                for(const team of result){
                    gallery.innerHTML =
                    `
                        <a class="bloc-user-link" href="/team/${team.id}">
                        <div class="row">
                            <img class="profil" src="/profil/${team.imagesProfiles.name}" alt="">
                            ${team.name}
                        </div>
                                      <p>${team.teamMembers.length} membres</p>
                        </a>
                        `
            


                        + gallery.innerHTML
                }
            }
        }
    }
    xhr.open("get", `/search/team`, true)
    xhr.send();


})