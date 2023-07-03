<div class="container">
    <div class="row">
        <div class="col-12 mt-4 mb-4 pt-3 pb-3 bg-white">
            <div class="container">
                <div class="container d-flex justify-content-between">
                    <h3> ASSIGN APPOINTMENT </h3>
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
                    <form action="<?php if (isset($data['id'])) {
                                        echo '/appointment-reassign' . '/' . $id;
                                    } else {
                                        echo '/appointment-assign' . '/' . $appointment_array['app_id'];
                                    } ?>" method="post">
                        <div class="form-group">

                            <label for="inputName">Staff Name</label>
                            <select <?php if (isset($id)) {
                                        echo "disabled";
                                    } else {
                                        echo "";
                                    } ?> name="s_uid" id="s_uid" class="form-control js-example-basic-single">
                                <?php if (isset($_POST['s_uid'])) : ?>
                                    <?php foreach ($staff_array as $row) : ?>
                                        <?php if ($row['staff_uid'] == $_POST['s_uid']) : ?>
                                            <option selected value="<?= $row['staff_uid'] ?>"><?= $row['staff_name'] ?></option>
                                        <?php else : ?>
                                            <option value="<?= $row['staff_uid'] ?>"><?= $row['staff_name'] ?></option>
                                        <?php endif ?>
                                    <?php endforeach; ?>

                                <?php else : ?>
                                    <option selected value=""> Choose Staff </option>
                                    <?php foreach ($staff_array as $row) : ?>
                                        <option value="<?= $row['staff_uid'] ?>"><?= $row['staff_name'] ?></option>
                                    <?php endforeach; ?>
                                <?php endif ?>

                            </select>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="inputName">Committee Position</label>
                                        <select name="a_position" id="a_position" class="form-control js-example-basic-single">
                                            <?php
                                            // Iterating Through the Position Array
                                            if (isset($_POST['a_position'])) {
                                                foreach ($app_position_array as $app_position) {
                                                    if ($app_position == $_POST['a_position']) {
                                                        echo "<option selected value='$app_position'>$app_position</option>";
                                                    } else {
                                                        echo "<option value='$app_position'>$app_position</option>";
                                                    }
                                                }
                                            } else {
                                                foreach ($app_position_array as $app_position) {
                                                    echo "<option value='$app_position'>$app_position</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="inputName">Start Date</label>
                                        <div class="input-group date" id="datepicker">
                                            <input type="date" class="form-control" id="date" name="start_date" value="<?php if (isset($_POST['start_date'])) {
                                                                                                                            echo $_POST['start_date'];
                                                                                                                        } else {
                                                                                                                            echo set_value('start_date');
                                                                                                                        } ?>">
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="inputName">End Date</label>
                                        <div class="input-group date" id="datepicker">
                                            <input type="date" class="form-control" id="date" name="end_date" value="<?php if (isset($_POST['end_date'])) {
                                                                                                                            echo $_POST['end_date'];
                                                                                                                        } else {
                                                                                                                            echo set_value('end_date');
                                                                                                                        } ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="container">
                                <div class="d-flex justify-content-end">
                                        <input type="reset" class="btn btn-secondary mr-1 ml-1" value="Clear" id="clear-btn">
                                        <input type="submit" class="btn btn-primary mr-1 ml-1" value="Add">
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
            });

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
                        window.location.href = <?= '"' . base_url('appointment-view') . '/' . $appointment_array['app_id'] . '"'?> ;
                    }
                })
            });
        </script>