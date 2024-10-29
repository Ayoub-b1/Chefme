document.addEventListener('DOMContentLoaded', () => {


    logout()
    function fill_userdata({ name, profile_pic, lastname, email }) {
        let name_place = document.querySelector('#name');
        let img_plcae = document.querySelector('#img');
        let lastanme_place = document.querySelector('#lastanme');
        let email_place = document.querySelector('#email');

        name_place.textContent = name;
        img_plcae.src = profile_pic;
        lastanme_place.textContent = lastname;
        email_place.textContent = email
        updateinput(name, lastname, profile_pic)

    }
    function get_profile() {
        let xhttp = new XMLHttpRequest();
        xhttp.open("GET", "/api/user/getsessinfo/", true);
        xhttp.send();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let data = JSON.parse(this.responseText);
                console.log(data.info[0]);
                fill_userdata(data.info[0]);
            }
        }
    }
    function updateinput(name, lastname, img) {
        let name_place = document.querySelector('#update_name');
        let img_plcae = document.querySelectorAll('input[name="pfp"]');
        let lastanme_place = document.querySelector('#update_lastname');
        name_place.value = name
        lastanme_place.value = lastname
        img_plcae.forEach(element => {
            console.log(element.value, img);
            if (element.value === img) {
                element.checked = true;
            }
        })

    }
    get_profile()
    document.getElementById('edit').addEventListener('click', function (event) {
        get_profile();
    })

    function getpfp() {
        let xhttp = new XMLHttpRequest();
        xhttp.open("GET", "/api/user/getpfp/", true);
        xhttp.send();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let data = JSON.parse(this.responseText);
                let radios_pfp = document.querySelector('.radios_pfp');
                let pfp = data.profile_picture;
                pfp.forEach(image => {
                    let radio = document.createElement('input');
                    radio.type = 'radio';
                    radio.id = 'pfp' + image.id;
                    radio.name = 'pfp';
                    radio.className = 'd-none'
                    radio.value = image.path;
                    let label = document.createElement('label');
                    label.htmlFor = 'pfp' + image.id;
                    let img = document.createElement('img');
                    img.className = 'img-fluid cur-pointer rounded-circle';
                    img.style.width = '100px';
                    img.src = image.path;
                    label.appendChild(img);
                    radios_pfp.appendChild(radio);
                    radios_pfp.appendChild(label);
                });
                console.log(data);
            }
        }
    }
    getpfp();
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
    getCategorie()
    function get_bookmarks() {
        let bookmarked_recipes = localStorage.getItem('bookmarked_recipes');
        let receipe_json = JSON.parse(bookmarked_recipes);
        let xhttp = new XMLHttpRequest();
        xhttp.open("POST", "/api/Bookmark/get_data/", true);
        let formData = new FormData();
        formData.append('bookmarked_recipes', JSON.stringify(receipe_json));
        xhttp.send(formData);
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let table = document.getElementById('bookmarks_table');
                let data = JSON.parse(this.responseText);
                recipes = JSON.parse(data.recipes);
                recipes.forEach((e) => {
                    let tr = document.createElement('tr');
                    let td1 = document.createElement('td');
                    let td2 = document.createElement('td');
                    let td3 = document.createElement('td');
                    let img = document.createElement('img');
                    img.src = e.recipe_img
                    img.className = 'img-fluid table_img';
                    td1.style.width = '10%';
                    td2.style.width = '80%';
                    td3.style.width = '10%';
                    td1.appendChild(img);
                    td2.innerHTML = `<p class="m-0  fw-bold " >${e.title}</p>`;
                    td3.innerHTML = `<a class="p-0 text-decoration-none text-danger text-center  fw-bold "  href="/view/recipe?id=${e.id_recipe}">View <i class="bi bi-arrow-up-right"></i></a>`;

                    tr.appendChild(td1);
                    tr.appendChild(td2);
                    tr.appendChild(td3);
                    table.appendChild(tr);
                });


            }
        }
    }
    get_bookmarks();
    function getSelectedRadioValue(radioNodeList) {
        for (let i = 0; i < radioNodeList.length; i++) {
            if (radioNodeList[i].checked) {
                return radioNodeList[i].value;
            }
        }
        return '';
    }
    function delete_user_recipe(event, id){
        event.preventDefault();
        let xhttp = new XMLHttpRequest();
        xhttp.open("POST", "/api/receipe/delete/", true);
        let formData = new FormData();
        formData.append('id_recipe', id);
        xhttp.send(formData);
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var myModal_close = document.getElementById('modal-close2');
                myModal_close.click();
                let response = JSON.parse(this.responseText);
                if (response.status == 'success') {
                    let alertMessage = alert_diss_abs(response.message);
                    let tempElement = document.createElement('div');
                    tempElement.innerHTML = alertMessage;
                    document.body.appendChild(tempElement.firstChild);
                }
                get_user_recipes();
            }
        }

    }
  

    function update_user_recipe(event, id) {

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
            stat = true;
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
        } else if (title.length < 4) {
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
            formData.append('recipe_id', id);

            console.log(formData);
            let xhttp = new XMLHttpRequest();
            xhttp.open('POST', '/api/receipe/update/', true);
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                   

                    console.log(this.responseText);
                    let response = JSON.parse(this.responseText)
                    console.log(response);
                    if (response.status == 'success') {
                        let alertMessage = alert_diss_abs(response.message);
                        let tempElement = document.createElement('div');
                        tempElement.innerHTML = alertMessage;
                        document.body.appendChild(tempElement.firstChild);
                        get_user_recipes();

                    } else {
                        let alertMessage = alert_diss_abs(response.message);
                        let tempElement = document.createElement('div');
                        tempElement.innerHTML = alertMessage;
                        document.body.appendChild(tempElement.firstChild);
                    }
                    let modal = new bootstrap.Modal(document.querySelector('#exampleModal'))
                    modal.dispose();
                    var myModal_close = document.getElementById('modal-close2');
                    myModal_close.click();
                }
            }
            xhttp.send(formData);
        }


    }
    function update_recipe(recipe) {
        let modal_header = document.querySelector('#exampleModalLabel1')
        modal_header.textContent = 'Update Recipe ' + recipe.title;
        const img = document.getElementById('custum-file-upload'); // label
        img.querySelector('.icon').style.display = 'none';
        img.querySelector('.text ').innerHTML = '<span class=" fw-bold text-white bg-danger rounded-3 px-2 py-1">Click to change image</span>'
        img.style.background = `url(${recipe.recipe_img})`;
        img.style.backgroundSize = 'cover';
        img.style.backgroundPosition = 'center';
        img.style.backgroundRepeat = 'no-repeat';

        const imageupload = document.getElementById('image-file'); // input
        imageupload.addEventListener('change', function () {
            const file = this.files[0];
            const reader = new FileReader();
            reader.onload = function (e) {
                img.querySelector('.icon').style.display = 'none';
                img.querySelector('.text ').innerHTML = '<span class=" fw-bold text-white bg-danger rounded-3 px-2 py-1">Click to change image</span>'
                img.style.background = `url(${e.target.result})`;
                img.style.backgroundSize = 'cover';
                img.style.backgroundPosition = 'center';
                img.style.backgroundRepeat = 'no-repeat';
            };
            reader.readAsDataURL(file);
        })

        let title = document.querySelector('#title');
        title.value = recipe.title;
        let description = document.querySelector('#description');
        description.textContent = recipe.description;

        function add_inputs(add, place, width, name, value) {
            add.addEventListener('click', () => {
                const div = document.createElement('div');
                const input = document.createElement('input');
                input.value = value;
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
        function set_inputs(add, place, width, name, value) {

            const div = document.createElement('div');
            const input = document.createElement('input');
            input.value = value;
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

        }

        const add_ingrediant = document.getElementById('add-ingrediant');
        const ingrediant_place = document.getElementById('ingrediant-place');
        add_inputs(add_ingrediant, ingrediant_place, '', 'ingrediants', '');

        const add_instructions = document.getElementById('add-instructions');
        const instructions_place = document.getElementById('instructions-place');
        add_inputs(add_instructions, instructions_place, 'w-100', 'instructions', '')
        let ingrediants = JSON.parse(recipe.Ingredient);
        let Instructions = JSON.parse(recipe.Instructions);
        ingrediants.forEach((e) => {
            set_inputs(add_ingrediant, ingrediant_place, '', 'ingrediants', e);
        })
        Instructions.forEach((e) => {
            set_inputs(add_instructions, instructions_place, 'w-100', 'instructions', e);
        })

        let preparation_time = document.getElementById('preparation-time');
        preparation_time.value = recipe.preparation_time;

        const Cooking_time = document.getElementById('Cooking-time');
        Cooking_time.value = recipe.cooking_time;

        const total_time = document.getElementById('total-time');

        preparation_time.addEventListener('input', () => {

            formatinputnumber(preparation_time)
            updatetime()
        });
        Cooking_time.addEventListener('input', () => {
            formatinputnumber(Cooking_time)
            updatetime();
        });
        updatetime();

        function updatetime() {
            total_time.value = Number(preparation_time.value) + Number(Cooking_time.value)

        }

        let recipe_difficulty = document.querySelectorAll('input[name="recipe_difficulty"]');
        recipe_difficulty.forEach((e) => {
            console.log(e);
            if (e.value == recipe.difficulty_level) {
                e.checked = true
            }
        })

        let categorie = document.querySelector('#categorie');
        Array.from(categorie.children).forEach((e) => {
            if (e.value == recipe.Category) {
                e.selected = true
            }
        })
        let Cuisine = document.querySelector('#Cuisine');
        Array.from(Cuisine.children).forEach((e) => {
            if (e.value == recipe.id_Cuisine) {
                e.selected = true
            }
        })

        let calories = document.querySelector('#calories');
        calories.value = recipe.calories;

        let servings = document.querySelector('#servings');
        servings.value = recipe.servings;
        let updae_recipes_form = document.querySelector('#updae_recipes');
        updae_recipes_form.addEventListener('submit', function (event) {
            update_user_recipe(event, recipe.id_recipe)
        })

    }
    function delete_recipe(recipe) {
        let modal_header = document.querySelector('#exampleModalLabel2');
        modal_header.textContent = 'Delete Recipe';

        let form = document.querySelector('#delete_recipe');
        form.addEventListener('submit', function (event) {
            delete_user_recipe(event, recipe.id_recipe)
        })
        let card_place = document.querySelector('#recipe_preview')
        let card = document.createElement("div");
        card.setAttribute('data-aos', 'fade-up');
        card.setAttribute('data-aos-delay', 200 );

        card.addEventListener('click', () => {
            window.location.href = `/view/recipe?id=${recipe.id_recipe}`
        })
        card.className = "w-75 mx-auto my-5";
        card.innerHTML = `<div class="mx-3    position-relative h-100 ">
        <div class="shadow bg-white hover-scale hover-bg-danger rounded-5 h-100 position-relative d-flex flex-column align-items-center mb-4 ">
                                  <img src="${recipe.recipe_img}" class="recipeimgtop" alt="...">
                                  <div class="mt-5 d-flex flex-column align-items-center py-4 px-4 text-center">
                                    <h6 class="bg-danger hover-bg-white text-white px-2 py-1 rounded-5">${recipe.Cuisine}</h6>
                                    <div class="d-flex align-items-center justify-content-between gap-lg-3 gap-xl-3 px-4 fs-lg-7 fs-6  gap-md-3 gap-5 gap-lg-2 my-3">
                                    <div class="d-flex align-items-center gap-1"><i class="bi bi-gear"></i>
                                    <h6 class="mb-0 fs-lg-7 fs-6">${recipe.difficulty_level}</h6></div>
                                    <div class="d-flex align-items-center gap-1"><i class="bi bi-clock"></i></i>
                                    <h6 class="mb-0 fs-lg-7 fs-6">${recipe.total_time}m Duration</h6></div>
  
  
                                    </div>
                                    <h5 class="fs-4 ">${recipe.title}</h5>
                                    <div class="truncate w-100 px-2">
                                    <p class="">${recipe.description}</p>
                                    </div>
                                    </div>
        </div>`
        card_place.appendChild(card);



    }
    function get_user_recipes() {
        let xhttp = new XMLHttpRequest();
        xhttp.open("GET", "/api/user/get_user_recipes/", true);
        xhttp.send();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let data = JSON.parse(this.responseText);
                let table = document.getElementById('created_recipes');
                table.innerHTML = '';
                let recipes = JSON.parse(data.recipes);
                recipes.forEach((e) => {
                    let tr = document.createElement('tr');
                    let td1 = document.createElement('td');
                    let td2 = document.createElement('td');
                    let td3 = document.createElement('td');
                    let td4 = document.createElement('td');
                    let img = document.createElement('img');
                    img.src = e.recipe_img
                    img.className = 'img-fluid table_img';
                    td1.style.width = '10%';
                    td2.style.width = '50%';
                    td3.style.width = '30%';
                    td1.appendChild(img);
                    td2.innerHTML = `<p class="m-0  fw-bold " >${e.title}</p>`;
                    td3.innerHTML = `<button type="button" class="text-decoration-none bg-transparent border-0 text-center  w-100 text-uppercase text-danger balence " data-bs-toggle="modal" data-bs-target="#update_modal">
                                        <i class="me-2 bi bi-plus-circle"></i>
                                        Update Recipe
                                    </button>`;
                    td3.addEventListener('click', function () {
                        update_recipe(e);
                    })
                    td4.innerHTML = `<button type="button" class="text-decoration-none bg-transparent border-0 text-center  w-100 text-uppercase text-danger balence " data-bs-toggle="modal" data-bs-target="#delete_modal">
                    <i class="bi text-danger cur-pointer  bi-trash3"></i>
                </button>
                    
                    `;
                    td4.addEventListener('click', function () {
                        delete_recipe(e);
                    });
                    tr.appendChild(td1);
                    tr.appendChild(td2);
                    tr.appendChild(td3);
                    tr.appendChild(td4);
                    table.appendChild(tr);
                })

            }
        }
    }
    get_user_recipes();
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
    document.getElementById('form-update').addEventListener('submit', function (event) {
        event.preventDefault();
        let form = event.target;
        let name = sanitizeInput(form.name.value);
        let lastname = sanitizeInput(form.lastname.value);
        let stat = true;





        if (name === '') {
            stat = false;
            addErrorMessage(form.name, 'This field is required');
        } else if (name.length < 3 || name.length > 30) { // Adjust the length range as needed
            stat = false;
            addErrorMessage(form.name, 'name must be between 3 and 30 characters');
        } else {
            removeErrorMessage(form.name);
        }
        if (lastname === '') {
            stat = false;
            addErrorMessage(form.lastname, 'This field is required');
        } else if (name.length < 3 || name.lastname > 30) { // Adjust the length range as needed
            stat = false;
            addErrorMessage(form.lastname, 'lastname must be between 3 and 30 characters');
        } else {
            removeErrorMessage(form.lastname);
        }
        if (stat) {

            let xhttp = new XMLHttpRequest();
            xhttp.open("POST", "/api/user/update/", true);
            let formData = new FormData();
            formData.append('name', name);
            formData.append('lastname', lastname);
            formData.append('pfp', form.pfp.value);
            xhttp.send(formData);
            xhttp.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) {
                    let data = JSON.parse(this.responseText);
                    if (data.status === 'success') {
                        window.location.href = "/profile";
                    }
                }
            }
        }

    })
    function calculateDays(startDate, endDate) {
        // Convert both dates to milliseconds
        const startMillis = startDate.getTime();
        const endMillis = endDate.getTime();

        // Calculate the difference in milliseconds
        const difference = Math.abs(endMillis - startMillis);

        // Convert the difference to days
        const daysDifference = Math.ceil(difference / (1000 * 3600 * 24));

        return daysDifference;
    }
    function count_up(place, target) {
        let currentCount = 0;
        const targetCount = target;
        const duration = 2000;
        const increment = Math.ceil(targetCount / (duration / 100));

        const interval = setInterval(() => {
            currentCount += increment;
            if (currentCount >= targetCount) {
                currentCount = targetCount;
                clearInterval(interval);
            }
            place.textContent = currentCount;
        }, 100);
    }
    function fill_userinfo({ recipe_count, active, Bio, prefered_cuisine, allergies, facebook, instagram, number, twitter_x }) {
        let name_place = document.querySelector('#recipe_count');
        let active_place = document.querySelector('#active');
        let bio_place = document.querySelector('#bio');
        let Cuisine_place = document.querySelector('#Cuisine');
        let allergies_place = document.querySelector('#allergies');
        let facebook_place = document.querySelector('#facebook');
        let instagram_place = document.querySelector('#instagram');
        let number_place = document.querySelector('#number');
        let twitter_place = document.querySelector('#twitter');
        count_up(name_place, recipe_count)
        count_up(active_place, calculateDays(new Date(active), new Date()))
        bio_place.value = Bio
        Cuisine_place.value = prefered_cuisine
        allergies_place.value = allergies
        facebook_place.value = facebook
        instagram_place.value = instagram
        number_place.value = number
        twitter_place.value = twitter_x
    }

    function get_personal_info() {
        let xhttp = new XMLHttpRequest();
        xhttp.open("GET", "/api/user/get_personal_info/", true);
        xhttp.send();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let data = JSON.parse(this.responseText);
                console.log(data.info);
                fill_userinfo(data.info)

            }
        }
    }
    get_personal_info()

    var changebtn = document.getElementById('changebtn');
    var savebtn = document.getElementById('savebtn');
    document.getElementById('edit-toggle').addEventListener('click', function (event) {
        let bio_place = document.querySelector('#bio');
        let Cuisine_place = document.querySelector('#Cuisine');
        let allergies_place = document.querySelector('#allergies');
        if (event.target.classList.contains('bi-pen-fill')) {
            bio_place.disabled = true;
            Cuisine_place.disabled = true;
            allergies_place.disabled = true;
            changebtn.classList.add('d-none');
            event.target.classList.remove('bi-pen-fill');
            event.target.classList.add('bi-pen');
        }
        else {
            bio_place.disabled = false;
            Cuisine_place.disabled = false;
            allergies_place.disabled = false;
            changebtn.classList.remove('d-none');
            event.target.classList.remove('bi-pen');
            event.target.classList.add('bi-pen-fill');

        }
    })
    document.getElementById('edit-social-toggle').addEventListener('click', function (event) {
        let face_place = document.querySelector('#facebook');
        let instagram_place = document.querySelector('#instagram');
        let phone_place = document.querySelector('#number');
        let twitter_place = document.querySelector('#twitter');
        if (event.target.classList.contains('bi-pen-fill')) {
            face_place.disabled = true;
            instagram_place.disabled = true;
            phone_place.disabled = true;
            twitter_place.disabled = true;
            savebtn.classList.add('d-none');
            event.target.classList.remove('bi-pen-fill');
            event.target.classList.add('bi-pen');
        }
        else {
            face_place.disabled = false;
            instagram_place.disabled = false;
            phone_place.disabled = false;
            twitter_place.disabled = false;
            savebtn.classList.remove('d-none');
            event.target.classList.remove('bi-pen');
            event.target.classList.add('bi-pen-fill');

        }
    })
    savebtn.addEventListener('click', function (event) {
        event.preventDefault();
        let form = event.target.parentElement;
        let facebook = sanitizeInput(form.facebook.value);
        let instagram = sanitizeInput(form.instagram.value);
        let number = sanitizeInput(form.number.value);
        let twitter = sanitizeInput(form.twitter.value);

        let xhttp = new XMLHttpRequest();
        xhttp.open("POST", "/api/user/update_social_info/", true);
        let formData = new FormData();
        formData.append('facebook', facebook);
        formData.append('instagram', instagram);
        formData.append('number', number);
        formData.append('twitter', twitter);
        xhttp.send(formData);
        xhttp.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                if (response.status === 'success') {
                    console.log('cds');
                    let alertMessage = alert_diss_abs(response.message);
                    let tempElement = document.createElement('div');
                    tempElement.innerHTML = alertMessage;
                    document.body.appendChild(tempElement.firstChild);
                    get_personal_info();
                } else if (response.status === 'error') {
                    let alertMessage = alert_diss_abs(response.message);
                    let tempElement = document.createElement('div');
                    tempElement.innerHTML = alertMessage;
                    document.body.appendChild(tempElement.firstChild);
                }
            }
        }
    })
    changebtn.addEventListener('click', function (event) {
        event.preventDefault();
        let form = event.target.parentElement;
        let bio = sanitizeInput(form.bio.value);
        let cuisine = sanitizeInput(form.Cuisine.value);
        let allergies = sanitizeInput(form.allergies.value);

        let xhttp = new XMLHttpRequest();
        xhttp.open("POST", "/api/user/update_personal_info/", true);
        let formData = new FormData();
        formData.append('bio', bio);
        formData.append('cuisine', cuisine);
        formData.append('allergies', allergies);
        xhttp.send(formData);
        xhttp.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                if (response.status === 'success') {
                    console.log('cds');
                    let alertMessage = alert_diss_abs(response.message);
                    let tempElement = document.createElement('div');
                    tempElement.innerHTML = alertMessage;
                    document.body.appendChild(tempElement.firstChild);
                    get_personal_info();
                } else if (response.status === 'error') {
                    let alertMessage = alert_diss_abs(response.message);
                    let tempElement = document.createElement('div');
                    tempElement.innerHTML = alertMessage;
                    document.body.appendChild(tempElement.firstChild);
                }

            }
        }
    })
    check_user_verified()
})