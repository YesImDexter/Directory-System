<h3 class="p-2"> Appointment Directory </h3>

<!-- CDN FOR DATA TABLES -->

<!-- DATA TABLE -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>

<!-- DATA TABLE RESPONSIVE -->
<script type="text/javascript" src="https://cdn.datatables.net/rowreorder/1.3.2/js/dataTables.rowReorder.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.3.2/css/rowReorder.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">

<hr>

<div class="container">
    <div class="d-flex justify-content-between">
        <div>
            <form class="d-flex">
                <a href="<?= base_url('staff-filter') ?>" class="btn btn-warning font-weight-bold"> Advanced Filtering <i class="fa fa-filter px-1"></i></a>
            </form>
        </div>
        <div>
            <a href="<?= base_url('appointment-create') ?>" class="btn btn-primary mr-1 ml-1"><i class="fa fa-plus"></i></a>
        </div>
    </div>
</div>

<?php //echo print_r($member_count) 
?>

<?php if (session()->getFlashData('status')) : ?>
    <div class="container">
        <hr>
        <div class="alert alert-success" role="alert"><i class="fa fa-check"></i>
            <?= session()->get('status') ?>
        </div>
    </div>
<?php endif; ?>

<hr>

<div class="container">
    <!-- Table Hover/Nowarp  -->
    <table id="datatable_var" class="table hover nowrap" style="width:100%">
        <thead>
            <tr>
                <th data-priority="4" style="width:1%;"><i class="fa-sharp fa-solid fa-hashtag mr-2"></i></th>
                <th data-priority="1"><i class="fa-solid fa-certificate mr-2"></i>Committee</th>
                <th data-priority="3"> <i class="fa-solid fa-user-group mr-2"></i>Members</th>
                <th data-priority="2" style="width:1%;"><i class="fa-solid fa-bars-progress mr-2"></i>Manage</th>
            </tr>
        </thead>

        <style>
            table.dataTable>tbody>tr.child span.dtr-title {
                width: 55%;
            }
        </style>

        <tbody>
            <?php $i = 1;
            foreach ($appointment_array as $row) :  ?>
                <tr>
                    <td> <?= $i . '.';
                            $i = $i + 1; ?> </td>
                    <td> <?= $row['app_committee'] ?></td>
                    <td> <?php if ($row['member_count'] == 0) {
                                echo "No Members";
                            } else {
                                echo $row['member_count'];
                            }
                            ?></td>
                    <td>
                        <div class="row d-inline">
                            <a href="<?= base_url('appointment-view/' . $row['app_id']) ?>" class="btn w-auto btn-info mr-1 ml-1"><i class="fa-solid fa-list"></i></a>
                            <button type="button" value="<?= $row['app_id'] ?>" class="delete_appointment btn w-auto btn-danger mr-1 ml-1"><i class="fa-solid fa-trash"></i></button>

                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {

        $('.delete_appointment').on('click', function(event) {
             event.preventDefault();
             var app_id = $(this).val();

             Swal.fire({
                 title: 'Delete Appointment ?',
                 text: "You won't be able to revert this!",
                 icon: 'warning',
                 showCancelButton: true,
                 confirmButtonColor: '#3fc3ee',
                 cancelButtonColor: '#f27474',
                 confirmButtonText: 'Yes, Delete Appointment'

             }).then((result) => {
                 if (result.isConfirmed) {
                     $.ajax({
                         url: '/ajax_requests_appointment',
                         method: 'post',
                         headers: {
                             'X-Requested-With': 'XMLHttpRequest',
                         },
                         data: {
                             app_id: app_id,
                             action: "delete_appointment",
                         },
                         dataType: 'JSON',
                         success: function(data) {
                             if (data == true) {
                                 Swal.fire(
                                     'Removed !',
                                     'Appointment has been successfully deleted.',
                                     'success'
                                 ).then(function() {
                                     location.reload();
                                 });
                             } else if (data == false) {
                                 Swal.fire(
                                     'Failed !',
                                     'Appointment failed to be deleted.',
                                     'warning'
                                 )
                             } else {
                                 Swal.fire(
                                     'Error !',
                                     'SYSTEM ERROR.',
                                     'error'
                                 )
                             }
                         },
                         error: function(data) {
                             console.log("FAILED");

                         }
                     });
                 }
             })
         });

        $('#datatable_var').DataTable({
            pagination: true,
            bFilter: true,
            bInfo: true,

            language: {
                searchPlaceholder: "Search Records",
                "search": "",
                "lengthMenu": " _MENU_ ",
            },
            responsive: true,

            columnDefs: [{
                orderable: false,
                targets: 3
            }]
        });
    });
</script>