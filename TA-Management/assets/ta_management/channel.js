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

  function currentUser() 
  {
      try {
          const req = new XMLHttpRequest();
          req.open("GET", './currentUser.php', true);
          req.setRequestHeader('Content-Type', "application/x-www-form-urlencoded");
          req.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200)
              {
                  populateTable(req, 'user');
              }
          }
          req.send(null);
      }catch (exception)
      {
          alert ("Request failed. Please try again.");
      }
  }

  function populateTable(request, tableName) {
    let table = document.getElementById(tableName);
    table.innerHTML = request.responseText;
  }

  function getMessages(){
    let course = getCourse()[0];
    let term = getCourse()[1];
    let year = getCourse()[2];
    try {
        const req = new XMLHttpRequest();
        req.open("GET", `./getMessages.php?action=getMessages&course=${course}&term=${term}&year=${year}`, true);
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

function populateOHTable(request) {
    let table = document.getElementById("oh-table");
    table.innerHTML = request.responseText;
  }


  function sendMessage()
  {
      const error_div = document.getElementById("ta-error-msg-cont");
      while (error_div.firstChild) {
          error_div.removeChild(error_div.lastChild);
      }
      const formData = new FormData(document.getElementById('add-message-form'));
      let course = getCourse()[0];
      let term = getCourse()[1];
      let year = getCourse()[2];
      var currentdate = new Date();
      let time = currentdate.toLocaleDateString() + " " +  currentdate.toLocaleTimeString();
      let message = formData.get("message");
      let tag = formData.get("tag");

      
      try {
          const syncRequest = new XMLHttpRequest();
          syncRequest.open("POST", "./addMessage.php", false);
          syncRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          syncRequest.send(`sender=channel&course=${course}&term=${term}&year=${year}&time=${time}&message=${message}&tag=${tag}`)
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
          var form = document.getElementById("add-message-form");
          form.reset();
  
          getMessages();
            
      }else{
          alert("Fail to send message!");
      }
  } catch (exception) {
      alert("Request failed. Please try again.");
      
  }
  }
