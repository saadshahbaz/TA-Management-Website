function checkUser() 
{
    try {
        const req = new XMLHttpRequest();
        req.open("GET", './checkUser.php', true);
        req.setRequestHeader('Content-Type', "application/x-www-form-urlencoded");
        req.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200)
            {
                if(req.responseText === 'false')
                {
                    window.location.href = '../logout/logout.html';
                }else{
                    getProfAccounts();
                    getCourses();
                    getAccounts();
                }
            }
        }
        req.send(null);
    }catch (exception)
    {
        alert ("Request failed. Please try again.");
    }
}

// Manage Courses

function populateCourseTable(request) {
    let table = document.getElementById("course-table");
    table.innerHTML = request.responseText;
}

function getCourses() {
    try {
        const req = new XMLHttpRequest();
        req.open("GET", "./get_courses.php", true);
        req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        req.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                populateCourseTable(req);
            }
        }
        req.send(null);
    } catch (exception) {
        alert("Request failed. Please try again.");
    }
}

function saveMultipleCourses() {
    let csv = document.getElementById("course-upload-csv").files[0];
    let formData = new FormData();
    formData.append("file", csv);

    try {
        const syncRequest = new XMLHttpRequest();
        syncRequest.open("POST", "./import_courses.php", false);
        syncRequest.send(formData);

        if (syncRequest.status === 200) {
            let parser = new DOMParser();
            let xmlDoc = parser.parseFromString(syncRequest.responseText, "text/xml");
            let error_msgs = xmlDoc.getElementsByClassName("error");
            
            // check if we received an error while trying to register
            if (error_msgs.length > 0) {
                let error_div = document.getElementById("course-error-msg-cont");
                // append all error messages
                for (msg of error_msgs) {
                    error_div.appendChild(msg);
                }
            }
            getCourses()
        }
    } catch (exception) {
        console.log(exception);
        alert("Request failed. Please try again.");
    }
}

function getRemoveCourseInformation()
{
    const error_div = document.getElementById("course-error-msg-cont");
    while (error_div.firstChild) {
        error_div.removeChild(error_div.lastChild);
    }
    const formData = new FormData(document.getElementById('remove-course-form'));

    let courseNumber = formData.get('course-code') + " "+ formData.get('crn-num');
    let email = formData.get('crn-email')
    let term = formData.get('crn-term')
    let year = formData.get('crn-year')

    removeCourse(courseNumber, email, term, year)
}

function saveCourse() {
    // Clear error messages
    const error_div = document.getElementById("course-error-msg-cont");
    while (error_div.firstChild) {
        error_div.removeChild(error_div.lastChild);
    }

    const formData = new FormData(document.getElementById("add-course-form"));
    
    let courseNumber = formData.get('course-code') + " "+ formData.get('crn-number');
    let name = formData.get('course-name')
    let dscrpn = formData.get('crn-dscrpn')
    let term = formData.get('crn-term')
    let year = formData.get('crn-year')
    let email = formData.get('crn-email')


    try {
        const syncRequest = new XMLHttpRequest();
        syncRequest.open("POST", "./add_courses.php", false);
        syncRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        syncRequest.send(`sender=sysop&courseNumber=${courseNumber}&courseName=${name}&courseDescription=${dscrpn}&term=${term}&year=${year}&instrEmail=${email}`);

        if (syncRequest.status === 200) {
            let parser = new DOMParser();
            let xmlDoc = parser.parseFromString(syncRequest.responseText, "text/xml");
            let error_msgs = xmlDoc.getElementsByClassName("error");
            
            // check if we received an error while trying to register
            if (error_msgs.length > 0) {
                let error_div = document.getElementById("course-error-msg-cont");
                // append all error messages
                for (msg of error_msgs) {
                    error_div.appendChild(msg);
                }
            }
            var courseform = document.getElementById("add-course-form");
            courseform.reset();
            getCourses();
        }
    } catch (exception) {
        console.log(exception);
        alert("Request failed. Please try again.");
    }
}

function removeCourse(courseNumber, email, term, year) {
    // Clear error messages

    try {
        const syncRequest = new XMLHttpRequest();
        syncRequest.open("POST", "./remove_courses.php", false);
        syncRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        syncRequest.send(`sender=sysop&courseNumber=${courseNumber}&term=${term}&year=${year}&instrEmail=${email}`);

        if (syncRequest.status === 200) {
            let parser = new DOMParser();
            let xmlDoc = parser.parseFromString(syncRequest.responseText, "text/xml");
            let error_msgs = xmlDoc.getElementsByClassName("error");
            
            // check if we received an error while trying to register
            if (error_msgs.length > 0) {
                let error_div = document.getElementById("course-error-msg-cont");
                // append all error messages
                for (msg of error_msgs) {
                    error_div.appendChild(msg);
                }
            }
            var courseform = document.getElementById("remove-course-form");
            courseform.reset();
            getCourses();
        }
    } catch (exception) {
        console.log(exception);
        alert("Request failed. Please try again.");
    }
}

