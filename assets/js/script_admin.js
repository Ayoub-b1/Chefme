AOS.init();

function sanitizeInput(input) {
    return input.trim().replace(/[&<>"']/g, function (match) {
        return {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;'
        }[match];
    });
}
function unsanitizeInput(input) {
    return input.replace(/&amp;|&lt;|&gt;|&quot;|&#39;/g, function (match) {
        return {
            '&amp;': '&',
            '&lt;': '<',
            '&gt;': '>',
            '&quot;': '"',
            '&#39;': "'"
        }[match];
    });
}
function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}



function addErrorMessage(input, message) {
    removeErrorMessage(input);

    input.insertAdjacentHTML('afterend', `<span class="text-danger">${message}</span>`);
    input.classList.add('vibration');
    setTimeout(() => {
        input.classList.remove('vibration');
    }, 700);
}

function removeErrorMessage(input) {
    if (input.nextElementSibling && input.nextElementSibling.className === 'text-danger') {
        input.nextElementSibling.remove();
    }
}
function validateEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}
function alert_diss_abs(message) {
    return `<div data-bs-theme="dark" class="alert alert-danger alert-dismissible px-3 rounded-2  position-fixed bottom-0 mb-5 translate-middle-x start-50 border-0   fade show  mx-auto mt-5 text-white fs-6 py-2 d-flex z-3 z-n1   " role="alert">
            <p class="me-5 mb-0">${message}</p>
    <button type="button" class="btn-close top-50  translate-middle-y text-white "  data-bs-dismiss="alert" aria-label="Close"></button>
  </div>`
}
function showLoading() {
    let loadingDiv = document.createElement('div');
    loadingDiv.classList.add('lds-ring');

    for (let i = 0; i < 4; i++) {
        let div = document.createElement('div');
        loadingDiv.appendChild(div);
    }

    return loadingDiv;
}
function formatNumberDecimal(value) {
    if (value % 1 !== 0) {
        return value.toString();
    } else {
        return value.toFixed(2);
    }
}

function formatinputnumber(num) {
    let currentValue = parseInt(num.value);
    const maxValue = parseInt(num.getAttribute('max'));



    if (currentValue < 1) {
        num.value = 1;
        currentValue = 1;
    } else {
        num.value = Math.round(currentValue);
    }
    if (currentValue > maxValue) {
        num.value = maxValue;
        currentValue = maxValue;
    }
}

function backmover(classes) {
    let element = document.querySelectorAll(classes);
    element.forEach((el) => {
        el.addEventListener("mousemove", (e) => {
            var zoomer = e.currentTarget;
            e.offsetX ? offsetX = e.offsetX : offsetX = e.touches[0].pageX
            e.offsetY ? offsetY = e.offsetY : offsetX = e.touches[0].pageX
            x = offsetX / zoomer.offsetWidth * 100
            y = offsetY / zoomer.offsetHeight * 100
            zoomer.style.backgroundPosition = x + '% ' + y + '%';
        });
    })


}
function logout() {
    document.getElementById('logout').addEventListener('click', function () {
        let xhttp = new XMLHttpRequest();
        xhttp.open('GET', '/api/user/logout.php', true);
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                if (response.status == 'success') {
                    window.location.href = '/signin';
                } else {
                    let alertMessage = alert_diss_abs(response.message);
                    let tempElement = document.createElement('div');
                    tempElement.innerHTML = alertMessage;
                    document.body.appendChild(tempElement.firstChild);
                }
            }
        }
        xhttp.send();
    })
}


document.addEventListener('DOMContentLoaded', async function () {

        let header = document.querySelector('header');
        let footer = document.querySelector('footer');
        let observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('scale-anime');
                } else {
                    entry.target.classList.remove('scale-anime');
                }
            })
        });
        let observer_diss = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('scale-anime');
                    observer_diss.disconnect()
                } else {
                    entry.target.classList.remove('scale-anime');
                }
            })
        });

        observer_diss.observe(header);

        observer.observe(footer);
   
})

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
