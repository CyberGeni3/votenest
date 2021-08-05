<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content card-info">
            <div class="card-header">
              <h4 class="card-title"><b>Add New Position</b></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="<?php echo URLROOT; ?>/positions/add">
                <div class="form-group row">
                    <label for="description" class="col-sm-3 control-label">Description</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="description" name="description" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="max_vote" class="col-sm-3 control-label">Maximum Vote</label>

                    <div class="col-sm-9">
                      <input type="number" class="form-control" id="max_vote" name="max_vote" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-info" name="add"><i class="fa fa-save"></i> Save</button>
              </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content card-success">
            <div class="card-header">
              <h4 class="card-title"><b>Edit Position</b></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="<?php echo URLROOT; ?>/positions/edit">
                <input type="hidden" class="id" name="id">
                <div class="form-group row">
                    <label for="edit_description" class="col-sm-3 control-label">Description</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_description" name="description">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edit_priority" class="col-sm-3 control-label">Priority</label>

                    <div class="col-sm-9">
                      <input type="number" class="form-control" id="edit_priority" name="priority">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edit_max_vote" class="col-sm-3 control-label">Maximum Vote</label>

                    <div class="col-sm-9">
                      <input type="number" class="form-control" id="edit_max_vote" name="max_vote">
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-success" name="edit"><i class="fa fa-check-square-o"></i> Update</button>
              </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content bg-danger">
            <div class="modal-header">
              <h4 class="modal-title"><b>Deleting...</b></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="<?php echo URLROOT; ?>/positions/delete">
                <input type="hidden" class="id" name="id">
                <div class="text-center">
                    <h2 class="bold description"></h2>
                    <p>Deleting position will also delete candidates associated with the position!</p>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-default btn-flat" name="delete"><i class="fa fa-trash"></i> Delete</button>
              </form>
            </div>
        </div>
    </div>
</div>



     