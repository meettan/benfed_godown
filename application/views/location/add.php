<div class="wraper">      
            
	<div class="col-md-6 container form-wraper">

		<form method="POST" action="<?php echo site_url("godown/godown/locationAdd") ?>">

			<div class="form-header">
			
				<h4>Add Location</h4>
			
			</div>

			<div class="form-group row">

				<label for="loc_name" class="col-sm-3 col-form-label">Name:</label>

				<div class="col-sm-9">

					<input type="text" id=loc_name name="loc_name" class="form-control" required />

				</div>
			</div>
								
			<div class="form-group row">

				<div class="col-sm-10">

					<input type="submit" class="btn btn-info active_flag_c" value="Save" />

				</div>

			</div>

		</form>

	</div>	

</div>


