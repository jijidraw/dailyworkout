const sendLinks = document.querySelectorAll("#js-send");
for(let sendLink of sendLinks){
    sendLink.addEventListener("click", function(e){
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