// Manage Professors

function populateProfTable(request) {
    let table = document.getElementById("profs-table");
    table.innerHTML = request.responseText;
}

function getProfAccounts() {
    try {
        const req = new XMLHttpRequest();
        req.open("GET", "./get_profs.php", true);
        req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        req.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                populateProfTable(req);
            }
        }
        req.send(null);
    } catch (exception) {
        alert("Request failed. Please try again.");
    }
}

function saveMultipleProfAccounts() {
    let csv = document.getElementById("prof-upload-csv").files[0];
    let formData = new FormData();
    formData.append("file", csv);

    console.log("exists");

    try {
        const syncRequest = new XMLHttpRequest();
        syncRequest.open("POST", "./import_profs.php", false);
        syncRequest.send(formData);

        if (syncRequest.status === 200) {
            let parser = new DOMParser();
            let xmlDoc = parser.parseFromString(syncRequest.responseText, "text/xml");
            let error_msgs = xmlDoc.getElementsByClassName("error");
            
            // check if we received an error while trying to register
            if (error_msgs.length > 0) {
                let error_div = document.getElementById("prof-error-msg-cont");
                // append all error messages
                for (msg of error_msgs) {
                    error_div.appendChild(msg);
                }
            }
            getProfAccounts();
        }
    } catch (exception) {
        console.log(exception);
        alert("Request failed. Please try again.");
    }
}

function saveProfAccount() {
    // Clear error messages
    const error_div = document.getElementById("prof-error-msg-cont");
    while (error_div.firstChild) {
        error_div.removeChild(error_div.lastChild);
    }

    const formData = new FormData(document.getElementById("add-profs-form"));
    let email = formData.get('inst-email');
    let faculty = formData.get('faculty');
    let department = formData.get('dept');
    let courseNumber = formData.get('course-code') + " "+ formData.get('crn-num');


    try {
        const syncRequest = new XMLHttpRequest();
        syncRequest.open("POST", "./add_profs.php", false);
        syncRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        syncRequest.send(`sender=sysop&professor=${email}&faculty=${faculty}&department=${department}&course=${courseNumber}`);

        if (syncRequest.status === 200) {
            let parser = new DOMParser();
            let xmlDoc = parser.parseFromString(syncRequest.responseText, "text/xml");
            let error_msgs = xmlDoc.getElementsByClassName("error");
            
            // check if we received an error while trying to register
            if (error_msgs.length > 0) {
                let error_div = document.getElementById("prof-error-msg-cont");
                // append all error messages
                for (msg of error_msgs) {
                    error_div.appendChild(msg);
                }
            }
            var profform = document.getElementById("add-profs-form");
            profform.reset();

        getProfAccounts();

        }
    } catch (exception) {
        console.log(exception);
        alert("Request failed. Please try again.");
    }
}

function getRemoveProfInformation()
{
    const error_div = document.getElementById("prof-error-msg-cont");
    while (error_div.firstChild) {
        error_div.removeChild(error_div.lastChild);
    }
    // now to add profs we first retrieve the entire Proffessors data
    const formData = new FormData(document.getElementById('remove-profs-form'));
    let email = formData.get('inst-email');
    let faculty = formData.get('faculty');
    let department = formData.get('dept');
    let courseNumber = formData.get('course-code') + " "+ formData.get('crn-num');

    removeProfessor(email, faculty, department, courseNumber);
}

function removeProfessor(email, faculty, department, courseNumber) {

    try {
        const syncRequest = new XMLHttpRequest();
        syncRequest.open("POST", "./remove_profs.php", false);
        syncRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        syncRequest.send(`sender=sysop&professor=${email}&faculty=${faculty}&department=${department}&course=${courseNumber}`);
    if (syncRequest.status === 200) {
        let parser = new DOMParser();
        let xmlDoc = parser.parseFromString(syncRequest.responseText, "text/xml");
        let error_msgs = xmlDoc.getElementsByClassName("error");
        
        // check if we received an error while trying to register
        if (error_msgs.length > 0) {
            let error_div = document.getElementById("prof-error-msg-cont");
            // append all error messages
            for (msg of error_msgs) {
                error_div.appendChild(msg);
            }
        }
        var profform = document.getElementById("remove-profs-form");
        profform.reset();
        getProfAccounts();
    }
} catch (exception) {
    alert("Request failed. Please try again.");
    
}
}

