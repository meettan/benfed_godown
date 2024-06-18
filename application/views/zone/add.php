<div class="wraper">      
            
	<div class="col-md-6 container form-wraper">

		<form method="POST" action="<?php echo site_url("godown/godown/zoneAdd") ?>">

			<div class="form-header">
			
				<h4>Add Zone</h4>
			
			</div>

			<div class="form-group row">

				<label for="zone_name" class="col-sm-3 col-form-label">Name:</label>

				<div class="col-sm-9">

					<input type="text" id=zone_name name="zone_name" class="form-control" required />

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


