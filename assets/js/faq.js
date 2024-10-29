document.addEventListener('DOMContentLoaded', function () {


    function set_faqs(data) {
        let accordionExample = document.querySelector('#accordionExample');
        console.log(accordionExample);
        data.forEach(element => {
            let faq = document.createElement('div');
            faq.classList.add('accordion-item');
            faq.innerHTML =`<h2 class="accordion-header">
                <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#collapse${element.id}" aria-expanded="true" aria-controls="collapseOne">
                    ${element.question}
                </button>
            </h2>
            <div id="collapse${element.id}" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    ${element.answer}
                </div>
            </div>`;
        accordionExample.appendChild(faq);
        })


    }
    function getfaq() {
        let xhttp = new XMLHttpRequest();
        xhttp.open("GET", "/api/content/faq/get/", true);
        xhttp.send();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                if (response.status == 'success') {

                    set_faqs(response.faq);
                }
            }
        }
    }
    getfaq()
    function set_privacy(data){
        let policy = document.querySelector('#policy');
        policy.innerHTML = data
    }
    function get_privacy(){
        let xhttp = new XMLHttpRequest();
        xhttp.open("GET", "/api/content/privacy/", true);
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
})