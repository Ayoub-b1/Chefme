document.addEventListener('DOMContentLoaded', () => {
    check_user_verified()

    logout();
    
    var data
    const urlParams = new URLSearchParams(window.location.search);

    if (urlParams.has('id')) {
        const parameterValue = urlParams.get('id');
        let xhttp = new XMLHttpRequest();
        xhttp.open('GET', '/api/receipe/get_unique/index.php?id=' + parameterValue, true);
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                if (response.status == 'success') {
                    data = response.recipe;
                    console.log(data);
                    setdata(data);
                }
            }
        }
        xhttp.send();

    }
    else {
        window.location.href = "../recipes";
    }
    function decodeHTMLEntities(text) {
        var element = document.createElement('div');
        element.innerHTML = text;
        return element.textContent;
    }

    function setdata({ recipe_img, title, description, date_added, Ingredient, Instructions, preparation_time, cooking_time, total_time, difficulty_level, name, lastname, email, Category, Cuisine, calories, servings }) {
        const image = document.querySelector('#img_placeholder');
        const figure = document.querySelector('#fig_placeholder');
        const title_place = document.querySelector('#title_place');
        const desc_place = document.querySelector('#desc_place');
        const creation_place = document.querySelector('#creation_place');
        const ingredients_place = document.querySelector('#ingredients_place');
        const instructions_place = document.querySelector('#instructions_place');
        const preparationtime_place = document.querySelector('#preparationtime_place');
        const cookingtime_place = document.querySelector('#cookingtime_place');
        const totaltime_place = document.querySelector('#totaltime_place');
        const difficulty_place = document.querySelector('#difficulty_place');
        const creator_place = document.querySelector('#creator_place');
        const creatormail_place = document.querySelector('#creatormail_place');
        const serving_place = document.querySelector('#serving_place');
        const calories_place = document.querySelector('#calories_place');
        const cuisine_place = document.querySelector('#cuisine_place');
        const categorie_place = document.querySelector('#categorie_place');

        image.src = '../' + recipe_img;
        figure.setAttribute('style', `background: url('../${recipe_img}')`)
        title_place.textContent = decodeHTMLEntities(title);
        desc_place.textContent = decodeHTMLEntities(description);
        creation_place.textContent = decodeHTMLEntities(date_added);
        JSON.parse(Ingredient).forEach((element, index) => {
            let h3 = document.createElement('h3');
            h3.className = 'text-capitalize fw-bold ff-ubunto fs-6 text-start balence line-h-1  letter-4 ';
            let number = document.createElement('span');
            number.className = 'text';
            h3.appendChild(document.createTextNode(" _\t\t" + decodeHTMLEntities("&nbsp;&nbsp;&nbsp;&nbsp;") + decodeHTMLEntities(element)));
            ingredients_place.appendChild(h3);
        });
        JSON.parse(Instructions).forEach((element, index) => {
            let h3 = document.createElement('h3');
            h3.className = 'text-capitalize fw-bold ff-ubunto fs-6 text-start balence line-h-1 letter-4 ';
            let number = document.createElement('span');
            number.className = 'text';
            h3.appendChild(document.createTextNode(" _\t\t" + decodeHTMLEntities("&nbsp;&nbsp;&nbsp;&nbsp;") + decodeHTMLEntities(element)));
            instructions_place.appendChild(h3);
        })
        preparationtime_place.textContent = decodeHTMLEntities(preparation_time);
        cookingtime_place.textContent = decodeHTMLEntities(cooking_time);
        totaltime_place.textContent = decodeHTMLEntities(total_time);
        difficulty_place.textContent = decodeHTMLEntities(difficulty_level);
        creator_place.textContent = decodeHTMLEntities(lastname + " " + name);
        serving_place.textContent = decodeHTMLEntities(servings);
        calories_place.textContent = decodeHTMLEntities(calories + 'Kcal');
        cuisine_place.textContent = decodeHTMLEntities(Cuisine);
        categorie_place.textContent = decodeHTMLEntities(Category);
        if (bookmarked_recipes.includes(data.id_recipe)) {
            const bookmark_btn = document.querySelector('#bookmark > i');
            bookmark_btn.classList.remove('bi-bookmark');
            bookmark_btn.classList.add('bi-bookmark-fill');
        }
    }
    backmover('.recipe_view')
    let bookmarked_recipes = localStorage.getItem('bookmarked_recipes');
    if (bookmarked_recipes == null) {
        bookmarked_recipes = [];
    }
    else {
        bookmarked_recipes = JSON.parse(bookmarked_recipes);
       }

    // TODO : make request to server one time each (for case user mark and quit from website)
    const bookmark_btn = document.querySelector('#bookmark > i');
    bookmark_btn.addEventListener('click', () => {
        console.log(data.id_recipe);
        if (bookmarked_recipes.includes(data.id_recipe)) {
            console.log(bookmarked_recipes);
            bookmarked_recipes.splice(bookmarked_recipes.indexOf(data.id_recipe), 1);
            console.log(bookmarked_recipes);
            localStorage.setItem('bookmarked_recipes', JSON.stringify(bookmarked_recipes));
        }
        else {
            bookmarked_recipes.push(data.id_recipe);
            localStorage.setItem('bookmarked_recipes', JSON.stringify(bookmarked_recipes));
        }
        if (bookmark_btn.classList.contains('bi-bookmark')) {
            bookmark_btn.classList.remove('bi-bookmark');
            bookmark_btn.classList.add('bi-bookmark-fill');
        }
        else {
            bookmark_btn.classList.remove('bi-bookmark-fill');
            bookmark_btn.classList.add('bi-bookmark');
        }

    })

})