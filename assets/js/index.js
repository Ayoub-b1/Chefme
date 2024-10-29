document.addEventListener('DOMContentLoaded', () => {
    check_user_verified();
    logout();
    function get_last_recipes() {
        let place = document.querySelector('#last_recipes');
        let xhttp = new XMLHttpRequest();
        xhttp.open('GET', '/api/receipe/get/get_last_recipes/', true);
        xhttp.send()
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                if (response.status == 'success') {
                    let recipes = response.recipes;
                    setTimeout(() => {
                        for (let i = 0; i < recipes.length; i++) {
                            let card = document.createElement("div");
                            card.setAttribute('data-aos', 'fade-up');
                            card.setAttribute('data-aos-delay', 200 * i);

                            card.addEventListener('click', () => {
                                window.location.href = `/view/recipe?id=${recipes[i].id_recipe}`
                            })
                            card.className = "col-12 col-md-6 col-lg-4  my-5  ";
                            card.innerHTML = `<div class="mx-3   position-relative h-100 ">
                          <div class="shadow bg-white hover-scale hover-bg-danger rounded-5 h-100 position-relative d-flex flex-column align-items-center mb-4 ">
                                                    <img src="${recipes[i].recipe_img}" class="recipeimgtop" alt="...">
                                                    <div class="mt-5 d-flex flex-column align-items-center pt-4 px-4 text-center">
                                                      <h6 class="bg-danger hover-bg-white text-white px-2 py-1 rounded-5">${recipes[i].Cuisine}</h6>
                                                      <div class="d-flex align-items-center justify-content-between gap-lg-3 gap-xl-3 px-4 fs-lg-7 fs-6  gap-md-3 gap-5 gap-lg-2 my-3">
                                                      <div class="d-flex align-items-center gap-1"><i class="bi bi-gear"></i>
                                                      <h6 class="mb-0 fs-lg-7 fs-6">${recipes[i].difficulty_level}</h6></div>
                                                      <div class="d-flex align-items-center gap-1"><i class="bi bi-clock"></i></i>
                                                      <h6 class="mb-0 fs-lg-7 fs-6">${recipes[i].total_time}m Duration</h6></div>
                    
                    
                                                      </div>
                                                      <h5 class="fs-4 ">${recipes[i].title}</h5>
                                                      <div class="truncate w-100 px-2">
                                                      <p class="">${recipes[i].description}</p>
                                                      </div>
                                                      </div>
                          </div>`
                            place.appendChild(card);
                        }
                    }, 600);

                }
            }
        }
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
        }, 300);
    }
    function get_users_active() {
        let xhttp = new XMLHttpRequest();
        xhttp.open('GET', '/api/user/get/get_users_active/', true);
        xhttp.send()
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                if (response.status == 'success') {
                    let active_users = document.querySelector('#active-users');
                    count_up(active_users, response.users)
                }
            }

        }
    }
    get_users_active()
    function get_recipes_count() {
        let xhttp = new XMLHttpRequest();
        xhttp.open('GET', '/api/receipe/get/get_recipes_count/', true);
        xhttp.send()
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                if (response.status == 'success') {
                    let active_users = document.querySelector('#avg-ratings');
                    count_up(active_users, response.receipe)
                }
            }

        }
    }
    get_recipes_count()
    
    get_last_recipes();
}

)