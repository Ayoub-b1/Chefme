document.addEventListener('DOMContentLoaded', function() {
    
    document.getElementById('form-sendcode').addEventListener('submit', function(event) {
        event.preventDefault();
        let form = event.target;
        let sendcode = sanitizeInput(form.sendcode.value);
        let stat = true;
    
        
       
        if (sendcode === '') {
            stat = false;
            addErrorMessage(form.sendcode, 'This field is required');
        }else{
            removeErrorMessage(form.sendcode);
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
                        if(response.message) {
                            let alertMessage = alert_diss_abs(response.message);
                            let tempElement = document.createElement('div');
                            tempElement.innerHTML = alertMessage;
                            document.body.appendChild(tempElement.firstChild);
                        }
                        setTimeout(() => {
                            if(response.redirectUrl){
                                window.location.href = response.redirectUrl;
                            }
                        }, 3000);
                    }else if (response.status === 'error') {
                        let alertMessage = alert_diss_abs(response.message);
                        let tempElement = document.createElement('div');
                        tempElement.innerHTML = alertMessage;
                        document.body.appendChild(tempElement.firstChild);
                    }
                    
                }
            };
            xhttp.open('POST', 'verification.php', true);
            let formData = new FormData();
            formData.append('sendcode', sendcode);        
            xhttp.send(formData);
        }
    
    })
    document.getElementById('submit-code').addEventListener('submit', function(event) {
        event.preventDefault();
        let form = event.target;
        let verifycode = sanitizeInput(form.verifycode.value);
        let stat = true;
    
        
       
        if (verifycode === '') {
            stat = false;
            addErrorMessage(form.verifycode, 'This field is required');
        }else{
            removeErrorMessage(form.verifycode);
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
                        if(response.message) {
                            let alertMessage = alert_diss_abs(response.message);
                            let tempElement = document.createElement('div');
                            tempElement.innerHTML = alertMessage;
                            document.body.appendChild(tempElement.firstChild);
                        }
                        setTimeout(() => {
                            if(response.redirectUrl){
                                window.location.href = response.redirectUrl;
                            }
                        }, 3000);
                    }else if (response.status === 'error') {
                        let alertMessage = alert_diss_abs(response.message);
                        let tempElement = document.createElement('div');
                        tempElement.innerHTML = alertMessage;
                        document.body.appendChild(tempElement.firstChild);
                    }
                    
                }
            };
            xhttp.open('POST', 'verification.php', true);
            let formData = new FormData();
            formData.append('verifycode', verifycode);        
            xhttp.send(formData);
        }
    
    })
})