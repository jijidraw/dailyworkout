const linkMuscles = document.querySelectorAll('a.js-muscle')
let galery = document.querySelector('.gallery')
let workoutID = gallery.id
console.log(linkMuscles)


for(let linkMuscle of linkMuscles){
    linkMuscle.addEventListener("click", function(e){
        e.preventDefault();
        galery.innerHTML=""

        const url = this.href;
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if(this.readyState == 4){
                if(this.status == 200){
                    let exercices = JSON.parse(this.response)
                    for(const exercice of exercices){
                        galery.innerHTML = `
                        <div class="card">
                            <h3>${exercice.name}</h3>
                                <div class="card-img">
                                    <img src="/exercice/${exercice.imageSystem.name}" width="400px" alt="">
                                </div>
                                <div class="card-a">
                                    <a data-exercice="${exercice.id}" data-workout="${workoutID}" class="js-exercice-link" href="/workout/adding/${exercice.id}/${workoutID}">Ajouter</a>
                                </div>
                        </div>
                            ` + galery.innerHTML

                    }
                }
            }
        }
        xhr.open("get", url, true)
        xhr.send();
    })
}