

function getYears()
{
    try {
        const req = new XMLHttpRequest();
        req.open("GET", `./dashboard.php?action=getYears`, true);
        req.setRequestHeader('Content-Type', "application/x-www-form-urlencoded");
        req.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200)
            {
                populateCourseTable(req, 'year');
            }
        }
        req.send(null);
    }catch (exception)
    {
        alert ("Request failed. Please try again.");
    }
}

function populateCourseTable(request, tableName)
{
    let table = document.getElementById(tableName);
    table.innerHTML = request.responseText;
}


function showCourses(){
    var semester = document.getElementById("semester");
    semester.classList.remove('hide');
}

function getSemesters()
{

    try {
        const req = new XMLHttpRequest();
        req.open("GET", `./dashboard.php?action=getSemesters`, true);
        // console.log(req);
        req.setRequestHeader('Content-Type', "application/x-www-form-urlencoded");
        req.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200)
            {
                populateCourseTable(req, 'semester');
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
    const year = document.getElementById('year');
    const selectYear = year.options[year.selectedIndex].value;
    const term = document.getElementById('semester');
    const selectTerm = term.options[term.selectedIndex].value;

    try {
        const req = new XMLHttpRequest();
        req.open("GET", `./dashboard.php?action=getCourses&year=${selectYear}&term=${selectTerm}`, true);
        // console.log(req);
        req.setRequestHeader('Content-Type', "application/x-www-form-urlencoded");
        req.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200)
            {
                populateCourseTable(req, 'course');
            }
        }
        req.send(null);
    }catch (exception)
    {
        alert ("Request failed. Please try again.");
    }
}

function displayOptions(){

    const year = document.getElementById('year');
    const selectYear = year.options[year.selectedIndex].value;
    const term = document.getElementById('semester');
    const selectTerm = term.options[term.selectedIndex].value;
    const course = document.getElementById('course');
    const selectCourse = course.options[course.selectedIndex].value;

    try {
        const req = new XMLHttpRequest();
        req.open("GET", './userType.php', true);
        console.log(req);
        req.setRequestHeader('Content-Type', "application/x-www-form-urlencoded");
        req.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200)
            {
                showButtons(req, selectYear, selectTerm, selectCourse);
            }
        }
        req.send(null);
    }catch (exception)
    {
        alert ("Request failed. Please try again.");
    }
}


function showButtons(request, year, term, course)
{
    console.log(course);
    if (request.responseText == 'prof')
    {
        document.getElementById("courseForm").innerHTML = 
        '<div class="modal-header"><h3 class="modal-title">' + course + ' - '+ term + ' - ' + year + '</h3></div>' +
        '<div class="modal-body">' +
        'Select an Option:<br /><br />' +
            '<div id="prof-form-modal">' + 
                '<div class="form-group">' +
                '<button style="display: block;margin: 10px 0;padding: 10px;width: 100%;" class="btn btn-danger" data-dismiss="modal" onclick="window.location.href=\'channel.html?course=' + course + '&term=' + term + '&year=' + year + '\'"  type="button">Course Channel</button><br />' +
                '<button style="display: block;margin: 10px 0;padding: 10px;width: 100%;" class="btn btn-danger" data-dismiss="modal" onclick="window.location.href=\'evaluations.html?course=' + course + '&term=' + term + '&year=' + year + '&tab=ta-performance' + '\'"  type="button">TA Performance Log</button><br />' +
                '<button style="display: block;margin: 10px 0;padding: 10px;width: 100%;" class="btn btn-danger" data-dismiss="modal" onclick="window.location.href=\'evaluations.html?course=' + course + '&term=' + term + '&year=' + year + '&tab=ta-wishlist' + '\'" type="button">TA Wishlist</button><br />' +
                '<button style="display: block;margin: 10px 0;padding: 10px;width: 100%;" class="btn btn-danger" data-dismiss="modal" onclick="window.location.href=\'evaluations.html?course=' + course + '&term=' + term + '&year=' + year + '&tab=ta-edStats' + '\'" type="button">Ed Statistics</button><br />' +
                '<button style="display: block;margin: 10px 0;padding: 10px;width: 100%;" class="btn btn-danger" data-dismiss="modal" onclick="window.location.href=\'ta_report.html?course=' + course + '&term=' + term + '&year=' + year + '\'" type="button">Generate TA Report</button><br />' +
                '<button style="display: block;margin: 10px 0;padding: 10px;width: 100%;" class="btn btn-danger" data-dismiss="modal" onclick="window.location.href=\'oh.html?course=' + course + '&term=' + term + '&year=' + year + '\'" type="button">Office Hours Sheet</button>' +
                '</div>' +
            '</div>' + 
        '</div>'
        ;                            
        
    }
    else if (request.responseText == 'ta'){
        document.getElementById("courseForm").innerHTML = 
        '<div class="modal-header"><h3 class="modal-title">' + course + ' - '+ term + ' - ' + year + '</h3></div>' + 
        'Select an Option:<br /><br />' +
        '<div class="modal-body">' +
            '<div id="prof-form-modal">' +
                '<div class="form-group">' +
                '<button style="display: block;margin: 10px 0;padding: 10px;width: 100%;" class="btn btn-danger" data-dismiss="modal" onclick="window.location.href=\'channel.html?course=' + course + '&term=' + term + '&year=' + year + '\'" type="button">Course Channel</button>' +
                   '<button style="display: block;margin: 10px 0;padding: 10px;width: 100%;" class="btn btn-danger" data-dismiss="modal" onclick="window.location.href=\'oh.html?course=' + course + '&term=' + term + '&year=' + year + '\'" type="button">Office Hours Sheet</button>' +
                '</div>' +
            '</div>' +
        '</div>'
        ;
    }
    else{
        alert ("Request failed. Please try again.");
    }
}