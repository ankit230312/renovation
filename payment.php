<?php include 'common/header.php';

$paymentSessionId = $_GET['session_id'] ?? '';
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
                                                <input type="text" class="form-control" id="inputPassword4" placeholder="">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Email</label>
                                                <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputAddress">Mobile Number</label>
                                            <input type="text" class="form-control" id="inputAddress" placeholder="8171.....">
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
                                    $totalPrice += ($area * $price);

                                    if (isset($item['id'])) {
                                        $productIds[] = $item['id'];
                                    }
                                }
                                // 
                                ?>

                                <!-- Always render the hidden input -->
                                <input type="hidden" id="product_ids" value="<?php echo implode(',', $productIds); ?>">

                                <div class="card-body">
                                    <h5 class="card-title" style="font-weight: 500; color:black ; font-size:large">Bill</h5>
                                    <h6 class="mt-4" style="font-weight: 500; color:black ; font-size:large">Item Details:</h6>
                                    <?php if (!empty($cartData)): ?>
                                        <ul class="list-group mb-3 mt-3">
                                            <li class="list-group-item" style="font-weight: 500; color:black ; font-size:large"><?php echo $rowitem['product_name'] ?></li>
                                            <?php foreach ($cartData as $item): ?>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <strong><?php echo htmlspecialchars($item['name']); ?></strong><br>
                                                        <small><?php echo htmlspecialchars($item['area']); ?> sqft</small>
                                                    </div>
                                                    <span>₹ <?php echo number_format($item['area'] * $item['price'], 2); ?></span>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <p>No items in cart.</p>
                                    <?php endif; ?>

                                    <?php
                                    // Fetch active booking amount
                                    $sqlBooking = "SELECT * FROM booking_amount WHERE is_active = 'Y' LIMIT 1";
                                    $resultBooking = $conn->query($sqlBooking);
                                    $bookingAmount = $resultBooking && $resultBooking->num_rows > 0 ? $resultBooking->fetch_assoc() : null;

                                    $finalPayable = $totalPrice; // default total
                                    $remainingAmount = 0.00;

                                    if ($bookingAmount) {
                                        if ($bookingAmount['offer_type'] === 'FIXED') {
                                            $finalPayable = floatval($bookingAmount['offer_value']);
                                            $remainingAmount = $totalPrice - $finalPayable;
                                        } elseif ($bookingAmount['offer_type'] === 'PERCENTAGE') {
                                            $percentValue = floatval($bookingAmount['offer_value']);
                                            $finalPayable = round(($totalPrice * $percentValue) / 100, 2);
                                            $remainingAmount = $totalPrice - $finalPayable;
                                        }
                                    }

                                    // echo "<p>Final Payable Amount: ₹ " . number_format($finalPayable, 2) . "</p>";
                                    // echo "<p>Remaining Amount after Booking: ₹ " . number_format($remainingAmount, 2) . "</p>";
                                    ?>

                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td style="text-align: left;">Item</td>
                                                <td style="text-align: right;"><?php echo $totalItems; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left;">Price</td>
                                                <td style="text-align: right;"><span>Rs</span> <?php echo number_format($totalPrice, 2); ?></td>
                                            </tr>
                                            <?php if ($bookingAmount): ?>
                                                <tr>
                                                    <td style="text-align: left;">Booking Amount</td>
                                                    <td style="text-align: right;"><span>Rs</span> <?php echo number_format($finalPayable, 2); ?></td>
                                                </tr>

                                                <td style="text-align: left;">Remaining Amount</td>
                                                <td style="text-align: right;"><span>Rs</span> <?php echo number_format($remainingAmount, 2); ?></td>

                                            <?php endif; ?>
                                            <tr>
                                                <td colspan="2" style="text-align: left;">
                                                    <form action="checkout.php" method="POST">
                                                        <input type="hidden" name="order_amount" value="<?php echo $finalPayable; ?>">
                                                        <input type="hidden" name="remaining_amount" value="<?php echo $remainingAmount; ?>">

                                                        <button type="submit" id="buy_now" class="btn btn-primary btn-block">
                                                            Buy Now
                                                        </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="row mt-3">
                                        <div class="col-md-2">
                                            <i class="fa fa-shield fa-2x" style="font-size: 57px" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-md-10">
                                            <p class="">Safe and Secure Payments. 100% Authentic products.</p>
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

    // document.getElementById("buyNowBtn").addEventListener("click", function() {
    //     const nameInput = document.getElementById("inputPassword4");
    //     const emailInput = document.getElementById("inputEmail4");
    //     const mobileInput = document.getElementById("inputAddress");
    //     const cityInput = document.getElementById("inputCity");
    //     const zipInput = document.getElementById("inputZip");
    //     const addressInput = document.getElementById("inputAddress2");

    //     const inputs = [nameInput, emailInput, mobileInput, cityInput, zipInput, addressInput];

    //     // Clear previous errors
    //     inputs.forEach(input => input.classList.remove("error-field"));

    //     const name = nameInput.value.trim();
    //     const email = emailInput.value.trim();
    //     const mobile = mobileInput.value.trim();
    //     const city = cityInput.value.trim();
    //     const zip = zipInput.value.trim();
    //     const address = addressInput.value.trim();

    //     const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    //     const mobilePattern = /^[6-9]\d{9}$/;

    //     let hasError = false;

    //     if (!name) {
    //         nameInput.classList.add("error-field");
    //         hasError = true;
    //     }

    //     if (!email || !emailPattern.test(email)) {
    //         emailInput.classList.add("error-field");
    //         hasError = true;
    //     }

    //     if (!mobile || !mobilePattern.test(mobile)) {
    //         mobileInput.classList.add("error-field");
    //         hasError = true;
    //     }

    //     if (!city) {
    //         cityInput.classList.add("error-field");
    //         hasError = true;
    //     }

    //     if (!zip) {
    //         zipInput.classList.add("error-field");
    //         hasError = true;
    //     }

    //     if (!address) {
    //         addressInput.classList.add("error-field");
    //         hasError = true;
    //     }

    //     if (hasError) {
    //         // alert("Please correct the highlighted fields.");
    //         return;
    //     }

    //     // Proceeding to payment
    //     // alert("All fields are valid. Proceeding to payment...\nSelected Product IDs: " + productIds);
    //     // document.getElementById("paymentForm").submit(); // Enable when ready
    // });
</script>

<script>
    // document.getElementById("buy_now").addEventListener("click", function() {
    //     window.location.href = "payment_success.php";
    // });
</script>