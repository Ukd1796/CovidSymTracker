<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true)
{
  header("location: index.php");
  exit;
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    include 'partials/_dbconnect.php';
    $bodyTemp = $_POST['bodyTemp']; 
    $oxgLvl = $_POST['oxgLvl']; 
    $userCough = $_POST['cough']; 
    $userFatigue = $_POST['fatigue']; 
    $userSmell = $_POST['smell']; 
    $userTaste = $_POST['taste'];
    $otherSymp = $_POST['otherSym']; 
    $patId = $_SESSION['patientId'];
    $exists = false;
     if($exists==false)
     {
        $sql2 = "INSERT INTO `dailysymptoms` (`PatientId`, `CurrentDate`, `BodyTemp`, `oxySaturation`, `Cough`, `Fatigue`, `LossSmell`, `LossTaste`, `OtherSym`) VALUES ('$patId', current_timestamp(), '$bodyTemp', '$oxgLvl', '$userCough', '$userFatigue', '$userSmell', '$userTaste', '$otherSymp')";
        $result2 = mysqli_query($conn,$sql2);
        if($result2)
        {
            header("location:patient_landing.php");
        }
        else
        {
             die(mysqli_error($conn));
        }
     }
}
?>
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<style>
* {
  box-sizing: border-box;
}

body {
  background-color: #112B3C;
}

#regForm {
  margin: 100px auto;
  font-family:  "Times New Roman", Times, serif;
  padding-left: 30px;
  padding-right: 30px;
  padding-bottom: 20px;
  width: 70%;
  min-width: 300px;
  height:600px;
  background: rgba(255,255,255,0.05);
    backdrop-filter: blur(10px);
    border-top: 1px solid rgba(255,255,255,0.2);
    border-left: 1px solid rgba(255,255,255,0.2);
    box-shadow: 5px 5px 30px rgba(0,0,0,0.2);
  border-radius: 3px;
}

h1 {
  text-align: center;  
  font-size: 50px;
}

input {
  padding: 10px;
  width: 100%;
  font-size: 25px;
  font-family: "Times New Roman", Times, serif;
  border: 1px solid #aaaaaa;
}
textarea{
  width: 100%;
  height: 150px;
}

/* Mark input boxes that gets an error on validation: */
input.invalid {
  background-color: #ffdddd;
}

/* Hide all steps by default: */
.tab {
  display: none;
  width:100%;
  font-size: 40px;
}


label {
  display:contents;
  cursor: pointer;
  font-weight: 500;
  position: relative;
  overflow: hidden;
  margin-bottom: 0.375em;
}
label input {
  position: absolute;
  visibility: hidden;
}
label input:checked + span {
  background-color: #d6d6e5;
}
label input:checked + span:before {
  box-shadow: inset 0 0 0 0.4375em #00005c;
}
label span {
  display: flex;
  align-items: left;
  padding: 0.375em 0.75em 0.375em 0.375em;
  border-radius: 99em;
  transition: 0.25s ease;
  background-color: #daeef5;
}
label span:hover {
  background-color: #d6d6e5;
}
label span:before {
  display: flex;
  flex-shrink: 0;
  background-color: #fff;
  width: 1.5em;
  height: 1.5em;
  border-radius: 50%;
  margin-right: 0.375em;
  transition: 0.25s ease;
  box-shadow: inset 0 0 0 0.125em #00005c;
}

button {
  background-color: #012b39;
  color: #ffffff;
  border: none;
  padding: 10px 20px;
  font-size: 17px;
  font-family: "Times New Roman", Times, serif;
  cursor: pointer;
}

button:hover {
  opacity: 0.8;
}

#prevBtn {
  background-color: #bbbbbb;
}

/* Make circles that indicate the steps of the form: */
.step {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbbbbb;
  border: none;  
  border-radius: 50%;
  display: inline-block;
  opacity: 0.5;
}

.step.active {
  opacity: 1;
}

/* Mark the steps that are finished and valid: */
.step.finish {
  background-color: #012b39;
}

</style>

<body style="background-color: #112B3C; position:relative;left:50px;overflow-x:hidden;">
<div class="container" > 
<form id="regForm" action="/covidSym2/symptoms.php" method="post" style="background-color:#ffff">
  <h1>Daily Symptoms</h1>
  <!-- One "tab" for each step in the form: -->
  <div class="tab">Enter Details:
    <p><input placeholder="Body Temperature" oninput="this.className = ''" name="bodyTemp"></p>
    <p><input placeholder="Oxygen Saturation" oninput="this.className = ''" name="oxgLvl"></p>
    <div style="overflow:auto;">
    <div style="float:right;">
      <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
      <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
    </div>
  </div>
  </div>
  <div class="tab">Do you have cough?<br/><br/>
  <label><nobr><input type="radio" name="cough" value="Yes" id="coughYes"checked><span>Yes</span></nobr></label><br/>
  <label><nobr><input type="radio" name="cough" value="No" id="coughNo"><span>No</span></nobr></label><br/>
  <div style="overflow:auto;">
    <div style="float:right;">
      <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
      <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
    </div>
  </div>
  </div>
  <div class="tab">Do you have any symptoms of fatigue?<br/><br/>
  <label><nobr><input type="radio" name="fatigue" value="Yes" id="fatigueYes" checked><span>Yes</span></nobr></label><br/>
  <label><nobr><input type="radio" name="fatigue" value="No" id="fatigueNo"><span>No</span></nobr></label><br/>
  <div style="overflow:auto;">
    <div style="float:right;">
      <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
      <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
    </div>
  </div>
  </div>
  <div class="tab">Do you have loss of smell?<br/><br/>
  <label><nobr><input type="radio" name="smell" value="Yes" id="smellYes"  checked><span>Yes</span></nobr></label><br/>
  <label><nobr><input type="radio" name="smell" value="No" id="smellNo"><span>No</span></nobr></label><br/>
  <div style="overflow:auto;">
    <div style="float:right;">
      <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
      <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
    </div>
  </div>
  </div>
  <div class="tab">Do you have loss of taste?<br/><br/>
  <label><nobr><input  type="radio" name="taste" value="Yes" id="tasteYes"  checked><span>Yes</span></nobr></label><br/>
  <label><nobr><input type="radio" name="taste" value="No" id="tasteNo"><span>No</span></nobr></label><br/>
  <div style="overflow:auto;">
    <div style="float:right;">
      <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
      <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
    </div>
  </div>
  </div>
  <div class="tab">Any other symptoms?
  <p><textarea name="otherSym" value="Yes" id="other"></textarea></p>
   <input type="Submit" style="background-color:#00005c; position:relative;color:white;">
  </div>
  <div style="text-align:center;margin-top:40px;">
    <span class="step"></span>
    <span class="step"></span>
    <span class="step"></span>
    <span class="step"></span>
    <span class="step"></span>
  </div>
</form>
</div>

</body>
<script>
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  //... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  //... and run a function that will display the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form...
  if (currentTab >= x.length) {
    // ... the form gets submitted:
    document.getElementById("regForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class on the current step:
  x[n].className += " active";
}
</script>

</html>
