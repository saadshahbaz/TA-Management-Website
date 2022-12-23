// function populateUserTable(request) {
//     let table = document.getElementById("user-table");
//     table.innerHTML = request.responseText;
// }

// function zortingen(){
//     var studentId = document.getElementById("studentId");
//     if (x.style.display === "none") {
//       x.style.display = "block";
//     } else {
//       x.style.display = "none";
//     }
// }

// function getAccounts() {
//     try {
//         const req = new XMLHttpRequest();
//         req.open("GET", "./get_users.php", true);
//         req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//         req.onreadystatechange = function() {
//             if (this.readyState == 4 && this.status == 200) {
//                 populateUserTable(req);
//             }
//         }
//         req.send(null);
//     } catch (exception) {
//         alert("Request failed. Please try again.");
//     }
// }

// function saveMultipleNewAccounts() {
//     let csv = document.getElementById("user-upload-csv").files[0];
//     let formData = new FormData();
//     formData.append("file", csv);
//     // command
//     try {
//         const syncRequest = new XMLHttpRequest();
//         syncRequest.open("POST", "./import_users.php", false);
//         syncRequest.send(formData);

//         if (syncRequest.status === 200) {
//             let parser = new DOMParser();
//             let xmlDoc = parser.parseFromString(syncRequest.responseText, "text/xml");
//             let error_msgs = xmlDoc.getElementsByClassName("error");
            
//             // check if we received an error while trying to register
//             if (error_msgs.length > 0) {
//                 let error_div = document.getElementById("error-msg-cont");
//                 // append all error messages
//                 for (msg of error_msgs) {
//                     error_div.appendChild(msg);
//                 }
//             }
//             getAccounts();
//         }
//     } catch (exception) {
//         console.log(exception);
//         alert("Request failed. Please try again.");
//     }
// }

// function getEditAccountInformation() {
//     const error_div = document.getElementById("error-msg-cont");
//     const formData = new FormData(document.getElementById("edit-user-form"));      
    
//     let email = formData.get('email');
//     let accounttypes = formData.get('to_add');

//     editAccount(email, accounttypes)

// }

// function editAccount(email, accounttypes){
//     try {
//         const syncRequest = new XMLHttpRequest();
//         syncRequest.open("POST", "./edit_users.php", false);
//         syncRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//         syncRequest.send(`sender=sysop&email=${email}&accounttypes=${accounttypes}`);
//     if (syncRequest.status === 200) {
//         let parser = new DOMParser();
//         let xmlDoc = parser.parseFromString(syncRequest.responseText, "text/xml");
//         let error_msgs = xmlDoc.getElementsByClassName("error");
        
//         // check if we received an error while trying to register
//         if (error_msgs.length > 0) {
//             let error_div = document.getElementById("user-error-msg-cont");
//             // append all error messages
//             for (msg of error_msgs) {
//                 error_div.appendChild(msg);
//             }
//         }
//         var userform = document.getElementById("edit-user-form");
//         userform.reset();
//         getAccounts();
//     }
// } catch (exception) {
//     alert("Request failed. Please try again.");
// }
// }

// function saveNewAccount() {
//     // Clear error messages
//     const error_div = document.getElementById("error-msg-cont");
//     //while (error_div.firstChild) {
//     //    error_div.removeChild(error_div.lastChild);
//     //}

//     const formData = new FormData(document.getElementById("add-user-form"));
      
//     userRoles = ["student", "professor", "ta", "admin", "sysop"];
//     selectedRoles = [];
//     for (var pair of formData.entries()) {
//         if (userRoles.includes(pair[0])) {
//             selectedRoles.push(userRoles.indexOf(pair[1])+1);
//         }
//     }

//     try {
//         const syncRequest = new XMLHttpRequest();
//         syncRequest.open("POST", "./add_users.php", false);
//         syncRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//         syncRequest.send(`sender=sysop&password=${formData.get('pwd')}&firstname=${formData.get('first-name')}&lastname=${formData.get('last-name')}&usernamezort=${formData.get('usernamezort')}&email=${formData.get('email')}&accounttypes=${JSON.stringify(selectedRoles)}`);

//         if (syncRequest.status === 200) {
//             let parser = new DOMParser();
//             let xmlDoc = parser.parseFromString(syncRequest.responseText, "text/xml");
//             let error_msgs = xmlDoc.getElementsByClassName("error");
            
//             // check if we received an error while trying to register
//             if (error_msgs.length > 0) {
//                 let error_div = document.getElementById("error-msg-cont");
//                 // append all error messages
//                 for (msg of error_msgs) {
//                     error_div.appendChild(msg);
//                 }
//             }
//             var userform = document.getElementById("add-user-form");
//             userform.reset();
//             getAccounts();
//         }
//     } catch (exception) {
//         console.log(exception);
//         alert("Request failed. Please try again.");
//     }
// }

// function getRemoveAccountInformation()
// {
//     const error_div = document.getElementById("user-error-msg-cont");
//     while (error_div.firstChild) {
//         error_div.removeChild(error_div.lastChild);
//     }
//     const formData = new FormData(document.getElementById('remove-user-form'));
      
    
//     let email = formData.get('email');
//     let accounttypes = formData.get('to_remove');

//     removeAccount(email, accounttypes);
    
// }

// function removeAccount(email, accounttypes) {
//     try {
//         const syncRequest = new XMLHttpRequest();
//         syncRequest.open("POST", "./remove_users.php", false);
//         syncRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//         syncRequest.send(`sender=sysop&email=${email}&accounttypes=${accounttypes}`);
//     if (syncRequest.status === 200) {
//         let parser = new DOMParser();
//         let xmlDoc = parser.parseFromString(syncRequest.responseText, "text/xml");
//         let error_msgs = xmlDoc.getElementsByClassName("error");
        
//         // check if we received an error while trying to register
//         if (error_msgs.length > 0) {
//             let error_div = document.getElementById("user-error-msg-cont");
//             // append all error messages
//             for (msg of error_msgs) {
//                 error_div.appendChild(msg);
//             }
//         }
//         var userform = document.getElementById("remove-user-form");
//         userform.reset();
//         getAccounts();
//     }
// } catch (exception) {
//     alert("Request failed. Please try again.");
    
// }
// }