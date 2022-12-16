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
                    getTaAccounts();
                }
            }
        }
        req.send(null);
    }catch (exception)
    {
        alert ("Request failed. Please try again.");
    }
}


function populateTaTable(request)
{
    let table = document.getElementById('ta-table');
   // table.append(request.responseText);
    table.innerHTML = request.responseText;
}

function getTaAccounts() 
{
    try {
        const req = new XMLHttpRequest();
        req.open("GET", './get_TAs.php', true);
        req.setRequestHeader('Content-Type', "application/x-www-form-urlencoded");
        req.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200)
            {
                populateTaTable(req);
            }
        }
        req.send(null);
    }catch (exception)
    {
        alert ("Request failed. Please try again.");
    }
}
function populateTaTable2(request, table_name)
{
    let table = document.getElementById(table_name);
    table.innerHTML = request.responseText;
}

function getTaByCourseAccounts() 
{
    const formData = new FormData(document.getElementById('get-ta-by-course'));
    let course_code = formData.get('course-code');
    let all_course = course_code + " " + formData.get('crn-num');
    let year = formData.get('years');
    let term = formData.get('term');

    console.log(term);

    try {
        const syncRequest = new XMLHttpRequest();
        syncRequest.open("POST", "./get_ta_by_course.php", false);
        syncRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        syncRequest.send(`sender=ta_admin&course=${all_course}&year=${year}&term=${term}`)
        if (syncRequest.readyState == 4 && syncRequest.status == 200)
        {
            populateTaTable2(syncRequest, 'ta-course-table');
        }
    }
    catch (exception) {
        alert("Request failed. Please try again.");
        
    }
}



function addTAInformation()
{
        // Clear error messages
    const error_div = document.getElementById("ta-error-msg-cont");
    while (error_div.firstChild) {
        error_div.removeChild(error_div.lastChild);
    }
    // now to add profs we first retrieve the entire Proffessors data
    const formData = new FormData(document.getElementById('add-ta-form'));
    let email = formData.get('ta-email').toLowerCase();
    let student_id = formData.get('ta-student-id');
    let name = formData.get('ta-name');
    let hours = formData.get('hours');
    let courseNumber =  formData.get('crn-num').toUpperCase();
    let term = formData.get('term');
    let year = formData.get('year');
    
    // document.getElementById("add-ta-form").reset();
    try {
        const syncRequest = new XMLHttpRequest();
        syncRequest.open("POST", "./add_newTA.php", false);
        syncRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        syncRequest.send(`sender=ta_admin&email=${email}&student_id=${student_id}&assigned_hours=${hours}&name=${name}&course=${courseNumber}&term=${term}&year=${year}`)
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
        var taform = document.getElementById("add-ta-form");
        taform.reset();

        getTaAccounts();
        populateTaTable2(syncRequest, 'output_add');
        

    }else{
        alert(name + " with McGill ID: " + student_id + " and email: " + email + " already exist for " + courseNumber + " in " + term + " " + year + "!");
    }
} catch (exception) {
    alert("Request failed. Please try again.");
    
}
    // send the data to php
}

function getRemoveTAInformation()
{
    const error_div = document.getElementById("ta-error-msg-cont");
    while (error_div.firstChild) {
        error_div.removeChild(error_div.lastChild);
    }
    // now to add profs we first retrieve the entire Proffessors data
    const formData = new FormData(document.getElementById('remove-ta-form'));
    let email = formData.get('ta-email').toLowerCase();
    let student_id = formData.get('ta-student-id');
    let name = formData.get('ta-name');
    let courseNumber =  formData.get('crn-num');
    let term = formData.get('term');
    let year = formData.get('year');

    removeTA(email, student_id, name, courseNumber, term, year);
}

