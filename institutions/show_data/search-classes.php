<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Search Classes</title> <!-- title for the page  -->
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script> <!-- include jquery library -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> <!-- include bootstrap library -->
  <link href="https://fonts.googleapis.com/css?family=Coustard|Lato&display=swap" rel="stylesheet"> <!-- include two google fonts -->

    <style>
        body {

            background-image: url("../images/back22.jpg");  /* put the background image  */

            background-size: cover; /* make it cover the screen */


        }

        .navtitle {
            font-family: 'Lato', sans-serif;  /* put font Lato to the nav title */
        }

        .navbar {
            box-shadow: 0 3px 4px rgba(0, 0, 0, 0.16), 0 3px 4px;   /* Adding simple shadow effect to the navbar */
        }
    </style>
</head>

<body>

    <!-- Grey with black text -->
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark"> <!-- make a dark navbar with bootstrap -->

        <div class="container">
            <a class="navbar-brand" href="../welcome.php"> <!-- Redirect to welcome page when click on it -->
                <h1 class="text-center navtitle">RSK GROUP OF COLLEGES</h1>
            </a>


            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item dropdown ">
                    <a class="navbar-toggler-icon" href="#" id="navbardrop" data-toggle="dropdown"></a> <!-- Creating a dropdown menu -->
                    <div class="dropdown-menu">

                        <a class="dropdown-item" href="../welcome.php">Home</a> <!-- One for home page -->
                        <a class="dropdown-item" href="../reset-password.php">Reset Password</a> <!-- Second for Reset Password -->
                        <a class="dropdown-item" href="../logout.php">Log out</a> <!-- Third to log out -->

                    </div>
                </li>
            </ul>
    </nav>

    <div class="container">
    <div class="col-13 col-sm-6 col-md-5 mx-auto" style="padding: 2%;"> 
        <div class="form-group">
          <h2 class="text-center" style=" font-size: 45px; font-family:'Coustard', serif; color: #FFFFFF; background-color:#353a40;">Search Group</h2>
          <input type="text" name="search" id="search" autocomplete="off" class="form-control" placeholder="Search Group">
          <div id="output" style="font-family: 'Coustard', serif; background-color:#353a40; color: rgb(255, 255, 255); padding-left: 2%;"></div>
        </div>
      </div>
    </div>

    <div class="container" style="padding: 2%;">

    
        <table class="table table-bordered table-striped table-dark" style="width: 100%;">
            <thead>
                <tr>
                    <th style="text-align: center; width: 10%;">ID</th>
                    <th style="text-align: center;width: 20%;">Name</th>
                    <th style="text-align: center;width: 10%;">Subject</th>
                    <th style="text-align: center;width: 10%;">Time Of Class</th>
                    <th style="text-align: center;width: 10%;">Teacher Name</th>
                    <th style="text-align: center;width: 10%;">Date of register</th>
                    <th style="text-align: center;width: 10%;">Show Students</th>
                    <th style="text-align: center;width: 10%;">Remove Class</th>
                </tr>
            </thead>
            <tbody>

                <tr>

                    <?php



                    // Initialize the session
                    session_start();

                    // Check if the user is logged in, if not then redirect him to login page
                    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
                        echo "<br/>" . "Please Login" . "<br/>";
                        exit;
                    }

                    include("../config.php");


                    $query = "SELECT * FROM groups ORDER BY name";
                    $result = mysqli_query($link, $query);


                    if (mysqli_num_rows($result) > 0) {
                        while ($user = mysqli_fetch_array($result)) {

                            if ($user['school_id'] == (int)$_SESSION['id']) {
                            $id = $user['id'];
                            echo "<td align='center'>" . $user['id'] . "</td>";
                            echo "<td align='center'>" . $user['name'] . "</td>";
                            echo "<td align='center'>" . $user['subject'] . "</td>";
                            echo "<td align='center'>" . $user['time_of_room'] . "</td>";
                            
                            $query2 = "SELECT name FROM teachers WHERE teachers.id={$user['teacher_id'] }";
                            $result2 = mysqli_query($link, $query2);
                            $user2 = mysqli_fetch_array($result2);
                            echo "<td align='center'>" . $user2['name'] . "</td>";
                            echo "<td align='center'>" . $user['date_of_register'] . "</td>";
                            echo ("<td align='center'><a href=\"../show_data/show-students-class.php?group_control_id=".$user['id']."\">Show Students</a></td>");
                            echo ("<td align='center'><a href=\"../remove_data/remove-class.php?group_id=".$user['id']."\">Remove Class</a></td>");
                            echo "</tr>";

                        }
                    }
                }
                    mysqli_close($link);
                    ?>
        </table>
    </div>

    <script type="text/javascript">
    $(document).ready(function() {
      $("#search").keyup(function() {
        var query = $(this).val();
        if (query != "") {
          $.ajax({
            url: '../search_data/search-group.php',
            method: 'POST',
            data: {
              query: query
            },
            success: function(data) {

              $('#output').html(data);
              $('#output').css('display', 'block');

              $("#search").focusin(function() {
                $('#output').css('display', 'block');
              });
            }
          });
        } else {
          $('#output').css('display', 'none');
        }
      });
    });
  </script>
</body>



<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</html>