document.addEventListener("DOMContentLoaded", function () {
  logout()
  function delete_category(id) {
    let modal = new bootstrap.Modal(document.getElementById('delete_modal'));

    modal.show();
    document.getElementById('form-delete').addEventListener('submit', function (event) {
      event.preventDefault();
      let xhttp = new XMLHttpRequest();
      xhttp.open("POST", "/api/category/delete/", true);
      let formData = new FormData();
      formData.append('id', id);
      xhttp.send(formData);
      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          let response = JSON.parse(this.responseText);
          if (response.status == 'success') {
            let alertMessage = alert_diss_abs(response.message);
            let tempElement = document.createElement('div');
            tempElement.innerHTML = alertMessage;
            document.body.appendChild(tempElement.firstChild);
            document.getElementById('modal-close').click();
            getCategorie()
          }
          else {
            let alertMessage = alert_diss_abs(response.message);
            let tempElement = document.createElement('div');
            tempElement.innerHTML = alertMessage;
            document.body.appendChild(tempElement.firstChild);
          }
        }
      }
    })

  }
  function delete_Cuisine(id) {
    let modal = new bootstrap.Modal(document.getElementById('delete_modal'));

    modal.show();
    document.getElementById('form-delete').addEventListener('submit', function (event) {
      event.preventDefault();
      let xhttp = new XMLHttpRequest();
      xhttp.open("POST", "/api/cuisine/delete/", true);
      let formData = new FormData();
      formData.append('id', id);
      xhttp.send(formData);
      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          let response = JSON.parse(this.responseText);
          if (response.status == 'success') {
            let alertMessage = alert_diss_abs(response.message);
            let tempElement = document.createElement('div');
            tempElement.innerHTML = alertMessage;
            document.body.appendChild(tempElement.firstChild);
            document.getElementById('modal-close').click();
            getCuisine()
          }
          else {
            let alertMessage = alert_diss_abs(response.message);
            let tempElement = document.createElement('div');
            tempElement.innerHTML = alertMessage;
            document.body.appendChild(tempElement.firstChild);
          }
        }
      }
    })

  }
  document.querySelector('#add_categories').addEventListener('submit', (event) => {
    event.preventDefault();
    let form = event.currentTarget;
    let category = sanitizeInput(form.category.value);
    let stat = true
    if (category === '') {
      stat = false;
      addErrorMessage(form.category, 'This field is required');
    } else if (category.length < 4) {
      stat = false;
      addErrorMessage(form.category, 'Minimum 4 characters');
    } else {
      removeErrorMessage(form.category);
    }
    if (stat == true) {
     
      let xhttp = new XMLHttpRequest();
      xhttp.open("POST", "/api/category/add/", true);
      let formData = new FormData();
      formData.append('category', category);
      xhttp.send(formData);
      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          let response = JSON.parse(this.responseText);
          if (response.status == 'success') {
            let alertMessage = alert_diss_abs(response.message);
            let tempElement = document.createElement('div');
            tempElement.innerHTML = alertMessage;
            document.body.appendChild(tempElement.firstChild);
            
            getCategorie()
            form.removeChild(loadingElement);
          }
          else {
            let alertMessage = alert_diss_abs(response.message);
            let tempElement = document.createElement('div');
            tempElement.innerHTML = alertMessage;
            document.body.appendChild(tempElement.firstChild);
            form.removeChild(loadingElement);
          }
        }
      }
    }
  })
  document.querySelector('#add_Cuisine').addEventListener('submit', (event) => {
    event.preventDefault();
    let form = event.currentTarget;
    let Cuisine = sanitizeInput(form.Cuisine.value);
    let stat = true
    if (Cuisine === '') {
      stat = false;
      addErrorMessage(form.Cuisine, 'This field is required');
    } else if (Cuisine.length < 4) {
      stat = false;
      addErrorMessage(form.Cuisine, 'Minimum 4 characters');
    } else {
      removeErrorMessage(form.Cuisine);
    }
    if (stat == true) {
 
      let xhttp = new XMLHttpRequest();
      xhttp.open("POST", "/api/cuisine/add/", true);
      let formData = new FormData();
      formData.append('Cuisine', Cuisine);
      xhttp.send(formData);
      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          let response = JSON.parse(this.responseText);
          if (response.status == 'success') {
            let alertMessage = alert_diss_abs(response.message);
            let tempElement = document.createElement('div');
            tempElement.innerHTML = alertMessage;
            document.body.appendChild(tempElement.firstChild);
            getCuisine()
          }
          else {
            let alertMessage = alert_diss_abs(response.message);
            let tempElement = document.createElement('div');
            tempElement.innerHTML = alertMessage;
            document.body.appendChild(tempElement.firstChild);
            form.removeChild(loadingElement);
          }
        }
      }
    }
  })
  function update_category(id, text){
    let modal = new bootstrap.Modal(document.getElementById('update_modal'))
    modal.show()
    console.log(text);
    let to_update_name = document.querySelector('#to_update_name')
    console.log(to_update_name);
    to_update_name.textContent = 'Update' + text
    
    let to_update_place = document.querySelector('#to_update_place')
    to_update_place.value = text
    to_update_place.setAttribute('name' , 'category')
    
    document.querySelector('#form-update').addEventListener('submit', (event) => {
      event.preventDefault();
      let form = event.currentTarget;
      let category = sanitizeInput(form.category.value);
      let stat = true
      if (category === '') {
        stat = false;
        addErrorMessage(form.category, 'This field is required');
      }else if (category.length < 4) {
        stat = false;
        addErrorMessage(form.category, 'Minimum 4 characters');
      }else{
        removeErrorMessage(form.category);
      }
      if (stat == true) {
        
        let xhttp = new XMLHttpRequest();
        xhttp.open("POST", "/api/category/update/" , true);
        let formData = new FormData();
        formData.append('id', id);
        formData.append('category', category);
        xhttp.send(formData);
        xhttp.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.responseText);
            if (response.status == 'success') {
              let alertMessage = alert_diss_abs(response.message);
              let tempElement = document.createElement('div');
              tempElement.innerHTML = alertMessage;
              document.body.appendChild(tempElement.firstChild);
              
              getCategorie()
              document.getElementById('update_modal_modal_close').click();

            }
            else {
              let alertMessage = alert_diss_abs(response.message);
              let tempElement = document.createElement('div');
              tempElement.innerHTML = alertMessage;
              document.body.appendChild(tempElement.firstChild);
              
            }
          }

        }

      }
    })

  }
  function update_cuisine(id, text){
    let modal = new bootstrap.Modal(document.getElementById('update_modal'))
    modal.show()
    console.log(text);
    let to_update_name = document.querySelector('#to_update_name')
    console.log(to_update_name);
    to_update_name.textContent = 'Update' + text
    
    let to_update_place = document.querySelector('#to_update_place')
    to_update_place.value = text
    to_update_place.setAttribute('name' , 'cuisine')
    
    document.querySelector('#form-update').addEventListener('submit', (event) => {
      event.preventDefault();
      let form = event.currentTarget;
      let cuisine = sanitizeInput(form.cuisine.value);
      let stat = true
      if (cuisine === '') {
        stat = false;
        addErrorMessage(form.cuisine, 'This field is required');
      }else if (cuisine.length < 4) {
        stat = false;
        addErrorMessage(form.cuisine, 'Minimum 4 characters');
      }else{
        removeErrorMessage(form.cuisine);
      }
      if (stat == true) {
        
        let xhttp = new XMLHttpRequest();
        xhttp.open("POST", "/api/cuisine/update/" , true);
        let formData = new FormData();
        formData.append('id', id);
        formData.append('cuisine', cuisine);
        xhttp.send(formData);
        xhttp.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.responseText);
            if (response.status == 'success') {
              let alertMessage = alert_diss_abs(response.message);
              let tempElement = document.createElement('div');
              tempElement.innerHTML = alertMessage;
              document.body.appendChild(tempElement.firstChild);
              
              document.getElementById('update_modal_modal_close').click();
              getCuisine()

            }
            else {
              let alertMessage = alert_diss_abs(response.message);
              let tempElement = document.createElement('div');
              tempElement.innerHTML = alertMessage;
              document.body.appendChild(tempElement.firstChild);
              
            }
          }

        }

      }
    })

  }
  function getCategorie() {
    let xhttp = new XMLHttpRequest();
    xhttp.open("GET", "/api/category/get", true);
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        let categories = JSON.parse(this.responseText);
        let category = categories.categories
        let place = document.querySelector("#categories");
        place.innerHTML = ``
        category.forEach((item, index) => {

          let tr = document.createElement("tr");
          let td1 = document.createElement("td");
          let td2 = document.createElement("td");
          let td3 = document.createElement("td");

          tr.setAttribute('data-aos', 'zoom-in');
          tr.setAttribute('data-aos-delay', index * 100);
          td1.textContent = item.Category;
          td2.innerHTML = `<i class="bi bi-pencil-square text-success cur-pointer hover-scale-1 "></i>`
          td3.innerHTML = `<i class="bi bi-x-circle-fill text-danger  cur-pointer hover-scale-1"></i>`
          td3.addEventListener('click', () => {
            delete_category(item.id_category)
          })
          td2.addEventListener('click', () => {
            update_category(item.id_category , item.Category)
          })
          tr.appendChild(td1);
          tr.appendChild(td2);
          tr.appendChild(td3);
          place.appendChild(tr);

        })

      }
    }
    xhttp.send()
  }
  getCategorie()
  function getCuisine() {
    let xhttp = new XMLHttpRequest();
    xhttp.open("GET", "/api/cuisine/get", true);
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        let cuisiness = JSON.parse(this.responseText);
        let cuisines = cuisiness.cuisines

        let place = document.querySelector("#cuisines");
        place.innerHTML = ``
        cuisines.forEach((item, index) => {

          let tr = document.createElement("tr");
          tr.setAttribute('data-aos', 'zoom-in');
          tr.setAttribute('data-aos-delay', index * 100);
          let td1 = document.createElement("td");
          let td2 = document.createElement("td");
          let td3 = document.createElement("td");

          td1.textContent = item.Cuisine;
          td2.innerHTML = `<i class="bi bi-pencil-square text-success cur-pointer hover-scale-1 "></i>`
          td3.innerHTML = `<i class="bi bi-x-circle-fill text-danger  cur-pointer hover-scale-1"></i>`
          td3.addEventListener('click', () => {
            delete_Cuisine(item.id_Cuisine)
          })
          td2.addEventListener('click', () => {
            update_cuisine(item.id_Cuisine , item.Cuisine)
          })
          tr.appendChild(td1);
          tr.appendChild(td2);
          tr.appendChild(td3);
          place.appendChild(tr);

        })

      }
    }
    xhttp.send()
  }
  getCuisine();
  function create_faq(data) {
    let placeholder = document.querySelector('#faq_form > .row');
    placeholder.innerHTML = ``;
    data.forEach(element => {
      let div = document.createElement('div');
      div.classList = `col-6`;
      div.innerHTML = `<div class="mb-3">
                <label for="question${element.id}" class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence">Question</label>
                <input type="text" name="question${element.id}" class="form-control shadow-sm " id="question${element.id}" value="${element.question}" placeholder="Question">
            </div>
            <div class="mb-3">
                <label for="Answer${element.id}" class="form-label text-capitalize fw-bold ff-ubunto fs-6 text-start balence">Answer</label>
                <textarea class="form-control shadow-sm " name="Answer${element.id}" id="Answer${element.id}" rows="3" placeholder="Answer">${element.answer}</textarea>
            </div>`

      placeholder.appendChild(div);
    });
    let div = document.createElement('div');
    div.classList = `col-6 d-flex flex-column m-auto align-items-center justiy-content-center`;
    let submit = document.createElement('input');
    submit.classList = `btn btn-danger px-5 w-fit h-fit py-3 rounded-5`;
    submit.setAttribute('type', 'submit');
    div.appendChild(submit);
    placeholder.appendChild(div);
  }
  function getfaq() {
    let xhttp = new XMLHttpRequest();
    xhttp.open("GET", "/api/content/faq/get/", true);
    xhttp.send();
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        let response = JSON.parse(this.responseText);
        if (response.status == 'success') {

          create_faq(response.faq);
        }
      }
    }
  }
  getfaq()
  let form = document.querySelector('#faq_form')
  form.addEventListener('submit', function (event) {
    event.preventDefault();
    let questions = document.querySelectorAll('input[name^="question"]');
    let answers = document.querySelectorAll('textarea[name^="Answer"]');
    let stat = true
    questions.forEach(q => {
      let question = sanitizeInput(q.value);


      if (question === '') {
        stat = false;
        addErrorMessage(q, 'This field is required');
      } else if (q.value.length < 20) {
        stat = false;
        addErrorMessage(q, 'Minimum 20 characters');
      } else {
        removeErrorMessage(q);
      }
    })
    answers.forEach(a => {
      let answer = sanitizeInput(a.value);
      if (answer === '') {
        stat = false;
        addErrorMessage(a, 'This field is required');
      } else if (a.value.length < 70) {
        stat = false;
        addErrorMessage(a, 'Minimum 70 characters');
      } else {
        removeErrorMessage(a);
      }
    })
    if (stat == true) {
      let xhttp = new XMLHttpRequest();
      xhttp.open("POST", "/api/content/faq/update/", true);
      let formData = new FormData();
      questions.forEach(q => {
        formData.append(`${q.id}`, sanitizeInput(q.value));
      })
      answers.forEach(a => {
        formData.append(`${a.id}`, sanitizeInput(a.value));
      })
      xhttp.send(formData);

      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          let response = JSON.parse(this.responseText);
          if (response.status == 'success') {
            let alertMessage = alert_diss_abs(response.message);
            let tempElement = document.createElement('div');
            tempElement.innerHTML = alertMessage;
            document.body.appendChild(tempElement.firstChild);
            getfaq()
          }
        }
      }
    }
  })
  function create_privacy(data) {
    let textarea = document.querySelector('#privacy_textarea');
    textarea.textContent = data
  }
  function get_privacy() {
    let xhttp = new XMLHttpRequest();
    xhttp.open("GET", "/api/content/privacy/", true);
    xhttp.send();
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        let response = JSON.parse(this.responseText);
        if (response.status == 'success') {

          create_privacy(response.privacy);
        }
      }
    }

  }
  get_privacy()
  let privacy_form = document.querySelector('#privacy_form');
  privacy_form.addEventListener('submit', function (event) {
    event.preventDefault();
    let stat = true
    let textarea = document.querySelector('#privacy_textarea');

    let privacy = sanitizeInput(textarea.value);

    if (privacy === '') {
      stat = false;
      addErrorMessage(textarea, 'This field is required');
    } else if (textarea.value.length < 100) {
      stat = false;
      addErrorMessage(textarea, 'Minimum 100 characters');
    } else {
      removeErrorMessage(textarea);
    }

    if (stat == true) {
      let xhttp = new XMLHttpRequest();
      xhttp.open("POST", "/api/content/privacy/", true);
      let formData = new FormData();
      formData.append('privacy', sanitizeInput(textarea.value));
      xhttp.send(formData);
      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          let response = JSON.parse(this.responseText);
          if (response.status == 'success') {
            let alertMessage = alert_diss_abs(response.message);
            let tempElement = document.createElement('div');
            tempElement.innerHTML = alertMessage;
            document.body.appendChild(tempElement.firstChild);
            get_privacy()
          }
        }
      }
    }
  })
});

