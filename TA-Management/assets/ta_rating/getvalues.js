let global_year = "2019";
let global_term = "Fall";
let global_course = "COMP 250";
let global_ta = "John Doe";

function populateTaTable(request, tag_name)
{
    let table = document.getElementById(tag_name);
    table.innerHTML = request.responseText;
   // table.append(request.responseText);
}



function getYear()
{
    try {
        const req = new XMLHttpRequest();
        req.open("GET", './getValues.php?action=getYear', true);
        req.setRequestHeader('Content-Type', "application/x-www-form-urlencoded");
        // console.log(req);
        req.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200)
            {
                populateTaTable(req, 'year-select');
            }
        }
        req.send(null);
    }catch (exception)
    {
        alert ("Request failed. Please try again.");
    }
}

function getTerms()
{
    const year = document.getElementById('year-select');
    const selectedYear = year.options[year.selectedIndex].value;
    global_year = selectedYear;
    try {
        const req = new XMLHttpRequest();
        req.open("GET", `./getValues.php?action=getTerms&year=${selectedYear}`, true);
        req.setRequestHeader('Content-Type', "application/x-www-form-urlencoded");
        // console.log(req);
        req.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200)
            {
                populateTaTable(req, 'term-select');
            }
        }
        req.send(null);
    }catch (exception)
    {
        alert ("Request failed. Please try again.");
    }
}

function getCourses()
{
    const term = document.getElementById('term-select');
    const selectTerm = term.options[term.selectedIndex].value;
    global_term = selectTerm;
    // const year = document.getElementById('year-select');
    // const selectedYear = year.options[term.selectedIndex].value;
    const selectedYear = global_year;
    //console.log(selected_year_for_value);
    
    try {
        const req = new XMLHttpRequest();
        req.open("GET", `./getValues.php?action=getCourses&year=${selectedYear}&term=${selectTerm}`, true);
        req.setRequestHeader('Content-Type', "application/x-www-form-urlencoded");
        // console.log(req);
        req.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200)
            {
                populateTaTable(req, 'course-select');
            }
        }
        req.send(null);
    }catch (exception)
    {
        alert ("Request failed. Please try again.");
    }
}

function getTAs()
{
    // const term = document.getElementById('term-select');
    const selectTerm = global_term;
    // const year = document.getElementById('year-select');
    const selectedYear = global_year;
    const course = document.getElementById('course-select');
    const selectedCourse = course.options[course.selectedIndex].value;
    global_course = selectedCourse;

    console.log(global_course, global_term, global_year);
    try {
        const req = new XMLHttpRequest();
        req.open("GET", `./getValues.php?action=getTAs&year=${selectedYear}&term=${selectTerm}&course=${selectedCourse}`, true);
        req.setRequestHeader('Content-Type', "application/x-www-form-urlencoded");
        // console.log(req);
        req.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200)
            {
                populateTaTable(req, 'ta-select');
            }
        }
        req.send(null);
    }catch (exception)
    {
        alert ("Request failed. Please try again.");
    }
}

function markStar(starNum) {
    for (i=1; i<6; i++) {
        let star = document.getElementById(`star-${i}`);

        if (i <= starNum) {
            star.style.color = 'rgb(237, 27, 47)';
        } else {
            star.style.color = 'black';
        }
    }
}

function getRating() {
    let rating = 1;

    for (i=1; i<6; i++) {
        let star = document.getElementById(`star-${i}`);
        if (star.style.color === 'rgb(237, 27, 47)') {
            rating = i;
        } 
    }

    return rating;
}

function getFeedbackFromValue() {
    const ta_email = document.getElementById("ta-select").value;
    const course = global_course;
    const term = global_term;
    const year = global_year;
    const rating = getRating();
    const comment = document.getElementById("feedback-msg").value;

    try {
        const syncRequest = new XMLHttpRequest();
        syncRequest.open("POST", "./addFeedback.php", false);
        syncRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        syncRequest.send(`sender=rating&ta_email=${ta_email}&course=${course}&rating=${rating}&comment=${comment}&term=${term}&year=${year}`);
    if (syncRequest.status === 200) {
        let parser = new DOMParser();
        let xmlDoc = parser.parseFromString(syncRequest.responseText, "text/xml");
        console.log(syncRequest.responseText);
        let error_msgs = xmlDoc.getElementsByClassName("error");
        
        // check if we received an error while trying to register
        if (error_msgs.length > 0) {
            let error_div = document.getElementById("error-msg-cont");
            // append all error messages
            for (msg of error_msgs) {
                error_div.appendChild(msg);
            }
        }

        let taform = document.getElementById("taform");
        taform.reset();
        let table = document.getElementById("ta-table");
        table.innerHTML = syncRequest.responseText;

    }
} catch (exception) {
    console.log(exception);
    alert("Request failed. Please try again.");
    
}
}

