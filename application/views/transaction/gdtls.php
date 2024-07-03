<div class="wraper">
    <form method="POST" id="product" action="<?php echo site_url("godown/godown/godowndtls") ?>" enctype='multipart/form-data'>
        <div class="col-md-6 container form-wraper" style="margin-bottom: 10px!important;">
            <div class="form-header">

                <h4>Godown Details</h4>

            </div>
          
            <div class="form-group row">

                <label for="yr" class="col-sm-2 col-form-label">WareHouse Name:</label>
                <div class="col-sm-10">
                   

                    <input type="text" id=w_name name="w_name" class="form-control"  required/>

                </div>
                </div>
                <div class="form-group row">
                <label for="w_addrs" class="col-sm-2 col-form-label">Address Including Pin:</label>
                <div class="col-sm-10">
                <textarea id=w_addrs name="w_addrs" class="form-control"></textarea>

                </div>

            </div>
            <div class="form-group row">
                <label for="ps" class="col-sm-2 col-form-label">PS</label>
                <div class="col-sm-4">
                    <input type="text" id=ps name="ps" class="form-control "  />

                </div>
            
                <label for="mouza" class="col-sm-2 col-form-label">Mouza:</label>
                <div class="col-sm-4">

               <input type="text" id=mouza name="mouza" class="form-control required"  />
                </div>
            </div>
            <div class="form-group row">
                <label for="capacity" class="col-sm-2 col-form-label">Capacity( In MT ):</label>
                <div class="col-sm-4">
                    <input type="text" id=capacity name="capacity" class="form-control required"  />

                </div>
                <label for="floorarea" class="col-sm-2 col-form-label">Floor Area(sq.ft.)</label>
                <div class="col-sm-4">
                    <input type="text" id=floorarea name="floorarea" class="form-control "  />

                </div>
</div>
<div class="form-group row">
            
            
                <label for="loc" class="col-sm-2 col-form-label">GPS Location:</label>
                <div class="col-sm-4">

                 
               <input type="text" id=location name="location" class="form-control required"  />
                </div>
            </div>
            <div class="form-header">

                <h4>Detailed Entry Of Land </h4>

            </div>
            <div class="form-group row">

                <label for="porcha" class="col-sm-2 col-form-label">Porcha:</label>

                <div class="col-sm-4">

                    <select name="porcha" id="porcha" style="width: 100%;"  class="form-control" required>

                        <option value="">Select</option>
                        <option value="Y">YES</option>
                        <option value="N">No</option>

                    </select>

                </div>

                <label for="dagty" class="col-sm-2 col-form-label">Daag Type:</label>

                <div class="col-sm-4">

                    <select name="dagty" id="Porcha" style="width: 100%;"  class="form-control" required>

                        <option value="">Select</option>
                        <option value="C">CS</option>
                        <option value="R">RS</option>
                        <option value="K">LR</option>
                        <option value="K">KB</option>
                        <option value="N">NA</option>
                    </select>

                </div>
