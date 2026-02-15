<?php include 'common/header.php';

$paymentSessionId = $_GET['session_id'] ?? '';

if (empty($user['id'])) {
    echo "<script>alert('Please Login')</script>";

    // print_r($user);die;

    // echo "<script>window.location.href = 'login-signup.html';</script>";
    // exit();
}
$userId = isset($user['id']) ? $user['id'] : 0;


?>
<style>
    .error-field {
        border: 2px solid red !important;
    }
</style>

<div class="features">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="section_title_container text-center new_cls">
                    <h2 class="section_title">Proceed To Payment</h2>
                </div>

                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card mt-2">
                                <div class="card-body">
                                    <form id="paymentForm">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputPassword4">Name</label>
                                                <input type="text" class="form-control" id="inputPassword4"
                                                    placeholder="">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Email</label>
                                                <input type="email" class="form-control" id="inputEmail4"
                                                    placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputAddress">Mobile Number</label>
                                            <input type="text" class="form-control" id="inputAddress"
                                                placeholder="8171.....">
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputCity">City</label>
                                                <input type="text" class="form-control" id="inputCity">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputZip">Zip</label>
                                                <input type="text" class="form-control" id="inputZip">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputAddress2">Address</label>
                                            <input type="text" class="form-control" id="inputAddress2" placeholder="">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="card">
                                <?php
                                $totalItems = 0;
                                $totalPrice = 0.00;
                                $cartData = [];
                                $productIds = [];


                                $cartData = ($_SESSION['cart']);
                                // print_r($cartData); // Debugging line to check cart data structured
                                // die;

                                if (!empty($cartData[0]['productId']) && isset($cartData[0]['productId']) && $cartData[0]['productId'] != 'undefined') {
                                    $productId = $cartData[0]['productId'];
                                } else {
                                    $productId = $_SESSION['single_cart_product'];
                                }
                                // $productId = 1;
                                $sqlitem = "SELECT * FROM products_item WHERE productID =  '$productId' and status = 'active' ORDER BY productID DESC";
                                $resultitem = $conn->query($sqlitem);

                                $resultitem = $conn->query($sqlitem);

                                if (!$resultitem) {
                                    die("SQL Error: " . $conn->error . "<br>Query: " . $sqlitem);
                                }

                                $rowitem = $resultitem->fetch_assoc();

                                foreach ($cartData as $item) {
                                    $area = floatval($item['area']);
                                    $price = floatval($item['price']);
                                    $totalItems++;
                                    $totalPrice += ($area * $price) + floatval($item['accessoriesTotal']);

                                    if (isset($item['id'])) {
                                        $productIds[] = $item['id'];
                                    }
                                }
                                // 
                                
                                /* ========================
    APPLY CART OFFER
 ======================== */
                                $offerDiscount = 0.00;
                                $today = date('Y-m-d');

                                $sqlOffer = "
                                SELECT *
                                FROM offers
                                WHERE is_active = 'Y'
                                AND apply_on = 'CART'
                                AND start_date <= '$today'
                                AND end_date >= '$today'
                                AND min_cart_value <= $totalPrice
                                LIMIT 1
                            ";

                                $resultOffer = $conn->query($sqlOffer);

                                if ($resultOffer && $resultOffer->num_rows > 0) {
                                    $offer = $resultOffer->fetch_assoc();

                                    if ($offer['offer_type'] === 'PERCENTAGE') {
                                        $offerDiscount = ($totalPrice * $offer['offer_value']) / 100;

                                        if (!empty($offer['max_discount']) && $offerDiscount > $offer['max_discount']) {
                                            $offerDiscount = $offer['max_discount'];
                                        }
                                    }
                                }

                                /* Price after offer */
                                $priceAfterOffer = $totalPrice - $offerDiscount;
                                if ($priceAfterOffer < 0) {
                                    $priceAfterOffer = 0;
                                }


                                ?>

                                <!-- Always render the hidden input -->
                                <input type="hidden" id="product_ids" value="<?php echo implode(',', $productIds); ?>">

                                <div class="card-body">
                                    <h5 class="card-title" style="font-weight: 500; color:black ; font-size:large">Bill
                                    </h5>
                                    <h6 class="mt-4" style="font-weight: 500; color:black ; font-size:large">Item
                                        Details:</h6>
                                    <?php if (!empty($cartData)): ?>
                                        <ul class="list-group mb-3 mt-3">
                                            <li class="list-group-item"
                                                style="font-weight: 500; color:black ; font-size:large">
                                                <?php echo $rowitem['product_name'] ?>
                                            </li>
                                            <?php foreach ($cartData as $item): ?>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <strong><?php echo htmlspecialchars($item['name']); ?></strong><br>
                                                        <small><?php echo htmlspecialchars($item['area']); ?> sqft</small>
                                                    </div>
                                                    <span>₹
                                                        <?php echo number_format(($item['area'] * $item['price']) + floatval($item['accessoriesTotal']), 2); ?></span>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <p>No items in cart.</p>
                                    <?php endif; ?>

                                    <?php

                                    $sqlBooking = "SELECT * FROM booking_amount WHERE is_active = 'Y' LIMIT 1";
                                    $resultBooking = $conn->query($sqlBooking);
                                    $bookingAmount = $resultBooking && $resultBooking->num_rows > 0 ? $resultBooking->fetch_assoc() : null;

                                    // $bookingAmount = $resultBooking && $resultBooking->num_rows > 0 ? $resultBooking->fetch_assoc() : null;
                                    
                                    $finalPayable = $priceAfterOffer; // IMPORTANT
                                    $remainingAmount = 0.00;

                                    if ($bookingAmount) {
                                        if ($bookingAmount['offer_type'] === 'FIXED') {
                                            $finalPayable = floatval($bookingAmount['offer_value']);
                                            $remainingAmount = $priceAfterOffer - $finalPayable;
                                        } elseif ($bookingAmount['offer_type'] === 'PERCENTAGE') {
                                            $percentValue = floatval($bookingAmount['offer_value']);
                                            $finalPayable = round(($priceAfterOffer * $percentValue) / 100, 2);
                                            $remainingAmount = $priceAfterOffer - $finalPayable;
                                        }
                                    }

                                    if ($remainingAmount < 0) {
                                        $remainingAmount = 0;
                                    }


                                    ?>

                                    <?php if (isset($offer)): ?>
                                        <div class="alert alert-success mt-3">
                                            <strong>🎉 Offer Applied!</strong><br>
                                            Code: <b>
                                                <?php echo htmlspecialchars($offer['offer_code']); ?>
                                            </b><br>
                                            <?php if ($offer['offer_type'] === 'PERCENTAGE'): ?>
                                                <?php echo $offer['offer_value']; ?>% off on cart
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>

                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td style="text-align:left;">Item</td>
                                                <td style="text-align:right;"><?php echo $totalItems; ?></td>
                                            </tr>

                                            <tr>
                                                <td style="text-align:left;">Price</td>
                                                <td style="text-align:right;">Rs
                                                    <?php echo number_format($totalPrice, 2); ?>
                                                </td>
                                            </tr>

                                            <?php if (!empty($offerDiscount)): ?>
                                                <tr>
                                                    <td style="text-align:left; color:green;">Offer Discount</td>
                                                    <td style="text-align:right; color:green;">
                                                        - Rs <?php echo number_format($offerDiscount, 2); ?>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>

                                            <?php if ($bookingAmount): ?>
                                                <tr>
                                                    <td style="text-align:left;">Booking Amount</td>
                                                    <td style="text-align:right;">Rs
                                                        <?php echo number_format($finalPayable, 2); ?>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="text-align:left;">Remaining Amount</td>
                                                    <td style="text-align:right;">Rs
                                                        <?php echo number_format($remainingAmount, 2); ?>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>

                                            <tr>
                                                <td colspan="2">
                                                    <form id="paymentForm12" action="checkout.php" method="POST">
                                                        <input type="hidden" name="userId"
                                                            value="<?php echo $userId; ?>">
                                                        <input type="hidden" name="order_amount"
                                                            value="<?php echo $finalPayable; ?>">
                                                        <input type="hidden" name="remaining_amount"
                                                            value="<?php echo $remainingAmount; ?>">
                                                        <input type="hidden" name="price" value="<?php echo $totalPrice; ?>">
                                                        <!-- ADD THESE -->
                                                        <input type="hidden" id="hiddenName" name="name">
                                                        <input type="hidden" id="hiddenEmail" name="email">
                                                        <input type="hidden" id="hiddenMobile" name="mobile">
                                                        <input type="hidden" id="hiddenCity" name="city">
                                                        <input type="hidden" id="hiddenZip" name="zip">
                                                        <input type="hidden" id="hiddenAddress" name="address">

                                                        <button type="button" id="buyNowBtn"
                                                            class="btn btn-primary btn-block">
                                                            Book Now
                                                        </button>
                                                    </form>

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>


                                    <div class="row mt-3">
                                        <div class="col-md-2">
                                            <i class="fa fa-shield fa-2x" style="font-size: 57px"
                                                aria-hidden="true"></i>
                                        </div>
                                        <div class="col-md-10">
                                            <p class="text-dark">Safe and Secure Payments. 100% Authentic products.</p>
                                        </div>
                                    </div>
                                </div> <!-- card-body -->
                            </div> <!-- card -->
                        </div> <!-- col -->
                    </div> <!-- row -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'common/footer.php'; ?>

