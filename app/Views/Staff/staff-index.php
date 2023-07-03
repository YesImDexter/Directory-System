 <h3 class="p-2"> Staff Directory </h3>

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
             <a href="<?= base_url('staff-create') ?>" class="btn btn-primary mr-1 ml-1"><i class="fa-solid fa-user-plus"></i></a>
         </div>
     </div>
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

 <div class="container">
     <table id="datatable_var" class="table hover nowrap" style="width:100%">
         <thead>
             <tr>
                 <th data-priority="6" style="width:1%;"></i><i class="fa-sharp fa-solid fa-hashtag mr-2"></i></th>
                 <th data-priority="1" style="width:20%;"><i class="fa fa-user mr-2"></i>Staff</th>
                 <th data-priority="3"><i class="fa-solid fa-briefcase  mr-2"></i>Unit</th>
                 <th data-priority="4"><i class="fa-solid fa-user-group mr-2"></i>Division</th>
                 <th data-priority="5"><i class="fa-solid fa-building mr-2"></i>Campus</th>
                 <th data-priority="2" style="width:3%;"><i class="fa-solid fa-bars-progress mr-2"></i>Manage</th>
             </tr>
         </thead>

         <tbody>
             <?php $i = 1;
                foreach ($staff_array as $row) : ?>
                 <tr>
                     <td> <?= $i . '.';
                            $i = $i + 1; ?> </td>
                     <td> <?= $row['staff_name'] ?></td>

                     <td> <?= $row['staff_unit'] ?></td>

                     <td> <?= $row['div_name'] ?> </td>

                     <td> <?= $row['camp_name'] ?> </td>

                     <td>
                         <div class="row d-inline">
                             <a href="<?= base_url('staff-edit/' . $row['staff_uid']) ?>" class="btn w-auto btn-info mr-1 ml-1"><i class="fa-regular fa-pen-to-square"></i> </a>
                             <button type="button" value="<?= $row['staff_uid'] ?>" class="delete_staff btn w-auto btn-danger mr-1 ml-1"><i class="fa-solid fa-trash"></i></button>
                             <a href="<?= base_url('staff-view/'  . $row['staff_uid']) ?>" class="btn w-auto btn-secondary mr-1 ml-1"><i class="fa-solid fa-circle-info"></i></a>
                         </div>
                     </td>
                 </tr>
             <?php endforeach; ?>
         </tbody>
     </table>
 </div>

 <script>
     $(document).ready(function() {

         $('.delete_staff').on('click', function(event) {
             event.preventDefault();
             var staff_uid = $(this).val();
             console.log(staff_uid)

             Swal.fire({
                 title: 'Delete Staff ?',
                 text: "You won't be able to revert this!",
                 icon: 'warning',
                 showCancelButton: true,
                 confirmButtonColor: '#3fc3ee',
                 cancelButtonColor: '#f27474',
                 confirmButtonText: 'Yes, Delete Staff'

             }).then((result) => {
                 if (result.isConfirmed) {
                     $.ajax({
                         url: '/ajax_requests',
                         method: 'post',
                         headers: {
                             'X-Requested-With': 'XMLHttpRequest',
                         },
                         data: {
                             staff_uid: staff_uid,
                             action: "delete_staff",
                         },
                         dataType: 'JSON',
                         success: function(data) {
                             if (data == true) {
                                 Swal.fire(
                                     'Deleted !',
                                     'Staff has been successfully deleted.',
                                     'success'
                                 ).then(function() {
                                     location.reload();
                                 });
                             } else if (data == false) {
                                 Swal.fire(
                                     'Failed !',
                                     'Staff failed to be deleted.',
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
                 targets: 5
             }]
         });
     });
 </script>