</div>
            <div class="form-group row">
                <label for="jlno" class="col-sm-2 col-form-label">JL No</label>
                <div class="col-sm-4">
                    <input type="text" id=jl name="jl" class="form-control "  />

                </div>
            
                <label for="dag" class="col-sm-2 col-form-label">DAAG No.:</label>
                <div class="col-sm-4">

               <input type="text" id=dag name="dag" class="form-control required"  />
                </div>
            </div>

            <div class="form-group row">
                <label for="khotian" class="col-sm-2 col-form-label">Khotian No</label>
                <div class="col-sm-4">
                    <input type="text" id=khotian name="khotian" class="form-control "  />

                </div>
            
                <label for="touzi" class="col-sm-2 col-form-label">Touzi No.:</label>
                <div class="col-sm-4">

               <input type="text" id=touzi name="touzi" class="form-control required"  />
                </div>
            </div>
            <div class="form-group row">
                <!-- <label for="floorarea" class="col-sm-2 col-form-label">Floor Area(sq.ft.)</label>
                <div class="col-sm-4">
                    <input type="text" id=floorarea name="floorarea" class="form-control "  />

                </div> -->
            
                <label for="areapremises" class="col-sm-2 col-form-label">Area Of Premises( SATAK/ACRE):</label>
                <div class="col-sm-4">

               <input type="text" id=areapr name="areapr" class="form-control required"  />
                </div>
                <label for="purpose" class="col-sm-2 col-form-label">Utilization Purpose:</label>
                <div class="col-sm-4">
                   
                    <select name="purpose" class="form-control required" id="purpose" >

                        <option value="">Select Purpose</option>
                        <?php
                        foreach ($purpdtls as $purp) {
                        ?>
                            <option value="<?php echo $purp->id; ?>"><?php echo $purp->purpose; ?></option>
                        <?php
                        }
                        ?>

                    </select>

            </div>
            <div class="form-group row">
                <!-- <label for="onholdv" class="col-sm-2 col-form-label">Rent Status:</label>
                <div class="col-sm-4">
                    <select name="status" class="form-control" id="status" required>
                        <option value="">Select Status</option>
                        <?php
                        foreach ($gdstat as $gdst) {
                        ?>
                            <option value="<?php echo $gdst->id; ?>"><?php echo $gdst->gd_status; ?></option>
                        <?php
                            }
                        ?>
                    </select>
               </div> -->
            
                <!-- <label for="purpose" class="col-sm-2 col-form-label">Utilization Purpose:</label>
                <div class="col-sm-4">
                   
                    <select name="purpose" class="form-control required" id="purpose" >

                        <option value="">Select Purpose</option>
                        <?php
                        foreach ($purpdtls as $purp) {
                        ?>
                            <option value="<?php echo $purp->id; ?>"><?php echo $purp->purpose; ?></option>
                        <?php
                        }
                        ?>

                    </select> -->

                 </div>
            </div>
            <div class="form-group row">
            
<!--             
                <label for="loc" class="col-sm-2 col-form-label">GPS Location:</label>
                <div class="col-sm-4">

                 
               <input type="text" id=location name="location" class="form-control required"  />
                </div> -->
            </div>
            <div class="form-header">

<h4>Detailed Entry Of Rent </h4>

