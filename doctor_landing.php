<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true)
{
  header("location: doctor_login.php");
  exit;
} 
// if(!isset($_COOKIE[ $_SESSION['cookieName']])) {
//   echo "Cookie named '" .  $_SESSION['cookieName']  . "' is not set!";
// } 
// else {
//    echo "Cookie '" .  $_SESSION['cookieName'] . "' is set!<br>";
//    echo "Value is: " .  $_SESSION['cookieValue'];
// }
?>
<?php
     include 'partials/_dbconnect.php';
     $sql = "Select * from userpatient ";
     $result = mysqli_query($conn,$sql);
     if(!$result)
     {
       die(mysqli_error($conn));
     }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="css/dashboard.css">
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="background-color:#112B3C">
      <a class="navbar-brand" href="#" style="font-weight:bold;">Covid<break>Sym</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" style="color:#FFFF;"href="/covidSym2/doctor_login.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" style="color:#FFFF;" href="#prescribe_medicine">Prescribe Medicine</a>
          </li>
          <li class="nav-item" style="position:relative; left:1100px;">
            <a class="nav-link" style="color:#FFFF;" href="/covidSym2/logout.php">Log Out</a>
          </li>
        </ul>
      </div>
    </nav>

    <h1 class="dashboard-title">Doctor Dashboard</h1>
    <table>
      <thead>
        <tr>
          <th>Patient Id</th>
          <th>Name</th>
          <th>Age</th>
          <th>Sex</th>
          <th>Details</th>
        </tr>
      </thead>
      <tbody>
      <?php
          $i =0;
          if(mysqli_num_rows($result)>0)
          {
          while($row=mysqli_fetch_assoc($result))
          {
          ?>
        <tr>
            <td><?php echo $row['PatientId']?></td>
            <td><?php echo $row['PatientName']?></td>
            <td><?php echo $row['PatientAge']?></td>
            <td> <?php if($row['PatientSex']==0)
                        echo "Male";
                        else
                        echo "Female"; ?></td>
            <td><button class="btn btn-warning"><a style="text-decoration: none;"href="patient_details_D.php?view=<?php echo $row['PatientId']?>">View</a></button></td>
          </tr>
          <?php
            $i++; 
          }
          }
        ?>
      </tbody>
    </table>
  </body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>
