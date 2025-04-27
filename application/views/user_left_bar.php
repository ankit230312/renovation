 <?php

 $url =  $this->uri->segment(2);

 ?>

    <style>

 </style>



 <div class="tab">

   <a class="tablinks <?php if($url=='profile')echo 'active'?>" href="<?=base_url('home/profile')?>" > My Profile</a>
   <a class="tablinks <?php if($url=='wallet')echo 'active'?>" href="<?=base_url('home/wallet')?>" > Wallet </a>
   <a class="tablinks <?php if($url=='address')echo 'active'?>" href="<?=base_url('home/address')?>"> My Address </a>

   <a class="tablinks <?php if($url=='order' || $url == 'order_details')echo 'active'?>"  href="<?=base_url('home/order')?>"> My Order</a>
   <a class="tablinks <?php if($url=='transaction')echo 'active'?>" href="<?=base_url('home/transaction')?>"> My Transactions </a>
   <a class="tablinks" href="<?=base_url('login/logout')?>"> Log Out</a>
</div>