// MANAGE USERS

function populateUserTable(request) {
    let table = document.getElementById("user-table");
    table.innerHTML = request.responseText;
}

function getAccounts() {
    try {
        const req = new XMLHttpRequest();
        req.open("GET", "./get_users.php", true);
        req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        req.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                populateUserTable(req);
            }
        }
        req.send(null);
    } catch (exception) {
        alert("Request failed. Please try again.");
    }
}

function saveMultipleNewAccounts() {
    let csv = document.getElementById("user-upload-csv").files[0];
    let formData = new FormData();
    formData.append("file", csv);
    // command
    try {
        const syncRequest = new XMLHttpRequest();
        syncRequest.open("POST", "./import_users.php", false);
        syncRequest.send(formData);

        if (syncRequest.status === 200) {
            let parser = new DOMParser();
            let xmlDoc = parser.parseFromString(syncRequest.responseText, "text/xml");
            let error_msgs = xmlDoc.getElementsByClassName("error");
            
            // check if we received an error while trying to register
            if (error_msgs.length > 0) {
                let error_div = document.getElementById("error-msg-cont");
                // append all error messages
                for (msg of error_msgs) {
                    error_div.appendChild(msg);
                }
            }
            getAccounts();
        }
    } catch (exception) {
        console.log(exception);
        alert("Request failed. Please try again.");
    }
}

function getEditAccountInformation() {
    const error_div = document.getElementById("error-msg-cont");
    const formData = new FormData(document.getElementById("edit-user-form"));      
    
    let email = formData.get('email');
    let accounttypes = formData.get('to_add');

    editAccount(email, accounttypes)

}

function editAccount(email, accounttypes){
    const formData = new FormData(document.getElementById("edit-user-form"));  
    try {
        const syncRequest = new XMLHttpRequest();
        syncRequest.open("POST", "./edit_users.php", false);
        console.log(email, accounttypes, formData.get('studentId'), formData.get('fac'), formData.get('dep'));
        syncRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        syncRequest.send(`sender=sysop&email=${email}&accounttypes=${accounttypes}&studentId=${formData.get('studentId')}&fac=${formData.get('fac')}&dep=${formData.get('dep')}`);

    if (syncRequest.status === 200) {
        let parser = new DOMParser();
        let xmlDoc = parser.parseFromString(syncRequest.responseText, "text/xml");
        let error_msgs = xmlDoc.getElementsByClassName("error");
        
        // check if we received an error while trying to register
        if (error_msgs.length > 0) {
            let error_div = document.getElementById("user-error-msg-cont");
            // append all error messages
            for (msg of error_msgs) {
                error_div.appendChild(msg);
            }
        }
        var userform = document.getElementById("edit-user-form");
        userform.reset();
        getAccounts();
    }
} catch (exception) {
    alert("Request failed. Please try again.");
}
}

function saveNewAccount() {
    // Clear error messages
    const error_div = document.getElementById("error-msg-cont");
    //while (error_div.firstChild) {
    //    error_div.removeChild(error_div.lastChild);
    //}

    const formData = new FormData(document.getElementById("add-user-form"));
      
    userRoles = ["student", "professor", "ta", "admin", "sysop"];
    selectedRoles = [];
    for (var pair of formData.entries()) {
        if (userRoles.includes(pair[0])) {
            selectedRoles.push(userRoles.indexOf(pair[1])+1);
        }
    }

    try {
        const syncRequest = new XMLHttpRequest();
        syncRequest.open("POST", "./add_users.php", false);
        syncRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        syncRequest.send(`sender=sysop&password=${formData.get('pwd')}&firstname=${formData.get('first-name')}&lastname=${formData.get('last-name')}&usernamezort=${formData.get('usernamezort')}&studentId=${formData.get('studentId')}&fac=${formData.get('fac')}&dep=${formData.get('dep')}&email=${formData.get('email')}&accounttypes=${JSON.stringify(selectedRoles)}`);
        if (syncRequest.status === 200) {
            let parser = new DOMParser();
            let xmlDoc = parser.parseFromString(syncRequest.responseText, "text/xml");
            let error_msgs = xmlDoc.getElementsByClassName("error");
            
            // check if we received an error while trying to register
            if (error_msgs.length > 0) {
                let error_div = document.getElementById("error-msg-cont");
                // append all error messages
                for (msg of error_msgs) {
                    error_div.appendChild(msg);
                }
            }
            var userform = document.getElementById("add-user-form");
            userform.reset();
            getAccounts();
        }
    } catch (exception) {
        console.log(exception);
        alert("Request failed. Please try again.");
    }
}

