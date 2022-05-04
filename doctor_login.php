<?php
$login = false;
$showError = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    include 'partials/_dbconnect.php';
    $DoctorId = $_POST['doctorId'];  
    $userPass = $_POST['doctorPass'];
    $sql = "Select * from userdoctor where DoctorId ='$DoctorId' AND DocPass ='$userPass'";
    $result = mysqli_query($conn,$sql);
    $num = mysqli_num_rows($result);
    if($num==1)
    {
       $login = true;
       session_start();
       $row = mysqli_fetch_array($result);
       $_SESSION['loggedin'] = true;
       $cookie_name = "doctorData";
       $cookie_value = $DoctorId;
       $_SESSION['cookieName'] = $cookie_name;
       $_SESSION['cookieValue'] = $cookie_value;
       setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
       header("location: doctor_landing.php");
    }
    else{
        $showError ="Invalid Credentials!!!";
    }
 } 
?>
<!DOCTYPE html>
<html>

<head>
    <title>Doctor Login</title>
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
    position: relative;
	width:100%;
	height: 100%;
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

input[type="checkbox"] {
	align-items: left;
  margin: 0 10px 8px 0;
}
.form-check-label{
    font-size: small;
	color: #000;
	display: inline;
	height: 20px;  
	width: 20px;  
	border-radius: 10%;  
}

</style>

<body>
        <div class="col-lg-6 login-left col-sm-12 col-md-12 left-container">
                <h1 class="login-text-left">Covid-19 Symptom Tracker</h1>
            </div>

        <div class="col-lg-6 col-sm-12 col-md-12 right-container">
            <div class="main">
          
            <h1 style="font-size:4rem;"><center>Welcome Back!!</center></h1>
            <h4 style="font-size:2rem;"><center>Login into your Doctor account</center></h4>
                <input type="checkbox" id="chk" aria-hidden="true">
                <div class="login">
                    <form  class="login-form" method="post" action="/covidSym2/doctor_login.php">
                        <label for="chk" aria-hidden="true">Login</label>
                        <br>
                        <input type="text"  style="height:2rem;" class="form-control form-email" id="inputEmail" placeholder="Doctor ID" name="doctorId" required>
                        <input type="password" style="height:2rem;" class="form-control form-password" id="inputPassword" placeholder="Password" name="doctorPass"/>
                        <br>
                        <button>Login</button>
                        <button>Sign up</button>
                    </form>
                </div>
            </div>
        </div>
</body>

<script>
    function validation() {
        let id = document.getElementById("patientInput").value;
        let pass = document.getElementById("password").value;

        if(pass.length < 8){
            alert("Password should be greater than 8 characters");
        }
        if(id == ""){
            alert("Please enter username");
        }
    }
    document.getElementById("submit").addEventListener("click",validation);
    
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
  </script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</html>