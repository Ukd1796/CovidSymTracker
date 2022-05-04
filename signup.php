<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $showAlert = true;
    include 'partials/_dbconnect.php';
    $userName = $_POST['userName'];
    $userAge = $_POST['userAge'];
    $userSex = $_POST['userSex'];
    $userBg = $_POST['userBg'];
    $userHeight = $_POST['userHeight'];
    $userWeight = $_POST['userWeight'];
    $userDob = $_POST['userDob'];
    $userPass = $_POST['userPass'];
    $exists = false;
    if ($exists == false) {
        $sql = "INSERT INTO `userpatient` ( `PatientName`, `PatientAge`, `PatientSex`, `PatientBg`, `PatientHeight`, `PatientWeight`, `PatientDob`, `PatientPassword`) VALUES ( '$userName ', '$userAge', '$userSex', '$userBg', '$userHeight', '$userWeight', '$userDob', '$userPass')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $showAlert = false;
        }
    }
    if ($showAlert == false) {
        echo "success";
        header("location: index.php");
    } else {
        echo "there was an error while creating this account";
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Slide Navbar</title>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>

<style>
    body{
	margin: 0;
	padding: 0;
	display: flex;
	position: relative;
	left:-10px;
	justify-content: right;
	align-items: center;
	min-height: 100vh;
	font-family: 'Jost', sans-serif;
	background-color: #f2f4f7;
	background-image: url("./images/background.jpg");
	background-size: 60%;
    background-repeat: no-repeat; 
}

.left-container{

	z-index: 1;
  }
  .login-text-left {
  position: absolute;
  width: 716px;
  height: 250px;
  left: 112px;
  top: 200px;

  font-family: Gotham Pro;
  font-style: normal;
  font-weight: normal;
  font-size: 65px;
  line-height: 80px;
  /* or 123% */


  color: #FFFFFF;

}
.main{
	width: 650px;
	height: 730px;
	background: red;
	overflow: hidden;
	background-color: #f2f4f7;
	border-radius: 10px;
}
#chk{
	display: none;
}
.signup{
	position: relative;
	width:100%;
	height: 100%;
}
label{
	color: #000000;
	font-size: 2em;
	justify-content: center;
	display: flex;
	margin: 20px;
	font-weight: bold;
	cursor: pointer;
	transition: .5s ease-in-out;
}
input{
	width: 60%;
	height: 10px;
	background: #e0dede;
	justify-content: center;
	display: flex;
	margin: 20px auto;
	padding: 10px;
	border: none;
	outline: none;
	border-radius: 5px;
}
#text{
	color: white;
}
button{
	width: 60%;
	height: 40px;
	margin: 10px auto;
	justify-content: center;
	display: block;
	color: #fff;
	background: #000000;
	font-size: 1em;
	font-weight: bold;
	margin-top: 20px;
	outline: none;
	border: none;
	border-radius: 5px;
	transition: .2s ease-in;
	cursor: pointer;
}
button:hover{
	background: #000000;
}
.login{
	height: 460px;
	background: #eee;
	border-radius: 60% / 10%;
	transform: translateY(-180px);
	transition: .8s ease-in-out;
}
.login label{
	color: #000000;
	transform: scale(.6);
}

#chk:checked ~ .login{
	transform: translateY(-500px);
}
#chk:checked ~ .login label{
	transform: scale(1);	
}
#chk:checked ~ .signup label{
	transform: scale(.6);
}

input[type="radio"] {
	align-items: center;
  margin: 0 4px 8px 0;
  padding: 10px;
}
.form-check-input{
	display: inline;
	align-items: center;
	height: 20px;  
	width: 20px;  
	background-color: lightgray;  
	border-radius: 50%;  
}
.form-check-input #text{
	color: #fff;
}
</style>

<body>
        <div class="col-lg-6 login-left col-sm-12 col-md-12 left-container">
                <h1 class="login-text-left" style="font-size:5rem;">Covid-19 Symptom Tracker</h1>
            </div>

        <div class="col-lg-6 col-sm-12 col-md-12 right-container">
            <div class="main">
                <input type="checkbox" id="chk" aria-hidden="true">
                <div class="signup">
                    <form action="post" method="/signup.php">
                        <label for="chk" aria-hidden="true">Sign up</label>
                        <input type="text" name="userName" placeholder="Name" required style="height:2rem;">
                        <input type="number" name="userAge" placeholder="Age" required style="height:2rem;">
                        <center>
                        <input class="form-check-input" type="radio" name="userSex" id="flexRadioDefault1" required>Male
                        <input class="form-check-input" type="radio" name="userSex" id="flexRadioDefault2">Female
                        </center>
                        <input type="text" class="form-control form-entryD" id="inputBG" placeholder="Blood Group" name="userBg" style="height:2rem;" />
                        <input type="text" class="form-control form-entryE" id="inputH" placeholder="Height" name="userHeight" style="height:2rem;" />
                        <input type="text" class="form-control form-entryF" id="inputW" placeholder="Weight" name="userWeight" style="height:2rem;"/>
                        <input type="date" class="form-control form-entryG" id="inputDOB" placeholder="Date of Birth" name="userDob" style="height:2rem;" />
                        <input type="password" class="form-control form-entryH" id="inputDOB" placeholder="Password" name="userPass" style="height:2rem;"/>
                        <button style="height:3rem;">Sign up</button>
                        
                    </form>
                </div>
            </div>
        </div>
</body>

</html>