let filterBtn = document.getElementById("search");
let filters = document.getElementById("bloc-column-filter")
console.log(filters)

filterBtn.addEventListener("click", function(){
    if(filterBtn.classList.value === "tab active"){
        filters.classList.remove('hidden')
    }
})

window.onclick = function(){
    if(filterBtn.classList.value != "tab active"){
        filters.classList.add('hidden')
    }else if(filterBtn.classList.value === "tab active"){
        filters.classList.remove('hidden')
    }
}