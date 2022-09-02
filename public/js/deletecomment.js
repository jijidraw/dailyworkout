const commentLists = document.querySelectorAll('a.delete-comment');

    for(let commentList of commentLists){
        commentList.addEventListener("click", function(e){
            e.preventDefault();
            var idPost = this.dataset.id
            var commentZone = document.getElementById('comment-zone' + idPost)
            var commentForm = document.getElementById('post-comment' + idPost)

            while (commentZone.hasChildNodes()) {
                commentZone.removeChild(commentZone.firstChild);
            }
            commentList.classList.add("hidden");
            commentForm.classList.add("hidden");
            const show = commentList.nextElementSibling
            show.classList.remove("hidden");
        })
    }