<div class="container">
    <div class="row">
        <div class="col-12 mt-4 mb-4 pt-3 pb-3 bg-white">
            <div class="container">
                <div class="container d-flex justify-content-between">
                    <h3> <?php if (isset($division_array['div_id'])) {
                                echo "EDIT DIVISION";
                            } else {
                                echo "ADD DIVISION";
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
                    <form id="division-form" action="<?php if (isset($division_array['div_id'])) {
                                                        echo '/division-edit' . '/' .  $division_array['div_id'];
                                                    } else {
                                                        echo "/division-create";
                                                    } ?>" enctype="multipart/form-data" method="post">

                        <div class="d-flex justify-content-center m-3">
                            <img id="img_placeholder" class="circle-img" src="<?php if (isset($division_array['div_image']) && $division_array['div_image'] != "") {
                                                                                    echo "." . division_upload_path . $division_array['div_image'];
                                                                                } else {
                                                                                    echo "http://via.placeholder.com/150x150";
                                                                                } ?>" onclick="UploadImage()">
                            <input type="file" name="img" id="img" onchange="LoadImage(event)" accept="<?= '.' . implode(', .', img_array_glob) ?>" style="display: none;">
                        </div>

                        <div class="d-flex justify-content-center m-3">
                            <input type="hidden" onclick="ClearImage()" id="clear_button" class="btn btn-danger" value="Clear Picture">
                        </div>

                        <input name="var_clear" id="var_clear" value="" hidden>

                        <hr>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="inputName">Division Name</label>
                                        <input name="d_name" type="text" class="form-control" id="inputName" placeholder="Division Name" value="<?php
                                                                                                                                                if (isset($_POST['d_name'])) {
                                                                                                                                                    echo $_POST['d_name'];
                                                                                                                                                } else if (isset($division_array['div_name'])) {
                                                                                                                                                    echo $division_array['div_name'];
                                                                                                                                                } else {
                                                                                                                                                    echo set_value('d_name');
                                                                                                                                                } ?>">
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Division Description</label>
                            <textarea name="d_desc" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="A Simple Description"><?php
                                                                                                                                                        if (isset($_POST['d_desc'])) {
                                                                                                                                                            echo $_POST['d_desc'];
                                                                                                                                                        } else if (isset($division_array['div_desc'])) {
                                                                                                                                                            echo $division_array['div_desc'];
                                                                                                                                                        } else {
                                                                                                                                                            echo  set_value('d_desc');
                                                                                                                                                        } ?></textarea>
                        </div>

                        <!-- FOR CAMPUS, DIVISION, UNIT, ASSIGN -->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="d_camp">Campus</label>
                                        <select name="d_camp" id="d_camp" class="form-control js-example-basic-single">
                                            <option value="0">Unassigned</option>
                                            <?php if (isset($_POST['d_camp'])) : ?>
                                                <?php foreach ($campus_array as $row) : ?>
                                                    <?php if ($row['camp_id'] == $_POST['d_camp']) : ?>
                                                        <option selected value="<?= $row['camp_id'] ?>"><?= $row['camp_name'] ?></option>
                                                    <?php else : ?>
                                                        <option value="<?= $row['camp_id'] ?>"><?= $row['camp_name'] ?></option>
                                                    <?php endif ?>
                                                <?php endforeach; ?>

                                            <?php elseif (isset($division_array['camp_id'])) : ?>
                                                <?php foreach ($campus_array as $row) : ?>
                                                    <?php if ($row['camp_id'] == $division_array['camp_id']) : ?>
                                                        <option selected value="<?= $row['camp_id'] ?>"><?= $row['camp_name'] ?></option>
                                                    <?php else : ?>
                                                        <option value="<?= $row['camp_id'] ?>"><?= $row['camp_name'] ?></option>
                                                    <?php endif ?>
                                                <?php endforeach; ?>

                                            <?php else : ?>
                                                <?php foreach ($campus_array as $row) : ?>
                                                    <option value="<?= $row['camp_id'] ?>"><?= $row['camp_name'] ?></option>
                                                <?php endforeach; ?>
                                            <?php endif ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="container">
                            <div class="d-flex justify-content-end">
                                <div>
                                    <?php if (isset($division_array['div_id'])) : ?>
                                        <input type="submit" class="btn btn-primary mr-1 ml-1" value="Update" id="update-btn">
                                    <?php else : ?>
                                        <input type="reset" class="btn btn-secondary mr-1 ml-1" value="Clear" id="clear-btn">
                                        <input type="submit" class="btn btn-primary mr-1 ml-1" value="Add">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // DYNAMIC DROPDOWN
        $(document).ready(function() {
            SetClearImageButton()

            $('.js-example-basic-single').select2();
        });

        $('#clear-btn').click(function(event) {
            document.getElementById('division-form').reset();
        });

        $('#update-btn').click(function(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Confirm Changes ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#a5dc86',
                cancelButtonColor: '#f27474',
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#division-form').submit();
                }
            })
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
                    window.location.href = "/division" ;
                }
            })
        });


        // PREVIEW IMAGES
        function UploadImage() {
            document.getElementById("img").click();
        }

        var LoadImage = function(event) {
            var image = document.getElementById('img_placeholder');
            image.src = URL.createObjectURL(event.target.files[0]);
            document.getElementById('clear_button').type = "button";

            //TRIGGER FOR CLEAR IMAGE
            document.getElementById("var_clear").value = "";
        }

        function ClearImage() {
            document.getElementById("img").value = "";
            document.getElementById("img_placeholder").src = "http://via.placeholder.com/150x150";
            document.getElementById('clear_button').type = "hidden";

            //TRIGGER FOR CLEAR IMAGE
            document.getElementById("var_clear").value = "clear";
        }

        function SetClearImageButton() {
            if (<?php if (isset($division_array['div_image'])) {
                    if ($division_array['div_image'] != "") {
                        echo json_encode(TRUE);
                    } else {
                        echo json_encode(FALSE);
                    }
                } else {
                    echo json_encode(FALSE);
                } ?>) {
                document.getElementById('clear_button').type = "button";
            } else {
                document.getElementById('clear_button').type = "hidden";
            }
        }
    </script>