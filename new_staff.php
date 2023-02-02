<?php if(!isset($conn)){ include 'db_connect.php'; } ?>
<style>
  textarea{
    resize: none;
  }
</style>
<div class="col-lg-12">
	<div class="card card-outline card-dark">
		<div class="card-body">
			<form action="" id="manage-staff">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="row">
          <div class="col-md-12">
            <div id="msg" class=""></div>

            <div class="row">
              <div class="col-sm-6 form-group ">
                <label for="" class="control-label">First Name</label>
                <input type="text" name="firstname" id="" placeholder="Enter first name" class="form-control" value="<?php echo isset($firstname) ? $firstname : '' ?>" required>
              </div>
              <div class="col-sm-6 form-group ">
                <label for="" class="control-label">Last Name</label>
                <input type="text" name="lastname" id="" placeholder="Enter last name" class="form-control form-control" value="<?php echo isset($lastname) ? $lastname : '' ?>" required>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-12 form-group ">
                <label for="" class="control-label">Service Centre Branch</label>
                <select name="branch_id" id="" class="form-control input-sm select2">
                  <option value=""></option>
                  <?php
                    $branches = $conn->query("SELECT *,concat(street,', ',city,', ',state,', ',zip_code,', ',country) as address FROM branches");
                    while($row = $branches->fetch_assoc()):
                  ?>
                  <option value="<?php echo $row['id'] ?>" <?php echo isset($branch_id) && $branch_id == $row['id'] ? "selected":'' ?>><?php echo $row['branch_code']. ' | '.(ucwords($row['address'])) ?></option>
                <?php endwhile; ?>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6 form-group ">
                <label for="" class="control-label">Email</label>
                <input type="email" name="email" id="" placeholder="Enter email address" class="form-control form-control" value="<?php echo isset($email) ? $email : '' ?>" required>
              </div>
              <div class="col-sm-6 form-group ">
                <label for="" class="control-label">Password</label>
                <input type="password" name="password" id="" placeholder="Create a strong password" class="form-control form-control" <?php echo isset($id) ? '' : 'required' ?>>
                <?php if(isset($id)): ?>
                  <small class=""><i>Leave this blank if you dont want to change this</i></small>
                <?php endif; ?>
              </div>
            </div>

            
          </div>
        </div>
      </form>
  	</div>
  	<div class="card-footer border-top border-dark">
  		<div class="d-flex w-100 justify-content-center align-items-center">
  			<button class="btn  btn-outline-primary mx-2" form="manage-staff">Confirm</button>
  			<a class="btn btn-outline-danger mx-2" href="./index.php?page=staff_list">Cancel</a>
  		</div>
  	</div>
	</div>
</div>
<script>
	$('#manage-staff').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_user',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved',"success");
					setTimeout(function(){
              location.href = 'index.php?page=staff_list'
					},2000)
				}else if(resp == 2){
          $('#msg').html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Email already exist.</div>')
          end_load()
        }
			}
		})
	})
  function displayImgCover(input,_this) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            $('#cover').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
      }
  }
</script>