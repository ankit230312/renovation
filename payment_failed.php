<?php include 'common/header.php'; ?>

<style>
@keyframes popIn {
  0% {
    transform: scale(0);
    opacity: 0;
  }
  60% {
    transform: scale(1.2);
    opacity: 1;
  }
  100% {
    transform: scale(1);
  }
}

.animated-icon {
  animation: popIn 0.6s ease-out;
}
</style>

<div class="features">
   <div class="container py-5">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6 text-center">

            <div class="card shadow-lg p-4">
                <div class="card-body">
                    <!-- Success Icon -->
                    <div class="text-danger mb-4">
                        <i class="fa fa-times-circle fa-5x animated-icon"></i>
                    </div>

                    <!-- Title -->
                    <h2 class="card-title mb-3 ">Payment Failed</h2>

                    <!-- Message -->
                    <p class="card-text text-muted">
                       Payment Failed.
                    </p>

                    <!-- Back or Home Button -->
                    <a href="#" class="btn btn-success mt-3">Go to Dashboard</a>
                </div>
            </div>

        </div>
    </div>
</div>
</div>



<?php include 'common/footer.php'; ?>
