<form class="" action="/search" method="post">
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-magnifying-glass"></i></span>
        </div>
        <input name="search_var" type="text" class="form-control" placeholder="Search" value="<?php
                                                                                                if (isset($_POST['search_var'])) {
                                                                                                    echo $_POST['search_var'];
                                                                                                } else {
                                                                                                    "";
                                                                                                } ?>">
    </div>

    <div class="container mt-4 mb-4">
        <div class="row">
            <div class="col">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="filter_staff" value="1" id="flexCheckChecked1" checked>
                    <label class="form-check-label" for="flexCheckChecked1">
                        Staff
                    </label>
                </div>
            </div>
            <div class="col">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="filter_division" value="1" id="flexCheckChecked2" checked>
                    <label class="form-check-label" for="flexCheckChecked2">
                        Divison
                    </label>
                </div>
            </div>
            <div class="col">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="filter_campus" value="1" id="flexCheckChecked3" checked>
                    <label class="form-check-label" for="flexCheckChecked3">
                        Campus
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="" aria-label="Default select example">
        <button type="submit" class="btn btn-info">Search</button>
        <input type="reset" class="btn btn-secondary mr-1 ml-1" value="Clear" id="clear-btn">
    </div>
</form>

<div class="mt-3">
    <?php if (isset($staff_array)) : ?>
        <a href="#staff_result"> <input class="btn btn-primary mb-2" value="To Staff"> </a>
    <?php endif ?>
    <?php if (isset($division_array)) : ?>
        <a href="#division_result"> <input class="btn btn-success mb-2" value="To Division"> </a>
    <?php endif ?>
    <?php if (isset($campus_array)) : ?>
        <a href="#campus_result"> <input class="btn btn-danger mb-2" value="To Campus"> </a>
    <?php endif ?>
</div>

<hr>

<!-- STAFFS -->
<?php if (isset($staff_array)) : ?>

    <div class="card mb-4">
        <div class="card-body">
            <h4> Staff </h4>
        </div>
    </div>

    <div class="container p-0 m-0" id="staff_result">
        <?php if (count($staff_array) == 0) : ?>

            <div class="alert alert-danger" role="alert"> <i class="fa-solid fa-circle-xmark" style="margin: 5px ;"></i>
                <?= "No Matches Found For Staff !" ?>
            </div>

        <?php else : ?>
            <div class="alert alert-success" role="alert"> <i class="fa-solid fa-square-poll-vertical" style="margin: 5px ;"></i>
                <?= count($staff_array) . " Matches Found For Staff !" ?>
            </div>

        <?php endif ?>
    </div>

    <hr>

    <?php $i = 1;
    foreach ($staff_array as $row) : ?>

        <?php if ($i % 3 == 1) : ?>
            <div class="card-deck mb-3">
            <?php endif ?>
            <div class="card">
                <img class="card-img-top mx-auto mt-4" src="<?php if (isset($row['staff_image']) && $row['staff_image'] != "") {
                                                                echo staff_upload_path . $row['staff_image'];
                                                            } else {
                                                                echo "http://via.placeholder.com/150x150";
                                                            } ?>" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title"><?= $row['staff_name'] ?></h5>
                    <p class="card-text"><?= $row['staff_position'] ?></p>

                    <p class="card-text">
                    <div class="row">
                        <div class="col-2">
                            <i class="fa-solid fa-user-group"> </i>
                        </div>
                        <div class="col">
                            <?= $row['div_name'] ?>
                        </div>
                    </div>
                    </p>

                    <p class="card-text">
                    <div class="row">
                        <div class="col-2">
                            <i class="fa-solid fa-building"> </i>
                        </div>
                        <div class="col">
                            <?= $row['camp_name'] ?>
                        </div>
                    </div>
                    </p>

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
    <?php if ($i % 3 != 1) : ?>
        </div>
    <?php endif  ?>
<?php endif ?>

