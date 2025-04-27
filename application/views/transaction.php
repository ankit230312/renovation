<style>
/* Style the tab */
.tab {
float: left;
border: 1px solid #0c757a29;
background-color: #0c757a29;
width: 30%;
height: auto;

}
.tab button a{
color:black
}
ins{
color: teal;
text-transform: uppercase;
}

/* Style the buttons inside the tab */
.tab button {
display: block;
background-color: inherit;
color: black;
padding: 16px 16px;
width: 100%;
border: none;
outline: none;
font-weight: 600;
text-align: left;
cursor: pointer;
transition: 0.3s;
border-bottom: 1px solid teal;
font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
background-color: #ddd;
}

/* Create an active/current "tab button" class */
.tab button.active {
background-color: #0c757a;
color: white;
font-weight: 600;
}

/* Style the tab content */
.tabcontent {
float: left;
padding: 0px 12px;
/* border: 1px solid #ccc; */
width: 70%;
border-left: none;
height: 100%;
}

.profile-sec h5 {
margin: 13px 0px;
font-size: 16px;
}

@media (max-width: 767.98px) {
/* .tab {
display: flex;
flex-direction: row;
position: relative;
overflow: scroll;
width: 100%;
height: auto;
white-space: nowrap;
top: auto;
} */

.tabcontent {
width: 100%;
}
}


.history-list li {
display: block;
padding: 20px;
border-bottom: 1px solid #efefef;
}

.purchase-history {
display: flex;
align-items: center;
}

.purchase-history-left h4 {
font-size: 16px;
color: #2b2f4c;
margin-bottom: 8px;
text-align: left;
font-weight: 500;
}

.purchase-history-left p {
font-size: 14px;
font-weight: 500;
color: #3e3f5e;
text-align: left;
margin-bottom: 8px;
line-height: 24px;
}

.purchase-history-left span {
font-weight: 400;
font-size: 13px;
color: #3e3f5e;
text-align: left;
display: block;
}

.purchase-history-right {
text-align: center;
}

.purchase-history-right {
margin-left: auto;
}

.purchase-history-right span {
display: block;
font-size: 16px;
font-weight: 600;
color: #f55d2c;
text-align: center;
}

.purchase-history-right a {
font-size: 14px;
font-weight: 500;
margin-top: 9px;
display: block;
color: #2b2f4c;
}
</style>


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
<div id="transactions" class="tabcontent">


<div class="col-lg-12 rounded shadow">
<div class="history-body scrollstyle_4">
<ul class="history-list">
    <?php if(!empty($transactions)){
        foreach($transactions as $trans){
            if($trans->type == 'CREDIT'){
                $sign = 'credited';
                $color = 'green';
            }if($trans->type == 'DEBIT'){
                $sign = 'debited'; 
                 $color = 'blue';
            }
        ?>
    <li>
        <div class="purchase-history">
            <div class="purchase-history-left">
                <h4>Purchase</h4>
                <p>Transaction ID <ins><?=$trans->txn_no?></ins></p>
                <span><?=$trans->transaction_at?></span>
            </div>
            <div class="purchase-history-right">
              <span style="color: <?=$color?>"><?=$sign?></span>
                <span style="color:red;"><?=$trans->amount?></span>
                <a href="<?=base_url('home/order_details/').$trans->orderID?>" class="btn 
                  btn-warning">View</a>
            </div>
        </div>
    </li>
<?php }}?>
    <?php 
    /*
        $start_loop = $pageno;
        $difference = $total_pages - $pageno;
        if($difference <= 5)
        {
         $start_loop = $total_pages - 5;
       }
       $end_loop = $start_loop + 4;

       if($pageno > 1)
       {
        echo '<ul class="pagination">';
         echo '<li><a  href="?pageno=1" class="page-link">First</a></li>';

         echo "<li class='page-item '><a class='page-link' href='?pageno=".($pageno - 1)."'><<</a></li>";
       }
       for($i=$start_loop; $i<=$end_loop; $i++)
       {  
        $class ='';
        if($pageno ==$i){
          $class = 'active';
        }   
         echo "<li class='page-item ".$class."'><a class='page-link' href='?pageno=".$i."'>".$i."</a></li>";
       }
       if($pageno <= $end_loop)
       {

         echo "<li class='page-item '><a class='page-link' href='?pageno=".($pageno + 1)."'>>></a></li>";
         echo "<li class='page-item'><a class='page-link' href='?pageno=".$total_pages."'>Last</a></li>";

          echo "<ul>";


       }
       */
       ?>
</ul>
</div>

</div>



</div>


</div>
</div>
</section>
