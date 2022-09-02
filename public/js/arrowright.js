let arrowRight = document.querySelector("#arrow-right");
let columnright = document.querySelector("#column-right");
    arrowRight.addEventListener("click", function(e) {
        e.preventDefault()
        columnright.classList.toggle('open')
        arrowRight.classList.toggle('open')
    })
    
    