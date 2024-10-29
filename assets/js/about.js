document.addEventListener('DOMContentLoaded', ()=>{
    function set_privacy(data){
        let policy = document.querySelector('#about');
        policy.innerHTML = data
    }
    function get_privacy(){
        let xhttp = new XMLHttpRequest();
        xhttp.open("GET", "/api/content/about/", true);
        xhttp.send();
        xhttp.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.responseText);
            if(response.status == 'success'){
    
              set_privacy(response.privacy);
            }
          }
        }
    
      }
      get_privacy()
      document.getElementById('mail_form').addEventListener('click', (event)=>{
        event.preventDefault()
        var subject = encodeURIComponent(document.getElementById("subject").value);
        var message = encodeURIComponent(document.getElementById("message").value);
        var to = 'chefme.services@gmail.com';
        var mailtoLink = "https://mail.google.com/mail/u/0/?fs=1&tf=cm&to=" + to + "&Subject=" + subject + "&body=" + message;
        window.open(mailtoLink);
    })
})