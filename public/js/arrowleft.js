let arrowleft = document.querySelector("#arrow-left");
let columnLeft = document.querySelector("#column-left");
let AllLi = document.querySelectorAll("li");
let RightArrow = document.querySelector("#arrow-right");
    arrowleft.addEventListener("click", function(e) {
        e.preventDefault()
        if(RightArrow){
            RightArrow.classList.toggle('hidden')
        }
        columnLeft.classList.toggle('open')
        arrowleft.classList.toggle('open')
})
for(let li of AllLi){
    li.addEventListener("click", function(){
        
        if(arrowleft.classList.value ==="arrow open"){
            columnLeft.classList.toggle('open')
            arrowleft.classList.toggle('open')
        }
    })
}