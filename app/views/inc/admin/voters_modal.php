<!-- Activate Voters -->
<div class="modal fade" id="activate">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><b>Starting...</b></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="<?php echo URLROOT; ?>/admins/activate">
                <input type="hidden" class="id" name="id">
                <div class="text-center">
                    <p><h2>This will start the election by activating all voters and sending them invitations!</h2></p>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
              <button type="submit" onclick="showEnd();" class="btn btn-default" name="activate"><i class="fa fa-check"></i> Start</button>
              </form>
            </div>
        </div>
    </div>
</div>

<!-- End Voters -->
<div class="modal fade" id="ending">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><b>Ending...</b></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="<?php echo URLROOT; ?>/admins/end">
                <input type="hidden" class="id" name="id">
                <div class="text-center">
                    <p><h2>Are you sure you want to end the election?</h2></p>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
              <button type="submit" onclick="showStart();" class="btn btn-default" name="ending"><i class="fa fa-check"></i> End</button>
              </form>
            </div>
        </div>
    </div>
</div>

<!-- Generate code modal -->
<div class="modal fade" id="generate_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
              <h4 class="modal-title"><b>Generate Codes</b></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="<?php echo URLROOT; ?>/admins/generate">
                <div class="form-group row">
                  <label for="generator" class="col-sm-4 col-form-label">Number of <code>codes</code>: </label>
                  <div class="col-sm-8">
                    <input type="number" class="form-control" id="generator" name="generate" required>
                  </div>
                </div>
                <div class="form-group row">
                    <label for="forposition" class="col-sm-4 control-label">Position</label>

                    <div class="col-sm-8">
                      <select class="form-control" id="forposition" name="forposition" required>
                        <option value="" selected>- Select -</option>
                        <?php
                          foreach($data['getPositions'] as $row){
                            echo "
                              <option value='".$row->id."'>".$row->description."</option>
                            ";
                          }
                        ?>
                      </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
              <button type="submit" class="btn btn-primary" name="generate_input"><i class="fa fa-check"></i> Generate</button>
              </form>
            </div>
        </div>
    </div>
</div>
