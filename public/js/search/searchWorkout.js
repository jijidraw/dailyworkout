const linkMuscles = document.querySelectorAll('a.js-muscle')
let workoutMuscle = document.querySelector('.workout-muscle')
let gallery = document.getElementById("gallery")
let isActive = document.querySelector(".active")

for(let linkMuscle of linkMuscles){
    linkMuscle.addEventListener("click", function(e){
        e.preventDefault();
        gallery.innerHTML=""
        workoutMuscle.innerHTML=""
        let nameMuscle = linkMuscle.innerHTML
        workoutMuscle.innerHTML = `
        <h3 class="bloc-title>
        ${nameMuscle}
        </h3>
        `
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if(this.readyState == 4){
                if(this.status == 200){
                    let workouts = JSON.parse(this.response)
                    for(const workout of workouts){
                        let exercicesPerso = workout.exercicePersos;
                        console.log(exercicesPerso)
                        let n = exercicesPerso.length;
                        let i = 0;
                        console.log(workout)
                        gallery.innerHTML =
                        `
                        <div class="card-container">
                        
                        <div class="workout-bloc">
                        <div class="${workout.level.name}">difficulté : ${ workout.level.name }</div>

                        <div class="workout-bar">
                        <div class="workout-detail">
                        <h4>${ workout.name }</h4>
                        <p> description : ${ workout.content }</p>
                        <p> rounds : ${ workout.rounds }</p>
                        </div>
                        <a class="main-link" href="/workout/${ workout.id }"> En savoir plus </a>
                        <div class="bloc-user-link">
                            <a href="/user/${workout.user.id}">
                            <div class="row">
                            <img class="profil" src="/profil/${workout.user.imagesProfiles.name}" alt="">
                            Workout par : ${workout.user.name}
                            </div>
                            </a>
                        </div>
                        </div>
                        </div>
                        </div>
                        `
                            // while (i < n) {
                            //     i;
                            //     i++;
                            // }
                            + gallery.innerHTML
                        
                    }
                    
                    }
                }
            }
        xhr.open("get", `/search/workout/${this.dataset.id}`, true)
        xhr.send();
    })
}