<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true)
{
  header("location: index.php");
  exit;
}
// if(!isset($_COOKIE[ $_SESSION['cookieName1']])) {
//   echo "Cookie named '" .  $_SESSION['cookieName1']  . "' is not set!";
// } 
// else {
//    echo "Cookie '" .  $_SESSION['cookieName1'] . "' is set!<br>";
//    echo "Value is: " .  $_SESSION['cookieValue1'];
// }
?>
<?php
     include 'partials/_dbconnect.php';
     $ptId = $_SESSION['patientId'];
     $sql2 = "Select * from prescribedmedicine where PatientId ='$ptId'";
     $result2 = mysqli_query($conn,$sql2);
     if(!$result2)
     {
       die(mysqli_error($conn));
     }
?>
<?php
    include 'partials/_dbconnect.php';
    $ptId = $_SESSION['patientId'];
    $sql = "Select * from dailysymptoms where PatientId ='$ptId'";
    $result = mysqli_query($conn,$sql);
    if(!$result)
    {
      die(mysqli_error($conn));
    }

?>
<?php
      $ptId = $_SESSION['patientId'];
      $sqlImg = "SELECT * FROM userimage WHERE PatientId = $ptId";
      $resultImg = mysqli_query($conn,$sqlImg);
      $rowImg = mysqli_fetch_assoc($resultImg);
?>
<?php
    include 'partials/_dbconnect.php';
    $ptId = $_SESSION['patientId'];
    if (isset($_POST['upload']))
    {
        $file = $_FILES['file'];
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $filtype = $_FILES['file']['type'];
        $fileExt = explode('.',$fileName);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpg','png','jpeg');
        if(in_array($fileActualExt,$allowed))
        {
              if($fileError===0)
              {
                 if($fileSize<1000000)
                 {
                   $fileNameNew = "profile".$ptId.".".$fileActualExt;
                   $fileDestination = 'images/'.$fileNameNew;
                   move_uploaded_file($fileTmpName,$fileDestination);
                   $sql = "UPDATE userimage SET status=0 where PatientId = '$ptId'";
                   $result4 = mysqli_query($conn,$sql);
                   header("Location:patient_landing.php");
                 }
              }
        } 
        else{
            echo "You cannot upload file of this type";
        }



    }
    else{
         
    }


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Patient Details</title>
    <!-- Required meta tags -->
    <link rel="stylesheet" href="css/patientDashboard.css" />
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
      crossorigin="anonymous"
    />
    <style>
      #popupForm
      {
        background-color:#888888;
        box-shadow: 5px 5px 5px #888888;
        position:fixed;
        left:830px;
      }
    </style>
  </head>
  <style></style>
  <body style="backgorund-color:#FFFFFF;">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="background-color:#112B3C">
      <a class="navbar-brand" href="#" style="font-weight:bold;">Covid<break>Sym</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" style="color:#FFFF;" href="/covidSym2/patient_landing.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" style="color:#FFFF;"href="/covidSym2/symptoms.php">Add Symptoms</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" style="color:#FFFF;" href="#prescribed_medicine">Medicine Prescribed</a>
          </li>
          <li class="nav-item" style="position:relative; left:1100px;">
            <a class="nav-link" style="color:#FFFF;" href="/covidSym2/logout.php">Log Out</a>
          </li>
        </ul>
      </div>
    </nav>
     <div>
    <h1 class="dashboard-title">Patient Details</h1>
     <section >
      <div class="container py-5">
        <div class="row">
        </div>  
        <div class="row" >
          <div class="col-lg-4">
            <div class="card mb-4 shadow" style="background-color: #112B3C;border-radius:30px;width:400px; position:relative;left:150px;height:325px;">
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
           
                <h5 class="my-3" style="color: white; position:absolute;left:150px; bottom:100px;"><?php echo $_SESSION['userName']?></h5>
                <p class="mb-1"></p>
                <p class="mb-4"></p>
                <div class="d-flex justify-content-center mb-2">
                </div>
              </div>
            </div>
          </div>
          <div id="popupForm" style= "z-index:1;width:540px; height:320px;position:absolute; border-radius:20px; display:none;">
            <br>
            <br>
            <h2 style="color:#FFFF">Upload Image</h2>
            <i class='fa fa-close' style='color: white; position:relative;size:200px;bottom:70px;left:450px;' onclick="closeImageForm()"></i>
              <br>
            <form action="" method="post" enctype="multipart/form-data">
              <input style="color:#FFFF"type="file" name="file" style="border-color:black;">
              <br><br><br>
              <input type="submit" name="upload">
            </form>
          </div>
          <div class="col-lg-5"   >
            <div class="card mb-4" id="container4" style="background-color: #112B3C;border-radius: 30px;color: #EFEFEF;font-size: 20px; position:relative; left:200px;">
              <div class="card-body" style="border: radius 30px;">
                <div class="row">
                  <div class="col-sm-5">
                    <p class="mb-0">Name</p>
                  </div>
                  <div class="col-sm-7">
                    <p class="mb-0"><?php echo $_SESSION['userName']?></p>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-5">
                    <p class="mb-0">Age</p>
                  </div>
                  <div class="col-sm-7">
                    <p class="mb-0"><?php echo $_SESSION['userAge'] ?></p>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-5">
                    <p class="mb-0">Patient Id:</p>
                  </div>
                  <div class="col-sm-7">
                    <p class="mb-0"><?php echo $_SESSION['patientId'] ?></p>
                  </div>
                </div>
                <hr>
                <div class="row">
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
                   ?> </p>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-5">
                    <p class="mb-0">Blood Group</p>
                  </div>
                  <div class="col-sm-7">
                    <p class="mb-0"><?php echo $_SESSION['userBg'] ?></p>
                  </div>
                </div>
              </div>
            </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    </div>
<div class="dailyContainer">
    <h1 class="dashboard-title" style="color:white;">Daily Symptoms</h1>
    <table data-aos="fade-up" style = "position:relative; left:100px;">
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
          if(mysqli_num_rows($result)>0)
          {
          while($row=mysqli_fetch_assoc($result))
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
  <section id="prescribed_medicine">
    <h2 class="dashboard-title">Prescribed Medicine</h2>
    <table style="position:relative; left:80px; width:1200px; box-shadow:none;">
      <thead>
        <tr>
          <th>Date</th>
          <th>Medicine Prescribed</th>
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
          <td><?php echo $row['Date']?></td>
          <td>
          <?php echo $row['Medicine']?>
          </td>
        </tr>
        <?php
            $i++; 
          }
          }
        ?>
      </tbody>
    </table>
    </section>
  </body>

  <script>
      function addImageForm() {
        document.getElementById("popupForm").style.display = "block";
        document.getElementById("container3").style.opacity = 0.4;
        document.getElementById("container4").style.opacity = 0.4;   
      }
      function closeImageForm() {
        document.getElementById("popupForm").style.display = "none";
        document.getElementById("container3").style.opacity = 1; 
        document.getElementById("container4").style.opacity = 1; 
        document.getElementById("container5").style.opacity = 1; 
      }
    </script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></scr>
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"></script>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="index.js"></script>
</html>
