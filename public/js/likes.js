const likesLink = document.querySelectorAll("#js-like");
for(let likeLink of likesLink){
    likeLink.addEventListener("click", function(e){
        e.preventDefault();
        const url = this.href;
        const spancount = this.querySelector('span.js-likes');
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if(this.readyState == 4){
                if(this.status == 200){
                    console.log(this.response)
                    let response = JSON.parse(this.response)
                    spancount.textContent = response.likes;
                }
            }
        }
        xhr.open("GET", url, true);
        xhr.send();
    })
}


