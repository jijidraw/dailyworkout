const linkSports = document.querySelectorAll('a.js-sport-group')
console.log(linkSports)
for(let linkSport of linkSports){
    linkSport.addEventListener("click", function(e){
        e.preventDefault();
        gallery.innerHTML=""
        workoutMuscle.innerHTML=""
        let nameMuscle = linkSport.innerHTML
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
                        <p> difficulté : ${ workout.difficulty }</p>
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
                            + gallery.innerHTML
                    }
                    }
                }
            }
        xhr.open("get", `/search/workout/sport/${this.dataset.id}`, true)
        xhr.send();
    })
}