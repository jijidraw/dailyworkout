const validLinks = document.querySelectorAll("#js-valid");
for(let validLink of validLinks){
    validLink.addEventListener("click", function(e){
        e.preventDefault();
        const url = this.href;
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if(this.readyState == 4){
                if(this.status == 200){
                    console.log(this.response)
                    let response = JSON.parse(this.response)
                    alert( response.message )
                }
            }
        }
        xhr.open("GET", url, true);
        xhr.send();
    })
}