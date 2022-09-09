const searchInput = document.querySelector("#search")
const link = document.querySelector(".user-get")


searchInput.addEventListener('keyup', function(){
    gallery.innerHTML=""
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(this.readyState == 4){
            if(this.status == 200){
                const valueSearch = searchInput.value;

                var users = JSON.parse(this.response)
                var result = users.filter(item => item.name.toLocaleLowerCase().includes(valueSearch.toLocaleLowerCase()));
                for(const user of result){
                    gallery.innerHTML =
                    `
                    <a class="bloc-user-link" href="/user/${user.id}">
                    <div class="row">
                    <img class="profil" src="/profil/${user.imagesProfiles.name}" alt="">
                    ${user.name}
                    </div>
                    </a>
                        `
            


                        + gallery.innerHTML
                }
                console.log(valueSearch)
                console.log(result)

            }
        }
    }
    xhr.open("get", `/search/user`, true)
    xhr.send();


})


