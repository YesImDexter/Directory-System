<div class="container">
    <div class="row">
        <!-- RIGHT COLUMN -->
        <div class="col col-bg-5 bg-danger">
            <div class="mt-3">
                <div class="card mb-3">
                    <div class="card-header m-2">
                        <h5> <i class="fa-solid fa-user-group mr-2"></i> Division </h5>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-auto">
                                    <img class="circle-img mb-3" style="width:130px ; height: auto;" src="<?php if (isset($division_array['div_image']) && $division_array['div_image'] != "") {
                                                                                                                echo "." . division_upload_path . $division_array['div_image'];
                                                                                                            } else {
                                                                                                                echo "http://via.placeholder.com/150x150";
                                                                                                            } ?>">
                                </div>
                                <div class="col-md">
                                    <h5 class="card-title"> <?= $division_array['div_name'] ?></h5>
                                    <p class="card-text"> <?= $division_array['div_desc'] ?> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($division_array['div_name'] != "Unassigned" && $division_array['camp_name'] != "Unassigned") : ?>
                    <div class="card mb-3">
                        <div class="card-header m-2">
                            <h5> <i class="fa-solid fa-building mr-2"></i> Campus </h5>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-auto">
                                        <img class="circle-img mb-3" style="width:130px ; height: auto;" src="<?php if (isset($division_array['camp_image']) && $division_array['camp_image'] != "") {
                                                                                                                    echo "." . campus_upload_path . $division_array['camp_image'];
                                                                                                                } else {
                                                                                                                    echo "http://via.placeholder.com/150x150";
                                                                                                                } ?>">
                                    </div>
                                    <div class="col-md">
                                        <h5 class="card-title"> <?= $division_array['camp_name'] ?></h5>
                                        <p class="card-text"> <?= $division_array['camp_desc'] ?> </p>
                                        <a href="<?= base_url('campus-view/'  . $division_array['camp_id']) ?>" class="btn btn-primary">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif ?>





                <?php $i = 1;
                foreach ($staff_array as $row) : ?>

                    <?php if ($i == 1) : ?>
                        <div class="card mb-4">
                            <div class="card-body">
                                <h4> Staff From This Division </h4>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($i % 3 == 1) : ?>
                        <div class="card-deck mb-3">
                        <?php endif ?>
                        <div class="card">
                            <img class="card-img-top mx-auto mt-4 d-flex" src="<?php if (isset($row['staff_image']) && $row['staff_image'] != "") {
                                                                                    echo "." . staff_upload_path . $row['staff_image'];
                                                                                } else {
                                                                                    echo "http://via.placeholder.com/150x150";
                                                                                } ?>" alt="Staff Image">
                            <div class="card-body">
                                <h5 class="card-title"><?= $row['staff_name'] ?></h5>
                                <p class="card-text"><?= $row['staff_position'] ?></p>

                            </div>

                            <a href="<?= base_url('staff-view/'  . $row['staff_uid']) ?>" class="btn btn-primary stretched-link"> <i class="fa-solid fa-eye"></i> View Staff </a>

                            <div class="card-footer">
                                <small class="text-muted"> Last updated at <?= $row['updated_at'] ?></small>
                            </div>
                        </div>

                        <?php $i++; ?>
                        <?php if ($i % 3 == 1) : ?>
                        </div>
                    <?php endif ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>