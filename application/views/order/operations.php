<div class="row" style="margin-top:20px">
  <div class="col-md-4 form-group">
    <label class="control-label">Operation</label>
    <select type="text" class="form-control input-sm" id="operation">
      <?php foreach ($operations as $operation) { ?>
        <option value="<?= $operation['operation_id'] ?>"><?= $operation['operation_name'] ?></option>
      <?php } ?>
      <select>
  </div>
  <div class="col-md-4 form-group">
    <button class="btn btn-primary btn-sm" style="margin-top:20px" id="btn_add_operation">Add Operation</button>
  </div>
</div>

<div class="row">
  <div class="col-md-10">
    <table id="operation_table" class="table table-striped table-bordered table-hover" width="100%">
      <thead>
        <tr>
          <th>Operation</th>
          <th>Operation Type</th>
          <th>UOM IN</th>
          <th>UOM Out</th>
          <th>Operation Order</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>
  </div>
</div>
