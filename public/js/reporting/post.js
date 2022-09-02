const reportPosts = document.querySelectorAll(".js-post");
for(let report of reportPosts){
    report.addEventListener("click", function(e){
        e.preventDefault();
        const url = this.href;
        const xhr = new XMLHttpRequest();
        xhr.open("get", url, true);
        xhr.onreadystatechange = function(){
            if(this.readyState == 4){
                if(this.status == 200){
                    alert("Votre signalement à bien été pris en compte. Un administrateur va s\'en occuper très rapidement.");
                }
            }
        }
        xhr.send();
    })
}