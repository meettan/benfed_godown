<div class="wraper">      
            
	<div class="col-md-6 container form-wraper">

		<form method="POST" action="<?php echo site_url("godown/godown/statusAdd") ?>">

			<div class="form-header">
			
				<h4>Add Status</h4>
			
			</div>

			<div class="form-group row">

				<label for="purpose" class="col-sm-3 col-form-label">status:</label>

				<div class="col-sm-9">

					<input type="text" id=gd_status name="gd_status" class="form-control" required />

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


