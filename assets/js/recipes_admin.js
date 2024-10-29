
document.addEventListener("DOMContentLoaded", function () {
    logout();
    var data = [];
    function send_delete(id) {
        let xhttp = new XMLHttpRequest();
        xhttp.open("POST", "/api/receipe/delete/", true);
        let formData = new FormData();
        formData.append('id_recipe', id);
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
                    
                    getReceipes()
                } else {
                    let alertMessage = alert_diss_abs(response.message);
                    let tempElement = document.createElement('div');
                    tempElement.innerHTML = alertMessage;
                    document.body.appendChild(tempElement.firstChild);
                }
            }
        }
    }
    function deletelement(card, id) {
        let div = document.createElement('div');
        div.className = 'position-fixed bottom-0 start-0 end-0 m-auto d-flex m-5 p-5 justify-content-center delete-icon';
        div.style.zIndex = 999;
        div.innerHTML = '<i class="bi bi-x-circle fs-1 text-danger" style="cursor:pointer"></i>';
        document.body.appendChild(div);

        div.addEventListener('dragover', function (event) {
            event.preventDefault();

            // Get the center coordinates of the card
            const cardRect = card.getBoundingClientRect();
            const cardCenterX = cardRect.left + cardRect.width / 2;
            const cardCenterY = cardRect.top + cardRect.height / 2;

            // Get the center coordinates of the div
            const divRect = div.getBoundingClientRect();
            const divCenterX = divRect.left + divRect.width / 2;
            const divCenterY = divRect.top + divRect.height / 2;

            // Calculate distance between the card and the div
            const distance = Math.sqrt(
                Math.pow(cardCenterX - divCenterX, 2) +
                Math.pow(cardCenterY - divCenterY, 2)
            );

            // Adjust the distance threshold
            const maxDistance = 400; // Adjust this value as needed

            // Calculate scale factor based on distance
            const minScale = 0.5; // Minimum scale factor
            const maxScale = 1.0; // Maximum scale factor
            const scaleFactor = Math.min(minScale, maxScale - distance / maxDistance);

            // Apply scale transformation to the card
            card.style.transform = `scale(${scaleFactor})`;
        });

        div.addEventListener('drop', () => {

            let modal = new bootstrap.Modal(document.getElementById('delete_modal'));

            modal.show()
            document.getElementById('form-delete').addEventListener('submit', function (event) {
                event.preventDefault();
                send_delete(id)
            })

        })

        div.addEventListener('dragleave', function (event) {
            event.preventDefault();
            // Get the center coordinates of the card
            const cardRect = card.getBoundingClientRect();
            const cardCenterX = cardRect.left + cardRect.width / 2;
            const cardCenterY = cardRect.top + cardRect.height / 2;

            // Get the center coordinates of the div
            const divRect = div.getBoundingClientRect();
            const divCenterX = divRect.left + divRect.width / 2;
            const divCenterY = divRect.top + divRect.height / 2;

            // Calculate distance between the card and the div
            const distance = Math.sqrt(
                Math.pow(cardCenterX - divCenterX, 2) +
                Math.pow(cardCenterY - divCenterY, 2)
            );

            // Calculate scale factor based on distance
            const maxDistance = 2000; // Adjust this value as needed
            const minScale = 1; // Minimum scale factor
            const maxScale = .5; // Maximum scale factor
            const scaleFactor = Math.max(minScale, maxScale - distance / maxDistance);

            // Apply scale transformation to the card
            card.style.transform = `scale(${scaleFactor})`;
        });
    }
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
                card.draggable = true;

                card.addEventListener('click', () => {
                    window.location.href = `/view/recipe?id=${filteredData[i].id_recipe}`
                });

                card.className = "col-12 col-md-6 col-lg-4  my-5  ";
                card.innerHTML = `<div class="mx-3   position-relative h-100 ">
          <div class="shadow bg-white hover-scale hover-bg-danger rounded-5 h-100 position-relative d-flex flex-column align-items-center mb-4 ">
                                    <img src="../${filteredData[i].recipe_img}" class="recipeimgtop" alt="...">
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

                // Initialize variables to store initial mouse position relative to the dragged element
                let offsetX, offsetY;

                // Add event listener to the card for dragstart
                card.addEventListener('dragstart', (event) => {
                    offsetX = event.clientX - (card.getBoundingClientRect().left + card.offsetWidth / 2);
                    offsetY = event.clientY - (card.getBoundingClientRect().top + card.offsetHeight / 2);
                    const dragImage = new Image();
                    dragImage.src = ''; // Specify the path to your drag image

                    // Set the custom drag image and its offset
                    event.dataTransfer.setDragImage(dragImage, offsetX, offsetY);
                    event.dataTransfer.setData('text/plain', i); // Set data to be dragged
                    event.target.style.zIndex = 999;
                    event.target.classList.add('cur-pointer')
                    document.body.classList.add('dragging');

                    // Calculate initial mouse position relative to the dragged element
                    const rect = event.target.getBoundingClientRect();
                    offsetX = event.clientX - rect.left;
                    offsetY = event.clientY - rect.top;



                    deletelement(card, filteredData[i].id_recipe);


                });

                // Add event listener to the card for dragend
                card.addEventListener('dragend', (event) => {
                    // Remove the custom drag image
                    event.dataTransfer.clearData();

                    // Remove any additional elements created during the drag operation
                    const deleteIcon = document.querySelector('.delete-icon');
                    if (deleteIcon) {
                        deleteIcon.parentNode.removeChild(deleteIcon);
                    }

                    // Your drag end logic here
                    event.target.style.zIndex = ''; // Reset zIndex
                    event.target.classList.remove('cur-pointer'); // Remove cursor pointer class
                    document.body.classList.remove('dragging'); // Remove dragging class from bod
                    event.target.style.position = 'relative';
                    event.target.style.left = '0px';
                    event.target.style.top = '0px';
                    getReceipes();
                });

                // Add event listener to the card for drag
                card.addEventListener('drag', (event) => {
                    // Update the position of the dragged element
                    event.preventDefault();

                    // Calculate the new position of the card
                    const newLeft = event.clientX - offsetX;
                    const newTop = event.clientY - offsetY;

                    // Apply the new position to the card
                    event.target.style.position = 'absolute';
                    event.target.style.left = newLeft + 'px';
                    event.target.style.top = newTop + 'px';
                });



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
                    if (input.type === 'search' || input.type === 'select-one' || input.type === 'number') {
                        input.value = '';
                    } else {
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



});