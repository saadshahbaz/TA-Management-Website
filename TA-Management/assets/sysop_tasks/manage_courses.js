// function populateCourseTable(request) {
//     let table = document.getElementById("course-table");
//     table.innerHTML = request.responseText;
// }

// function getCourses() {
//     try {
//         const req = new XMLHttpRequest();
//         req.open("GET", "./get_courses.php", true);
//         req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//         req.onreadystatechange = function() {
//             if (this.readyState == 4 && this.status == 200) {
//                 populateCourseTable(req);
//             }
//         }
//         req.send(null);
//     } catch (exception) {
//         alert("Request failed. Please try again.");
//     }
// }

// function saveMultipleCourses() {
//     let csv = document.getElementById("course-upload-csv").files[0];
//     let formData = new FormData();
//     formData.append("file", csv);

//     try {
//         const syncRequest = new XMLHttpRequest();
//         syncRequest.open("POST", "./import_courses.php", false);
//         syncRequest.send(formData);

//         if (syncRequest.status === 200) {
//             let parser = new DOMParser();
//             let xmlDoc = parser.parseFromString(syncRequest.responseText, "text/xml");
//             let error_msgs = xmlDoc.getElementsByClassName("error");
            
//             // check if we received an error while trying to register
//             if (error_msgs.length > 0) {
//                 let error_div = document.getElementById("course-error-msg-cont");
//                 // append all error messages
//                 for (msg of error_msgs) {
//                     error_div.appendChild(msg);
//                 }
//             }
//             getCourses()
//         }
//     } catch (exception) {
//         console.log(exception);
//         alert("Request failed. Please try again.");
//     }
// }

// function getRemoveCourseInformation()
// {
//     const error_div = document.getElementById("course-error-msg-cont");
//     while (error_div.firstChild) {
//         error_div.removeChild(error_div.lastChild);
//     }
//     const formData = new FormData(document.getElementById('remove-course-form'));

//     let courseNumber = formData.get('course-code') + " "+ formData.get('crn-num');
//     let email = formData.get('crn-email')
//     let term = formData.get('crn-term')
//     let year = formData.get('crn-year')

//     removeCourse(courseNumber, email, term, year)
// }

// function saveCourse() {
//     // Clear error messages
//     const error_div = document.getElementById("course-error-msg-cont");
//     while (error_div.firstChild) {
//         error_div.removeChild(error_div.lastChild);
//     }

//     const formData = new FormData(document.getElementById("add-course-form"));
    
//     let courseNumber = formData.get('course-code') + " "+ formData.get('crn-number');
//     let name = formData.get('course-name')
//     let dscrpn = formData.get('crn-dscrpn')
//     let term = formData.get('crn-term')
//     let year = formData.get('crn-year')
//     let email = formData.get('crn-email')

//     try {
//         const syncRequest = new XMLHttpRequest();
//         syncRequest.open("POST", "./add_courses.php", false);
//         syncRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//         syncRequest.send(`sender=sysop&courseNumber=${courseNumber}&courseName=${name}&courseDescription=${dscrpn}&term=${term}&year=${year}&instrEmail=${email}`);

//         if (syncRequest.status === 200) {
//             let parser = new DOMParser();
//             let xmlDoc = parser.parseFromString(syncRequest.responseText, "text/xml");
//             let error_msgs = xmlDoc.getElementsByClassName("error");
            
//             // check if we received an error while trying to register
//             if (error_msgs.length > 0) {
//                 let error_div = document.getElementById("course-error-msg-cont");
//                 // append all error messages
//                 for (msg of error_msgs) {
//                     error_div.appendChild(msg);
//                 }
//             }
//             var courseform = document.getElementById("add-course-form");
//             courseform.reset();
//             getCourses();
//         }
//     } catch (exception) {
//         console.log(exception);
//         alert("Request failed. Please try again.");
//     }
// }

// function removeCourse(courseNumber, email, term, year) {
//     // Clear error messages

//     try {
//         const syncRequest = new XMLHttpRequest();
//         syncRequest.open("POST", "./remove_courses.php", false);
//         syncRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//         syncRequest.send(`sender=sysop&courseNumber=${courseNumber}&term=${term}&year=${year}&instrEmail=${email}`);

//         if (syncRequest.status === 200) {
//             let parser = new DOMParser();
//             let xmlDoc = parser.parseFromString(syncRequest.responseText, "text/xml");
//             let error_msgs = xmlDoc.getElementsByClassName("error");
            
//             // check if we received an error while trying to register
//             if (error_msgs.length > 0) {
//                 let error_div = document.getElementById("course-error-msg-cont");
//                 // append all error messages
//                 for (msg of error_msgs) {
//                     error_div.appendChild(msg);
//                 }
//             }
//             var courseform = document.getElementById("remove-course-form");
//             courseform.reset();
//             getCourses();
//         }
//     } catch (exception) {
//         console.log(exception);
//         alert("Request failed. Please try again.");
//     }
// }