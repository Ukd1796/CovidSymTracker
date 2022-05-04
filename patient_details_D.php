<?php
$ptId;
session_start();
ini_set('error_reporting', 0);
ini_set('display_errors', 0);
if(isset($_GET['view']))
{
  $ptId = $_GET['view']; 
}
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true)
{
  header("location: doctor_login.php");
  exit;
}
?>
<?php
     include 'partials/_dbconnect.php';
     $sql = "Select * from userpatient where PatientId ='$ptId'";
     $result = mysqli_query($conn,$sql); 
     $num = mysqli_num_rows($result);
     if($num==1)
     {
        $row = mysqli_fetch_array($result);
        $_SESSION['userName'] = $row["PatientName"];
        $_SESSION['userAge'] = $row["PatientAge"]; 
        $_SESSION['userSex'] = $row["PatientSex"]; 
        $_SESSION['userBg'] = $row["PatientBg"]; 
        $_SESSION['userWeight'] = $row["PatientWeight"]; 
        $_SESSION['userHeight'] = $row["PatientHeight"]; 
     }
?>
<?php
$sql2 = "Select * from dailysymptoms where PatientId ='$ptId'";
     $result2 = mysqli_query($conn,$sql2);
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    include 'partials/_dbconnect.php'; 
    $patientId = $_POST['patientId'];
    $dateMed = $_POST['medDate'];  
    $userMed = $_POST['medicine']; 
    $exists = false;
     if($exists==false)
     {
        $sql3 = "INSERT INTO `prescribedmedicine` (`PatientId`, `Date`,`Medicine`) VALUES ('$patientId','$dateMed','$userMed')";
        $result3 = mysqli_query($conn,$sql3);
        if($result3)
        {
            $ptId = $patientId;
        }
        else
        {
             die(mysqli_error($conn));
        }
     }
}
?>
<?php
      $sqlImg = "SELECT * FROM userimage WHERE PatientId = $ptId";
      $resultImg = mysqli_query($conn,$sqlImg);
      $rowImg = mysqli_fetch_assoc($resultImg);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Patient Details</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
      crossorigin="anonymous"
    />

    <link rel="stylesheet" href="css/patientdetails.css"/>
  </head>
  <style></style>
  <body style="background-color:#ffff;">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="background-color:#112B3C">
      <a class="navbar-brand" href="#" style="font-weight:bold;">Covid<break>Sym</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" style="color:#FFFF;"href="/doctor_login.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" style="color:#FFFF;" href="#prescribe_medicine">Prescribe Medicine</a>
          </li>
          <li class="nav-item" style="position:relative; left:1100px;">
            <a class="nav-link" style="color:#FFFF;" href="/logout.php">Log Out</a>
          </li>
        </ul>
      </div>
    </nav>


    <!-- <div id="particle-container"></div> -->
    <h1 class="dashboard-title">Patient Details</h1>
    <section >
      <div class="container py-5">
        <div class="row">
        </div>
    
        <div class="row" >
          <div class="col-lg-4">
            <div class="card mb-4 shadow" style="background-color: #112B3C;border-radius:30px;width:400px;position:relative;left:150px;" >
              <div class="card-body text-center">
              <?php
                   if($rowImg['status']==0)
                   {
                  ?>
                    <img src='images/profile<?php echo $ptId?>.jpg'
                       class="rounded-circle img-fluid" style="width: 150px; border-radius:2px;" onclick="addImageForm()">;
                  <?php
                   }
                    else{ ?>
                     <img src='images/profileImg.jpg'
                       class="rounded-circle img-fluid" style="width: 150px;" onclick="addImageForm()">;
                 <?php     
                   }
                ?>
                <h5 class="my-3" style="color: white;"><?php echo $_SESSION['userName']?></h5>
                <p class="mb-1"></p>
                <p class="mb-4"></p>
                <div class="d-flex justify-content-center mb-2">
                </div>
              </div>
            </div>
          
          </div>
          <div class="col-lg-5" >
            <div class="card mb-4" style="background-color: #112B3C;border-radius: 30px;color: #EFEFEF;font-size: 20px; position:relative;left:175px;">
              <div class="card-body" style="border: radius 30px;">
                <div class="row" style="padding:0px;">
                  <div class="col-sm-5">
                    <p class="mb-0">Name</p>
                  </div>
                  <div class="col-sm-7">
                    <p class="mb-0"><?php echo $_SESSION['userName']?></p>
                  </div>
                </div>
                <hr>
                <div class="row" style="padding:0px;">
                  <div class="col-sm-5">
                    <p class="mb-0">Age</p>
                  </div>
                  <div class="col-sm-7">
                    <p class="mb-0"><?php echo $_SESSION['userAge'] ?></p>
                  </div>
                </div>
                <hr>
                <div class="row" style="padding:0px;">
                  <div class="col-sm-5">
                    <p class="mb-0">Patient Id:</p>
                  </div>
                  <div class="col-sm-7">
                    <p class="mb-0"><?php echo $ptId?></p>
                  </div>
                </div>
                <hr>
                <div class="row" style="padding:0px;">
                  <div class="col-sm-5">
                    <p class="mb-0">Sex</p>
                  </div>
                  <div class="col-sm-7">
                    <p class="mb-0"> 
                    <?php 
                   if($_SESSION['userSex']==0)
                   echo "Male";
                   else
                   echo "Female"; 
                   ?> </p></p>
                  </div>
                </div>
                <hr>
                <div class="row" style="padding:0px;">
                  <div class="col-sm-5">
                    <p class="mb-0">Blood Group</p>
                  </div>
                  <div class="col-sm-7">
                    <p class="mb-0"><?php echo $_SESSION['userBg']?></p>
                  </div>
                </div>
              </div>
            </div>
            </div>
          </div>
        </div>
      </div>
    </section>
