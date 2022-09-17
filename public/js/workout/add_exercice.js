function addExercice() {
const linksExercices = document.querySelectorAll('.js-exercice-link')

for(let linkExercice of linksExercices) {
    linkExercice.addEventListener("click", function(e){
        e.preventDefault();
        let IdWorkout = this.dataset.workout
        let IdExercice = this.dataset.exercice
        let url = `/workout/add/${IdExercice}/${IdWorkout}`
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if(this.readyState == 4 ){
                if(this.status == 200){
                    let exercice = JSON.parse(this.response)
                    console.log(exercice)
                    var card = 
                    `
                    <div class="card">
                    <h3>${exercice.exercice.name}</h3>
                    <div class="card-img">
                    <img src="/exercice/${exercice.exercice.imageSystem.name}" width="400px" alt="">
                    </div>
                    <div class="card-a">
                    <form method="post" action="/workout/delete/exercice/${exercice.id}">
                    <input class="btdelete" type="submit" value="retirer">
                    </form>
                    </div>
                    </div>
                    `
                    document.querySelector('.workout-list-exercice').innerHTML += card;
                }
            }
        }
        xhr.open("get", url, true)
        xhr.send();
    })
}
}