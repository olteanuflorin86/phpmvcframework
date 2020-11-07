<?php
?>

<h1>Create an account</h1>
<!-- I think that it will send the data to register function in AuthController and we can access it from there -->
<!-- The data will be accessed with getBody method that uses $_POST inside -->
<form action="" method="post">
	<div class="row"> 
		<div class="col">
			<div class="form-group">
    			<label>First Name</label>
            	<input type="text" name="firstName"
            		value="<?php echo $model->firstName?>"          		   
            		class="form-control<?php echo $model->hasError('firstName') ? ' is-invalid' : '' ?>">
					<!-- Under we display the actual error if we have any -like firstName is missing -->
        			<div class="invalid-feedback">
        				<!-- 
        				    There might be more than just one error...
        				    ..we will diaplay one error at a time
        				 -->
        				 <!-- we got to have 'firstName' bellow, we can't use any work we want -->
        				<?php echo $model->getFirstError('firstName'); ?>
        			</div>
        	</div>
		</div>
		<div class="col">
			<div class="form-group">
                <label>Last Name</label>
                <input type="text" name="lastName"  class="form-control">
        	</div>
		</div>
    </div> 
    <div class="col">
    	<div class="form-group">
    		<label>Email</label>
            <input type="email" name="email" class="form-control">
        </div>
        <div class="form-group">
    		<label>Password</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="form-group">
    		<label>Confirm Password</label>
            <input type="password" name="confirmPassword" class="form-control">
        </div>
        <button type="submit">Submit</button>
    </div>
</form>