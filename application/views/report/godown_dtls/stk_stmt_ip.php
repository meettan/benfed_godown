<style>
table {
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid #dddddd;

    padding: 6px;

    font-size: 14px;
}

th {

    text-align: center;

}

tr:hover {background-color: #f5f5f5;}

</style>


    
    <div class="wraper">      

        <div class="col-md-6 container form-wraper">
    
                 <!-- <form method="POST" id="form" action="<?php echo site_url("fert/rep/salerepsoc");?>" > -->
                 <form method="POST" id="form" action="<?php echo site_url("fert/rep/godowndtls");?>" >
                <div class="form-header">
                
                    <h4> Give Input</h4>
                
                </div>

                <div class="form-group row">

                    <label for="from_dt" class="col-sm-2 col-form-label">From Date:</label>

                    <div class="col-sm-6">

                        <input type="date"
                               name="from_date"
                               class="form-control required"
                               value="<?php echo date('Y-m-d');?>"/>  

                    </div>

                </div>

                <div class="form-group row">

                    <label for="to_date" class="col-sm-2 col-form-label">To Date:</label>

                    <div class="col-sm-6">

                        <input type="date"
                               name="to_date"
                               class="form-control required"
                               value="<?php echo date('Y-m-d');?>"
                        />  

                    </div>

                </div>  

                <!-- <div class="form-group row">
                <label for="branch" class="col-sm-2 col-form-label">Branch:</label>
                <div class="col-sm-6">

                    <select name="br" class="form-control sch_cd required" id="br" required>

                        <option value="">Select Branch</option>

                        <?php

                            foreach($all_branch as $br){

                                
                        ?>

                        <option value="<?php echo $br->district_code;?>"><?php echo $br->district_name;?></option>

                        <?php

                            }

                        ?>     

                    </select>

                </div>

            </div> -->
                <div class="form-group row">

                    <div class="col-sm-10">

                        <input type="submit" class="btn btn-info" value="Submit" />

                    </div>

                </div>

            </form>    

        </div>

    </div>