<!-- DIVISIONS -->
<?php if (isset($division_array)) : ?>

    <div class="card mb-3">
        <div class="card-body">
            <h4> Division </h4>
        </div>
    </div>

    <div class="container p-0 m-0" id="division_result">

        <?php if (count($division_array) == 0) : ?>

            <div class="alert alert-danger" role="alert"> <i class="fa-solid fa-circle-xmark" style="margin: 5px ;"></i>
                <?= "No Matches Found For Division !" ?>
            </div>

        <?php else : ?>
            <div class="alert alert-success" role="alert"> <i class="fa-solid fa-square-poll-vertical" style="margin: 5px ;"></i>
                <?= count($division_array) . " Matches Found For Division !" ?>
            </div>

        <?php endif ?>
    </div>

    <hr>

    <?php
    $i = 1;
    foreach ($division_array as $row) : ?>

        <?php if ($i % 3 == 1) : ?>
            <div class="card-deck mb-4">
            <?php endif ?>
            <div class="card">
                <img class="card-img-top mx-auto mt-4" src="<?php if (isset($row['div_image']) && $row['div_image'] != "") {
                                                                echo "." . division_upload_path . $row['div_image'];
                                                            } else {
                                                                echo "http://via.placeholder.com/150x150";
                                                            } ?>" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title"><?= $row['div_name'] ?></h5>
                    <h6 class="card-title"><?= $row['camp_name'] ?></h6>
                </div>

                <a href="<?= base_url('division-view/'  . $row['div_id']) ?>" class="btn btn-success stretched-link"> <i class="fa-solid fa-eye"></i> View Division </a>
            </div>

            <?php $i++; ?>
            <?php if ($i % 3 == 1) : ?>
            </div>
        <?php endif ?>
    <?php endforeach; ?>
    <?php if ($i % 3 != 1) : ?>
        </div>
    <?php endif  ?>
<?php endif ?>

<!-- CAMPUS -->
<?php if (isset($campus_array)) : ?>

    <div class="card mb-3">
        <div class="card-body">
            <h4> Campus </h4>
        </div>
    </div>

    <div class="container p-0 m-0" id="campus_result">

        <?php if (count($campus_array) == 0) : ?>

            <div class="alert alert-danger" role="alert"> <i class="fa-solid fa-circle-xmark" style="margin: 5px ;"></i>
                <?= "No Matches Found For Campus !" ?>
            </div>

        <?php else : ?>
            <div class="alert alert-success" role="alert"> <i class="fa-solid fa-square-poll-vertical" style="margin: 5px ;"></i>
                <?= count($campus_array) . " Matches Found For Campus !" ?>
            </div>

        <?php endif ?>
    </div>

    <hr>

    <?php
    $i = 1;
    foreach ($campus_array as $row) : ?>

        <?php if ($i % 3 == 1) : ?>
            <div class="card-deck mb-4">
            <?php endif ?>
            <div class="card">
                <img class="card-img-top mx-auto mt-4" src="<?php if (isset($row['camp_image']) && $row['camp_image'] != "") {
                                                                echo "." . campus_upload_path . $row['camp_image'];
                                                            } else {
                                                                echo "http://via.placeholder.com/150x150";
                                                            } ?>" alt="Campus Image">
                <div class="card-body">
                    <h5 class="card-title"><?= $row['camp_name'] ?></h5>
                </div>

                <a href="<?= base_url('campus-view/'  . $row['camp_id']) ?>" class="btn btn-danger stretched-link"> <i class="fa-solid fa-eye"></i> View Campus </a>
            </div>

            <?php $i++; ?>
            <?php if ($i % 3 == 1) : ?>
            </div>
        <?php endif ?>
    <?php endforeach; ?>
    <?php if ($i % 3 != 1) : ?>
        </div>
    <?php endif  ?>
<?php endif ?>

<style>
    html {
        scroll-behavior: smooth;
    }
</style>