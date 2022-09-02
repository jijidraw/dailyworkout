let checkboxs = document.querySelectorAll('input[type="checkbox"]')

for(let checkbox of checkboxs){
    checkbox.addEventListener("click", function() {

        let label = checkbox.nextElementSibling
        console.log(label)
        if(checkbox.checked){
            label.classList.value="checked"
        } else {
            label.classList.value = "unchecked"
        }
    })
}

for(let check of checkboxs){
    let label = check.nextElementSibling
    label.classList === "unchecked"
    if(check.checked){
        label.classList.value = "checked"
    } else {
        label.classList.value = "unchecked" 
    }
}

