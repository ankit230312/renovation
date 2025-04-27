<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2><?=$title?></h2>
                    <ul class="breadcrumb padding-0">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url("reports")?>">Product Order</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card">
            <form method="GET" action="<?=base_url("reports/")?>">
                <div class="row body">
                    <div class="col-sm-3">
                        <label>Delivery Date :</label>
                        <input value="<?php if (isset($_GET['delivery_date']) && !empty($_GET['delivery_date'])){echo $_GET['delivery_date'];}?>" class="form-control" type="date" name="delivery_date">
                    </div>
                    <div class="col-sm-2">
                        <label>Category :</label>
                        <select class="form-control" name="cat">
                            <option value="">ALL</option>
                            <?php foreach ($categories as $c){?>
                                <option <?php if (isset($_GET['cat']) && ($_GET['cat'] == $c->categoryID)){echo 'selected';}?> value="<?=$c->categoryID?>"><?=$c->title?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label>Apartment :</label>
                        <select class="form-control" name="apartment">
                            <option value="">ALL</option>
                            <?php foreach ($apartments as $a){?>
                                <option <?php if (isset($_GET['apartment']) && ($_GET['apartment'] == $a->apartment)){echo 'selected';}?> value="<?=$a->apartment?>"><?=$a->apartment?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label>Status :</label>
                        <select class="form-control" name="status">
                            <option value="">ALL</option>
                            <option <?php if (isset($_GET['status']) && ($_GET['status'] == 'OUT_FOR_DELIVERY')){echo 'selected';}?> value="OUT_FOR_DELIVERY">IN PROGRESS</option>
                            <option <?php if (isset($_GET['status']) && ($_GET['status'] == 'DELIVERED')){echo 'selected';}?> value="DELIVERED">DELIVERED</option>
                            <option <?php if (isset($_GET['status']) && ($_GET['status'] == 'CANCEL')){echo 'selected';}?> value="CANCEL">CANCELLED</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label>Click to Filter</label>
                        <button class="form-control btn btn-primary" type="submit">SUBMIT</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-sm dataTable js-exportable" >
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>PRODUCT</th>
                                    <th>CATEGORY</th>
                                    <th>WEIGHT</th>
                                    <th>QTY</th>
                                    <th>NET PRICE</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($orders as $o){  ?>
                                    <tr>
                                        <td><?=$o->productID?></td>
                                        <td><?=$o->product_name?></td>
                                        <td><?=$o->main_category_name?></td>
                                        <td><?=$o->unit_value.$o->unit?></td>
                                        <td><?=$o->qty?></td>
                                        <td><?=$o->net_price?></td>
                                    </tr>
                                <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function(){
        $('#datatable1').dataTable({
            bLengthChange: false,
            order: [[ 0, "asc" ]],
            responsive: true,
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
            }
        });

    });
</script>