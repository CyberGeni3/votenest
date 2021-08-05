<!-- View Ballot -->
<div class="modal fade" id="view">
    <div class="modal-dialog">
        <div class="modal-content card-primary">
            <div class="card-header">
              <h4 class="card-title">Your Votes</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>   
            </div>
            <div class="card-body">
              <?php
                foreach($data['viewvote'] as $row){
                  echo "
                    <div class='row votelist'>
                      <span class='col-sm-4'><span class='pull-right'><b>".$row->description." :</b></span></span> 
                      <span class='col-sm-8'>".$row->canfirst." ".$row->canlast."</span>
                    </div>
                  ";
                }
              ?>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            </div>
        </div>
    </div>
</div>