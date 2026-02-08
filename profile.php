<?php include 'common/header.php';

if (!isset($_SESSION["user_id"])) { ?>
    <script>
        // Clear specific localStorage key
        localStorage.removeItem("user_name");

        // OR clear everything if needed:
        // localStorage.clear();

        // Redirect to login page
        window.location.href = "index.php";
    </script>
<?php }


$userID = $_SESSION['user_id']; // logged-in user

$sql = "
SELECT 
    o.orderID,
    o.status,
    o.added_on,
    o.total_amount,
    p.product_image
FROM orders o
JOIN order_items oi ON oi.orderID = o.orderID
JOIN products_item p ON p.productID = oi.productID
WHERE o.userID = ?
GROUP BY o.orderID
ORDER BY o.orderID DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
?>

<style>
    .btn-invoice {
        display: inline-block;
        padding: 6px 12px;
        font-size: 14px;
        background: #0d6efd;
        color: #fff;
        border-radius: 4px;
        text-decoration: none;
    }

    .btn-invoice:hover {
        background: #0b5ed7;
    }
</style>





<div class="container my-3">
    <div class="">
        <div class="dashboard-container">
            <!-- Sidebar -->
            <div class="sidebar">
                <div>
                    <div class="profile">
                        <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="User" />
                        <h2><?php echo $user['full_name'] ?></h2>
                        <!-- <p>8218024554</p> -->
                    </div>



                    <ul class="menu_profile">
                        <li class="active" data-tab="orders">🛒 Orders</li>
                        <li data-tab="support">💬 Customer Support</li>
                        <!-- <li data-tab="addresses">📍 Addresses</li> -->
                        <li data-tab="profile">👤 Profile</li>
                    </ul>
                </div>
                <div class="logout">

                    <button onclick="logoutUser()" class="btn btn-danger">Logout</button>
                </div>
            </div>

            <!-- Main content -->
            <div class="main">
                <!-- Orders -->
                <div id="orders" class="tab-content active">
                    <h2>Orders</h2>
                    <div class="orders">

                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <div class="order-card">
                                    <div class="order-info">
                                        <div class="order-images">
                                            <img src="https://your-s3-bucket/<?= htmlspecialchars($row['product_image']) ?>"
                                                alt="">
                                        </div>

                                        <div class="order-details">
                                            <p class="status">
                                                Order
                                                <?= ucfirst(strtolower($row['status'])) ?> ✔
                                            </p>
                                            <p>
                                                Placed at
                                                <?= date("d M Y, h:i a", strtotime($row['added_on'])) ?>
                                            </p>
                                        </div>

                                        <div class="order-actions">
                                            <?php
                                            $orderID = (int) $row['orderID'];
                                            $invoiceFile = __DIR__ . '/invoices/invoice_' . $orderID . '.pdf';
                                            if (file_exists($invoiceFile)): ?>
                                                <a target="_blank" rel="noopener noreferrer"
                                                   href="<?php echo 'invoices/invoice_' . $orderID . '.pdf'; ?>"
                                                   class="btn btn-invoice"
                                                   download="<?php echo 'Order_Invoice_' . $orderID . '.pdf'; ?>">
                                                    View Invoice
                                                </a>
                                            <?php else: ?>
                                                <span class="btn btn-invoice" style="background:#6c757d;cursor:not-allowed;">Invoice unavailable</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <!-- C:\xampp\htdocs\splitfloor\invoices -->

                                    <div class="price">
                                        ₹
                                        <?= number_format($row['total_amount'], 2) ?>
                                    </div>


                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p>No orders found</p>
                        <?php endif; ?>

                    </div>
                </div>


                <!-- Customer Support -->
                <div id="support" class="tab-content">
                    <h2>Customer Support</h2>
                    <p class="support-intro">Find answers to common questions or contact us directly.</p>

                    <div class="faq-container">
                        <div class="faq-item">
                            <button class="faq-question">❓ How can I track my order?</button>
                            <div class="faq-answer">
                                <p>You can track your order from the <strong>Orders</strong> tab. Each order shows its
                                    current status and delivery details.</p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question">💳 What payment methods are accepted?</button>
                            <div class="faq-answer">
                                <p>We accept UPI, credit/debit cards, net banking, and cash on delivery (COD) for
                                    eligible orders.</p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question">🚚 How can I change my delivery address?</button>
                            <div class="faq-answer">
                                <p>Go to the <strong>Addresses</strong> section and update your saved address before
                                    placing your next order.</p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question">🔁 What is your return policy?</button>
                            <div class="faq-answer">
                                <p>Returns are accepted within 7 days for eligible products. Visit the
                                    <strong>Orders</strong> section to initiate a return request.
                                </p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question">📞 Still need help?</button>
                            <div class="faq-answer">
                                <p>Contact us directly:</p>
                                <p>📧 support@splitfloor.com</p>
                                <p>📞 +91 80000 00000</p>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Addresses -->
                <div id="addresses" class="tab-content">
                    <div class="address-header">
                        <h2>Saved Addresses</h2>
                        <button class="add-address-btn">➕ Add New Address</button>
                    </div>

                    <div class="address-list">
                        <div class="address-card">
                            <h4>🏠 Home</h4>
                            <p>Ground floor, Room no 003, Raj Homes Rooms, near HR Pharmacy, 62, Mamura, Sector 66,
                                Noida, Uttar Pradesh 201307, India</p>
                            <button class="edit-btn">Edit</button>
                            <button class="delete-btn">Delete</button>
                        </div>

                        <div class="address-card">
                            <h4>📍 Other</h4>
                            <p>40, Sector 66, Mamura, Noida</p>
                            <button class="edit-btn">Edit</button>
                            <button class="delete-btn">Delete</button>
                        </div>

                        <div class="address-card">
                            <h4>📍 Other</h4>
                            <p>8 Sarjan State, Ashutosh City Bareilly, near Hari Har Mandir, Rajendra Nagar, Bareilly
                            </p>
                            <button class="edit-btn">Edit</button>
                            <button class="delete-btn">Delete</button>
                        </div>
                    </div>

                    <!-- Hidden form for adding a new address -->
                    <div class="add-address-form" style="display:none;">
                        <h3>Add New Address</h3>
                        <form id="newAddressForm">
                            <label>Address Label (e.g., Home, Office)</label>
                            <input type="text" name="label" placeholder="Enter label" required />

                            <label>Full Address</label>
                            <textarea name="address" rows="3" placeholder="Enter full address" required></textarea>

                            <button type="submit">Save Address</button>
                            <button type="button" class="cancel-btn">Cancel</button>
                        </form>
                    </div>
                </div>


                <!-- Profile -->
                <div id="profile" class="tab-content">
                    <h2>Profile</h2>

                    <form id="profileForm">
                        <div class="form-group">
                            <label for="name">Name *</label>
                            <input type="text" id="name" name="name" value="User XYZ" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" placeholder="-" required>
                            <small>We promise not to spam you</small>
                        </div>

                        <button type="submit" class="submit-btn">Submit</button>
                    </form>

                    <hr>

                    <div class="delete-section">
                        <h3>Delete Account</h3>
                        <p>Deleting your account will remove all your orders, wallet amount and any active referral</p>
                        <button class="delete-btn">Delete Account</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    const menuItems = document.querySelectorAll('.menu_profile li');
    const tabs = document.querySelectorAll('.tab-content');

    menuItems.forEach(item => {
        item.addEventListener('click', () => {
            // Remove active class from sidebar
            menuItems.forEach(i => i.classList.remove('active'));
            item.classList.add('active');

            // Hide all tab content
            tabs.forEach(tab => tab.classList.remove('active'));

            // Show clicked tab content
            const tabId = item.getAttribute('data-tab');
            document.getElementById(tabId).classList.add('active');
        });
    });
</script>

<script>
    const faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        question.addEventListener('click', () => {
            item.classList.toggle('active');
        });
    });
</script>
<script>
    // Show/Hide Add Address Form
    const addBtn = document.querySelector('.add-address-btn');
    const form = document.querySelector('.add-address-form');
    const cancelBtn = document.querySelector('.cancel-btn');

    addBtn.addEventListener('click', () => {
        form.style.display = 'block';
        addBtn.style.display = 'none';
    });

    cancelBtn.addEventListener('click', () => {
        form.style.display = 'none';
        addBtn.style.display = 'inline-block';
    });

    // Handle new address submission (demo)
    document.getElementById('newAddressForm').addEventListener('submit', (e) => {
        e.preventDefault();
        alert('✅ New address saved successfully!');
        form.style.display = 'none';
        addBtn.style.display = 'inline-block';
    });
</script>

<script>
    function logoutUser() {
        localStorage.clear(); // Clear user info
        if (typeof google !== "undefined" && google.accounts && google.accounts.id) {
            google.accounts.id.disableAutoSelect();
        } // Clear Google cached session
        alert("You have been logged out.");
        location.href = "logout.php";
    }
</script>



<?php include 'common/footer.php'; ?>