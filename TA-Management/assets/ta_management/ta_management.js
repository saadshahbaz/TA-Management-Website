let global_term = "Fall 2019";
let global_course = "COMP 250";
let global_current_term = "Fall";
let global_current_year = "2019";
let current_table_value = "ta-wishlist";



function populateTaTable(request, tag_name)
{
    let table = document.getElementById(tag_name);
    table.innerHTML = request.responseText;
   // table.append(request.responseText);
}

function makeTabActive()
{
    let nav_name = ""; 
    let tab_name = "";

    if (current_table_value === "ta-performance"){
        nav_name = "nav-performance-tab";
        tab_name = "nav-performance";
    }else if (current_table_value === "ta-wishlist"){
        nav_name = "nav-wishlist-tab";
        tab_name = "nav-wishlist";
    }else if (current_table_value === "ta-edStats"){
        nav_name = "nav-ed-tab";
        tab_name = "nav-ed-stats";
    }

    let tab = document.getElementById(nav_name);
    tab.className += " active";

    let tab2 = document.getElementById(tab_name);
    tab2.className += " show active";
}


// function getTerm_Year()
// {
    

//     const selectedCourse = global_course;
//     try {
//         const req = new XMLHttpRequest();
//         req.open("GET", `./getValuesTAManagement.php?action=getTerms&course=${selectedCourse}`, true);
//         req.setRequestHeader('Content-Type', "application/x-www-form-urlencoded");
//         req.onreadystatechange = function() {
//             if (this.readyState == 4 && this.status == 200)
//             {
//                 populateTaTable(req, 'term-year-select');
//                 populateTaTable(req, 'term-year-select-performance');
//             }
//         }
//         req.send(null);
//     }catch (exception)
//     {
//         alert ("Request failed. Please try again.");
//     }
// }

function getTAs(ta_options)
{
    // console.log(ta_options, term_options);
    // let table = document.getElementById("ifuser");
    // const message = " ";
    // table.innerHTML = message;
    // const term = document.getElementById(term_options);
    // const selectTerm = term.options[term.selectedIndex].value;
    // // global_term = selectTerm;
    // const array_term = selectTerm.split(" ");
    // const selectedTerm = array_term[0];
    // const selectedYear = array_term[1];
    const selectedCourse = global_course;
    const selectedTerm = global_current_term;
    const selectedYear = global_current_year;
    try {
        const req = new XMLHttpRequest();
        req.open("GET", `./getValuesTAManagement.php?action=getTAs&term=${selectedTerm}&year=${selectedYear}&course=${selectedCourse}`, true);
        req.setRequestHeader('Content-Type', "application/x-www-form-urlencoded");
        // console.log(req);
        req.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200)
            {
                populateTaTable(req, ta_options);
            }
        }
        req.send(null);
    }catch (exception)
    {
        alert ("Request failed. Please try again.");
    }
}

function saveTaToWishList()
{
    const term = global_term;
    const ta_email = document.getElementById("ta-current-select").value;
    const course = global_course;

    console.log(ta_email, term);
    try {
        const syncRequest = new XMLHttpRequest();
        syncRequest.open("POST", "./addToWishList.php", false);
        syncRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        syncRequest.send(`sender=rating&email=${ta_email}&course=${course}&term=${term}`);
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

        let taform = document.getElementById("wishlistForm");
        taform.reset();
        let table = document.getElementById("wishlist-table");
        table.innerHTML = syncRequest.responseText;

    }else{
        // alert(ta_email + " already has been added to the wishlist!");
        let table = document.getElementById("ifuser");
        const message = ta_email + " already has been added to the wishlist!";
        table.innerHTML = message;
    }
} catch (exception) {
    console.log(exception);
    alert("Request failed. Please try again.");
    
}

}

function saveTAPerformanceLog()
{
    const term = global_term;
    const ta_email = document.getElementById("ta-current-select-performance").value;
    const course = global_course;
    const comment = document.getElementById("performace-msg").value;

    console.log(ta_email, term, comment);
    try {
        const syncRequest = new XMLHttpRequest();
        syncRequest.open("POST", "./addPerformanceLog.php", false);
        syncRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        syncRequest.send(`sender=rating&email=${ta_email}&course=${course}&term=${term}&comments=${comment}`);
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

        let taform = document.getElementById("performanceForm");
        taform.reset();
        let table = document.getElementById("performance-table");
        table.innerHTML = syncRequest.responseText;

    }else{
        // alert(ta_email + " already has been added to the wishlist!");
        let table = document.getElementById("ifuser");
        const message = ta_email + " already has been added to the wishlist!";
        table.innerHTML = message;
    }
} catch (exception) {
    console.log(exception);
    alert("Request failed. Please try again.");
    
}

}

function getEdStats()
{
    try {
        const req = new XMLHttpRequest();
        req.open("GET", './getEdStats.php', true);
        req.setRequestHeader('Content-Type', "application/x-www-form-urlencoded");
        req.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200)
            {
                populateTaTable(req, 'ed-table');
            }
        }
        req.send(null);
    }catch (exception)
    {
        alert ("Request failed. Please try again.");
    }
}

function importEdStats()
{
    let csv = document.getElementById("ta-cohort-upload-csv").files[0];
    let formData = new FormData();
    formData.append("file", csv);
    formData.append("course", global_course);
    formData.append("term", global_term);


    try {
        const syncRequest = new XMLHttpRequest();
        syncRequest.open("POST", "./import_ed_stats.php", false);
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

        }
        getEdStats();
    
    }catch (exception) {
        console.log(exception);
        alert("Request failed. Please try again.");
    }

    
}

function getCourse(){
    let urlString = window.location.href;
    let paramString = urlString.split('?')[1];
    let queryString = new URLSearchParams(paramString);
    var iter = queryString.entries();
    let courseNumber = iter.next().value[1];
    let term = iter.next().value[1];
    let year = iter.next().value[1];
    let tab = iter.next().value[1];
    console.log(tab);
    global_course = courseNumber;
    global_term = term + " " + year;
    global_current_term = term;
    global_current_year = year;
    current_table_value = tab;

    let pLog = document.getElementById("performance-log-selection");
    pLog.innerHTML = "Selected Course: " + courseNumber + " and Term: " + term + " " + year;

    //wishlist-log-selection

    let wLog = document.getElementById("wishlist-log-selection");
    wLog.innerHTML = "Selected Course: " + courseNumber + " and Term: " + term + " " + year;

    return [courseNumber, term, year];
}


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

                    getCourse();
                    makeTabActive();
                    // getTerm_Year();
                    getTAs('ta-current-select-performance');
                    getTAs('ta-current-select');
                    getEdStats();
                }
            }
        }
        req.send(null);
    }catch (exception)
    {
        alert ("Request failed. Please try again.");
    }
}


