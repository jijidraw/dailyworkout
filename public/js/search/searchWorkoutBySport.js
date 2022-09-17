const linkSports = document.querySelectorAll('a.js-sport-group')
// let workoutMuscle = document.querySelector('.workout-muscle')

for(let linkSport of linkSports){
    linkSport.addEventListener("click", function(e){
        e.preventDefault();
        let Url = `/search/workout/sport/${this.dataset.id}`
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