<style>
    table {
        border-collapse: collapse;
    }

    table,
    td,
    th {
        border: 1px solid #dddddd;

        padding: 6px;

        font-size: 14px;
    }

    th {

        text-align: center;

    }

    tr:hover {
        background-color: #f5f5f5;
    }
</style>

<script>
    function printDiv() {

        var divToPrint = document.getElementById('divToPrint');

        var WindowObject = window.open('', 'Print-Window');
        WindowObject.document.open();
        WindowObject.document.writeln('<!DOCTYPE html>');
        WindowObject.document.writeln('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title></title><style type="text/css">');


        WindowObject.document.writeln('@media print { .center { text-align: center;}' +
            '                                         .inline { display: inline; }' +
            '                                         .underline { text-decoration: underline; }' +
            '                                         .left { margin-left: 315px;} ' +
            '                                         .right { margin-right: 375px; display: inline; }' +
            '                                          table { border-collapse: collapse; font-size: 12px;}' +
            '                                          th, td { border: 1px solid black; border-collapse: collapse; padding: 6px;}' +
            '                                           th, td { }' +
            '                                         .border { border: 1px solid black; } ' +
            '                                         .bottom { bottom: 5px; width: 100%; position: fixed ' +
            '                                       ' +
            '                                   } } </style>');
        WindowObject.document.writeln('</head><body onload="window.print()">');
        WindowObject.document.writeln(divToPrint.innerHTML);
        WindowObject.document.writeln('</body></html>');
        WindowObject.document.close();
        setTimeout(function() {
            WindowObject.close();
        }, 10);

    }
</script>