<!-- JavaScript Section -->
<script>
    const productIdsInput = document.getElementById('product_ids');
    const productIds = productIdsInput ? productIdsInput.value : '';
    console.log("Selected Product IDs:", productIds);

    document.getElementById("buyNowBtn").addEventListener("click", function () {
        const nameInput = document.getElementById("inputPassword4");
        const emailInput = document.getElementById("inputEmail4");
        const mobileInput = document.getElementById("inputAddress");
        const cityInput = document.getElementById("inputCity");
        const zipInput = document.getElementById("inputZip");
        const addressInput = document.getElementById("inputAddress2");

        const inputs = [nameInput, emailInput, mobileInput, cityInput, zipInput, addressInput];

        inputs.forEach(input => input.classList.remove("error-field"));

        let hasError = false;

        inputs.forEach(input => {
            if (!input.value.trim()) {
                input.classList.add("error-field");
                hasError = true;
            }
        });

        if (hasError) {
            return;
        }

        // Copy values to hidden fields
        document.getElementById("hiddenName").value = nameInput.value;
        document.getElementById("hiddenEmail").value = emailInput.value;
        document.getElementById("hiddenMobile").value = mobileInput.value;
        document.getElementById("hiddenCity").value = cityInput.value;
        document.getElementById("hiddenZip").value = zipInput.value;
        document.getElementById("hiddenAddress").value = addressInput.value;

        // Submit form
        document.getElementById("paymentForm12").submit();
    });
</script>
<script>
if (!<?= json_encode(isset($_SESSION['user_id'])) ?>) {
                                            
    const userEmail = localStorage.getItem("user_email");

    if (userEmail) {
        fetch("ajax/restore-session.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ email: userEmail })
        })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            if (data.status === "ok") {
                location.reload();
            } else {
                localStorage.clear();
                window.location.href = "login-signup.html";
            }
        });
    }
}
</script>
