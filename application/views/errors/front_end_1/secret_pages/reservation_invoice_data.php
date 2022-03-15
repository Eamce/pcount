<style type="text/css">
  ul.demo {
  list-style-type: none;
  margin: 0;
  padding: 0;
}
</style>
 <div id="nvoice-details"> 
  <div class="container-fluid">
    <div class="row" style="padding: 20px 20px 20px 20px;">
      <div class="col-md-2"></div>
      <div class="col-md-8">
        <h3 style="font-weight: bold;">Invoice</h3>
        <div class="row">
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-6">
                <ul class="demo">
                  <li><b>Invoice Number</b></li>
                  <li><?php echo $trans_data->rcard_num;?></li>
                </ul>
              </div>
              <div class="col-md-6">
                <ul class="demo">
                  <li><b>Date/Time Of Issue</b></li>
                  <li><?php echo date('m-d-Y g:s:i a', strtotime($trans_data->DateTime_trans));?></li>
                </ul>
              </div>
            </div>
            <div class="row" style="margin-top: 10px;">
              <div class="col-md-6">
                <ul class="demo">
                  <li><b>Billing to</b></li>
                  <li><?php echo $trans_data->full_name;?></li>
                  <li><?php echo $trans_data->address;?></li>
                  <li><?php echo $trans_data->email;?></li>
                </ul>
              </div>
              <div class="col-md-6">
                <ul class="demo">
                  <li><b>Arrival Date: </b> <?php echo date('m-d-Y', strtotime($trans_data->check_in));?></li>
                  <li><b>Departure Date: </b> <?php echo date('m-d-Y', strtotime($trans_data->check_out));?></li>
                  <li><b>Company: </b><?php echo $trans_data->company;?></li>
                  <li><b>No. of Adult/s: </b><?php echo $trans_data->num_adults;?></li>
                  <li><b>No. of Children/s: </b><?php echo $trans_data->num_childs;?></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-6"></div>
              <div class="col-md-6">
               <ul class="demo">
                <li><h3><b>SAFARI HOTEL</b></h3></li>
                <li><h5>29 Land St, Lorem City, CA</h5></li>
                <li><h5>info@safarihotel.com</h5></li>
                <li><h5>+00 123 4567</h5></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <table class="table" width="100%">
            <thead>
              <tr>
                <th>Description</th>
                <th style="text-align: center;">Qty</th>
                <th style="text-align: right;">Price/Rate</th>
                <th style="text-align: right;">Total</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($g_rooms as $key => $value): ?>
               <tr>
                <td>
                  <?php echo $value['room_num']."  --------------- ".$value['roomtype'];?> <br>
                  <?php echo $value['amenity'];?>
                </td>
                <td style="text-align: center;"><?php 
                $dt = strtotime( $trans_data->check_out) - strtotime($trans_data->check_in);
                $dt_diff = round($dt / (60 * 60 * 24));
                echo $dt_diff.'/ Night';
                ?>
              </td>
              <td style="text-align: right;">
                <?php 
                echo '₱ '.number_format($value['rate'],2).'/ Night';
                ?>
              </td>
              <td style="text-align: right;">
                <?php 
                $totz = $value['rate'] * $dt_diff;
                echo '₱ '.number_format($totz,2);
                ?>
              </td>
            </tr>
          <?php endforeach ?>

        </tbody>
      </table>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8"></div>
    <div class="col-md-4">
      <div class="row">
        <div class="col-md-6">
          <ul class="demo">
            <li><b>Subtotal</b></li>
            <li><b>Discount</b></li>
            <li><b>Total</b></li>
          </ul>
        </div>
        <div class="col-md-6">
          <ul class="demo" style="text-align: right;">
            <li><?php 
            $dt2 = strtotime( $trans_data->check_out) - strtotime($trans_data->check_in);
            $dt_diff2 = round($dt2 / (60 * 60 * 24));
            $total =  $sub_tot->rate * $dt_diff2;
            echo '₱ '.number_format($total,2);
            ?></li>
            <li><?php echo '₱ '.number_format($trans_data->discount_amt,2);?></li>
            <li><?php 
            $f_total = $total - $trans_data->discount_amt;
            echo '₱ '.number_format($f_total,2);
            ?></li>
          </ul>
        </div>
      </div>
    </div>

  </div>
</div>
<div class="col-md-2"></div>
</div><!-- end row -->
</div><!-- end container -->
</div><!-- end reervation-details -->
<div class="row" id="btn_print_div" style="margin: 10px 0 10px 0;">
  <div class="col-md-2"></div>
  <div class="col-md-8" style="text-align: right;">
    <form action="<?php echo base_url();?>home_page" method="POST">
      <input type="hidden" name="t_g_id" id="t_g_id" value="<?php echo $trans_data->t_g_id;?>">
        <button type="submit" class="btn btn-default" style="background-color: lightblue; border-radius: 4px;"><i class="fa fa-print"></i> Print</button>
    </form>
  </div>
  <div class="col-md-2"></div>
</div>