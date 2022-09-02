const workoutLikes = document.querySelectorAll("#js-workout-like")
for(let likeLink of workoutLikes){
    likeLink.addEventListener("click", function(e){
        let workoutId = this.dataset.id
        let star = document.getElementById('star' + workoutId)
        console.log(star)
        e.preventDefault();
        const url = this.href;
        const xhr = new XMLHttpRequest();
        xhr.open("GET", url, true);
        xhr.onreadystatechange = function(){
            if(this.readyState == 4){
                if(this.status == 200){
                    let response = JSON.parse(this.response);
                    alert(response.message)
                    star.classList.toggle("svg-star")
                    star.classList.toggle("svg-empty")
                }
            }
        }
        xhr.send();
    })
}