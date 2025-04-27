

<section class="mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

               <?php
               $this->load->view('user_left_bar');
               ?>
               <?php 
               echo $this->session->flashdata('message');
               ?>
               <div id="wallet" class="tabcontent">


                <div class="col-lg-12 p-3 bg-white rounded shadow-sm mb-5">

                    <div class="card card-body account-right">
                        <div class="widget">

                            <div class="row">


                                <div class="reward-body-dtt">
                                    <div class="reward-img-icon">
                                        <img src="images/wallet.png" alt="">
                                    </div>
                                    <span class="rewrd-title">My Balance</span>
                                    <h4 class="cashbk-price">₹<?=$myprofile['wallet']?></h4>
                                    <a href="<?=base_url('home/transaction')?>"><span class="date-reward">Transaction History</span></a>
                                </div>
                                
                            </div>
                            <div style="float: right;">
                                <button type="button" id="add_balance" class="btn btn-danger"><i class="fa fa-plus"
                                    aria-hidden="true"></i> Add Balance</button>
                                </div>

                                <div id="add_balance_form" style="display: none;">
                                    <form method="post" action="">
                                        <label>Choose Amount</label>
                                        <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" name="amount_add" id="amount_add" value="100"><br>

                                        <input type="radio" name="amount" value="100" checked>Rs.100.00<br>
                                        <input type="radio" name="amount" value="200">Rs.200.00<br>
                                        <input type="radio" name="amount" value="500">Rs.500.00<br>
                                        <input type="radio" name="amount" value="1000">Rs.1000.00<br>
                                        <button class="btn btn-success" id="add_bal">Add</button>
                                    </form>
                                    
                                </div>


                            </div>
                        </div>
                    </div>


                </div>


            </div>
        </div>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script type="text/javascript">
        $("#add_balance").click(function(){
           $('#add_balance_form').toggle(1000);
       });

        $('input[type=radio][name=amount]').change(function() {
            var value = this.value;
            $('#amount_add').val(value);
        });
         $("#add_bal").click(function(){
           return false;
       });
    </script>