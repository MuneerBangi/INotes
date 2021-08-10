<?php
$insert = false;
$update = false;
$delete = false;
require_once "config.php";
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
    header("location: login.php");
}


if(isset($_GET['delete'])){
  $srno = $_GET['delete'];
  $delete = true;
  $sql= "DELETE FROM `notes` WHERE `sr_no` = $srno";
  $result = mysqli_query($conn, $sql);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") 
{
    if(isset($_POST['srEdit']))
    {
        //Update the Record
        $srno = $_POST["srEdit"];
        $title = $_POST["titleEdit"];
        $description = $_POST["descriptionEdit"];
        $sql= "UPDATE `notes` SET `title` = '$title' , `description` = '$description' WHERE `notes`.`sr_no` = $srno";
        $result=mysqli_query($conn, $sql);
        if ($result) {
            $update = true;
        }
    }
    else
    {
      $title = $_POST["title"];
      $description = $_POST["description"];


      //Sql Query to be executed
      $sql="INSERT INTO `notes` (`title`,`description`) VALUES ( '$title', '$description')";
      $result = mysqli_query($conn, $sql);
      
      //Record Inserted
      if ($result) 
      {
          $insert = true;
      }
      else
      {
        echo "The record was not Inserted Successfully because of this error...>".mysqli_error($conn);
      }
    } 
}
?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>PHP login system!</title>
  </head>
  <body>
  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit This Note</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/LoginPage/welcome.php" method="Post">
                            <input type="hidden" name="srEdit" id="srEdit">
                            <div class="form-group">
                                <label for="title">Note Title</label>
                                <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="desc">Note Description</label>
                                <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
                            </div>

                            <!-- <button type="submit" class="btn btn-primary">Update Note</button> -->
                            <button type="submit" class="btn btn-primary">Save changes</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                           
     
                    </div>

                    </div>
                <div class="modal-footer d-block mr-auto">
                                   </div>
                </form>
            </div>
        </div>
        </div>



  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">INotes Login System</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="register.php">Register</a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" href="login.php">Login</a>
      </li> -->
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>

      
     
    </ul>

  <div class="navbar-collapse collapse">
  <ul class="navbar-nav ml-auto">
  <li class="nav-item active">
        <a class="nav-link" href="#"> <img src="https://img.icons8.com/metro/26/000000/guest-male.png"> <?php echo "Welcome ". $_SESSION['username']?></a>
      </li>
  </ul>
  </div>


  </div>
</nav>

<?php
        if ($insert) 
        {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Success!</strong> You Note has been Inserted Successfully.
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>";
        }


        if ($update) 
        {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Success!</strong> You Note has been Updated Successfully.
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>";
        }

        if ($delete) 
        {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Success!</strong> You Note has been Deleted Successfully.
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>";
        }
    ?>

<div class="container my-4">
                <h2>Add a Note</h2>
                <form action="/LoginPage/welcome.php" method="Post">
                    <div class="form-group">
                        <label for="title">Note Title</label>
                        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="desc">Note Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Note</button>
                </form>
            </div>
</div>

<div class="container my-4">

                <table class="table" id="myTable">
                    <thead>
                        <tr>
                            <th scope="col">Sr No</th>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                            $sql = "SELECT * FROM `notes`";
                            $result = mysqli_query($conn, $sql);
                            $srno = 0;
                            while($row = mysqli_fetch_assoc($result))
                            {
                                $srno = $srno + 1;
                                echo "<tr>
                                <th scope='row'>".$srno."</th>
                                <td>".$row['title']."</td>
                                <td>".$row['description']."</td>
                                <td><button  class='edit btn btn-primary btn-sm' id=".$row['sr_no']." >Edit</button> <button  class='delete btn btn-primary btn-sm' id=d".$row['sr_no']." >Delete</button></td>
                                </tr> ";
                            }
                        ?>

                    </tbody>
                </table>

</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>

<script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log("edit", );
            tr = e.target.parentNode.parentNode;
            title = tr.getElementsByTagName("td")[0].innerText;
            description = tr.getElementsByTagName("td")[1].innerText;
            console.log(title, description);
            titleEdit.value = title;
            descriptionEdit.value = description;
            srEdit.value = e.target.id;
            console.log(e.target.id);
            $('#editModal').modal('toggle');
        })
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log("edit", );
           srno= e.target.id.substr(1,)
            if(confirm("Are You Sure you want to Delete Note!")){
                console.log("yes");
                window.location = `/LoginPage/welcome.php?delete=${srno}`;
            }
            else{
                console.log("no");
            }
        })
    })
</script>


  </body>
</html>
