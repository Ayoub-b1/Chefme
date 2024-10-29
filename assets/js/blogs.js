document.addEventListener("DOMContentLoaded", function () {
    logout()
    let selectedFiles = []; // Array to store selected images
    function decodeHTMLEntities(text) {
        var element = document.createElement('div');
        element.innerHTML = text;
        return element.textContent;
    }
    function fill_userdata({ name, profile_pic, lastname, email }) {
        let img_place = document.querySelector('#addpostlabel');
        let addpost_place = document.querySelector('#post');
        let name_post_place = document.querySelector('#name_post');
        let email_post_place = document.querySelector('#email_post');

        img_place.src = profile_pic;
        addpost_place.setAttribute('placeholder', `Hello ${name} ${lastname}, What's on your mind?`);
        name_post_place.textContent = name;
        email_post_place.textContent = email;
    }

    function get_profile() {
        let xhttp = new XMLHttpRequest();
        xhttp.open("GET", "/api/user/getsessinfo/", true);
        xhttp.send();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let data = JSON.parse(this.responseText);
                fill_userdata(data.info[0]);
            }
        };
    }
    check_user_verified()
    get_profile();

    const imageUpload = document.getElementById('post_image'); // input
    const previewContainer = document.getElementById('preview'); // Container for previews

    imageUpload.addEventListener('change', function () {
        previewContainer.innerHTML = ''; // Clear previous previews
        selectedFiles = []; // Clear previous selected files

        const files = this.files;
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            if (file.type.startsWith('video/')) {
                generateVideoThumbnail(file);
            } else {
                generateImagePreview(file);
            }
            selectedFiles.push(file);
        }
    });
    function generateVideoThumbnail(videoFile) {
        const video = document.createElement('video');
        video.src = URL.createObjectURL(videoFile);
        video.preload = 'metadata';
        video.addEventListener('loadedmetadata', function () {
            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const ctx = canvas.getContext('2d');

            // Calculate the middle frame time
            const middleTime = video.duration / 2;
            video.currentTime = middleTime;

            // Capture the middle frame after seeking
            video.addEventListener('seeked', function () {
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                const thumbnail = document.createElement('img');
                thumbnail.src = canvas.toDataURL('image/jpeg');
                thumbnail.alt = videoFile.name;
                thumbnail.style.objectFit = 'cover';
                thumbnail.style.borderRadius = '8px'; // Adjust as needed
                thumbnail.style.border = '1px dashed gray';
                thumbnail.style.width = '100%'; // Adjust as needed
                thumbnail.style.aspectRatio = '1/1'; // Adjust as needed
                thumbnail.style.margin = '10px 0';
                thumbnail.addEventListener('click', function () {
                    removeImage(thumbnail);
                })
                previewContainer.appendChild(thumbnail);
            });

        });

    }


    // Function to generate preview for images
    function generateImagePreview(imageFile) {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(imageFile);
        img.alt = imageFile.name;
        img.style.objectFit = 'cover';
        img.style.borderRadius = '8px'; // Adjust as needed
        img.style.border = '1px dashed gray';
        img.style.width = '100%'; // Adjust as needed
        img.style.aspectRatio = '1/1'; // Adjust as needed
        img.style.margin = '10px 0';
        img.addEventListener('click', function () {
            removeImage(img);
        });
        previewContainer.appendChild(img);
    }
    function removeImage(img) {
        const index = Array.from(previewContainer.children).indexOf(img);
        if (index !== -1) {
            previewContainer.removeChild(img);
            selectedFiles.splice(index, 1);
        }
    }
    function isValidFileType(file) {
        const validImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        const validVideoTypes = ['video/mp4', 'video/mpeg', 'video/quicktime'];
        return validImageTypes.includes(file.type) || validVideoTypes.includes(file.type);
    }
    function getLikeCount(post_id) {
        return new Promise((resolve, reject) => {
            let xhttp = new XMLHttpRequest();
            xhttp.open("GET", `/api/blog/get/like_count/?post_id=${post_id}`, true);
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    let response = JSON.parse(this.responseText);
                    resolve(response.like_count);
                }
            };
            xhttp.send();
        })
    };
    function getdisLikeCount(post_id) {
        return new Promise((resolve, reject) => {
            let xhttp = new XMLHttpRequest();
            xhttp.open("GET", `/api/blog/get/dislike_count/?post_id=${post_id}`, true);
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    let response = JSON.parse(this.responseText);
                    resolve(response.like_count);
                }
            };
            xhttp.send();
        });
    }
    function check_like_set(post_id) {
        let xhttp = new XMLHttpRequest();
        xhttp.open("GET", `/api/blog/like/check_like?post_id=${post_id}`, true);
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                if (response.status == 'success') {
                    if (response.like == 'true') {
                        return true;
                    }
                    else {
                        return false
                    }
                }
            }
        }
    }
    function check_dislike_set(post_id) {
        let xhttp = new XMLHttpRequest();
        xhttp.open("GET", `/api/blog/dislike/check_dislike?post_id=${post_id}`, true);
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                if (response.status == 'success') {
                    if (response.dislike == 'true') {
                        return true;
                    }
                    else {
                        return false
                    }
                }
            }
        }
    }

    function updatepostinfocounts(post_id, likeplace_id, dislikeplace_id) {

        getLikeCount(post_id)
            .then(like_count => {
                document.querySelector(`#${likeplace_id}`).textContent = like_count;
            })
            .catch(error => {
                console.error('Error getting like count:', error);
            });

        getdisLikeCount(post_id)
            .then(like_count => {
                document.querySelector(`#${dislikeplace_id}`).textContent = like_count;
            })
            .catch(error => {
                console.error('Error getting like count:', error);
            });

    }

    function handleLike(like_check, post_id) {
        if (like_check.checked) {
            let xhttp = new XMLHttpRequest();
            let formData = new FormData();
            xhttp.open("POST", "/api/blog/like/", true);
            formData.append('post_id', post_id);
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    let response = JSON.parse(this.responseText);
                    if (response.status === 'success') {
                        like_check.checked = check_like_set(post_id);
                        updatepostinfocounts(post_id, `like_count_${post_id}`, `dislike_count_${post_id}`);
                    }
                }
            };
            xhttp.send(formData);
        }
    }

    function handleDislike(like_check, post_id) {
        if (like_check.checked) {
            let xhttp = new XMLHttpRequest();
            let formData = new FormData();
            xhttp.open("POST", "/api/blog/dislike/", true);
            formData.append('post_id', post_id);
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    let response = JSON.parse(this.responseText);
                    if (response.status === 'success') {
                        like_check.checked = check_dislike_set(post_id);
                        updatepostinfocounts(post_id, `like_count_${post_id}`, `dislike_count_${post_id}`);

                    }
                }
            };
            xhttp.send(formData);
        }
    }
    document.querySelector('#form-post').addEventListener('submit', function (event) {
        event.preventDefault();
        let form = event.target;
        let post = sanitizeInput(form.post_text.value);
        let stat = true;
        let images = selectedFiles;

        if (post === '') {
            stat = false;
            addErrorMessage(form.post_text, 'This field is required');
        } else if (post.length < 60) {
            stat = false;
            addErrorMessage(form.post_text, 'Minimum 60 characters');
        } else {
            removeErrorMessage(form.post_text);
        }

        const maxSizeInBytes = 15 * 1024 * 1024;
        for (let i = 0; i < images.length; i++) {
            if (images[i].size > maxSizeInBytes) {
                stat = false;
                let alertMessage = alert_diss_abs(`The image ${i + 1} is too large. Please select an image smaller than 15MB.`);
                let tempElement = document.createElement('div');
                tempElement.innerHTML = alertMessage;
                document.body.appendChild(tempElement.firstChild);
            }
            if (!isValidFileType(images[i])) {
                stat = false;
                let alertMessage = alert_diss_abs(`The file ${i + 1} is not a valid image or video.`);
                let tempElement = document.createElement('div');
                tempElement.innerHTML = alertMessage;
                document.body.appendChild(tempElement.firstChild);
            }
        }
        let xhttp = new XMLHttpRequest();
        xhttp.open('POST', '/api/blog/add/add_blog/', true);
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                if (response.status == 'success') {
                    let itemsContainer = document.getElementById('blogs_place');
                    itemsContainer.innerHTML = ``
                    load_posts();
                }
            }
        }
        let formData = new FormData();
        formData.append('post_text', post);
        for (let i = 0; i < images.length; i++) {
            formData.append('image[]', images[i]); // Append each file with a unique name
        }

        xhttp.send(formData);


    });
    function check_user_verified_stat() {
        let xhttp = new XMLHttpRequest();
        xhttp.open('GET', '/api/user/check_user_verified/', true);
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                if (response.status == 'success') {
                    if (response.verified.verified == 0) {
                        document.querySelector('#post_div').classList.add('d-none')
                    }
                }
            }
        }
        xhttp.send();
    }
    check_user_verified_stat()
    function load_posts() {
        let currentPage = 1;
        let itemsPerPage = 3;
        let totalItems = 100;
        let isLoading = false;

        const itemsContainer = document.getElementById('blogs_place');
        const loadingIndicator = document.getElementById('loading');

        function fetchItems(page, perPage) {
            return new Promise((resolve, reject) => {
                const xhttp = new XMLHttpRequest();
                const url = `/api/blog/get/?page=${page}&perPage=${perPage}`;
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4) {
                        if (this.status == 200) {
                            const response = JSON.parse(this.responseText);
                            resolve(response.items);
                        } else {
                            reject('Error fetching items');
                        }
                        loadingIndicator.style.display = 'none';
                    }
                };
                xhttp.open("GET", url, true);
                xhttp.send();
            });
        }
        function renderItems(items) {

            items.forEach(item => {
                const container = document.createElement('div');
                container.className = `bg-white shadow  p-4 w-100 d-flex flex-column rounded-4 shadow`;
                container.setAttribute('data-aos', 'fade-up');
                container.setAttribute('data-aos-duration', '1000');
                container.setAttribute('data-aos-delay', '400');
                container.innerHTML = `
                <div class="d-flex align-items-center gap-3  justify-content-between w-100">
                    <img class="img-fluid rounded-circle  placeholder  img_post" alt="">
                    <div class="d-flex flex-column gap-2 w-100">
                        <p class="mb-0 placeholder  rounded-3  w-50"></p>
                        <div class=" placeholder rounded-3  w-75  ">
                            <span></span>
                        </div>
                    </div>
                </div>
                <p class="placeholder rounded-3 p-5   w-100 mt-3"></p>
            `



                itemsContainer.appendChild(container);
                setTimeout(() => {
                    container.innerHTML = ''
                    let span = document.createElement('span');
                    span.className = 'bg-primary position-absolute custom-position px-2 py-1 rounded text-white text-secondary-emphasis fw-bold ';
                    span.textContent = item.post_date;
                    container.appendChild(span);

                    let div = document.createElement('div');
                    div.className = `d-flex align-items-center gap-3  justify-content-between w-100`;


                    let img = document.createElement('img');
                    img.src = item.profile_pic;
                    img.className = 'img-fluid rounded-circle    img_post';

                    div.appendChild(img);

                    let details = document.createElement('div');
                    details.className = 'd-flex flex-column gap-1 w-100';
                    let p = document.createElement('p');
                    p.textContent = item.name + ' ' + item.lastname;
                    p.className = 'mb-0  rounded-3 ';

                    let emaildiv = document.createElement('div');
                    emaildiv.className = 'rounded-1 privacy custum-mini-card w-fit';
                    emaildiv.addEventListener('click', function () {
                        window.location.href = '/view/profile?email=' + item.email;
                    })
                    let emailspan = document.createElement('span');
                    emailspan.textContent = item.email;

                    emaildiv.appendChild(emailspan);

                    details.appendChild(p);
                    details.appendChild(emaildiv);
                    div.appendChild(details);
                    container.appendChild(div);
                    let post_text = document.createElement('p')
                    post_text.className = 'mb-0  text-secondary p-4';
                    post_text.innerHTML = decodeHTMLEntities(item.post_text);
                    container.appendChild(post_text);

                    if (item.url != null) {
                        let media_container = document.createElement('div');
                        media_container.id = 'carouselExampleAutoplaying';
                        media_container.className = 'carousel slide carousel-dark';
                        media_container.setAttribute('data-bs-ride', 'carousel');
                        let carousel_inner = document.createElement('div');
                        carousel_inner.className = 'carousel-inner';
                        let media_json = JSON.parse(item.url);
                        media_json.forEach((media) => {
                            if (media.type == 'image') {
                                let carousel_item = document.createElement('div');
                                carousel_item.className = 'carousel-item ';
                                let img = document.createElement('img');
                                img.src = media.url;
                                img.className = 'd-block w-100';
                                carousel_item.appendChild(img);
                                carousel_inner.appendChild(carousel_item);
                            } else if (media.type == 'video') {
                                let carousel_item = document.createElement('div');
                                carousel_item.className = 'carousel-item ';
                                let video = document.createElement('video');
                                video.src = media.url;
                                video.controls = true;
                                video.muted = true
                                video.autoplay = true;
                                video.className = 'd-block w-100';
                                carousel_item.appendChild(video);
                                carousel_inner.appendChild(carousel_item);

                            }
                        })
                        carousel_inner.children[0].className = 'carousel-item active';
                        media_container.appendChild(carousel_inner);
                        media_container.innerHTML += `<button class="carousel-control-prev  h-50 my-auto " type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon " aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next h-50 my-auto" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                        </button>`
                        container.appendChild(media_container);
                    }

                    let action_div = document.createElement('div');
                    action_div.className = 'd-flex  justify-content-between my-3 align-items-center w-100';


                    let action_div_left = document.createElement('div');
                    action_div_left.className = 'd-flex align-items-center ms-3 gap-5';

                    let like_div = document.createElement('label');
                    like_div.setAttribute('for', `like_${item.post_id}`);
                    like_div.className = 'like_check d-flex cur-pointer hover-scale-1 gap-2 fs-5 justify-content-center align-items-center';
                    like_check = document.createElement('input');
                    like_check.checked = check_like_set(item.post_id);
                    like_check.setAttribute('type', 'radio');
                    like_check.setAttribute('id', `like_${item.post_id}`);
                    like_check.setAttribute('name', 'likes');
                    like_check.setAttribute('value', 'like');
                    like_check.className = ' d-none ';
                    like_check.addEventListener('change', (event) => handleLike(event.target, item.post_id));

                    let like_icon = document.createElement('i');
                    like_icon.className = 'bi bi-hand-thumbs-up';
                    like_div.appendChild(like_check);
                    like_div.appendChild(like_icon);

                    let like_count = document.createElement('span');
                    like_count.id = `like_count_${item.post_id}`;
                    like_count.textContent = item.like_count;
                    setInterval(() => {
                        getLikeCount(item.post_id)
                            .then(like_count_data => {
                                like_count.textContent = like_count_data;
                            })
                            .catch(error => {
                                console.error('Error getting like count:', error);
                            });
                    }, 60000);
                    like_div.appendChild(like_count);

                    action_div_left.appendChild(like_div);

                    let dislike_div = document.createElement('label');
                    dislike_div.setAttribute('for', `dislike_${item.post_id}`);
                    dislike_div.className = 'd-flex cur-pointer hover-scale-1 gap-2 fs-5 justify-content-center align-items-center';

                    dislike_check = document.createElement('input');
                    like_check.checked = check_dislike_set(item.post_id);

                    dislike_check.setAttribute('type', 'radio');
                    dislike_check.setAttribute('id', `dislike_${item.post_id}`);
                    dislike_check.setAttribute('name', 'likes');
                    dislike_check.setAttribute('value', 'dislike');
                    dislike_check.className = 'd-none';
                    dislike_check.addEventListener('change', (event) => handleDislike(event.target, item.post_id));

                    let dislike_icon = document.createElement('i');
                    dislike_icon.className = 'bi bi-hand-thumbs-down';
                    dislike_div.appendChild(dislike_check);
                    dislike_div.appendChild(dislike_icon);

                    let dislike_count = document.createElement('span');
                    dislike_count.textContent = item.dislike_count;
                    setInterval(() => {
                        getdisLikeCount(item.post_id)
                            .then(like_count_data => {
                                dislike_count.textContent = like_count_data;
                            })
                            .catch(error => {
                                console.error('Error getting like count:', error);
                            });
                    }, 60000);
                    dislike_count.id = `dislike_count_${item.post_id}`;

                    dislike_div.appendChild(dislike_count);

                    action_div_left.appendChild(dislike_div);

                    action_div.appendChild(action_div_left);

                    container.appendChild(action_div);

                }, 1700);
            });
        }
        function debounce(func, delay) {
            let timeout;
            return function () {
                const context = this;
                const args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    timeout = null;
                    func.apply(context, args);
                }, delay);
            };
        }

        const debouncedHandleScroll = debounce(handleScroll, 1000);
        function handleScroll() {
            if (itemsContainer.offsetHeight + itemsContainer.scrollTop >= itemsContainer.scrollHeight && !isLoading) {
                isLoading = true;
                loadingIndicator.style.display = 'block';
                setTimeout(() => {
                    fetchItems(currentPage, itemsPerPage)
                        .then(newItems => {
                            renderItems(newItems);
                            currentPage++;
                            isLoading = false;
                            loadingIndicator.style.display = 'none';
                        })
                        .catch(error => {
                            isLoading = false;
                            loadingIndicator.style.display = 'none';
                        });
                }, 1500)
            }
        }

        window.addEventListener('scroll', debouncedHandleScroll);

        fetchItems(currentPage, itemsPerPage)
            .then(initialItems => {
                renderItems(initialItems);
                currentPage++;
            })
            .catch(error => {
                console.error('Error fetching initial items:', error);
            });
    }
    load_posts();
});

