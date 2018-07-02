/* --------------- TOPNAVIGATION --------------------------------------------*/
function myFunction() {
  var x = document.getElementById('myNavbar');
  if (x.className === 'navbar') {
    x.className += ' responsive';
  } else {
    x.className = 'navbar';
  }
}

/* --------------- SIDENAVIGATION --------------------------------------------*/
function openNav() {
  document.getElementById("mySidenav").style.display = "block";
  document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.display = "none";
  document.getElementById("mySidenav").style.width = "0";
}

var main = document.getElementById("main");
var navbar = document.getElementById("myNavbar");

/* --------------- LOGIN MODAL --------------------------------------------*/
var modal = document.getElementById("id01");

	document.getElementById("defaultOpen").click();

	window.onclick = function(event) {
		if(event.target == modal) {
			modal.style.display = "none";
		}
    /*Close Sidebar when clicked outside*/
    if(event.target == main || event.target == navbar) {
      document.getElementById("mySidenav").style.display = "none";
      document.getElementById("mySidenav").style.width = "0";
      main.style.marginLeft= "0";
    }

    if(document.getElementById("mySidenav").style.display == "block" &&
       document.getElementsByClassName("loginBtn").onclick == true) {
         document.getElementById("mySidenav").style.display = "none";
         document.getElementById("mySidenav").style.width = "0";
         main.style.marginLeft= "0";
       }
	}

	function openLogin(evt, actionName) {
		var i, tabcontent, tablinks;
		tabcontent = document.getElementsByClassName("tabcontent");
		tablinks = document.getElementsByClassName("tablinks");

		for(i = 0; i < tabcontent.length; i++) {
			tabcontent[i].style.display = "none";
		}

		for(i = 0; i < tablinks.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" active", "");
		}

		document.getElementById(actionName).style.display = "block";
		evt.currentTarget.className += " active";
	}

  /* --------------- UPLOAD EVENT -----------------------------------------*/
  function addEvent() {
    var loungesNumber = document.getElementsByName('loungename').length;
    var loungesArray = [];
    for (var i = 0; i < loungesNumber; i++) {
      var n = i+1;
      var lname = document.getElementById('lounge'+n);
      var lnumber = lname.nextElementSibling;
      var ldesc = lnumber.nextElementSibling;
      var lounge = {loungeName: lname.value, loungeNumber: lnumber.value, loungeDescription: ldesc.value};
      loungesArray.push(lounge);
    }
  }

/* --------------- RESERVATION -----------------------------------------*/
  var reservationDiv = document.getElementById('ifReservationActive');
  var reservationButton = document.getElementById('reservationButton');

  function showReservation() {
      if (document.getElementById('resCheck').checked) {
        reservationDiv.style.display = 'block';
        reservationButton.style.display = 'block';
      } else {
        reservationDiv.style.display = 'none';
        reservationButton.style.display = 'none';
      }
  }

  function addLounge() {
    var checkIfHereInput = document.createElement('input');
    var input1 = document.createElement('input');
    var input2 = document.createElement('input');
    var input3 = document.createElement('input');
    var input4 = document.createElement('textarea');
    var remButton = document.createElement('input');

    checkIfHereInput.setAttribute('type', 'text');
    checkIfHereInput.setAttribute('name', 'checkIfHere');
    checkIfHereInput.setAttribute('style', 'display:none;');

    input1.setAttribute('type', 'text');
    input1.setAttribute('placeholder', 'Lounge name');
    input1.setAttribute('name', 'loungename[]');
    input1.setAttribute('required', 'true');

    input2.setAttribute('type', 'text');
    input2.setAttribute('placeholder', 'Number of People');
    input2.setAttribute('name', 'loungenumber[]');
    input2.setAttribute('required', 'true');

    input3.setAttribute('type', 'text');
    input3.setAttribute('placeholder', 'Minimum consumption');
    input3.setAttribute('name', 'loungeconsum[]');
    input3.setAttribute('step', 'any');
    input3.setAttribute('required', 'true');

    input4.setAttribute('rows', '4');
    input4.setAttribute('cols', '50');
    input4.setAttribute('placeholder', 'Description');
    input4.setAttribute('name', 'loungedescription[]');
    input4.setAttribute('style', 'margin-bottom:0;');
    input4.setAttribute('required', 'true');

    remButton.setAttribute('type', 'button');
    remButton.setAttribute('value', '-');
    remButton.setAttribute('class', 'removeLoungeButton');
    remButton.setAttribute('onclick', 'removeOtherLounge(this)');

    reservationDiv.appendChild(checkIfHereInput);
    reservationDiv.appendChild(input1);
    reservationDiv.appendChild(input2);
    reservationDiv.appendChild(input3);
    reservationDiv.appendChild(input4);
    reservationDiv.appendChild(remButton);
  }

  function removeFirstLounge(e) {
    var input4 = e.previousSibling.previousSibling;
    var input3 = input4.previousSibling.previousSibling;
    var input2 = input3.previousSibling.previousSibling;
    var input1 = input2.previousSibling.previousSibling;
    var checkIfHereInput = input1.previousSibling.previousSibling;


    reservationDiv.removeChild(checkIfHereInput);
    reservationDiv.removeChild(input1);
    reservationDiv.removeChild(input2);
    reservationDiv.removeChild(input3);
    reservationDiv.removeChild(input4);
    reservationDiv.removeChild(e);
    checkIfExists();
  }

  function removeOtherLounge(e) {
    var input4 = e.previousSibling;
    var input3 = input4.previousSibling;
    var input2 = input3.previousSibling;
    var input1 = input2.previousSibling;
    var checkIfHereInput = input1.previousSibling;

    reservationDiv.removeChild(checkIfHereInput);
    reservationDiv.removeChild(input1);
    reservationDiv.removeChild(input2);
    reservationDiv.removeChild(input3);
    reservationDiv.removeChild(input4);
    reservationDiv.removeChild(e);
    checkIfExists();
  }

  function checkIfExists() {
    var loungeFirst = document.getElementsByName('checkIfHere').length;
    var resCheckBox = document.getElementById('resCheck');
    if(loungeFirst < 1) {
      resCheck.checked = false;
      addLounge();
      showReservation();
    }
  }

  function reserveLounge() {

  }
