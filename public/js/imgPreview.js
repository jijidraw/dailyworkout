function previewImages() {
    var preview = document.querySelector('.preview');

    if (this.files) {
        [].forEach.call(this.files, readAndPreview);
    }
    function readAndPreview(file) {
        if (!/\.(jpe?g|png|gif)$/i.test(file.name)) {
            return alert(file.name + " n est pas une image");
        }
            var reader = new FileReader();
            reader.addEventListener("load", function() {
                var image = new Image();
                image.height = 200;
                image.title = file.name;
                image.src = this.result;
                preview.appendChild(image);
            });
            reader.readAsDataURL(file);
    }
}
document.querySelector('input[type=file]').addEventListener("change", previewImages);