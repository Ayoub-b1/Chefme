document.addEventListener('DOMContentLoaded', function () {

    let urlParams = new URLSearchParams(window.location.search);
    let token = urlParams.get('token');
    if (token == null || token == '') {
        alert('Invalid link');
        window.location.href = '/signin';
    } else {

    document.getElementById('form-reset').addEventListener('submit', function (event) {
        event.preventDefault();
        let form = event.target;
        let password = sanitizeInput(form.password.value);
        let co_password = sanitizeInput(form.co_password.value);


       

            let stat = true;

            if (password === '') {
                stat = false;
                addErrorMessage(form.password, 'This field is required');
            } else if (password.length < 8) {
                stat = false;
                addErrorMessage(form.password, 'Minimum 8 characters');
            } else {
                removeErrorMessage(form.password);
            }
            if (co_password === '') {
                stat = false;
                addErrorMessage(form.co_password, 'This field is required');
            } else if (co_password.length < 8) {
                stat = false;
                addErrorMessage(form.co_password, 'Minimum 8 characters');
            } else if (password !== co_password) {
                stat = false;
                addErrorMessage(form.co_password, 'Password does not match');
            } else {
                removeErrorMessage(form.co_password);
            }

            if (stat === true) {
                let loadingElement = showLoading();
                form.appendChild(loadingElement);
                let xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) {
                        form.removeChild(loadingElement);
                        var response = JSON.parse(this.responseText);
                        if (response.status === 'success') {
                            let alertMessage = alert_diss_abs(response.message);
                            let tempElement = document.createElement('div');
                            tempElement.innerHTML = alertMessage;
                            document.body.appendChild(tempElement.firstChild);
                            if (response.redirectUrl) {
                                setTimeout(() => {
                                    window.location.href = response.redirectUrl;
                                }, 3000);
                            }
                        } else if (response.status === 'error') {
                            let alertMessage = alert_diss_abs(response.message);
                            let tempElement = document.createElement('div');
                            tempElement.innerHTML = alertMessage;
                            document.body.appendChild(tempElement.firstChild);
                        }

                    }
                };
                xhttp.open('POST', '/reset.php', true);
                let formData = new FormData();
                formData.append('token', token);
                formData.append('password', password);

                xhttp.send(formData);
            }

        })
    }
})