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

<div class="container">
    <div class="container d-flex justify-content-between">
        <!-- $appointment_array['app_committee'] -->
        <h3> <?= $appointment_array['app_committee'] ?> </h3>
        <a href="<?= base_url('appointment') ?>" class="btn btn-warning mr-1 ml-1"> Back </a>
    </div>

    <?php if (session()->getFlashData('status')) : ?>
        <div class="container">
            <hr>
            <div class="alert alert-success" role="alert"><i class="fa fa-check" aria-hidden="true"></i>
                <?= session()->get('status') ?>
            </div>
        </div>
    <?php endif; ?>

 <hr>

    <div class="container d-flex justify-content-between mb-3">
        <a href="<?= base_url('appointment-edit/' . $appointment_array['app_id']) ?>" class="btn w-auto btn-info mr-1 ml-1 "><i class="fa-regular fa-pen-to-square"></i></a>
        <a href="<?= base_url('appointment-assign/' . $appointment_array['app_id']) ?>" class="btn w-auto btn-info mr-1 ml-1"><i class="fa-solid fa-user-plus"></i></a>
    </div>

    <div class="container">
        <table id="datatable_var" class="table hover nowrap" style="width:100%">
            <thead>
                <tr>
                    <th data-priority="7" style="width:1%;"></i><i class="fa-sharp fa-solid fa-hashtag mr-2"></i></th>
                    <th data-priority="1"><i class="fa fa-user mr-2"></i>Staff</th>
                    <th data-priority="3"><i class="fa fa-user mr-2"></i>Position</th>
                    <th data-priority="6"><i class="fa-solid fa-briefcase mr-2"></i>Campus</th>
                    <th data-priority="4"><i class="fa-solid fa-calendar-week mr-2"></i>Start Date</th>
                    <th data-priority="5"><i class="fa-solid fa-calendar-week mr-2"></i>End Date</th>
                    <th data-priority="2" style="width:1%;"><i class="fa-solid fa-bars-progress mr-2"></i>Manage</th>
                </tr>
            </thead>

            <style>
                table.dataTable>tbody>tr.child span.dtr-title {
                    width: 40%;
                }
            </style>

            <tbody>
                <?php $i = 1;
                foreach ($staff_array as $row) :  ?>
                    <tr>
                        <td> <?= $i . '.';
                                $i = $i + 1; ?> </td>
                        <td> <?= $row['staff_name'] ?> </td>
                        <td> <?= $row['app_position'] ?> </td>
                        <td> <?= $row['camp_name'] ?> </td>
                        <td> <?= $row['start_date']; ?> </td>
                        <td> <?= $row['end_date']; ?> </td>
                        <td>
                            <div class="row d-inline"><a href="<?= base_url('appointment-reassign/' . $row['app_staff_id']) ?>" class="btn w-auto btn-info mr-1 ml-1"><i class="fa-regular fa-pen-to-square"></i> </a>
                                <button type="button" value="<?= $row['app_staff_id'] ?>" class="remove_staff btn w-auto btn-danger mr-1 ml-1"><i class="fa-solid fa-trash"></i></button>
                                <a href="<?= base_url('staff-view/'  . $row['staff_uid']) ?>" class="btn w-auto btn-secondary mr-1 ml-1"><i class="fa-solid fa-circle-info"></i></a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>

<script>
    $(document).ready(function() {

        $('.remove_staff').on('click', function(event) {
             event.preventDefault();
             var app_staff_id = $(this).val();

             Swal.fire({
                 title: 'Remove Staff?',
                 text: "You won't be able to revert this!",
                 icon: 'warning',
                 showCancelButton: true,
                 confirmButtonColor: '#3fc3ee',
                 cancelButtonColor: '#f27474',
                 confirmButtonText: 'Yes, Remove Staff'

             }).then((result) => {
                 if (result.isConfirmed) {
                     $.ajax({
                         url: '/ajax_requests_appointment',
                         method: 'post',
                         headers: {
                             'X-Requested-With': 'XMLHttpRequest',
                         },
                         data: {
                             app_staff_id: app_staff_id,
                             action: "remove_appointment",
                         },
                         dataType: 'JSON',
                         success: function(data) {
                             if (data == true) {
                                 Swal.fire(
                                     'Removed !',
                                     'Staff has been successfully removed.',
                                     'success'
                                 ).then(function() {
                                     location.reload();
                                 });
                             } else if (data == false) {
                                 Swal.fire(
                                     'Failed !',
                                     'Staff failed to be removed.',
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
                             console.log(app_staff_id);
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
                targets: 6
            }]
        });
    });
</script>