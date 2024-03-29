<?php 
include "config.php";

//write the query to get data from users table

$sql = "SELECT * FROM users";
//execute the query
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Welcome to AJAX PHP CRUD Function</title>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="0"/>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div class="container mt-5">

<h3 class="text-center">Welcome to AJAX PHP CRUD Function!</h3>
    <p class="datatable design text-center">Example PHP code that can create, read, update and delete function using AJAX application. </p>
		
<button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#userformModal">Enlist</button>
<br>
<h2>Member List</h2><br>
<table class="table">
	<thead>
		<tr>
		<th>ID No.#</th>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Email Ad</th>
        <th>Age</th>
		<th>Gender</th>
		<th>Action</th>
	</tr>
	</thead>
	<tbody id="users_data">	
	        	
	</tbody>
</table>



<div class="modal fade" id="userformModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Member Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST" id="user_form">
                <div class="form-group">
                <label>First Name</label>
                <input type="text" name="firstname" id="firstname" class="form-control">
                <input type="hidden" name="user_id" id="user_id" class="form-control">
                </div>

                <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="lastname" id="lastname" class="form-control">
                </div>

                <div class="form-group">
                <label>Email Ad</label>
                <input type="email" name="email" id="email" class="form-control">
                </div>

                <div class="form-group">
                <label>Age</label>
                <input type="text" name="age" id="age" class="form-control">
                </div>

                <div class="form-group">
                <label>Gender</label><br>
                <input type="radio" name="gender" value="Male"> Male
                <input type="radio" name="gender" value="Female"> Female
                </div>
                <br><br>
                <button type="submit" class="btn btn-success float-right">Submit</button>
            </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

</div> <!-- container -->

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script type="text/javascript">
    function delete_record(id) {
        if(confirm("Are you sure? You want to delete this record?")){
            $.ajax({
                type : "GET",
                url : "process.php?delete_id="+id,
                dataType : 'json',
                beforeSend : function() {
                    toastr.info("Please wait..");
                },
                success : function(response) {
                    console.log(response);
                    if (response.status) { //if response status is true show success message
                         toastr.warning(response.message);
                         get_all_users();
                    }else{
                      //  alert(response.message);
                    }
                }
            });
        }else{
         alert('ok');
        }
        
    }

    function edit_record(id) {
        $.ajax({
            type : "GET",
            url : "process.php?edit_id="+id,
            dataType : 'json',
            beforeSend : function() {
                toastr.info("Please wait..");
            },
            success : function(response) {
               // alert('ok2');
                console.log(response);
                if (response.status) { //if response status is true show success message
                    $("#firstname").val(response.data.firstname);
                    $("#user_id").val(response.data.id);
                    $("#lastname").val(response.data.lastname);
                    $("#email").val(response.data.email);
                    $("#age").val(response.data.age);
                    $("input[name=gender][value="+response.data.gender+"]").prop("checked",true);
                    $("#userformModal").modal('show');
                  //  setTimeout(function(){ alert(response.message);window.location.reload(); }, 3000);
                    
                }else{
                  //  alert(response.message);
                }
            }
        });
    }
</script>
<script type="text/javascript">
    $(document).ready(function() {

        $("#user_form").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type : "POST",
                url : "process.php",
                data : $("#user_form").serialize(),
                dataType : 'json',
                beforeSend : function() {
                    toastr.info("Please wait..");
                },
                success : function(response) {
                   // alert('ok2');
                    console.log(response);
                    if (response.status) {
                        toastr.success(response.message);
                        $("#user_form")[0].reset();
                        $("#userformModal").modal('hide');
                        get_all_users();
                    }else{
                        toastr.error(response.message);
                    }
                }
            });
        });

    });

    function get_all_users() {

        $.ajax({
            type : "GET",
            url : "process.php?get_users=1",
            dataType : 'html',
            success : function(response) {
                console.log(response);
                $("#users_data").html(response);

            }
        });
    }

    get_all_users();
</script>
<br>
<footer align="center">
Copyright © 2022 . All Right Reserved. <a href="https://goog-it.com/">Googit Web Dev</a>
</footer>
</body>
</html>
