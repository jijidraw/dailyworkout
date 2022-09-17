const linkMuscles = document.querySelectorAll('a.js-muscle')
let workoutMuscle = document.querySelector('.workout-muscle')

for(let linkMuscle of linkMuscles){
    linkMuscle.addEventListener("click", function(e){
        e.preventDefault();
        let Url = `/search/workout/muscles/${this.dataset.id}`
        fetch(Url, {
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            }
        }).then(response => 
            response.json()
            ).then(data => {
                const content = document.querySelector("#content");
                content.innerHTML = data.content;
            })
    })
}