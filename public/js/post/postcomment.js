// fonction pour poster un commentaire sous un post

const commentForm = document.querySelectorAll("#comment-form");
for(let form of commentForm){
    form.addEventListener("submit", function(event) {
    event.preventDefault();
    let formId = form.dataset.id
    var commentZone = document.getElementById('comment-zone' + formId)
    let request = new XMLHttpRequest();
    let message = (this.firstElementChild.value);
    let Jsondata = JSON.stringify(message);
    request.open("POST", `/post/comment/${this.dataset.id}`, true);
    request.onreadystatechange = function(){
        if(this.readyState == 4){
            if(this.status == 200){
                data = JSON.parse(this.response)
                let dateComment = new Date(data.created_at).toLocaleDateString()
                console.log(data)
                var comment =
                `
                <div class="comment-post">
                        <a href="user/${data.user.id}">
                        <div class="row">
                        <img class="profil" src="../profil/${data.user.imagesProfiles.name}" alt="">
                                <div class="column">
                                    <span>${data.user.name}</span>
                                    <p class="date">le : ${dateComment}</p>
                                </div>
                        </div>
                        </a>
                        <p class="comment-text"> ${data.content}</p>
                </div>
                `
                commentZone.innerHTML += comment;
            }
        }
    }
    request.setRequestHeader("Content-Type", "application/json");
    request.send(Jsondata);
    form.reset();
});
}