<div class="wraper">

    <div class="col-lg-12 container contant-wraper">

        <div id="divToPrint">

            <div style="text-align:center;">

                <h2>THE WEST BENGAL STATE CO.OP.MARKETING FEDERATION LTD.</h2>
                <h4>HEAD OFFICE: SOUTHEND CONCLAVE, 3RD FLOOR, 1582 RAJDANGA MAIN ROAD, KOLKATA-700107.</h4>
                <h4>Godown Details Between: <?php echo $_SESSION['date']; ?></h4>
                <!-- <h5 style="text-align:left"><label>District: </label> <?php echo $branch->district_name; ?></h5> -->

            </div>
            <br>

            <table style="width: 100%;" id="example">

                <thead>
                    <!-- <tr>
                        <th>District</th>
                        <th>Name </th>
                        <th>Address</th>
                        <th>Location</th>
                        <th>Capasity</th>
                        <th>Mouja</th>
                        <th>Dag No</th> -->
                        

                        <!-- <th colspan=4><b>Solid(MTS)</b></th>
                        <th colspan=5><b>Liquid(LTR)</b></th> -->
                    <!-- </tr> -->

                    <tr>

                        <th>Sl No.</th>
                        <th>District</th>
                        <th>Name </th>
                        <th>Address</th>
                        <th>Location</th>
                        <th>Capacity</th>
                        <th>Mouja</th>
                        <th>Daag No</th>       
                        <th>Khotian</th>
                        <th>Daag Type</th>
                        <th>Touzi No.</th>
                        <th>Floor Area(sq.ft.)</th>
                        <th>DISTANCE FROM NEAREST RAKE POINT</th>
                        <th>DISTANCE FROM ROAD:</th>
                        <th>BRAEDTH OF APPROACH ROAD:</th>
                        <th>TYPE OF APP. ROAD:</th>
                        <th>PHYSICAL CONDITION:</th>
                        <th>CONDITION OF ELECTRICITY:</th>
                        <th>VENTILLATION:</th>
                        <th>PLINTH HEIGHT:</th>
                        <th>INTERNAL/EXTERNAL WIRING:</th>
                        <th>RENT STATUS:</th>
                        <th>Utilization Purpose:</th>
                        <th>fire extinguisher</th>
                        <th>Rent Duration</th>
                        <th>Rent start Date</th>
                        <th>Rent End Date</th>
                        <th>Monthly Rent Amount</th>
       
                        
                    </tr>

                </thead>

                <tbody>

                    <?php

                    if ($godown) {

                        $i = 1;
                        // $total = 0.00;
                        // $sldtotal_sale = 0.00;
                        // $lqdtotal_sale = 0.00;
                        // $sldtotal_pur = 0.00;
                        // $lqdtotal_pur = 0.00;
                        // $sldtot_op = 0.00;
                        // $lqdtot_op = 0.00;
                        // $sldcls_baln = 0.00;
                        // $lqdcls_baln = 0.00;
                        // $lqdtotal = 0.00;
                        // $sldtotal = 0.00;
                        // $val = 0;

                        foreach ($godown as $gd) {
                    ?>

                            <tr class="rep">
                                <td class="report"><?php echo $i++; ?></td>
                                <!-- <td></td> -->
                                <td class="report"><?php echo $gd->district_name; ?>
                                <td class="report name" id="name">
                                <?php echo $gd->w_name; ?>
                                </td>
                                <td class="report addrs" id="addrs">
                                <?php echo $gd->w_addrs; ?>
                                </td>
                                <td class="report location" id="location">
                                <?php echo $gd->location; ?>
                                </td>
                                <td class="report capacity" id="capacity">
                                <?php echo $gd->capacity; ?> 
                                </td>
                                <td class="report mouza" id="mouza">
                                <?php echo $gd->mouza; ?> 
                                </td>

                                <td class="report dag" id="dag">
                                <?php echo $gd->dag; ?>   
                               
                                </td>

                                <td class="report khotian" id="khotian">
                                <?php echo $gd->khotian; ?> 
                                </td>
                                <td class="report daag_type" id="daag_type">
                                <?php echo $gd->dagty; ?> 
                                </td>
                                <td class="report touzi" id="touzi">
                                <?php echo $gd->touzi; ?> 
                                </td>
                                <td class="report floorarea" id="floorarea">
                                <?php echo $gd->floorarea; ?> 
                                </td>
                                <td class="report disnrp" id="disnrp">
                                <?php echo $gd->disnrp; ?> 
                                </td>
                                <td class="report disfr" id="disfr">
                                <?php echo $gd->disfr; ?> 
                                </td>
                                <td class="report bar" id="bar">
                                <?php echo $gd->bar; ?> 
                                </td>
                                <td class="report tar" id="tar">
                                <?php echo $gd->tar; ?> 
                                </td>
                                <td class="report phc" id="phc">
                                <?php echo $gd->phc; ?> 
                                </td>
                                <td class="report eleccon" id="eleccon">
                                <?php echo $gd->eleccon; ?> 
                                </td>
                                <td class="report venti" id="venti">
                                <?php echo $gd->venti; ?> 
                                </td>

                                <td class="report ph" id="ph">
                                <?php echo $gd->ph; ?> 
                                </td>
                                <td class="report iew" id="iew">
                                <?php echo $gd->iew; ?> 
                                </td>
                                <td class="report status" id="status">
                                <?php echo $gd->status; ?> 
                                </td>
                                <td class="report purpose" id="purpose">
                                <?php echo $gd->purpose; ?> 
                                </td>
                                <td class="report fireext" id="fireext">
                                <?php echo $gd->fireext; ?> 
                                </td>
                                <td class="report rent_duration" id="rent_duration">
                                <?php echo $gd->rent_duration; ?> 
                                </td>
                                <td class="report rent_st_dt" id="rent_st_dt">
                                <?php echo $gd->rent_st_dt; ?> 
                                </td>
                                <td class="report rent_end_dt" id="rent_end_dt">
                                <?php echo $gd->rent_end_dt; ?> 
                                </td>
                                <td class="report monthly_remt_amt" id="monthly_remt_amt">
                                <?php echo $gd->monthly_remt_amt; ?> 
                                </td>
                               

                            </tr>

                        <?php

                        }
                        ?>


                    <?php
                    } else {

                        echo "<tr><td colspan='14' style='text-align:center;'>No Data Found</td></tr>";
                    }

                    ?>

                </tbody>
                <tfooter>
                    <tr>
                        <td class="report" colspan="2" style="text-align:left"><b>Total</b></td>
                        <!-- <td class="report"></td> -->

                        <!-- <td class="report"><b><?= $sldtot_op ?></b></td>
                        <td class="report"><b><?= $sldtotal_pur ?></b></td>
                        <td class="report"><b><?= $sldtotal_sale ?></b></td>
                        <td class="report"><b><?= $sldtotal ?></b></td>
                        <td class="report"><b><?= $lqdtot_op ?></b></td>
                        <td class="report"><b><?= $lqdtotal_pur ?></b></td>
                        <td class="report"><b><?= $lqdtotal_sale ?></b></td>
                        <td class="report"><b><?= $lqdtotal ?></b></td> -->
                        <!-- <td class="report"></td>  -->

                        <!-- <td class="report"><?= $total ?></td>   -->

                    </tr>
                </tfooter>
            </table>

        </div>

        <div style="text-align: center;">

            <button class="btn btn-primary" type="button" onclick="printDiv();">Print</button>
            <!-- <button class="btn btn-primary" type="button" id="btnExport" >Excel</button>-->

        </div>

    </div>

</div>


<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css" rel="stylesheet" />
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>

<script>
    $('#example').dataTable({
        destroy: true,
        searching: false,
        ordering: false,
        paging: false,

        dom: 'Bfrtip',
        buttons: [{
            extend: 'excelHtml5',
            title: ' godown_dtls',
            text: 'Export to excel'

        }]
    });
</script>