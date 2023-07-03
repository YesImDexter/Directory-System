<div class="container">
    <div class="row">
        <div class="col-12 mt-4 mb-4 pt-3 pb-3 bg-white">
            <div class="container">
                <div class="container d-flex justify-content-between">
                    <h3> <?php if (isset($campus_array['camp_id'])) {
                                echo "EDIT CAMPUS";
                            } else {
                                echo "ADD CAMPUS";
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
                    <form id="campus-form" action="<?php if (isset($campus_array['camp_id'])) {
                                                        echo '/campus-edit' . '/' .  $campus_array['camp_id'];
                                                    } else {
                                                        echo "/campus-create";
                                                    } ?>" enctype="multipart/form-data" method="post">

                        <div class="d-flex justify-content-center m-3">
                            <img id="img_placeholder" class="circle-img" src="<?php if (isset($campus_array['camp_image']) && $campus_array['camp_image'] != "") {
                                                                                    echo "." . campus_upload_path . $campus_array['camp_image'];
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
                                        <label for="inputName">Campus Name</label>
                                        <input name="c_name" type="text" class="form-control" id="inputName" placeholder="Campus Name" value="<?php
                                                                                                                                                if (isset($_POST['c_name'])) {
                                                                                                                                                    echo $_POST['c_name'];
                                                                                                                                                } else if (isset($campus_array['camp_name'])) {
                                                                                                                                                    echo $campus_array['camp_name'];
                                                                                                                                                } else {
                                                                                                                                                    echo set_value('c_name');
                                                                                                                                                } ?>">
                                    </div>
                                </div>

                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="inputName">Campus Acronym</label>
                                        <input name="c_acronym" type="text" class="form-control" id="inputName" placeholder="Campus Acronym" value="<?php
                                                                                                                                                    if (isset($_POST['c_acronym'])) {
                                                                                                                                                        echo $_POST['c_acronym'];
                                                                                                                                                    } else if (isset($campus_array['camp_acronym'])) {
                                                                                                                                                        echo $campus_array['camp_acronym'];
                                                                                                                                                    } else {
                                                                                                                                                        echo set_value('c_acronym');
                                                                                                                                                    } ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Campus Description</label>
                            <textarea name="c_desc" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="A Simple Description"><?php
                                                                                                                                                        if (isset($_POST['c_desc'])) {
                                                                                                                                                            echo $_POST['c_desc'];
                                                                                                                                                        } else if (isset($campus_array['camp_desc'])) {
                                                                                                                                                            echo $campus_array['camp_desc'];
                                                                                                                                                        } else {
                                                                                                                                                            echo  set_value('c_desc');
                                                                                                                                                        } ?></textarea>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="inputName">Campus Address</label>
                                        <input name="c_address" type="text" class="form-control" id="inputName" placeholder="Campus Full Address" value="<?php
                                                                                                                                                if (isset($_POST['c_address'])) {
                                                                                                                                                    echo $_POST['c_address'];
                                                                                                                                                } else if (isset($campus_array['camp_address'])) {
                                                                                                                                                    echo $campus_array['camp_address'];
                                                                                                                                                } else {
                                                                                                                                                    echo set_value('c_address');
                                                                                                                                                } ?>">
                                    </div>
                                </div>

                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="inputName">Campus Office Number</label>
                                        <input name="c_office_no" type="text" class="form-control" id="inputName" placeholder="Campus Main Number" value="<?php
                                                                                                                                                    if (isset($_POST['c_office_no'])) {
                                                                                                                                                        echo $_POST['c_office_no'];
                                                                                                                                                    } else if (isset($campus_array['camp_office_no'])) {
                                                                                                                                                        echo $campus_array['camp_office_no'];
                                                                                                                                                    } else {
                                                                                                                                                        echo set_value('c_office_no');
                                                                                                                                                    } ?>">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="inputName">Campus Map URL</label>
                                        <input name="c_map" type="text" class="form-control" id="inputName" placeholder="Campus Map URL" value="<?php
                                                                                                                                                if (isset($_POST['c_map'])) {
                                                                                                                                                    echo $_POST['c_map'];
                                                                                                                                                } else if (isset($campus_array['camp_map_url'])) {
                                                                                                                                                    echo $campus_array['camp_map_url'];
                                                                                                                                                } else {
                                                                                                                                                    echo set_value('c_map');
                                                                                                                                                } ?>">
                                    </div>
                                </div>

                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="inputName">Campus Website</label>
                                        <input name="c_website" type="text" class="form-control" id="inputName" placeholder="Website URL" value="<?php
                                                                                                                                                    if (isset($_POST['c_website'])) {
                                                                                                                                                        echo $_POST['c_website'];
                                                                                                                                                    } else if (isset($campus_array['camp_website'])) {
                                                                                                                                                        echo $campus_array['camp_website'];
                                                                                                                                                    } else {
                                                                                                                                                        echo set_value('c_website');
                                                                                                                                                    } ?>">
                                    </div>
                                </div>
                            </div>
                        </div>



                        <hr>

                        <div class="container">
                            <div class="d-flex justify-content-end">
                                <div>
                                    <?php if (isset($campus_array['camp_id'])) : ?>
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
        });

        $('#clear-btn').click(function(event) {
            document.getElementById('campus-form').reset();
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
                    $('#campus-form').submit();
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
                    window.location.href = "/campus";
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
            if (<?php if (isset($campus_array['camp_image'])) {
                    if ($campus_array['camp_image'] != "") {
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