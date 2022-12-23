function sendLoginRequest() {
    let email = document.getElementById("login-form").elements["email"].value;
    let password = document.getElementById("login-form").elements["password"].value;

    try {
        const syncRequest = new XMLHttpRequest();
        syncRequest.open("POST", "login.php", false);
        syncRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        syncRequest.send(`email=${email}&password=${password}`);

        if (syncRequest.status === 200) {
            let parser = new DOMParser();
            let xmlDoc = parser.parseFromString(syncRequest.responseText, "text/xml");
            let scripts = xmlDoc.getElementsByTagName("script");

            // login success
            if (scripts.length > 0) {
                document.body.innerHTML = syncRequest.responseText;
                let scripts = document.body.getElementsByTagName("script");
                eval(scripts[0].text); // execute the declaration code for our returned 
                // functions so that the browser knows they exist
                redirect(); // redirect to the user's dashboard
            }
            // login fail
            else {
                let errorDiv = document.getElementById("login-error");
                errorDiv.innerHTML = syncRequest.responseText;
            }
        }
    }
    catch (exception) {
        alert("Request failed. Please try again.");
    }
}