<?php include 'common/header.php';

unset($_SESSION['single_cart_product'])


?>

<style>
@keyframes popInRotate {
  0% {
    transform: scale(0) rotate(0deg);
    opacity: 0;
  }
  60% {
    transform: scale(1.2) rotate(270deg);
    opacity: 1;
  }
  100% {
    transform: scale(1) rotate(360deg);
  }
}

.animated-icon-combo {
  display: inline-block;
  animation: popInRotate 1s ease-out;
}
</style>

<div class="features">
    <div class="container py-5">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 text-center">

                <div class="card shadow-lg p-4">
                    <div class="card-body ">
                        <!-- Success Icon -->
                        <div class="text-success mb-4">
                            <i class="fa fa-check-circle fa-5x animated-icon-combo"></i>
                        </div>

                        <!-- Title -->
                        <h2 class="card-title mb-3">Payment Successful</h2>

                        <!-- Message -->
                        <p class="card-text text-muted">
                            Thank you! Your payment has been processed successfully.
                        </p>

                        <!-- Back or Home Button -->
                        <a href="product.php" class="btn btn-success mt-3">Go to Cart</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



<?php include 'common/footer.php'; ?>