function getRemoveAccountInformation()
{
    const error_div = document.getElementById("user-error-msg-cont");
    while (error_div.firstChild) {
        error_div.removeChild(error_div.lastChild);
    }
    const formData = new FormData(document.getElementById('remove-user-form'));
      
    
    let email = formData.get('email');
    let accounttypes = formData.get('to_remove');

    removeAccount(email, accounttypes);
    
}

function removeAccount(email, accounttypes) {
    try {
        const syncRequest = new XMLHttpRequest();
        syncRequest.open("POST", "./remove_users.php", false);
        syncRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        syncRequest.send(`sender=sysop&email=${email}&accounttypes=${accounttypes}`);
    if (syncRequest.status === 200) {
        let parser = new DOMParser();
        let xmlDoc = parser.parseFromString(syncRequest.responseText, "text/xml");
        let error_msgs = xmlDoc.getElementsByClassName("error");
        
        // check if we received an error while trying to register
        if (error_msgs.length > 0) {
            let error_div = document.getElementById("user-error-msg-cont");
            // append all error messages
            for (msg of error_msgs) {
                error_div.appendChild(msg);
            }
        }
        var userform = document.getElementById("remove-user-form");
        userform.reset();
        getAccounts();
    }
} catch (exception) {
    alert("Request failed. Please try again.");
    
}
}

function showStudentID(){
    //var courses = document.getElementById("courses");
    var studentId = document.getElementById("studentId");
    var student = document.getElementById("student");
    var ta = document.getElementById("ta");
    var professor = document.getElementById("professor");
    var taadmin = document.getElementById("admin");
    var sysop = document.getElementById("sysop");
    // document.getElementById("studentId2").style.display = 'block';
    //display studentId if student checked
    if(student.checked){
        studentId.classList.remove('hide');
    }
    //display studentId if ta checked
    else if(ta.checked){
        studentId.classList.remove('hide');
    }
    else if (taadmin.checked){
        studentId.classList.add('hide');
    }
    else if (professor.checked){
        studentId.classList.add('hide');
    }
    //hide courses if student not checked
    else if (sysop.checked){
        studentId.classList.add('hide');
    }
    else{
        studentId.classList.add('hide');
    }
}

function showFacDep(){
    var student = document.getElementById("student");
    var ta = document.getElementById("ta");
    var professor = document.getElementById("professor");
    var taadmin = document.getElementById("admin");
    var sysop = document.getElementById("sysop");
    var fac = document.getElementById("fac");
    var dep = document.getElementById("dep");
    if(professor.checked){
        fac.classList.remove('hide');
        dep.classList.remove('hide');
    }
    //display studentId if ta checked
    else if(ta.checked){
        fac.classList.add('hide');
        dep.classList.add('hide');
    }
    else if (taadmin.checked){
        fac.classList.add('hide');
        dep.classList.add('hide');
    }
    else if (student.checked){
        fac.classList.add('hide');
        dep.classList.add('hide');
    }
    //hide courses if student not checked
    else if (sysop.checked){
        fac.classList.add('hide');
        dep.classList.add('hide');
    }
    else{
        fac.classList.add('hide');
        dep.classList.add('hide');
    }
}

function betterFunc(){
    var student = document.getElementById("student2");
    var ta = document.getElementById("ta2");
    var professor = document.getElementById("prof2");
    var taadmin = document.getElementById("admin2");
    var sysop = document.getElementById("sysop2");
    var fac = document.getElementById("fac2");
    var dep = document.getElementById("dep2");
    var studentId = document.getElementById("studentId2");
    if(professor.checked){
        fac.classList.remove('hide');
        dep.classList.remove('hide');
        studentId.classList.add('hide');
    }
    //display studentId if ta checked
    else if(ta.checked){
        fac.classList.add('hide');
        dep.classList.add('hide');
        studentId.classList.remove('hide');
    }
    else if (taadmin.checked){
        fac.classList.add('hide');
        dep.classList.add('hide');
        studentId.classList.add('hide');
    }
    else if (student.checked){
        fac.classList.add('hide');
        dep.classList.add('hide');
        studentId.classList.remove('hide');
    }
    //hide courses if student not checked
    else if (sysop.checked){
        fac.classList.add('hide');
        dep.classList.add('hide');
        studentId.classList.add('hide');
    }
    else{
        fac.classList.add('hide');
        dep.classList.add('hide');
        studentId.classList.add('hide');
    }
}