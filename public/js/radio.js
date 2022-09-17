let radios = document.querySelectorAll('input[type="radio"]')
let RadiosLabel = document.querySelectorAll('.radio-select')
console.log(RadiosLabel)
for(let checkbox of radios){
    checkbox.addEventListener("click", function() {
        for(let RadioLabel of RadiosLabel){
            if(RadioLabel.classList.value="radio-check"){
                RadioLabel.classList.value="radio-select"
            }
        }

        let label = checkbox.nextElementSibling
        if(checkbox.checked){
            label.classList.value="radio-check"
        } else {
            label.classList.value = "radio-uncheck"
        }
    })
}