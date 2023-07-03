<div class="container">
    <div class="row">
        <div class="col-12 mt-4 mb-4 pt-3 pb-3 bg-white">
            <div class="container">
                <div class="container d-flex justify-content-between">
                    <h3> <?php if (isset($appointment_array['app_id'])) {
                                echo "EDIT APPOINTMENT";
                            } else {
                                echo "ADD APPOINTMENT";
                            } ?> </h3>

                    <a class="btn btn-warning" id="back-btn"> Back </a>
                </div>

                <!-- VALIDATION ERRORS -->
                <?php if (isset($error_list)) : ?>
                    <hr>
                    <div class="alert alert-danger">
                        <?php foreach ($error_list as $error) : ?>
                            <?php foreach ($error as $error_string) : ?>
                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                <?= $error_string ?><br>
                            <?php endforeach ?>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>

                <hr>

                <div class="container">
                    <form action="<?php if (isset($appointment_array['app_id'])) {
                                        echo '/appointment-edit' . '/' .  $appointment_array['app_id'];
                                    } else {
                                        echo "/appointment-create";
                                    } ?>" method="post">
                        <div class="form-group">
                            <label for="inputName">Committee Title</label>
                            <input name="a_committee" type="text" class="form-control" placeholder="Committee Name" value="<?php
                                                                                                                            if (isset($_POST['a_committee'])) {
                                                                                                                                echo $_POST['a_committee'];
                                                                                                                            } else if (isset($appointment_array['app_committee'])) {
                                                                                                                                echo $appointment_array['app_committee'];
                                                                                                                            } else {
                                                                                                                                echo set_value('a_committee');
                                                                                                                            } ?>">
                        </div>

                        <hr>

                        <div class="container">
                            <div class="d-flex justify-content-end">
                                <?php if (isset($appointment_array['app_committee'])) : ?>
                                    <input type="submit" class="btn btn-primary mr-1 ml-1" value="Update" id="update-btn">
                                <?php else : ?>
                                    <input type="reset" class="btn btn-secondary mr-1 ml-1" value="Clear" id="clear-btn">
                                    <input type="submit" class="btn btn-primary mr-1 ml-1" value="Add">
                                <?php endif; ?>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <script>
                // DYNAMIC DROPDOWN
                $(document).ready(function() {

                    $('#back-btn').click(function(event) {
                        event.preventDefault();

                        Swal.fire({
                            title: 'Exit without saving changes ?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#a5dc86',
                            cancelButtonColor: '#f27474',
                            confirmButtonText: 'Confirm'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                if (<?php if(isset($appointment_array['app_id'])){ echo json_encode(TRUE); }else{ echo json_encode(FALSE) ;} ?>) {
                                    window.location.href = "/appointment-view/<?= $appointment_array['app_id'];?>";
                                } else {
                                    window.location.href = "/appointment";
                                }
                            }
                        })
                    });


                })
            </script>