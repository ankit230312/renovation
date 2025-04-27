<section class="content">

    <div class="container-fluid">

        <div class="block-header">

            <div class="row clearfix">

                <div class="col-lg-5 col-md-5 col-sm-12">

                    <h2><?=$title?></h2>

                    <ul class="breadcrumb padding-0">

                        <li class="breadcrumb-item"><a href="<?=base_url()?>"><i class="zmdi zmdi-home"></i></a></li>

                        <li class="breadcrumb-item"><a href="<?=base_url("deals")?>">Deals</a></li>

                        <li class="breadcrumb-item active">Edit</li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

    <!-- Input -->

    <div class="row clearfix">

        <div class="col-lg-12">

            <div class="card">

                <div class="header">

                    <h2 class="text-left"><a class="btn-sm btn btn-primary" href="<?=base_url("deals")?>"><i class="zmdi zmdi-arrow-back"></i> List</a></h2>

                </div>

                <div class="body">

                    <?php if (isset($error)){?>

                        <h2 class="title text-danger"><?=$error?></h2>

                    <?php }?>

                    <form method="post">

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Product <span class="text-danger">*</span> :</label>

                                    <select class="form-control js-example-basic-single" name="productID" required>

                                        <?php foreach ($products as $p){?>

                                            <option value="<?=$p->productID?>" <?= (($deal->productID == $p->productID)?'selected':'') ?>><?=$p->product_name.' ('.$p->price.' / '.$p->unit_value.' '.$p->unit.') '?></option>

                                        <?php }?>

                                    </select>

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                                <div class="col-sm-12">

                                    <div class="form-group">

                                        <label>City <span class="text-danger">*</span> :</label>

                                        <select class="form-control" id="cities" name="cityID[]" required multiple="">

                                            <?php foreach ($city as $c){?>

                                                <option value="<?=$c->id?>" <?= (($deal->cityID == $c->id)?'selected':'') ?>><?=$c->title?></option>

                                            <?php }?>

                                        </select>

                                    </div>

                                </div>

                            </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Deal Price <span class="text-danger">*</span> :</label>

                                    <input class="form-control" value="<?=$deal->deal_price?>" required type="number" step="0.01" placeholder="Enter Deal Price" name="deal_price">

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                                <div class="col-sm-12">

                                    <div class="form-group">

                                        <label>Max Quantity :</label>

                                        <input class="form-control" required type="number" value="<?=$deal->max_quantity?>"  placeholder="Enter Max Quantity" name="max_quantity">

                                    </div>

                                </div>

                            </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Start Date <span class="text-danger">*</span> :</label>

                                    <input class="form-control" required type="date" placeholder="Enter Start Date" value="<?=date("Y-m-d",strtotime($deal->start_date))?>" name="start_date">

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>End Date <span class="text-danger">*</span> :</label>

                                    <input class="form-control" required type="date" placeholder="Enter End Date" value="<?=date("Y-m-d",strtotime($deal->end_date))?>" name="end_date">

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                            <div class="col-sm-12">

                                <div class="form-group">

                                    <label>Status <span class="text-danger">*</span> :</label>

                                    <select class="form-control" name="status" required>

                                        <option <?=(($deal->status == 'Y')?'selected':'')?> value="Y">Active</option>

                                        <option <?=(($deal->status == 'N')?'selected':'')?> value="N">InActive</option>

                                    </select>

                                </div>

                            </div>

                        </div>

                        <div class="row clearfix">

                            <div class="col-sm-6">

                                <div class="form-group">

                                    <button class="btn btn-default btn-round" type="submit"><i class="zmdi zmdi-check-circle"></i> Submit</button>

                                    <button class="btn btn-primary btn-round" type="reset"><i class="zmdi zmdi-replay"></i> Reset</button>

                                </div>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <!-- #END# Input -->

    </div>

</section>

<script type="text/javascript">

    

$(document).ready(function() {

    $('.js-example-basic-single').select2();

});

</script>

<script>
    $(document).ready(function () {
       $("#cities").select2();
    });
 </script>
