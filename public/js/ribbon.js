const ribbonsButton = document.querySelectorAll('.ribbon');
for (let ribbonBtn of ribbonsButton){
    ribbonBtn.addEventListener("click", function() {
        datasetId = this.dataset.id;
        var ribbonBloc = document.getElementById('ribbon' + datasetId);
        ribbonBtn.classList.toggle('open');
        ribbonBloc.classList.toggle('open');
    })
}