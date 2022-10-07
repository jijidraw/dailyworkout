// let removeExercices = document.querySelectorAll('.delete-exercice')
//     for(let linkExercice of removeExercices) {
//         linkExercice.addEventListener("click", function(e){
//             e.preventDefault();
//             let IdExercice = this.dataset.exercice
//             let url = `/workout/delete/exercice/${IdExercice}`
//             const xhr = new XMLHttpRequest();
//             xhr.onreadystatechange = function(){
//                 if(this.readyState == 4 ){
//                     if(this.status == 200){
//                         linkExercice.classList = 'hidden'
//                         let message = document.createElement('message');
//                         message.innerHTML = '<p class="flash-message">Exercice retiré</p>'
//                         document.body.appendChild(message);
//                     }
//                 }
//             }
//             xhr.open("get", url, true)
//             xhr.send();
//         })
//     }

function removeExercice() {
    const removeExercices = document.querySelectorAll('.delete-exercice')
    for(let linkExercice of removeExercices) {
        linkExercice.addEventListener("click", function(e){
            e.preventDefault();
            let IdExercice = this.dataset.exercice
            let url = `/workout/delete/exercice/${IdExercice}`
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function(){
                if(this.readyState == 4 ){
                    if(this.status == 200){
                        linkExercice.classList = 'hidden'
                        let message = document.createElement('message');
                        message.innerHTML = '<p class="flash-message">Exercice retiré</p>'
                        document.body.appendChild(message);
                    }
                }
            }
            xhr.open("get", url, true)
            xhr.send();
        })
    }
    }
    removeExercice();

    