</div>
            <div class="form-group row">
                <label for="rent_st_dt" class="col-sm-2 col-form-label">Rent/Lease Start Dt:</label>
                <div class="col-sm-4">
                    <input type="date" id=rent_st_dt name="rent_st_dt" class="form-control required"  />

                </div>
                
            <!-- </div>
            <div class="form-group row"> -->
                <label for="rent_end_dt" class="col-sm-2 col-form-label">Rent/Lease End Dt:</label>
                <div class="col-sm-4">
                    <input type="date" id=rent_end_dt name="rent_end_dt" class="form-control required"  />

                </div>
            </div>
            <div class="form-group row">
                <label for="onholdv" class="col-sm-2 col-form-label">Rent Status:</label>
                <div class="col-sm-4">
                    <select name="status" class="form-control" id="status" required>
                        <option value="">Select Status</option>
                        <?php
                        foreach ($gdstat as $gdst) {
                        ?>
                            <option value="<?php echo $gdst->id; ?>"><?php echo $gdst->gd_status; ?></option>
                        <?php
                            }
                        ?>
                    </select>
               </div>
                        </div>
            <div class="form-group row">
                <label for="onholdv" class="col-sm-2 col-form-label">Rent Duration:</label>
                <div class="col-sm-4">
                    <input type="text" id=rent_duration name="rent_duration" class="form-control required"  />

                </div>
            <!-- </div>
            <div class="form-group row"> -->
                <label for="rate" class="col-sm-2 col-form-label">Rate:</label>
                <div class="col-sm-4">
                    <input type="text" id=rate name="rate" class="form-control required"  />

                </div>
            </div>
            <div class="form-group row">
                <label for="monthly_remt_amt" class="col-sm-2 col-form-label">Monthly rent amount:</label>
                <div class="col-sm-10">
                    <input type="text" id=monthly_remt_amt name="monthly_remt_amt" class="form-control required"  />

                </div>
            </div>
            <div class="form-group row">
                <label for="to_whome" class="col-sm-2 col-form-label">To Whome( Rented/Lease out ):</label>
                <div class="col-sm-10">
                    <input type="text" id=to_whome name="to_whome" class="form-control required"  />

                </div>
            </div>
            
            <div class="form-group row">
                <label for="remarks" class="col-sm-2 col-form-label">Remarks:</label>
                <div class="col-sm-10">

                    <textarea id=remarks name="remarks" class="form-control"></textarea>
                </div>
            </div>
          
        </div>

    

        <div class="col-md-5 container form-wraper" style="margin-left: 10px;">

                <div class="form-header">

                    <h4>File Details :</h4>

                </div>

                <table class="table">
                    <thead>
                    <tr><th>Document Name</th><th>Document.(PDF, Size upto 2MB)</th><th></th></tr>
                    </thead>
                    <tbody id="intro2">
                    <tr>
                        <td><input type="text" name="name[]" class="form-control"></td>
                        <td><input type="file" name="fileToUpload[]" class="form-control doc"></td>
                        <td><button type="button" class="btn btn-success addAnotherrow"><i class="fa fa-plus"></i></button></td>
                    </tr>
                    
                </tbody>
                </table>
        </div>

        <div class="col-md-12">
        <input type="submit" id="submit" class="btn btn-info" value="Save" />

        </div>
    </form>

</div>


