<?php 
    session_start();

    if (!isset($_SESSION['loggedin'])) {
        header('Location: index.html');
        exit();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Manage Users</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="adminJS.js"></script>        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            @import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');

body {
    font-family: 'Montserrat', sans-serif;
    margin: 0;
}
        /* Add a black background color to the top navigation */
        .topnav {
        background-color:#f5f6f7;
        overflow: hidden;

        }
        .text-area a{
            color: #3d3d3d;
            text-decoration: none;
        }

        .text-area p{
            letter-spacing: 1px;
        }
        /* Style the links inside the navigation bar */
        .topnav a {
        float: left;
        display: block;
        color: #3d3d3d;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 20px;
        font-family: 'Montserrat', 'sans-serif';

        }

        /* Change the color of links on hover */
        .topnav a:hover {
        background-color: #ddd;
        color: #7da3a1;
        }

        .text-area {
            margin: 5px;
        }

        /* Add an active class to highlight the current page */
        .topnav a.active {
        background-color: #7da3a1;
        color: white;
        }

        /* Hide the link that should open and close the topnav on small screens */
        .topnav .icon {
        display: none;
        }

        @media screen and (max-width: 600px) {
            .topnav a:not(:first-child) {display: none;}
            .topnav a.icon {
            float: right;
            display: block;
            }
        }

        /* The "responsive" class is added to the topnav with JavaScript when the user clicks on the icon. This class makes the topnav look good on small screens (display the links vertically instead of horizontally) */
        @media screen and (max-width: 600px) {
            .topnav.responsive {position: relative;}
            .topnav.responsive a.icon {
            position: absolute;
            right: 0;
            top: 0;
            }
            .topnav.responsive a {
            float: none;
            display: block;
            text-align: left;
            }
        }
        p {
            padding-left: 10px;
        }
   
        .add ,.delete,.change{
            padding-left: 20px;
        }
        .change input,.change button{
            margin-top: 10px;
            margin-bottom: 5px;
        }
        table, td, th {  
            border: 1px solid #ddd;
            text-align: left;
            }

            table {
            border-collapse: collapse;
            width: 90%;
            margin : 0px auto;
            }

            th, td {
            padding: 15px;
            text-align: left;
            }
            tr:hover {background-color: #3d3d3d;}
            tr:nth-child(even) {background-color: #ffffff;}
            th {
            background-color: #7da3a1;
            color: white;
            }
            .add button ,.delete button,.change button{
                border-radius: 20px;
                border: 1px solid #7da3a1;
                background-color: #7da3a1;
                color: #ffffff;
                font-size: 15px;
                font-weight: bold;
                padding: 12px 45px;
                letter-spacing: 1px;
                text-transform: uppercase;
                transition: transform 80ms ease-in;
                font-family: 'Montserrat', sans-serif;

            }
            #alert {
                margin : 0px auto;
                padding-bottom: 20px;
            
            }
            button:hover{
                cursor: pointer;
            }
            input {
                background-color: #eee;
                border: none;
                padding: 12px 15px;
                padding-left: 20px;
                margin: 4px 0;
                width: 15%;
                border-radius: 15px;
            }
        </style>
    </head>
    <body>
        <div class="topnav" id="myTopnav">
            <a href="adminHome.php" class="active">Home</a>
            <a href="manageStock.php">Manage Stock</a>
            <a href="findStock.php">Find Stock</a>
            <a href="viewStock.php">View&Filter Stock</a>
            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
              <i class="fa fa-bars"></i>
            </a>
          </div>
          <br>
          <div class="text-area">
              <p>Users you have added:</p>
          </div>
          <div class="usersList" style="overflow-x:auto;">
            <table >
                <tr>
                    <th> User Id </th>
                    <th> User Name </th>
                    <th> Lab In Charge </th>
                </tr>
                <?php 
                    require_once('dbConnect.php');
                    $con = dbConnect();
                    if ($stmt = $con->prepare('SELECT userId, userName,userLabInCharge FROM userdetails WHERE userAddedBy = ?')) {
                        $stmt->bind_param('s', $_SESSION['adminID']);
                        $stmt->execute();
                        $stmt=$stmt->get_result();
                    }
                    if ($stmt->num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($stmt)) {
                            echo "<tr><td>".$row['userId']."</td><td>".$row['userName']."</td><td>".$row['userLabInCharge']."</td><tr>";
                        }
                        echo "</table>";
                    }
                    else {
                        echo "<tr><td>"."-"."</td><td>"."-"."</td><td>"."-"."</td><tr>";
                        echo "</table>";
                        echo "0 users added";
                    }
                    $stmt->close();
                    $con->close();
                ?>
            </table>
            <br>
            <div class="add">
                <form action="addUser.php" method="POST">
                    <span>Add User:</span>
                    <input name="userId" type="text" placeholder="UserId" required />
                    <input name="userName" type="text" placeholder="UserName" required />
                    <input name="userPassword" type="password" placeholder="Password" required/>
                    <input name="userLabInCharge" type="text" placeholder="LabInCharge" required />
                    <button>Add</button>
                </form>
            </div>
            <br>
            <div class="delete">
                <form  action="deleteUser.php" method="POST">
                    <span>Delete User:</span>
                    <input name="userId" type="text" placeholder="UserId" required />
                    <button>Delete</button>
                </form>
            </div>
            <br>
            <!--<div class="change">
                <form  action="changeUser.php" method="POST">
                    <span>Change User:</span>
                    <span style="color:red">*Fill in only the values you want to change(userId is required)</span><br>
                    <input name="userOldId" type="text" placeholder="OldUserId" required />
                    <input name="userNewId" type="text" placeholder="NewUserId" required /><br>
                    <input name="userOldName" type="text" placeholder="OldUserName"  />
                    <input name="userNewName" type="text" placeholder="NewUserName" /><br>
                    <input name="userOldPassword" type="password" placeholder="OldPassword" required/>
                    <input name="userNewPassword" type="password" placeholder="NewPassword" required/><br>
                    <input name="userOldLabInCharge" type="text" placeholder="OldLabInCharge" required />
                    <input name="userNewLabInCharge" type="text" placeholder="NewLabInCharge" required /><br>
                    <button>Change</button><br>
                </form>
            </div>-->
        </div>
    </body>
</html>
