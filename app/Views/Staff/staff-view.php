<div class="container">
    <div class="row">
        <!-- LEFT COLUMN -->
        <div class="col pb-3 col-sm-auto bg-info">
            <div class="mt-3">
                <div class="card" style="width: auto;">

                    <div class="d-flex justify-content-center">
                        <img class="img_placeholder" src="<?php if ($staff_array['staff_image'] != null) {
                                                                echo "." . staff_upload_path . $staff_array['staff_image'];
                                                            } else {
                                                                echo "http://via.placeholder.com/150x150";
                                                            } ?>" style="margin: 20px; width:200px; height:auto;">
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"> <i class="fa-solid fa-envelope p-2"> </i> <?= $staff_array['staff_email'] ?> </li>
                        <li class="list-group-item"> <i class="fa-solid fa-phone p-2"> </i> <?= $staff_array['staff_tel'] ?> </li>
                        <li class="list-group-item"> <i class="fa-solid fa-briefcase p-2"></i> <?= $staff_array['camp_office_no'] . " " . $staff_array['staff_office'] ?> </li>
                        <li class="list-group-item"> <i class="fa-solid fa-fax p-2"></i> <?= $staff_array['staff_fax'] ?></li>
                        <li class="list-group-item"> <i class="fa-solid fa-user-group p-2"> </i><?= $staff_array['div_name'] ?></li>
                        <li class="list-group-item"> <i class="fa-solid fa-building p-2"> </i> <?= $staff_array['camp_name'] ?></li>
                    </ul>
                    <div class="card-footer">
                        <small class="text-muted"> Last updated at <?= $staff_array['updated_at'] ?></small>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN -->
        <div class="col col-bg-5 bg-danger">
            <div class="mt-3">

                <div class="card mb-3" style="width: auto;">
                    <div class="card-body">
                        <h5 class="card-title">
                            <h2> <?php if ($staff_array['staff_title'] != "Unassigned") {
                                        echo $staff_array['staff_title'] . ' ' . $staff_array['staff_name'];
                                    } else {
                                        echo $staff_array['staff_name'];
                                    }; ?> </h2>
                        </h5>

                        <?php if ($staff_array['staff_position'] != "Unassigned") : ?>
                            <h6 class="card-subtitle mb-3 text-muted">
                                <h5> <?= $staff_array['staff_position'] ?> </h5>
                            </h6>
                        <?php endif ?>

                        <?php if ($staff_array['staff_unit'] != "Unassigned") : ?>
                            <h6 class="card-subtitle mb-3 text-muted">
                                <h5> <?= $staff_array['staff_unit'] ?> </h5>
                            </h6>
                        <?php endif ?>

                        <?php if ($staff_array['staff_type'] != "Unassigned") : ?>
                            <h6 class="card-subtitle mb-3 text-muted">
                                <h5> <?= $staff_array['staff_type'] ?> </h5>
                            </h6>
                        <?php endif ?>

                        <p class="card-text"> <?= $staff_array['staff_desc'] ?> </p>
                    </div>
                </div>


                <h5> </h5>
                <h5> </h5>

                <?php if ($appointment_array != NULL) : ?>
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
                <?php endif ?>

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
                                        <p class="card-text"> <?= $staff_array['div_desc'] ?> </p>
                                        <a href="<?= base_url('division-view/'  . $staff_array['div_id']) ?>" class="btn btn-primary">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif ?>

                <?php if ($staff_array['div_name'] != "Unassigned" && $staff_array['camp_name'] != "Unassigned") : ?>
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
                                        <p class="card-text"> <?= $staff_array['camp_desc'] ?> </p>
                                        <a href="<?= base_url('campus-view/'  . $staff_array['camp_id']) ?>" class="btn btn-primary">View</a>
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