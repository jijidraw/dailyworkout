const workoutNotations = document.querySelectorAll(".js-notation")
for(let workoutNote of workoutNotations){
    workoutNote.addEventListener("click", function(e){
        e.preventDefault();
        const url = this.href;
        const xhr = new XMLHttpRequest();
        xhr.open("GET", url, true);
        xhr.onreadystatechange = function(){
            if(this.readyState == 4){
                if(this.status == 200){
                    alert('votre note à bien été prise en compte')
                }
            }
        }
        xhr.send();
    })
}