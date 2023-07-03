<div class="container">
    <div class="row">
        <div class="col-12 mt-4 mb-4 pt-3 pb-3 bg-white">
            <div class="container">
                <div class="container d-flex justify-content-between">
                    <h3> <?php if (isset($staff_array['staff_uid'])) {
                                echo "EDIT STAFF";
                            } else {
                                echo "ADD STAFF";
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
                    <form id="staff-form" action="<?php if (isset($staff_array['staff_uid'])) {
                                                        echo '/staff-edit' . '/' .  $staff_array['staff_uid'];
                                                    } else {
                                                        echo "/staff-create";
                                                    } ?>" enctype="multipart/form-data" method="post">

                        <div class="d-flex justify-content-center m-3">
                            <img id="img_placeholder" class="circle-img" src="<?php if (isset($staff_array['staff_image']) && $staff_array['staff_image'] != "") {
                                                                                    echo "." . staff_upload_path . $staff_array['staff_image'];
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
                                        <label for="inputName">Staff Name</label>
                                        <input name="s_name" type="text" class="form-control" id="inputName" placeholder="Staff Name" value="<?php
                                                                                                                                                if (isset($_POST['s_name'])) {
                                                                                                                                                    echo $_POST['s_name'];
                                                                                                                                                } else if (isset($staff_array['staff_name'])) {
                                                                                                                                                    echo $staff_array['staff_name'];
                                                                                                                                                } else {
                                                                                                                                                    echo set_value('s_name');
                                                                                                                                                } ?>">
                                    </div>
                                </div>

                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="inputOfficeNo">Staff ID</label>
                                        <input name="s_id" type="text" class="form-control" id="inputID" placeholder="Staff ID" value="<?php
                                                                                                                                        if (isset($_POST['s_id'])) {
                                                                                                                                            echo $_POST['s_id'];
                                                                                                                                        } else if (isset($staff_array['staff_id'])) {
                                                                                                                                            echo $staff_array['staff_id'];
                                                                                                                                        } else {
                                                                                                                                            echo set_value('s_id');
                                                                                                                                        } ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Staff Description</label>
                            <textarea name="s_desc" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="A Simple Description"><?php
                                                                                                                                                        if (isset($_POST['s_desc'])) {
                                                                                                                                                            echo $_POST['s_desc'];
                                                                                                                                                        } else if (isset($staff_array['staff_desc'])) {
                                                                                                                                                            echo $staff_array['staff_desc'];
                                                                                                                                                        } else {
                                                                                                                                                            echo  set_value('s_desc');
                                                                                                                                                        } ?></textarea>
                        </div>

                        <!-- FOR TYPE, POSITION, TITLE -->

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="s_type">Type</label>
                                        <select name="s_type" id="s_type" class="form-control js-example-basic-single">
                                            <?php
                                            // Iterating Through the Type Array
                                            if (isset($_POST['s_type'])) {
                                                foreach ($type_array as $staff_type) {
                                                    if ($staff_type == $_POST['s_type']) {
                                                        echo "<option selected value='$staff_type'>$staff_type</option>";
                                                    } else {
                                                        echo "<option value='$staff_type'>$staff_type</option>";
                                                    }
                                                }
                                            } else if (isset($staff_array['staff_type'])) {
                                                foreach ($type_array as $staff_type) {
                                                    if ($staff_type == $staff_array['staff_type']) {
                                                        echo "<option selected value='$staff_type'>$staff_type</option>";
                                                    } else {
                                                        echo "<option value='$staff_type'>$staff_type</option>";
                                                    }
                                                }
                                            } else {
                                                foreach ($type_array as $staff_type) {
                                                    echo "<option value='$staff_type'>$staff_type</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- 082 539 222 -->
                                <!-- 110 -->

                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="s_position">Position</label>
                                        <select id="s_position" class="form-control js-example-basic-single" name="s_position">
                                            <?php
                                            // Iterating Through the Type Array
                                            if (isset($_POST['s_position'])) {
                                                foreach ($position_array as $staff_position) {
                                                    if ($staff_position == $_POST['s_position']) {
                                                        echo "<option selected value='$staff_position'>$staff_position</option>";
                                                    } else {
                                                        echo "<option value='$staff_position'>$staff_position</option>";
                                                    }
                                                }
                                            } else if (isset($staff_array['staff_position'])) {
                                                foreach ($position_array as $staff_position) {
                                                    if ($staff_position == $staff_array['staff_position']) {
                                                        echo "<option selected value='$staff_position'>$staff_position</option>";
                                                    } else {
                                                        echo "<option value='$staff_position'>$staff_position</option>";
                                                    }
                                                }
                                            } else {
                                                foreach ($position_array as $staff_position) {
                                                    echo "<option value='$staff_position'>$staff_position</option>";
                                                }
                                            }
                                            echo "</select>"
                                            ?>
                                    </div>
                                </div>

                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="s_title">Title</label>
                                        <select name="s_title" id="inputState" class="form-control js-example-basic-single">
                                            <?php
                                            // Iterating Through the Type Array
                                            if (isset($_POST['s_title'])) {
                                                foreach ($title_array as $staff_title) {
                                                    if ($staff_title == $_POST['s_title']) {
                                                        echo "<option selected value='$staff_title'>$staff_title</option>";
                                                    } else {
                                                        echo "<option value='$staff_title'>$staff_title</option>";
                                                    }
                                                }
                                            } else if (isset($staff_array['staff_title'])) {
                                                foreach ($title_array as $staff_title) {
                                                    if ($staff_title == $staff_array['staff_title']) {
                                                        echo "<option selected value='$staff_title'>$staff_title</option>";
                                                    } else {
                                                        echo "<option value='$staff_title'>$staff_title</option>";
                                                    }
                                                }
                                            } else {
                                                foreach ($title_array as $staff_title) {
                                                    echo "<option value='$staff_title'>$staff_title</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- FOR CAMPUS, DIVISION, UNIT, ASSIGN -->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="s_camp">Campus</label>
                                        <select name="s_camp" id="s_camp" class="form-control js-example-basic-single">
                                            <option value="0">Unassigned</option>
                                            <?php if (isset($_POST['s_camp'])) : ?>
                                                <?php foreach ($campus_array as $row) : ?>
                                                    <?php if ($row['camp_id'] == $_POST['s_camp']) : ?>
                                                        <option selected value="<?= $row['camp_id'] ?>"><?= $row['camp_name'] ?></option>
                                                    <?php else : ?>
                                                        <option value="<?= $row['camp_id'] ?>"><?= $row['camp_name'] ?></option>
                                                    <?php endif ?>
                                                <?php endforeach; ?>

                                            <?php elseif (isset($staff_array['camp_id'])) : ?>
                                                <?php foreach ($campus_array as $row) : ?>
                                                    <?php if ($row['camp_id'] == $staff_array['camp_id']) : ?>
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

                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="inputState">Division</label>
                                        <select name="s_div" id="s_div" class="form-control js-example-basic-single" disabled>
                                            <option value="0" selected>Unassigned</option>
                                        </select>
                                    </div>
                                </div>

                                <input id="s_div_placeholder" value="" hidden>

                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="inputState">Unit</label>
                                        <select name="s_unit" class="form-control js-example-basic-single">
                                            <?php
                                            // Iterating Through the Type Array
                                            if (isset($_POST['s_unit'])) {
                                                foreach ($unit_array as $staff_unit) {
                                                    if ($staff_unit == $_POST['s_unit']) {
                                                        echo "<option selected value='$staff_unit'>$staff_unit</option>";
                                                    } else {
                                                        echo "<option value='$staff_unit'>$staff_unit</option>";
                                                    }
                                                }
                                            } else if (isset($staff_array['staff_unit'])) {
                                                foreach ($unit_array as $staff_unit) {
                                                    if ($staff_unit == $staff_array['staff_unit']) {
                                                        echo "<option selected value='$staff_unit'>$staff_unit</option>";
                                                    } else {
                                                        echo "<option value='$staff_unit'>$staff_unit</option>";
                                                    }
                                                }
                                            } else {
                                                foreach ($unit_array as $staff_unit) {
                                                    echo "<option value='$staff_unit'>$staff_unit</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- FOR STAFF INFO AND REACHING -->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="inputEmail">Email</label>
                                        <input name="s_email" type="text" class="form-control" id="inputEmail" placeholder="Email Address" value="<?php if (isset($_POST['s_email'])) {
                                                                                                                                                        echo $_POST['s_email'];
                                                                                                                                                    } else if (isset($staff_array['staff_email'])) {
                                                                                                                                                        echo $staff_array['staff_email'];
                                                                                                                                                    } else {
                                                                                                                                                        echo set_value('s_email');
                                                                                                                                                    } ?>">
                                    </div>
                                </div>

                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="inputOfficeNoExt">Office Extension Number</label>
                                        <input name="s_office" type="text" class="form-control" id="s_office" placeholder="Office Number Extension" value="<?php if (isset($_POST['s_office'])) {
                                                                                                                                                                echo $_POST['s_office'];
                                                                                                                                                            } else if (isset($staff_array['staff_office'])) {
                                                                                                                                                                echo $staff_array['staff_office'];
                                                                                                                                                            } else {
                                                                                                                                                                echo set_value('s_office');
                                                                                                                                                            } ?>">
                                    </div>
                                </div>

                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="inputOfficeNo">Office Full Number</label>
                                        <input name="s_office_full" type="text" class="form-control" id="s_office_full" value="" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="inputTel">Telephone Number</label>
                                        <input name="s_tel" type="text" class="form-control" id="inputTel" placeholder="Phone Number" value="<?php if (isset($_POST['s_tel'])) {
                                                                                                                                                    echo $_POST['s_tel'];
                                                                                                                                                } else if (isset($staff_array['staff_tel'])) {
                                                                                                                                                    echo $staff_array['staff_tel'];
                                                                                                                                                } else {
                                                                                                                                                    echo set_value('s_tel');
                                                                                                                                                } ?>">
                                    </div>
                                </div>

                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="inputFAX">FAX</label>
                                        <input name="s_fax" type="text" class="form-control" id="inputFAX" placeholder="FAX" value="<?php if (isset($_POST['s_fax'])) {
                                                                                                                                        echo $_POST['s_fax'];
                                                                                                                                    } else if (isset($staff_array['staff_fax'])) {
                                                                                                                                        echo $staff_array['staff_fax'];
                                                                                                                                    } else {
                                                                                                                                        echo set_value('s_fax');
                                                                                                                                    } ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="container">
                            <div class="d-flex justify-content-end">
                                <div>
                                    <?php if (isset($staff_array['staff_uid'])) : ?>
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
            SetOfficeFullNo();
            FindDivision();

            $('.js-example-basic-single').select2();
        });

        $('#s_office').change(function(event) {
            SetOfficeFullNo();
        });

        $('#s_camp').change(function(event) {
            SetOfficeFullNo();
            FindDivision();
        });

        $('#clear-btn').click(function(event) {
            document.getElementById('staff-form').reset();
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
                    $('#staff-form').submit();
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
                    window.location.href = "/staff" ;
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
            if (<?php if (isset($staff_array['staff_image'])) {
                    if ($staff_array['staff_image'] != "") {
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

        function FindDivision() {
            var div_id = <?php if (isset($_POST['s_div'])) {
                                echo $_POST['s_div'];
                            } else if (isset($staff_array['div_id'])) {
                                echo $staff_array['div_id'];
                            } else {
                                echo strval("0");
                            } ?>;
            var camp_id = $('#s_camp').val();
            if ($('#s_camp').val() != "0") {
                $.ajax({
                    url: '/ajax_requests',
                    method: 'post',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    data: {
                        camp_id: camp_id,
                        div_id_set: div_id,
                        action: "get_division",
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        document.getElementById("s_div").disabled = false;
                        // console.log(data[0].length);
                        // console.log(data[0]);
                        // console.log(data[1]);

                        if (data[0] != 0) {
                            var div_id = data[0];
                            var html = '<option value="0"> Unassigned </option>';
                            for (var count = 0; count < (data[1]).length; count++) {
                                if (data[1][count].div_id == div_id) {
                                    html += '<option value="' + data[1][count].div_id + '" selected>' + data[1][count].div_name + '</option>';
                                } else {
                                    html += '<option value="' + data[1][count].div_id + '">' + data[1][count].div_name + '</option>';
                                }
                            }
                        } else {
                            var html = '<option value="0" selected> Unassigned </option>';
                            for (var count = 0; count < (data[1]).length; count++) {
                                html += '<option value="' + data[1][count].div_id + '">' + data[1][count].div_name + '</option>';
                            }
                        }
                        $('#s_div').html(html);
                    },
                    error: function(data) {
                        console.log("FAILED");
                    }
                });
            } else {
                $("#s_div").val("0")
                document.getElementById("s_div").disabled = true;
            }
        }

        function SetOfficeFullNo() {
            var camp_id = $('#s_camp').val();
            var ext = $('#s_office').val();
            if (ext.length == 0) {
                document.getElementById("s_office_full").setAttribute("value", "Fill Campus And Extension");
            } else if (ext.length > 3 || ext.length < 3) {
                document.getElementById("s_office_full").setAttribute("value", "Invalid Extension");
            } else if (camp_id != "0" && ext != "") {
                $.ajax({
                    url: '/ajax_requests',
                    method: 'post',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    data: {
                        camp_id: camp_id,
                        action: "get_campus_no",
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        var newValue = data + " - " + ext;
                        document.getElementById("s_office_full").setAttribute("value", newValue);
                    },
                    error: function(data) {
                        console.log("FAILED");
                    }
                });
            } else {
                document.getElementById("s_office_full").setAttribute("value", "");
            }
        }
    </script>