<script>
    $(document).ready(function() {

        var i = 2;

        $('#dist').change(function() {

            $.get(

                    '<?php echo site_url("transaction/f_get_lstmnth"); ?>', {


                        dist_cd: $(this).val()


                    }

                )
                .done(function(data) {
                    var parseData = JSON.parse(data);
                    var mnth = parseData.end_mnth;
                    var yr = parseData.end_yr;
                    var mnth_nm = '';


                    var date_month= parseData.end_mnth;
                    var date_month_nm="";


                    if (parseFloat(date_month) == 1) {
                        date_month_nm = 'JAN';
                    } else if (parseFloat(date_month) == 2) {
                        date_month_nm = 'FEB';
                    } else if (parseFloat(date_month) == 3) {
                        date_month_nm = 'MAR';
                    } else if (parseFloat(date_month) == 4) {
                        date_month_nm = 'APR';
                    } else if (parseFloat(date_month) == 5) {
                        date_month_nm = 'MAY';
                    } else if (parseFloat(date_month) == 6) {
                        date_month_nm = 'JUN';
                    } else if (parseFloat(date_month) == 7) {
                        date_month_nm = 'JUL';
                    } else if (parseFloat(date_month) == 8) {
                        date_month_nm = 'AUG';
                    } else if (parseFloat(date_month) == 9) {
                        date_month_nm = 'SEP';
                    } else if (parseFloat(date_month) == 10) {
                        date_month_nm = 'OCT';
                    } else if (parseFloat(date_month) == 11) {
                        date_month_nm = 'NOV';
                    } else if (parseFloat(date_month) == 12) {
                        date_month_nm = 'DEC';
                    }



                    $('#current_mnth_nm').val(date_month_nm);
                    $('#current_yr_nm').val(parseData.end_yr);
                    $('#closedBy').val(parseData.closed_by);
                    $('#closeddate').val(parseData.closed_dt);

                    // alert(mnth);
                    if (parseFloat(mnth) == 12) {
                        // alert(yr);
                        mnth = 1;
                        yr = parseFloat(yr) + 1;
                    } else {
                        mnth = parseFloat(mnth) + 1;
                    }

                    if (parseFloat(mnth) == 1) {
                        mnth_nm = 'JAN';
                    } else if (parseFloat(mnth) == 2) {
                        mnth_nm = 'FEB';
                    } else if (parseFloat(mnth) == 3) {
                        mnth_nm = 'MAR';
                    } else if (parseFloat(mnth) == 4) {
                        mnth_nm = 'APR';
                    } else if (parseFloat(mnth) == 5) {
                        mnth_nm = 'MAY';
                    } else if (parseFloat(mnth) == 6) {
                        mnth_nm = 'JUN';
                    } else if (parseFloat(mnth) == 7) {
                        mnth_nm = 'JUL';
                    } else if (parseFloat(mnth) == 8) {
                        mnth_nm = 'AUG';
                    } else if (parseFloat(mnth) == 9) {
                        mnth_nm = 'SEP';
                    } else if (parseFloat(mnth) == 10) {
                        mnth_nm = 'OCT';
                    } else if (parseFloat(mnth) == 11) {
                        mnth_nm = 'NOV';
                    } else if (parseFloat(mnth) == 12) {
                        mnth_nm = 'DEC';
                    }

                    $('#yr_nm').val(yr);
                    $('#yr_sl').val(yr);
                    $('#mnth_nm').val(mnth_nm);
                    $('#mnth_id').val(mnth);
                    mtVal();


                });


        });
        $('#dist').change(function() {

            $.get(

                    '<?php echo site_url("transaction/f_get_onholdv"); ?>', {


                        dist_cd: $(this).val()


                    }

                )
                .done(function(data) {


                    $('#onholdv').val(data);

                    if (data > 0) {
                        alert("Some vouchers are on hold.Please contact branch!");
                        // $('#submit').attr('type', 'buttom');

                        $("#submit").attr("disabled", true);
                        return false;
                    } else {
                        // $('#submit').attr('type', 'submit');
                        $("#submit").attr("disabled", false);
                    }
                });


        });


    });




    // $("#mnth_id").change(function(){
    //     alert($(this).val());
    // });
    function mtVal() {
        var year = $("#mnth_id").val();

        $.get(
                '<?php echo site_url("transaction/checked_MonthEnd"); ?>', {
                    year: year
                }
            )
            .done(function(data) {
               //  alert(data);
                if (data == 1) {
                    $('#submit').attr('type', 'submit');
                } else {
                    $('#submit').attr('type', 'buttom');
                    return false;
                }
            });

    }

    $('.addAnotherrow').click(function(){
    let row = '<tr>'+
                '<td><input type="text" name="name[]" class="form-control"></td><td><input type="file" name="fileToUpload[]" required class="form-control doc"></td>'
                +'<td><button type="button" class="btn btn-danger removeRow"><i class="fa fa-remove"></i></button></td>'
            +'</tr>';
    $('#intro2').append(row);
});

$("#intro2").on('click', '.removeRow',function(){
    $(this).parents('tr').remove();
});

$(document).ready(function() {
    $('#intro2').on('change', '.doc', function(){

        var ext = $(this).val().split('.').pop().toLowerCase();
        if($.inArray(ext, ['pdf']) == -1) {
                    // Swal.fire({
                    //     text: 'invalid extension!',
                    //     position: "middle",
                    //     color: '#f0f0f0',
                    //     timer: 100000
                    // });
            alert('Invalid Extension')        
            $(this).val('');
        }else{
                //  2000000  => 2MB  File size 
            if(this.files[0].size > 2000000) {
                    // Swal.fire({
                    //         text: "Please upload file up to 8MB. Thanks!!",
                    //         position: "middle",
                    //         color: '#f0f0f0',
                    //         timer: 100000
                    // });
            alert('Please upload file up to 2MB. Thanks!!')  
            $(this).val('');
            }
            }
    });
})
</script>