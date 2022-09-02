const commentLinks = document.querySelectorAll('a.js-comment');
for(let commentLink of commentLinks){
    commentLink.addEventListener("click", function(event){
        event.preventDefault();
        var idPost = this.dataset.id
        var commentForm = document.getElementById('post-comment' + idPost)
        var commentZone = document.getElementById('comment-zone' + idPost)
        let deleteLink = document.getElementById('delete-link' + idPost)

        console.log(deleteLink)
        
        const url = this.href;
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if(this.readyState == 4){
                if(this.status == 200){

                    let comments = JSON.parse(this.response)

                    commentForm.classList.remove("hidden");

                    for(const comment of comments){
                    console.log(comment)

                        let dateComment = new Date(comment.created_at).toLocaleDateString()
                        commentZone.innerHTML = `
                        <div class="comment-post">
                        <a href="user/${comment.user.id}">
                        <div class="row">
                        <img class="profil" src="/profil/${comment.user.imagesProfiles.name}" alt="">
                                <div class="column">
                                    <span>${comment.user.name}</span>
                                    <p class="date">le : ${dateComment}</p>
                                </div>
                        </div>
                        </a>
                        <p class="comment-text"> ${comment.content}</p>
                        </div>
                        `
                         + commentZone.innerHTML
                    }
                }
            }
        }
        xhr.open("get", url, true)
        
        xhr.send();
        commentLink.classList.add("hidden");
        deleteLink.classList.remove("hidden")
    })

}
