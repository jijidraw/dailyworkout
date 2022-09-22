let arrowRight = document.querySelector("#arrow-right");
let arrow = document.querySelector("#arrow-left");
let columnright = document.querySelector("#column-right");

    arrowRight.addEventListener("click", function(e) {
        e.preventDefault()
        arrow.classList.toggle('hidden')
        columnright.classList.toggle('open')
        arrowRight.classList.toggle('open')
    })


    
    