<div class="dailyContainer">
    <h1 class="dashboard-title" style="color:white;">Daily Symptoms</h1>
    <table data-aos="fade-up">
      <thead>
        <tr>
          <th>Date</th>
          <th>Body Temperature</th>
          <th>Oxygen Saturation</th> 
           <th>Cough</th>
          <th>Fatigue</th>
          <th>Loss of Smell</th>
          <th>Loss of Taste</th>
          <th>Others</th>
        </tr>
      </thead>
      <tbody>
      <?php
          $i =0;
          if(mysqli_num_rows($result2)>0)
          {
          while($row=mysqli_fetch_assoc($result2))
          {
          ?>
        <tr>
        <td><?php echo $row['CurrentDate']?></td>
          <td><?php echo $row['BodyTemp']?></td>
          <td><?php echo $row['oxySaturation']?></td>
          <td>
          <?php if($row['Cough']==0)
                        echo "Yes";
                        else
                        echo "No"; ?>
          </td>
          <td><?php if($row['Fatigue']==0)
                        echo "Yes";
                        else
                        echo "No"; ?></td>
          <td><?php if($row['LossSmell']==0)
                        echo "Yes";
                        else
                        echo "No"; ?></td>
          <td><?php if($row['LossTaste']==0)
                        echo "Yes";
                        else
                        echo "No";?></td>
          <td>
          <?php echo $row['OtherSym']?>
          </td>
        </tr>
        <?php
            $i++; 
          }
          }
        ?>
      </tbody>
    </table>
    <br /><br />
  </div>
  <div class="chart">
    <canvas id="myChart" width="500" height="100"></canvas>
  </div>
  <section id="prescribe_medicine">
    <h2 class="dashboard-title">Prescribe Medicine</h2>
<div style="background-color:#112B3C; width:60% ;border-radius:10px; position:relative; height:320px;left:400px;bottom:40px;">
  <form action="/patient_Details_D.php" method="post">
    <label for="Date" style="color:#ffff">Date:</label>
    <input style ="height:40px;"type="date" style="height:3rem;" name="medDate" >
    <label for="patientId" style="color:#ffff">Patient ID:</label>
    <input type="text" style="height:40px;" placeholder="Enter the Patient Id:" name="patientId">
    <br>
    <label for="Medicine" style="color:#ffff">Prescription:</label>
    <input style ="width:500px;height:150px;width:70%;" type="textarea" placeholder="Enter the prescription:" name="medicine">
    <br>
    <input type="submit" style="background-color:#022B57;color:#E2B842; height:50px; position:relative; left:300px;">
  </form>
</div>
</section>
  </body>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"
  ></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
  <script>
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['01/01/2022', '02/01/2022', '03/01/2022', '04/01/2022'],
            datasets: [{
                label: 'Daily Temperature',
                data: [98.7, 97.2, 102.7, 96.8],
                backgroundColor: "#012b39",
   
   borderColor: "#012b39",
                borderWidth: 8
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: false
                }
            }
        }
    });

    var textWrapper = document.querySelector('.ml3');
textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

AOS.init();



    </script>
</html>
