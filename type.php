<?php include 'common/header.php';

if ($_GET['id']) {
    $property_id = $_GET['id'];
} else {
    header("Location: index.php");
    exit();
}

?>

<style>
    .course_main {
        background: rgba(1, 78, 121, 0.1);
    }

    .course_image {
        width: 100%;
        border-top-left-radius: 6px;
        border-top-right-radius: 6px;
        overflow: hidden;
        height: 300px;
    }
</style>


<!-- Course -->

<div class="course course_main ">
    <div class="container">
        <div class="row">

            <!-- Course -->
            <div class="col-lg-12">


                <div class="courses">
                    <div class="section_background parallax-window" data-parallax="scroll"
                        data-image-src="images/courses_background.jpg" data-speed="0.8"></div>
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="section_title_container text-center">
                                    <h2 class="section_title">Property Types</h2>

                                </div>
                            </div>
                        </div>
                        <?php


                        // Fetch active floor types C:\xampp\htdocs\splitfloor\admin\uploads\property_type
                        $sql = "SELECT * FROM floor_type WHERE property_id = $property_id and status = 'active'";
                        $result = $conn->query($sql);
                        ?>

                        <div class="row courses_row">
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <div class="col-lg-4 course_col mb-1">
                                        <div class="course">
                                            <!-- Image -->
                                            <div class="course_image">
                                                <img src="admin/uploads/property_type/<?php echo $row['type_image']; ?>" alt="<?php echo $row['floor_type']; ?>">
                                            </div>

                                            <!-- Body -->
                                            <div class="course_body">
                                                <h3 class="course_title">
                                                    <a href="course.php?floor_id=<?php echo base64_encode($row['floor_id']); ?>">
                                                        <?php echo htmlspecialchars($row['floor_type']); ?>
                                                    </a>
                                                </h3>
                                            </div>

                                            <!-- Footer (optional, can be customized) -->
                                            <div class="course_footer">
                                                <div class="course_footer_content d-flex flex-row align-items-center justify-content-start">
                                                    <div class="course_info">

                                                        <a href="course.php?floor_id=<?php echo base64_encode($row['floor_id']); ?>" class="btn btn-primary">View Details</a>
                                                        <!-- <span>Property ID: <?php echo $row['property_id']; ?></span> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <p>No floor types found.</p>
                            <?php endif; ?>
                        </div>

                        <?php $conn->close(); ?>


                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<!-- Newsletter -->


<?php include 'common/footer.php'; ?>