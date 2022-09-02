const accordions = document.querySelectorAll('.accordion');
for (let acc of accordions){
    acc.addEventListener("click", function() {
        this.classList.toggle("active");
        workoutId = this.dataset.id;

        var panel = document.getElementById('panel' + workoutId);
        if (panel.style.height) {
            panel.style.height = null;
        } else {
            panel.style.height = panel.scrollHeight + "px";
        }
    })
}