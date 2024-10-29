
document.addEventListener("DOMContentLoaded", function () {
  logout();
  var data = [];
  function displayrecipes(data, place, filters) {
    place.innerHTML = "";
    let filteredData = data;
    console.log(filteredData);
    if (filters && filters.length > 0) {
      filteredData = data.filter(recipe => {
        return filters.every(filter => {

          switch (filter.name) {
            case 'search':
              return recipe.title.toLowerCase().includes(filter.value.toLowerCase());
            case 'difficulty':
              return recipe.difficulty_level === filter.value;
            case 'totaletime_filter':
              const timeRange = filter.value;
              if (timeRange === "-10min") {
                return recipe.total_time <= 10;
              } else if (timeRange === "+10min") {
                return recipe.total_time > 10 && recipe.total_time <= 30;
              } else if (timeRange === "+30min") {
                return recipe.total_time > 30;
              }
              return true;
            case 'categorie_filter':
              return recipe.id_category === parseInt(filter.value);
            case 'Cuisine_filter':
              return recipe.id_Cuisine === parseInt(filter.value);
            case 'serving_filter':
              return recipe.servings === parseInt(filter.value);
            default:
              return true;
          }
        });
      });
    }
    if (filteredData.length === 0) {
      let card = document.createElement("div");

      card.className = "col-12 text-center";
      card.innerHTML = "<p>No recipes found.</p>";
      place.appendChild(card);
      return; // Exit the function
    }
    setTimeout(() => {
      for (let i = 0; i < filteredData.length; i++) {
        let card = document.createElement("div");
        card.setAttribute('data-aos', 'fade-up');
        card.setAttribute('data-aos-delay', 200 * i);

        card.addEventListener('click', () => {
          window.location.href = `/view/recipe?id=${filteredData[i].id_recipe}`
        })
        card.className = "col-12 col-md-6 col-lg-4  my-5  ";
        card.innerHTML = `<div class="mx-3   position-relative h-100 ">
        <div class="shadow bg-white hover-scale hover-bg-danger rounded-5 h-100 position-relative d-flex flex-column align-items-center mb-4 ">
                                  <img src="${filteredData[i].recipe_img}" class="recipeimgtop" alt="...">
                                  <div class="mt-5 d-flex flex-column align-items-center pt-4 px-4 text-center">
                                    <h6 class="bg-danger hover-bg-white text-white px-2 py-1 rounded-5">${filteredData[i].Cuisine}</h6>
                                    <div class="d-flex align-items-center justify-content-between gap-lg-3 gap-xl-3 px-4 fs-lg-7 fs-6  gap-md-3 gap-5 gap-lg-2 my-3">
                                    <div class="d-flex align-items-center gap-1"><i class="bi bi-gear"></i>
                                    <h6 class="mb-0 fs-lg-7 fs-6">${filteredData[i].difficulty_level}</h6></div>
                                    <div class="d-flex align-items-center gap-1"><i class="bi bi-clock"></i></i>
                                    <h6 class="mb-0 fs-lg-7 fs-6">${filteredData[i].total_time}m Duration</h6></div>
  
  
                                    </div>
                                    <h5 class="fs-4 ">${filteredData[i].title}</h5>
                                    <div class="truncate w-100 px-2">
                                    <p class="">${filteredData[i].description}</p>
                                    </div>
                                    </div>
        </div>`
        place.appendChild(card);
      }
    }, 600);
  }


  function updateliked() {
    let bookmarked_recipes = localStorage.getItem('bookmarked_recipes');
    let bookmarked_recipes_original = localStorage.getItem('bookmarked_recipes_original');
    if (bookmarked_recipes == null) {
      return;
    }
    else {
      if (bookmarked_recipes_original != bookmarked_recipes) {
        localStorage.setItem('bookmarked_recipes_original', bookmarked_recipes);
        bookmarked_recipes = JSON.parse(bookmarked_recipes);
        let xhttp = new XMLHttpRequest();
        xhttp.open("POST", "/api/Bookmark/update/", true);
        xhttp.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.responseText);
            if (response.status == 'success') {
              console.log(response);
            }
          }
        }
        let formData = new FormData();
        bookmarked_recipes.forEach((ing, index) => {
          formData.append('bookmarked_recipes[' + index + ']', ing);
        });
        xhttp.send(formData);
      }
    }
  }
  updateliked();
  function getCategorie() {
    let xhttp = new XMLHttpRequest();
    xhttp.open("GET", "/api/category/get", true);
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        let categories = JSON.parse(this.responseText);
        let category = categories.categories
        let select = document.querySelectorAll(".category_place");
        select.forEach(function (select) {
          for (let i = 0; i < category.length; i++) {
            let option = document.createElement("option");
            option.value = category[i].id_category;
            option.text = category[i].Category;
            select.appendChild(option);
          }
        })

      }
    }
    xhttp.send()
  }
  function getReceipes() {
    let xhttp = new XMLHttpRequest();
    xhttp.open("GET", "/api/receipe/get", true);
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        let response = JSON.parse(this.responseText);
        if (response.status == 'success') {
          data = response.recipes
          displayrecipes(data, document.querySelector(".recipes"))
        }


      }
    }
    xhttp.send()
  }
  getReceipes()
  function getCuisine() {
    let xhttp = new XMLHttpRequest();
    xhttp.open("GET", "/api/cuisine/get", true);
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        let cuisinesjson = JSON.parse(this.responseText);
        console.log(cuisinesjson);
        let cuisines = cuisinesjson.cuisines
        let select = document.querySelectorAll(".cuisine_place");
        select.forEach(function (select) {
          for (let i = 0; i < cuisines.length; i++) {
            let option = document.createElement("option");
            option.value = cuisines[i].id_Cuisine;
            option.text = cuisines[i].Cuisine;
            select.appendChild(option);
          }
        })

      }
    }
    xhttp.send()
  }
  getCuisine();
  getCategorie()
  const menubtn = document.getElementById("menu-toggle");
  menubtn.addEventListener("click", function () {
    const menu = document.getElementById("menu");
    if (menu.classList.contains('d-none')) {
      menu.classList.remove('d-none')
      menu.classList.add('d-flex');
    } else {
      menu.classList.remove('d-flex')
      menu.classList.add('d-none');
    }
  })
  const inpNumbers = document.querySelectorAll('input[type="number"]');

  inpNumbers.forEach((input) => {
    input.addEventListener('input', () => {
      const maxValue = parseInt(input.getAttribute('max'));
      const currentValue = parseInt(input.value);

      if (currentValue < 1) {
        input.value = 1;
      }
      if (currentValue > maxValue) {
        input.value = maxValue;
      }
    });
  });
  function sendfilters(filters) {
    console.log(filters);
    displayrecipes(data, document.querySelector(".recipes"), filters)
  }
  const filterInputs = document.querySelectorAll('input[name="difficulty"], input[name="totaletime_filter"], select[name="categorie_filter"], select[name="Cuisine_filter"], input[name="serving_filter"] , input[name="search"]');

  function displayAppliedFilters() {
    const appliedFiltersElement = document.getElementById('filters');
    appliedFiltersElement.innerHTML = '';
    let filters = [];
    let filtersApplied = false;

    filterInputs.forEach(input => {
      if ((input.type === 'radio' && input.checked) || (input.type === 'select-one' && input.value !== '') || (input.type === 'number' && input.value !== '') || (input.type === 'search' && input.value.trim() !== '')) {
        filtersApplied = true;

        const miniCard = document.createElement('div');
        miniCard.classList.add('mini-card');
        let inputValue = input.type === 'number' ? input.value + ' personne(s)' : input.value;
        if (input.type === 'select-one') {
          const selectedOption = input.options[input.selectedIndex];
          inputValue = selectedOption.textContent.trim();
        } if (input.type === 'search') {
          inputValue = 'Title : ' + input.value;
        }
        miniCard.innerHTML = inputValue + '<i class="bi bi-x-lg fw-bold "></i>';
        filters.push({ name: input.name, value: input.value });
        miniCard.addEventListener('click', () => {
          if (input.type === 'search'|| input.type === 'select-one' || input.type === 'number') {
            input.value = ''; 
          } else  {
            input.checked = false;
          }
          filters = filters.filter(filter => filter.name !== input.name); // Remove the filter from the filters array
          displayAppliedFilters(); // Update the displayed filters
        });
        

        appliedFiltersElement.appendChild(miniCard);
      }
    });
    sendfilters(filters);
    if (appliedFiltersElement.previousElementSibling) {
      appliedFiltersElement.previousElementSibling.remove()
    }

    if (filtersApplied) {
      appliedFiltersElement.parentElement.classList.remove('d-none');
      appliedFiltersElement.insertAdjacentHTML('beforebegin', '<h1 class="text-capitalize fw-bold ff-ubunto fs-6 text-start balence">Applied Filters</h1>');
    } else {
      appliedFiltersElement.parentElement.classList.add('d-none');
    }
  }

  filterInputs.forEach(input => {
      input.addEventListener('change', displayAppliedFilters);

    
  });


  displayAppliedFilters();
  const imageupload = document.getElementById('image-file'); // input
  imageupload.addEventListener('change', function () {
    const file = this.files[0];
    const reader = new FileReader();
    reader.onload = function (e) {
      const img = document.getElementById('custum-file-upload'); // label
      img.querySelector('.icon').style.display = 'none';
      img.querySelector('.text ').innerHTML = '<span class=" fw-bold text-white bg-danger rounded-3 px-2 py-1">Click to change image</span>'
      img.style.background = `url(${e.target.result})`;
      img.style.backgroundSize = 'cover';
      img.style.backgroundPosition = 'center';
      img.style.backgroundRepeat = 'no-repeat';
    };
    reader.readAsDataURL(file);
  })

  function add_inputs(add, place, width, name) {
    add.addEventListener('click', () => {
      const div = document.createElement('div');
      const input = document.createElement('input');
      const remove = document.createElement('i');

      div.className = `d-flex align-items-center gap-3 ${width} `;

      input.setAttribute('class', `form-control ${name}`)
      input.setAttribute('name', `${name}`)

      remove.className = 'bi bi-x-lg fw-bold p-2 mini-card-i ';
      remove.addEventListener('click', () => {
        remove.parentElement.remove();
      })
      div.appendChild(input)
      div.appendChild(remove)

      place.insertBefore(div, add)

    })
  }
  const add_ingrediant = document.getElementById('add-ingrediant');
  const ingrediant_place = document.getElementById('ingrediant-place');
  add_inputs(add_ingrediant, ingrediant_place, '', 'ingrediants');
  const add_instructions = document.getElementById('add-instructions');
  const instructions_place = document.getElementById('instructions-place');
  add_inputs(add_instructions, instructions_place, 'w-100', 'instructions')


  const modal = document.getElementById('exampleModal');
  modal.addEventListener('show.bs.modal', function (e) {
    const ingrediant_place = document.getElementById('ingrediant-place');
    const instructions_place = document.getElementById('instructions-place');
    clearContainer(ingrediant_place);
    clearContainer(instructions_place);

  });
  function clearContainer(container) {
    const children = container.children;
    for (let i = children.length - 1; i >= 1; i--) {
      const child = children[i];
      if (child.tagName.toLowerCase() !== 'i') {
        container.removeChild(child);
      }
    }
  }


  const preparation_time = document.getElementById('preparation-time');
  const Cooking_time = document.getElementById('Cooking-time');
  const total_time = document.getElementById('total-time');

  preparation_time.addEventListener('input', () => {

    formatinputnumber(preparation_time)
    updatetime()
  });
  Cooking_time.addEventListener('input', () => {
    formatinputnumber(Cooking_time)
    updatetime();
  });
  function updatetime() {
    total_time.value = Number(preparation_time.value) + Number(Cooking_time.value)

  }
  const calories = document.getElementById('calories');
  const servings = document.getElementById('servings');
  calories.addEventListener('input', () => {
    const currentValue = parseInt(calories.value);

    if (currentValue < 1) {
      calories.value = 1;
    }

  });
  servings.addEventListener('input', () => {
    const currentValue = parseInt(servings.value);
    const maxValue = parseInt(servings.getAttribute('max'));

    if (currentValue < 1) {
      servings.value = 1;
    }
    if (currentValue > maxValue) {
      servings.value = maxValue;
    }
  });
  function getSelectedRadioValue(radioNodeList) {
    for (let i = 0; i < radioNodeList.length; i++) {
      if (radioNodeList[i].checked) {
        return radioNodeList[i].value;
      }
    }
    return '';
  }
  function check_user_verified() {
    let xhttp = new XMLHttpRequest();
    xhttp.open('GET', '/api/user/check_user_verified/', true);
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.responseText);
            if (response.status == 'success') {
                if (response.verified.verified == 0) {
                    let verification_banner = document.createElement('div');
                    verification_banner.classList.add('verification-banner');
                    verification_banner.classList.add('cur-pointer');
                    verification_banner.setAttribute('data-aos', 'slide-right')
                    verification_banner.textContent = 'please verify your account';
                    verification_banner.addEventListener('click', function () {
                        window.location.href = '/verification';
                    })
                    document.body.insertAdjacentElement('afterbegin', verification_banner);
                }
            }
        }
    }
    xhttp.send();
}
  check_user_verified()

  document.getElementById('add_recipes').addEventListener('submit', function (event) {

    event.preventDefault()
    let add_recipes_form = event.target;
    let recipe_img = add_recipes_form.recipe_img.files[0];
    let title = sanitizeInput(add_recipes_form.title.value);
    let description = sanitizeInput(add_recipes_form.description.value);
    let ingrediants_form = add_recipes_form.querySelectorAll('[name="ingrediants"]');
    let ingredients = [];
    for (let i = 0; i < ingrediants_form.length; i++) {
      ingredients.push(sanitizeInput(ingrediants_form[i].value));
    }
    let instructions_form = add_recipes_form.querySelectorAll('[name="instructions"]');
    let instructions = [];
    for (let i = 0; i < instructions_form.length; i++) {
      instructions.push(sanitizeInput(instructions_form[i].value));
    }
    let preparation_time = sanitizeInput(add_recipes_form.preparation_time.value);
    let Cooking_time = sanitizeInput(add_recipes_form.Cooking_time.value);
    let total_time = sanitizeInput(add_recipes_form.total_time.value);

    let recipe_difficulty = getSelectedRadioValue(add_recipes_form.recipe_difficulty);
    let categorie = sanitizeInput(add_recipes_form.categorie.value);
    let Cuisine = sanitizeInput(add_recipes_form.Cuisine.value);
    let calories = sanitizeInput(add_recipes_form.calories.value);
    let servings = sanitizeInput(add_recipes_form.servings.value);

    let stat = true;
    if (!recipe_img) {
      stat = false;
      addErrorMessage(add_recipes_form.recipe_img, 'Please select an image');
    } else {
      let validImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];
      if (!validImageTypes.includes(recipe_img.type)) {
        stat = false;
        addErrorMessage(add_recipes_form.recipe_img, 'Please select a valid image (JPEG, PNG, or JPG)');
      } else {
        const maxSizeInBytes = 2 * 1024 * 1024;
        if (recipe_img.size > maxSizeInBytes) {
          stat = false;
          addErrorMessage(add_recipes_form.recipe_img, '<span class="bg-dark py-2 px-1 ">The selected image is too large. Please select an image smaller than 2MB.</span>');
        } else {
          removeErrorMessage(add_recipes_form.recipe_img);
        }
      }
    }

    if (title === '') {
      stat = false;
      addErrorMessage(add_recipes_form.title, 'This field is required');
    } else if (title.length < 8) {
      stat = false;
      addErrorMessage(add_recipes_form.title, 'Minimum 8 characters');
    } else {
      removeErrorMessage(add_recipes_form.title);
    }
    if (description === '') {
      stat = false;
      addErrorMessage(add_recipes_form.description, 'This field is required');
    } else if (description.length < 60) {
      stat = false;
      addErrorMessage(add_recipes_form.description, 'Minimum 60 characters');
    } else {
      removeErrorMessage(add_recipes_form.description);
    }
    ingredients.forEach((ing, index) => {
      if (ing == '') {
        stat = false;
        addErrorMessage(ingrediants_form[index], 'This field is required ')
      } else if (ing.length < 3) {
        stat = false;
        addErrorMessage(ingrediants_form[index], 'Minimum 3 characters');
      } else {
        removeErrorMessage(ingrediants_form[index])
      }
    })
    instructions.forEach((ins, index) => {
      if (ins === '') {
        stat = false;
        addErrorMessage(instructions_form[index], 'This field is required ')
      } else if (ins.length < 10) {
        stat = false;
        addErrorMessage(instructions_form[index], 'Minimum 10 characters');
      } else {
        removeErrorMessage(instructions_form[index])
      }
    });
    if (preparation_time === '') {
      stat = false;
      addErrorMessage(add_recipes_form.preparation_time, 'This field is required');
    } else {
      removeErrorMessage(add_recipes_form.preparation_time);
    }
    if (Cooking_time === '') {
      stat = false;
      addErrorMessage(add_recipes_form.Cooking_time, 'This field is required');
    } else {
      removeErrorMessage(add_recipes_form.Cooking_time);
    }
    if (total_time === '') {
      stat = false;
      addErrorMessage(add_recipes_form.total_time, 'previous field are required');
    } else {
      removeErrorMessage(add_recipes_form.Cooking_time);
    }
    if (recipe_difficulty === '') {
      stat = false;
      addErrorMessage(add_recipes_form.recipe_difficulty, 'This field is required');
    } else {
      removeErrorMessage(add_recipes_form.recipe_difficulty);
    }

    if (categorie === '') {
      stat = false;
      addErrorMessage(add_recipes_form.categorie, 'This field is required');
    } else {
      removeErrorMessage(add_recipes_form.categorie);
    }

    if (Cuisine === '') {
      stat = false;
      addErrorMessage(add_recipes_form.Cuisine, 'This field is required');
    } else {
      removeErrorMessage(add_recipes_form.Cuisine);
    }

    if (calories === '') {
      stat = false;
      addErrorMessage(add_recipes_form.calories, 'This field is required');
    } else {
      removeErrorMessage(add_recipes_form.calories);
    }

    if (servings === '') {
      stat = false;
      addErrorMessage(add_recipes_form.servings, 'This field is required');
    } else {
      removeErrorMessage(add_recipes_form.servings);
    }
    if (stat) {
      let formData = new FormData();
      formData.append('recipe_img', recipe_img);
      formData.append('title', title);
      formData.append('description', description);
      ingredients.forEach((ing, index) => {
        formData.append('ingrediants[' + index + ']', ing);
      });
      instructions.forEach((ins, index) => {
        formData.append('instructions[' + index + ']', ins);
      });
      formData.append('preparation_time', preparation_time);
      formData.append('Cooking_time', Cooking_time);
      formData.append('total_time', total_time);
      formData.append('recipe_difficulty', recipe_difficulty);
      formData.append('categorie', categorie);
      formData.append('Cuisine', Cuisine);
      formData.append('calories', calories);
      formData.append('servings', servings);

      console.log(formData);
      let xhttp = new XMLHttpRequest();
      xhttp.open('POST', '/api/receipe/add/', true);
      xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          var myModal_close = document.getElementById('modal-close');
          myModal_close.click();

          console.log(this.responseText);
          let response = JSON.parse(this.responseText)
          console.log(response);
          if (response.status == 'success') {
            let alertMessage = alert_diss_abs(response.message);
            let tempElement = document.createElement('div');
            tempElement.innerHTML = alertMessage;
            document.body.appendChild(tempElement.firstChild);

          } else {
            let alertMessage = alert_diss_abs(response.message);
            let tempElement = document.createElement('div');
            tempElement.innerHTML = alertMessage;
            document.body.appendChild(tempElement.firstChild);
          }
        }
      }
      xhttp.send(formData);
    }

  })
});