const followLinks = document.querySelectorAll("#js-follow");
for(let followLink of followLinks){
    followLink.addEventListener("click", function(e){
        e.preventDefault();
        const url = this.href;
        const xhr = new XMLHttpRequest();
        xhr.open("get", url, true);
        xhr.onreadystatechange = function(){
            if(this.readyState == 4){
                if(this.status == 200){
                    let response = JSON.parse(this.response)
                    alert(response.message);
                    if(followLink.innerHTML == "désabonner"){
                        followLink.innerHTML="suivre"
                    }else{
                        followLink.innerHTML="désabonner"
                    }
                }
            }
        }
        xhr.send();
    })
}