function removeTA(email, student_id, name, courseNumber, term, year) {
    // const error_div = document.getElementById("ta-error-msg-cont");
    // while (error_div.firstChild) {
    //     error_div.removeChild(error_div.lastChild);
    // }
    // // now to add profs we first retrieve the entire Proffessors data
    // const formData = new FormData(document.getElementById('remove-ta-form'));
    // let email = formData.get('ta-email');
    // let student_id = formData.get('ta-student-id');
    // let name = formData.get('ta-name');
    // let courseNumber =  formData.get('crn-num');
    // let term = formData.get('term');
    // let year = formData.get('year');

    // document.getElementById("remove-ta-form").reset();

    try {
        const syncRequest = new XMLHttpRequest();
        syncRequest.open("POST", "./remove_ta.php", false);
        syncRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        syncRequest.send(`sender=ta_admin&email=${email}&student_id=${student_id}&name=${name}&course=${courseNumber}&term=${term}&year=${year}`)
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
        var taform = document.getElementById("remove-ta-form");
        taform.reset();
        getTaAccounts();
        populateTaTable2(syncRequest, 'output_add');
    }
} catch (exception) {
    alert("Request failed. Please try again.");
    
}
}

function ta_quota(formData2) 
{
    try {
        const syncRequest = new XMLHttpRequest();
        syncRequest.open("POST", "./import_ta_quota.php", false);
        syncRequest.send(formData2);

        if (syncRequest.status === 200) {
            let parser = new DOMParser();
            let xmlDoc = parser.parseFromString(syncRequest.responseText, "text/xml");
            let error_msgs = xmlDoc.getElementsByClassName("error");
            
            // check if we received an error while trying to register
        }
    
    }catch (exception) {
        console.log(exception);
        alert("Request failed. Please try again IN quota");
    }
}

function importMultipleTAs()
{
    let csv = document.getElementById("ta-cohort-upload-csv").files[0];
    let formData = new FormData();
    formData.append("file", csv);

    let csv2 = document.getElementById("ta-quota-upload-csv").files[0];
    let formData2 = new FormData();
    formData2.append("file", csv2);

    console.log("exists");

    try {
        const syncRequest = new XMLHttpRequest();
        syncRequest.open("POST", "./import_ta_cohort.php", false);
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
            
            ta_quota(formData2);

        }
    
    }catch (exception) {
        console.log(exception);
        alert("Request failed. Please try again.");
    }

    
}

function getTAAnalysis(id, email) {
    // const formData = new FormData(document.getElementById('get-ta-report'));
    // let id = formData.get('id-num');
    // let email = formData.get('email-ta-report');



    console.log("This is the ID " + id + " and the email is: " + email);

    try {
        const syncRequest = new XMLHttpRequest();
        syncRequest.open("POST", "./get_fullta_summary.php", false);
        syncRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        syncRequest.send(`sender=ta_admin&student_id=${id}&email=${email}`)
        if (syncRequest.readyState == 4 && syncRequest.status == 200)
        {
            populateTaTable2(syncRequest, 'ta-report');
        }
    }
    catch (exception) {
        alert("Request failed. Please try again.");
        
    }
}

function getTAReports() 
{

    // We can give a summary of these which means having two features
    // report of one line getting the total courses they have taught
    // [TA EMAIL, STUDENT_ID, COURSES TAUGHT, TA_THIS_YEAR, AVERAGE RATING, ]
    const formData = new FormData(document.getElementById('get-ta-report'));
    let id = formData.get('id-num');
    let email = formData.get('email-ta-report').toLowerCase();;

    console.log("This is the ID" + id + " and the email is: " + email);

    try {
        const syncRequest = new XMLHttpRequest();
        syncRequest.open("POST", "./getTAReport.php", false);
        syncRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        syncRequest.send(`sender=ta_admin&student_id=${id}&email=${email}`)
        if (syncRequest.readyState == 4 && syncRequest.status == 200)
        {
            populateTaTable2(syncRequest, 'ta-basic-report');
        }

        getTAAnalysis(id, email);
    }
    catch (exception) {
        alert("Request failed. Please try again.");
        
    }
}

function buttonInformationRemove(id)
{
    console.log(id);
    let x = document.getElementById("myTable").rows[parseInt(id)]
    let email = x.cells[0].innerHTML;
    let student_id = x.cells[1].innerHTML;
    let ta_name = x.cells[2].innerHTML;
    let course = x.cells[3].innerHTML;
    let term = x.cells[4].innerHTML;
    let year = x.cells[5].innerHTML;
    
    let y = confirm("Are you sure you want to remove \nName: " + ta_name + " \nStudent ID: " + student_id + " \nEmail: " + email +"\nCourse Number: " + course + " \nTerm: " + term + " \nYear: " + year);

    if (y == true) {
        removeTA(email, student_id, ta_name, course, term, year);
    }else{
        return;
    }
}