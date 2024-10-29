document.addEventListener('DOMContentLoaded', function() {
    
    document.getElementById('form-signin').addEventListener('submit', function(event) {
        event.preventDefault();
        let form = event.target;
        let email = sanitizeInput(form.email.value);
        let password = sanitizeInput(form.password.value);
        let stat = true;
    
        
    
    
       
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
        if (stat === true) {
            let loadingElement = showLoading();
            form.appendChild(loadingElement);
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {

                if (this.readyState == 4 && this.status == 200) {
                    form.removeChild(loadingElement);
                    var response = JSON.parse(this.responseText);
                    if(response.status === 'success'){
                        localStorage.setItem('bookmarked_recipes', JSON.parse(response.bookmarked_recipes))
                        localStorage.setItem('bookmarked_recipes_original', JSON.parse(response.bookmarked_recipes))
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
            xhttp.open('POST', 'signin.php', true);
            let formData = new FormData();
            formData.append('email', email);
            formData.append('password', password);
        
            xhttp.send(formData);
        }
    
    })
})