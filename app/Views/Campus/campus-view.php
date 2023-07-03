<div class="container">
    <div class="row">
        <!-- RIGHT COLUMN -->
        <div class="col col-bg-5 bg-danger p-2">
            <div class="container mt-3">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-auto">
                                    <img class="circle-img mb-5" style="width:130px ; height: auto;" src="<?php if (isset($campus_array['camp_image']) && $campus_array['camp_image'] != "") {
                                                                                                                echo "." . campus_upload_path . $campus_array['camp_image'];
                                                                                                            } else {
                                                                                                                echo "http://via.placeholder.com/150x150";
                                                                                                            } ?>">
                                </div>
                                <div class="col-md mb-4">
                                    <h5 class="card-title"> <?= $campus_array['camp_name'] . " ( " . $campus_array['camp_acronym']  . " ) " ?></h5>
                                    <p class="card-text"> <?= $campus_array['camp_desc'] ?> </p>
                                </div>
                            </div>
                            <div class="col m-0 p-0">

                                <div class="card">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><i class="fa-sharp fa-solid fa-location-dot m-2"></i> <?= $campus_array['camp_address'] ?> </li>
                                        <li class="list-group-item"><i class="fa-solid fa-phone m-2"></i> <?= $campus_array['camp_office_no'] ?></li>
                                        <li class="list-group-item"><i class="fa-solid fa-map m-2"></i> <a href="<?= $campus_array['camp_map_url'] ?>" target="_blank"> <?= $campus_array['camp_map_url'] ?> </a></li>
                                        <li class="list-group-item"><i class="fa-solid fa-globe m-2"></i> <a href="<?= $campus_array['camp_website'] ?>" target="_blank"> <?= $campus_array['camp_website'] ?> </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <?php
                $i = 1;
                foreach ($division_array as $row) : ?>

                    <?php if ($i == 1) : ?>
                        <div class="card mb-4">
                            <div class="card-body">
                                <h4> Division From This Campus </h4>
                            </div>
                        </div>
                    <?php endif; ?>

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
                                <p class="card-text"><?= $row['div_desc'] ?></p>
                            </div>

                            <a href="<?= base_url('division-view/'  . $row['div_id']) ?>" class="btn btn-success stretched-link"> <i class="fa-solid fa-eye"></i> View Division </a>
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
</div>