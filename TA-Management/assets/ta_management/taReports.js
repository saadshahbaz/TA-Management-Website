let global_course = "COMP 250";
let global_term = "Fall 2019";
let global_ter = "Fall";
let global_year = "2019";

function populateTaTableTAReport(request, tag_name)
{
    let table = document.getElementById(tag_name);
    table.innerHTML = request.responseText;
   // table.append(request.responseText);
}

function getTerm_Year()
{

    message = "<option value='' selected disabled>" + global_term + "</option>";
    console.log(message);
    let table = document.getElementById('term-year-report');
    table.innerHTML = message;
    // populateTaTableTAReport(message, 'term-year-report');
    

    // const selectedCourse = global_course;
    // try {
    //     const req = new XMLHttpRequest();
    //     req.open("GET", `./getValuesTAManagement.php?action=getTerms&course=${selectedCourse}`, true);
    //     req.setRequestHeader('Content-Type', "application/x-www-form-urlencoded");
    //     req.onreadystatechange = function() {
    //         if (this.readyState == 4 && this.status == 200)
    //         {
    //             populateTaTableTAReport(req, 'term-year-report');
    //         }
    //     }
    //     req.send(null);
    // }catch (exception)
    // {
    //     alert ("Request failed. Please try again.");
    // }
}

function getCourse(tag_name)
{
    let table = document.getElementById(tag_name);
    let value = "Report for " + global_course;
    table.innerHTML = value;

}

function getTAAnalysis() {
    try {
        const syncRequest = new XMLHttpRequest();
        syncRequest.open("POST", "./getSummaryByCourse.php", false);
        syncRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        syncRequest.send(`sender=ta_admin&course=${global_course}&term=${global_ter}&year=${global_year}`);
        console.log("Entered here");
        if (syncRequest.readyState == 4 && syncRequest.status == 200)
        {
            populateTaTableTAReport(syncRequest, 'ta-report');
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
    // const term = document.getElementById('term-year-report');
    // const selectTerm = term.options[term.selectedIndex].value;
    // global_term = selectTerm;
    // const array_term = selectTerm.split(" ");
    // const selectedTerm = array_term[0];
    // const selectedYear = array_term[1];

    // global_ter = selectedTerm;
    // global_year = selectedYear;

    try {
        const syncRequest = new XMLHttpRequest();
        syncRequest.open("POST", "./getCourseReport.php", false);
        syncRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        syncRequest.send(`sender=ta_admin&course=${global_course}&term=${global_ter}&year=${global_year}`)
        if (syncRequest.readyState == 4 && syncRequest.status == 200)
        {
            populateTaTableTAReport(syncRequest, 'ta-basic-report');
        }

        getTAAnalysis();
    }
    catch (exception) {
        alert("Request failed. Please try again.");
        
    }
}

function getCourses(){
    let urlString = window.location.href;
    let paramString = urlString.split('?')[1];
    let queryString = new URLSearchParams(paramString);
    var iter = queryString.entries();
    let courseNumber = iter.next().value[1];
    let term = iter.next().value[1];
    let year = iter.next().value[1];
    global_course = courseNumber;
    global_term = term + " " + year;
    global_ter = term;
    global_year = year;

    console.log(global_ter, global_year);


    return [courseNumber, term, year];
}