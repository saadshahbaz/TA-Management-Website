// function to show courses based on attribute but also to make sure at least one type os selected
function coursesShow(){
    //var courses = document.getElementById("courses");
    var studentId = document.getElementById("studentId");
    var student = document.getElementById("student");
    var ta = document.getElementById("ta");
    var professor = document.getElementById("professor");
    var taadmin = document.getElementById("taadmin");
    var sysop = document.getElementById("sysop");
    console.log(studentId);
    //display studentId if student checked
    if(student.checked){
        studentId.classList.remove('hide');
        professor.removeAttribute("required");
        ta.removeAttribute("required");
        taadmin.removeAttribute("required");
        sysop.removeAttribute("required");
    }
    //display studentId if ta checked
    else if(ta.checked){
        studentId.classList.remove('hide');
        professor.removeAttribute("required");
        student.removeAttribute("required");
        taadmin.removeAttribute("required");
        sysop.removeAttribute("required");
    }
    else if (taadmin.checked){
        studentId.classList.add('hide');
        professor.removeAttribute("required");
        student.removeAttribute("required");
        ta.removeAttribute("required");
        sysop.removeAttribute("required");
    }
    else if (professor.checked){
        studentId.classList.add('hide');
        ta.removeAttribute("required");
        student.removeAttribute("required");
        taadmin.removeAttribute("required");
        sysop.removeAttribute("required");
    }
    //hide courses if student not checked
    else if (sysop.checked){
        studentId.classList.add('hide');
        professor.removeAttribute("required");
        student.removeAttribute("required");
        ta.removeAttribute("required");
        taadmin.removeAttribute("required");
    }
    else{
        studentId.classList.add('hide');
        professor.setAttribute("required", '');
        student.setAttribute("required", '');
        ta.setAttribute("required", '');
        taadmin.setAttribute("required", '');
        sysop.setAttribute("required", '');
    }
}

function showCourses(){
    var semester = document.getElementById("semester");
    semester.classList.remove('hide');
}

function getCourses()
{
    const year = document.getElementById('year');
    const selectYear = year.options[year.selectedIndex].value;
    const term = document.getElementById('semester');
    const selectTerm = term.options[term.selectedIndex].value;

    try {
        const req = new XMLHttpRequest();
        req.open("GET", `./registerCourses.php?action=getCourses&year=${selectYear}&term=${selectTerm}`, true);
        console.log(req);
        req.setRequestHeader('Content-Type', "application/x-www-form-urlencoded");
        req.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200)
            {
                populateCourseTable(req, 'course-select');
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

function getYears()
{
    try {
        const req = new XMLHttpRequest();
        req.open("GET", `./registerCourses.php?action=getYears`, true);
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

function sendRegisterRequest(){

    const formData = new FormData(document.getElementById('login-form'));
    

    console.log(formData.getAll('type[]'));
    let email = formData.get('email');
    let password = formData.get('password');
    let fname = formData.get('fname');
    let lname = formData.get('lname');
    let username = formData.get('username');
    let studentId = formData.get('studentId');
    let type = formData.getAll('type[]');
    let course = formData.getAll('course[]');
    

    try {
        const syncRequest = new XMLHttpRequest();
        syncRequest.open("POST", "register.php", false);
        syncRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        syncRequest.send(`email=${email}&password=${password}&fname=${fname}&lname=${lname}&username=${username}&studentId=${studentId}&type=${type}&course=${course}`);

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