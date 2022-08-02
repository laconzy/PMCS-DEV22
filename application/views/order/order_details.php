
  <div class="panel-body" id="data-form">
    <div class="col-sm-3">
      <div class="form-group">
        <label class="control-label">Order ID#</label>
        <input type="text" class="form-control input-sm" value="<?= isset($order_id) ? $order_id : 0 ?>" disabled id="order_id">
      </div>
      <div class="form-group">
        <label class="control-label">Colour Code</label>
        <select class="color" id="color" style="width: 100%">
        </select>
      </div>
      <div class="form-group">
        <label class="control-label">Customer PO</label>
        <input type="text" class="form-control input-sm" id="customer_po">
      </div>
      <div class="form-group">
        <label class="control-label">Delivary Date</label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </div>
          <div class="input-group input-daterange">
            <input type="text" class="form-control input-sm date" value="" id="delivary_date" >
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label">Sales Qty</label>
        <input type="text" class="form-control input-sm" value="" id="sales_qty">
      </div>
      <!--<div class="form-group">
        <label class="control-label">Planned Qty</label>
        <input type="text" class="form-control input-sm" id="planned_qty" disabled>
      </div>-->
    </div>

    <div class="col-sm-3">
      <div class="form-group">
        <label class="control-label">Order Code</label>
        <input type="text" class="form-control input-sm" id="order_code">
      </div>
      <div class="form-group">
        <label class="control-label">Colour Decs</label>
        <input type="text" class="form-control input-sm" id="color_name" disabled>
      </div>
      <div class="form-group">
        <label class="control-label">UOM</label>
        <select id="uom" class="form-control input-sm">
          <option value="">- SELECT -</option>
          <option value="PCS">Pcs</option>
          <option value="PACK">Pack</option>
        </select>
      </div>
      <div class="form-group">
        <label class="control-label">Pcd Date</label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </div>
          <div class="input-group input-daterange">
            <input type="text" class="form-control input-sm date" value="" id="pcd_date">
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label">SMV</label>
        <input type="number" class="form-control input-sm" value="" id="smv">
      </div>
    </div>

    <div class="col-sm-3">
      <div class="form-group">
        <label class="control-label">Style Code</label>
        <select id="style" style="width: 100%">
        </select>
      </div>
      <div class="form-group">
        <label class="control-label">Customer Code</label>
        <select id="customer" style="width: 100%">
        </select>
      </div>
      <div class="form-group">
        <label class="control-label">Ship Method</label>
        <select id="ship_method" class="form-control input-sm">
          <option value="">- SELECT -</option>
          <option value="SEA">SEA</option>
          <option value="AIR">AIR</option>
        </select>
      </div>
      <div class="form-group">
        <label class="control-label">Plan Deli Date</label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </div>
          <div class="input-group input-daterange">
            <input type="text" class="form-control input-sm date" value="" id="planned_delivary_date">
          </div>
        </div>
      </div>
      <div class="form-group">
        <input type="checkbox" value="" id="shipment_complete" style="margin-top:30px">
        <label class="control-label" for="shipment_complete">Shipment Complete</label>
      </div>
    </div>

    <div class="col-sm-3">
      <div class="form-group">
        <label class="control-label">Style Desc</label>
        <input type="text" class="form-control input-sm" id="style_name" disabled>
      </div>
      <div class="form-group">
        <label class="control-label">Customer Name</label>
        <input type="text" class="form-control input-sm" id="customer_name" disabled>
      </div>
      <div class="form-group">
        <label class="control-label">Country</label>
        <select class="form-control input-sm" id="country">
          <option value="">- SELECT -</option>
          <?php foreach ($load_country as $row) { ?>
          <option value="<?php echo $row['country_id']; ?>"><?php echo $row['country_name'];?>
          </option>
          <?php } ?>
        </select>
      </div>
      <div class="form-group">
        <label class="control-label">Season</label>
        <select class="form-control input-sm" id="season">
          <option value="">- SELECT -</option>
          <?php foreach ($seasons as $season) { ?>
            <option value="<?= $season['season_id'] ?>"><?= $season['season_name'] ?></option>
          <?php } ?>
        </select>
      </div>
      <!--<div class="form-group">
        <label class="control-label">Original Ord Qty</label>
        <input type="text" class="form-control input-sm" id="original_ord_qty" disabled>
      </div>-->

    </div>

  </div>
  <div class="col-md-12">
    <br>
    <a class="ladda-button btn btn-primary" data-style="expand-right" id="btn_order_save">Save</a>
    <!--<a class="btn btn-success next" id="btnNext">Next</a>-->
  </div>
