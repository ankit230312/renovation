<?php
// if (!isset($_GET['page'])) {
//     header("Location: ?page=1");
//     exit;
// }

include "common/header.php";


?>

<style>
    .course_image {
        width: 100%;
        height: 200px;
        border-top-left-radius: 6px;
        border-top-right-radius: 6px;
        overflow: hidden;
    }

    .course_image img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .courses {
        width: 100%;
        padding-top: 0;
        padding-bottom: 100px;
        background: rgba(1, 78, 121, 0.1);
    }

    .card {
        border-radius: 8px;
        border: 1px solid #dee2e6;

    }

    label {
        color: #333;
        font-weight: 500;
    }

    .form-control,
    .form-check-input {
        border-radius: 4px;
    }

    .btn-primary {
        font-weight: 500;
    }

    .form-check-label {
        margin-left: 5px;
        color: #555;
    }

    .side-img {
        margin-top: 10%;
        height: 500px;
        /* fixed height for slider */
        overflow-y: scroll;
        /* scroll vertically */
        scroll-snap-type: y mandatory;
    }

    .side-img img {
        width: 100%;
        border-radius: 10px;
        height: 500px;
        /* full height per slide */
        object-fit: fill;
        scroll-snap-align: start;
    }

    .mySwiper {
        height: 500px;
        width: 100%;

    }

    .mySwiper img {
        width: 100%;
        border-radius: 10px;
        height: 500px;
        /* full height per slide */
        object-fit: fill;
        scroll-snap-align: start;
    }

    .home {
        width: 100%;
        height: 73px;
        background: rgba(1, 78, 121, 0.1);
        border-bottom: solid 1px #edeff0;
    }


    @media (max-width: 768px) {

        .firt {
            visibility: hidden;
        }
    }

    .card-body {
        display: flex;
        flex-direction: column;
        justify-content: space-between;

    }

    .h-250p {
        height: 310px;
    }

    .product-card {
        transition: all 0.3s ease;
        border-radius: 12px;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12);
    }

    .product-card .btn-primary {
        border-radius: 20px;
        padding: 6px 16px;
    }

    .product-card .btn-outline-primary {
        border-radius: 20px;
    }
</style>

<div class="home">
    <div class="breadcrumbs_container">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="breadcrumbs">
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li>Society</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="courses">
    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-10 p-3 strt mx-auto" style="overflow-y: auto; height:100vh;scrollbar-width: none; -ms-overflow-style: none;">
                <div class="courses_container">
                    <div class="row">
                        <div id="societyList" class="mt-4 row">

                            <?php
                            $query = "SELECT * FROM products WHERE status='active' ORDER BY updated_on DESC";
                            $result = mysqli_query($conn, $query);

                            while ($row = mysqli_fetch_assoc($result)) {

                                $productId = $row['productID'];
                                $productName = $row['product_name'];
                                $desc = $row['product_description'];
                            ?>
                                <div class="col-md-12 col-lg-12 mb-4">
                                    <div class="card h-100 shadow-sm border-0 product-card">

                                        <div class="card-body d-flex flex-column">

                                            <!-- Title -->




                                            <!-- Actions -->
                                            <div class="d-flex justify-content-between align-items-center mt-3">

                                                <h5 class="card-title fw-bold mb-2">
                                                    <?= htmlspecialchars($productName) ?>
                                                </h5>
                                                <a href="type.php?id=<?= $productId ?>" class="btn btn-sm btn-primary">
                                                    Select
                                                </a>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            <?php } ?>

                        </div>


                    </div>
                    <!-- <div class="row courses_row">
						
					</div> -->

                </div>
            </div>

        </div>
    </div>
</div>

<?php include 'common/footer.php'; ?>