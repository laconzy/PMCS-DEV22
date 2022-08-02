<div class="modal fade hmodal-success" id="item_model" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="color-line"></div>
            <div class="modal-header" style="padding:0px 0px 15px 20px;">
                <h3>Order Item Details</h3>
                <!--<small class="font-bold">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small>-->
            </div>
            <div class="modal-body">

              <input type="hidden" id="order_item_id" value="0" >

              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label">Item Code</label>
                    <select style="width:100%" id="order_item_search">
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label">Item Description</label>
                    <input type="text" class="form-control input-sm" id="item_description" disabled>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label">Color</label>
                    <select class="color" style="width:100%" id="item_color_search">
                    </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12" style="margin-top:20px">
                  <table id="tbl_order_item" class="table table-striped table-bordered table-hover" width="100%">
                    <thead>
                      <tr>
                        <th>Component Code</th>
                        <th>Component Description</th>
                        <th>Color</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td></td>
                        <td>No Content</td>
                        <td></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <hr>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label">Size</label>
                    <select style="width:100%" id="item_size_search">
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label">Order Qty</label>
                    <input type="number" style="text-align:right" class="form-control input-sm" id="item_order_qty">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label">Planned Qty</label>
                    <input type="number" style="text-align:right" class="form-control input-sm" id="item_planned_qty">
                  </div>
                </div>
                <div class="col-md-3">
                  <button class="btn btn-primary btn-sm" style="margin-top:20px" id="btn_add_sizes">Add Qty</button>
                </div>
                <div class="col-md-12" style="margin-top:20px">
                  <table id="tbl_order_item_sizes" class="table table-striped table-bordered table-hover" width="100%">
                    <thead>
                      <tr>
                        <th>Size</th>
                        <th>Order Qty</th>
                        <th>Planned Qty</th>
                        <th width="15%">Actions</th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
                </div>
              </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn_save_items">Save changes</button>
            </div>
        </div>
    </div>
</div>
