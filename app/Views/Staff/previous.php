<div class="container">
    <div class="row d-flex " id="row-display">
        <!-- LEFT COLUMN -->
        <div class="col pb-3 col-sm-auto bg-info">
            <div class="container">
                <div class="d-flex justify-content-center">
                    <img id="img_placeholder" src="<?php if ($staff_array['staff_image'] != null) {
                                                        echo "." . staff_upload_path . $staff_array['staff_image'];
                                                    } else {
                                                        echo "http://via.placeholder.com/150x150";
                                                    } ?>" class="circle-img" style="margin: 20px; width:200px; height:auto; ">
                </div>

                <div class="row-auto justify-content-center d-flex">
                    <div class="col-auto">
                        <div class="row"> <i class="fa-solid fa-envelope p-2"> </i> </div>
                        <div class="row"> <i class="fa-solid fa-phone p-2"> </i> </div>
                        <div class="row"> <i class="fa-solid fa-phone p-2"> </i> </div>
                        <div class="row"> <i class="fa-solid fa-fax p-2"></i> </div>
                        <div class="row"> <i class="fa-solid fa-user-group p-2"> </i></div>
                        <div class="row"> <i class="fa-solid fa-building p-2"> </i></div>
                    </div>
                    <div class="col-auto">
                        <div class="row">
                            <h5> <?= $staff_array['staff_email'] ?></h5>
                        </div>
                        <div class="row">
                            <h5> <?= $staff_array['staff_tel'] ?></h5>
                        </div>
                        <div class="row">
                            <h5> <?= $staff_array['staff_office'] ?></h5>
                        </div>
                        <div class="row">
                            <h5> <?= $staff_array['staff_fax'] ?></h5>
                        </div>
                        <div class="row">
                            <h5> </i><?= $staff_array['div_name'] ?></h5>
                        </div>
                        <div class="row">
                            <h5> </i> <?= $staff_array['camp_name'] ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN -->
        <div class="col col-bg-5 bg-danger">
            <div class="container mt-3">
                <h5> <?php if ($staff_array['staff_title'] != "Unassigned") {
                            echo $staff_array['staff_title'] . ' ' . $staff_array['staff_name'];
                        } else {
                            echo $staff_array['staff_name'];
                        }; ?> </h5>
                <h5> <?= $staff_array['staff_type'] ?> </h5>
                <h5> <?= $staff_array['staff_position'] ?> </h5>
                <h5> <?= $staff_array['staff_unit'] ?> </h5>
                <p> <?= $staff_array['staff_desc'] ?> </p>

                <table class="table table-responsive-lg table-dark table-hover" style="border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Committee</th>
                            <th scope="col">Position</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($appointment_array as $row) : ?>
                            <tr>
                                <th scope="row"> <?= $i . '.';
                                                    $i = $i + 1; ?> </th>
                                <td> <?= $row['app_committee'] ?></td>

                                <td> <?= $row['app_position'] ?></td>

                                <td> <?= $row['start_date'] ?> </td>

                                <td> <?= $row['end_date'] ?> </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>

                <?php if ($staff_array['div_name'] != "Unassigned") : ?>
                    <div class="card mb-3">
                        <div class="card-header m-2">
                            <h5> <i class="fa-solid fa-user-group mr-2"></i> Division </h5>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-auto">
                                        <img class="circle-img mb-3" style="width:130px ; height: auto;" src="<?php if (isset($staff_array['div_image']) && $staff_array['div_image'] != "") {
                                                                                                                    echo "." . division_upload_path . $staff_array['div_image'];
                                                                                                                } else {
                                                                                                                    echo "http://via.placeholder.com/150x150";
                                                                                                                } ?>">
                                    </div>
                                    <div class="col-md">
                                        <h5 class="card-title"> <?= $staff_array['div_name'] ?></h5>
                                        <p class="card-text"> With supporting text below as a natural lead-in to additional content. </p>
                                        <a href="#" class="btn btn-primary">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif ?>

                <?php if ($staff_array['div_name'] != "Unassigned") : ?>
                    <div class="card mb-3">
                        <div class="card-header m-2">
                            <h5> <i class="fa-solid fa-building mr-2"></i> Campus </h5>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-auto">
                                        <img class="circle-img mb-3" style="width:130px ; height: auto;" src="<?php if (isset($staff_array['camp_image']) && $staff_array['camp_image'] != "") {
                                                                                                                    echo "." . campus_upload_path . $staff_array['camp_image'];
                                                                                                                } else {
                                                                                                                    echo "http://via.placeholder.com/150x150";
                                                                                                                } ?>">
                                    </div>
                                    <div class="col-md">
                                        <h5 class="card-title"> <?= $staff_array['camp_name'] ?></h5>
                                        <p class="card-text"> With supporting text below as a natural lead-in to additional content. </p>
                                        <a href="#" class="btn btn-primary">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif ?>

            </div>
        </div>
    </div>
</div>