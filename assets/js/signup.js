document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('form-signup').addEventListener('submit', function(event) {
        event.preventDefault();
        let form = event.target;
        let name = sanitizeInput(form.name.value);
        let lname = sanitizeInput(form.lastname.value);
        let email = sanitizeInput(form.email.value);
        let password = sanitizeInput(form.password.value);
        let confirmPassword = sanitizeInput(form.Confirmpassword.value);
    
        let stat = true;
    
        
    
    
       
        if (name === '') {
            stat = false;
            addErrorMessage(form.name, 'This field is required');
        }else{
            removeErrorMessage(form.name);
        }
    
        if (lname === '') {
            stat = false;
            addErrorMessage(form.lastname, 'This field is required');
        }
        else{
            removeErrorMessage(form.lastname);
        }
    
        if (email === '') {
            stat = false;
            addErrorMessage(form.email, 'This field is required');
        } else if (!validateEmail(email)) {
            stat = false;
            addErrorMessage(form.email, 'Invalid email address');
        } else if (email.length < 6 || email.length > 100) { // Adjust the length range as needed
            stat = false;
            addErrorMessage(form.email, 'Email address must be between 6 and 100 characters');
        }else{
            removeErrorMessage(form.email);
        }
    
        if (password === '') {
            stat = false;
            addErrorMessage(form.password, 'This field is required');
        } else if (password.length < 8) {
            stat = false;
            addErrorMessage(form.password, 'Minimum 8 characters');
        }else{
            removeErrorMessage(form.password);
        }
    
        if (confirmPassword === '') {
            stat = false;
            addErrorMessage(form.Confirmpassword, 'This field is required');
        } else if (confirmPassword.length < 8) {
            stat = false;
            addErrorMessage(form.Confirmpassword, 'Minimum 8 characters');
        } else if (password !== confirmPassword) {
            stat = false;
            addErrorMessage(form.Confirmpassword, 'Password does not match');
        }else{
            removeErrorMessage(form.Confirmpassword);
        }
    
        if (stat === true) {
            let loadingElement = showLoading();
            form.appendChild(loadingElement);
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    form.removeChild(loadingElement);

                    var response = JSON.parse(this.responseText);
                    if(response.status === 'success'){
                        localStorage.setItem('bookmarked_recipes', [])
                        localStorage.setItem('bookmarked_recipes_original', [])
                        if (response.redirectUrl) {
                            window.location.href = response.redirectUrl; 
                        }
                    }else if (response.status === 'error') {
                        let alertMessage = alert_diss_abs(response.message);
                        let tempElement = document.createElement('div');
                        tempElement.innerHTML = alertMessage;
                        document.body.appendChild(tempElement.firstChild);
                    }
                }
            };
            xhttp.open('POST', 'signup.php', true);
            let formData = new FormData();
            formData.append('name', name);
            formData.append('lastname', lname);
            formData.append('email', email);
            formData.append('password', password);
            formData.append('Confirmpassword', confirmPassword);
        
            xhttp.send(formData);
        }
    });

});