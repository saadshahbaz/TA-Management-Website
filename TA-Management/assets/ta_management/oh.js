//function to get course
function getCourse() {
  let urlString = window.location.href;
  let paramString = urlString.split("?")[1];
  let queryString = new URLSearchParams(paramString);
  var iter = queryString.entries();
  let courseNumber = iter.next().value[1];
  let term = iter.next().value[1];
  let year = iter.next().value[1];
  return [courseNumber, term, year];
}

function addOH(role) {
  const error_div = document.getElementById("ta-error-msg-cont");
  while (error_div.firstChild) {
    error_div.removeChild(error_div.lastChild);
  }

  if (role == "ta") {
    const formData = new FormData(
        document.querySelectorAll("[id='add-oh-form']")[0]
      );
    let email = formData.get("email");
    console.log(email);
    let location = formData.get("location");
    let day = formData.get("day");
    let start_time = formData.get("start_time");
    let end_time = formData.get("end_time");
    let position = "ta";
    let responsibilities = formData.get("responsibilities");
    let course = getCourse();
    try {
        const syncRequest = new XMLHttpRequest();
        syncRequest.open("POST", "./addOH.php", false);
        syncRequest.setRequestHeader(
          "Content-Type",
          "application/x-www-form-urlencoded"
        );
        syncRequest.send(
          `sender=oh&email=${email}&location=${location}&day=${day}&start_time=${start_time}&end_time=${end_time}&courseNumber=${course[0]}&term=${course[1]}&year=${course[2]}&position=${position}&responsibilities=${responsibilities}`
        );
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
          var ohform = document.getElementById("add-oh-form");
          ohform.reset();
    
          getOH();
        } else {
          alert("Request failed. Please try again.");
        }
      } catch (exception) {
        alert("Request failed. Please try again.");
      }
  } else {
    const formData = new FormData(
        document.querySelectorAll("[id='add-oh-form']")[1]
      );
    let email = formData.get("email");
    let location = formData.get("location");
    let day = formData.get("day");
    let start_time = formData.get("start_time");
    let end_time = formData.get("end_time");
    let position = "professor";
    let responsibilities = formData.get("responsibilities");
    let course = getCourse();
    try {
        const syncRequest = new XMLHttpRequest();
        syncRequest.open("POST", "./addOH.php", false);
        syncRequest.setRequestHeader(
          "Content-Type",
          "application/x-www-form-urlencoded"
        );
        syncRequest.send(
          `sender=oh&email=${email}&location=${location}&day=${day}&start_time=${start_time}&end_time=${end_time}&courseNumber=${course[0]}&term=${course[1]}&year=${course[2]}&position=${position}&responsibilities=${responsibilities}`
        );
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
          var ohform = document.getElementById("add-oh-form");
          ohform.reset();
    
          getOH();
        } else {
          alert("Request failed. Please try again.");
        }
      } catch (exception) {
        alert("Request failed. Please try again.");
      }
  }
}
function populateOHTable(request) {
  let table = document.getElementById("oh-table");
  table.innerHTML = request.responseText;
}

function getOH() {
  let course = getCourse()[0];
  let term = getCourse()[1];
  let year = getCourse()[2];
  try {
    const req = new XMLHttpRequest();
    req.open("GET", `./getOH.php?action=getOH&course=${course}&term=${term}&year=${year}`, true);
    req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    req.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        populateOHTable(req);
      }
    };
    req.send(null);
  } catch (exception) {
    alert("Request failed. Please try again.");
  }
}

function buttonInformationRemove(id) {
  let x = document.getElementById("myTable").rows[parseInt(id)];
  let email = x.cells[1].innerHTML;
  let location = x.cells[2].innerHTML;
  let day = x.cells[3].innerHTML;
  let start_time = x.cells[4].innerHTML;
  let end_time = x.cells[5].innerHTML;
  let position = x.cells[6].innerHTML;
  let responsibilities = x.cells[7].innerHTML;
  let courseNumber = getCourse()[0];
  let term = getCourse()[1];
  let year = getCourse()[2];

  let y = confirm("Are you sure you want to remove this OH?");

  if (y == true) {
    removeOH(
      email,
      location,
      day,
      start_time,
      end_time,
      courseNumber,
      term,
      year,
      position,
      responsibilities
    );
  } else {
    return;
  }
}

function removeOH(
  email,
  location,
  day,
  start_time,
  end_time,
  courseNumber,
  term,
  year,
    position,
    responsibilities
) {
  try {
    const syncRequest = new XMLHttpRequest();
    syncRequest.open("POST", "./removeOH.php", false);
    syncRequest.setRequestHeader(
      "Content-Type",
      "application/x-www-form-urlencoded"
    );
    syncRequest.send(
      `email=${email}&location=${location}&day=${day}&start_time=${start_time}&end_time=${end_time}&courseNumber=${courseNumber}&term=${term}&year=${year}&position=${position}&responsibilities=${responsibilities}`
    );
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
      getOH();
    } else {
      alert("Request failed. Please try again.");
    }
  } catch (exception) {
    alert("Request failed. Please try again.");
  }
}

//get ta based on course term and year
function getTA() {
  const course = getCourse()[0];
  const term = getCourse()[1];
  const year = getCourse()[2];

  try {
    const req = new XMLHttpRequest();
    req.open(
      "GET",
      `./getTAByCourse.php?action=getTA&year=${year}&term=${term}&course=${course}`,
      true
    );
    console.log(req);
    req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    req.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        populateTable(req, "ta");
      }
    };
    req.send(null);
  } catch (exception) {
    alert("Request failed. Please try again.");
  }
}

function populateTable(request, tableName) {
  let table = document.getElementById(tableName);
  table.innerHTML = request.responseText;
}

//get ta based on course term and year
function getProf() {
  const course = getCourse()[0];
  const term = getCourse()[1];
  const year = getCourse()[2];

  try {
    const req = new XMLHttpRequest();
    req.open(
      "GET",
      `./getProfByCourse.php?action=getProf&year=${year}&term=${term}&course=${course}`,
      true
    );
    console.log(req);
    req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    req.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        console.log(req);
        populateTable(req, "prof");
      }
    };
    req.send(null);
  } catch (exception) {
    alert("Request failed. Please try again.");
  }
}

function fillEmail(role) {
  const course = getCourse()[0];
  const term = getCourse()[1];
  const year = getCourse()[2];

  try {
    const req = new XMLHttpRequest();
    req.open(
      "GET",
      `./fillEmail.php?action=fillEmail&year=${year}&term=${term}&course=${course}&role=${role}`,
      true
    );
    console.log(req);
    req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    req.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        if (role == "ta") {
          populateEmailTableTa(req, "email");
        } else {
          populateEmailTableProf(req, "email");
        }
      }
    };
    req.send(null);
  } catch (exception) {
    alert("Request failed. Please try again.");
  }
}

function populateEmailTableTa(request, tableName) {
  var bothElements = document.querySelectorAll("[id='email']");
  let table = bothElements[0];
  table.innerHTML = request.responseText;
}
function populateEmailTableProf(request, tableName) {
  var bothElements = document.querySelectorAll("[id='email']");
  let table = bothElements[1];
  table.innerHTML = request.responseText;
}
