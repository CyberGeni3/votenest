<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content card-info">
            <div class="card-header">
              <h4 class="card-title"><b>Add New Candidate</b></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="<?php echo URLROOT; ?>/candidates/add" enctype="multipart/form-data">
                <div class="form-group row">
                  <label for="firstname" class="col-sm-3 col-form-label">First Name</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter first name" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="middlename" class="col-sm-3 col-form-label">Middle Name</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Enter middle name" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="lastname" class="col-sm-3 col-form-label">Last Name</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter last name" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="email" class="col-sm-3 col-form-label">Email</label>
                  <div class="col-sm-9">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                  </div>
                </div>
                <div class="form-group row">
                <label for="program" class="col-sm-3 col-form-label">Program</label>
                  <div class="col-sm-9">
                    <select name="program" id="program" class="select2bs4" style="width: 100%;" required>
                      <option value="BSIT" selected="selected">Bachelor of Science in Information Technology</option>
                      <option value="BIT">Bachelor of Industrial Technology</option>
                      <option value="BSHM">Bachelor of Science in Hospitality Management</option>
                      <option value="BSME">Bachelor of Science in Mechanical Engineering</option>
                      <option value="BSEE">Bachelor of Science in Electrical Engineering</option>
                      <option value="BSCE">Bachelor of Science in Civil Engineering</option>
                      <option value="BAE">Bachelor of Arts in English</option>
                      <option value="BALIT">Bachelor of Arts in Literature</option>
                      <option value="BEED">Bachelor in Elementary Education</option>
                      <option value="BSED">Bachelor in Secondary Education</option>
                      <option value="BTLE">Bachelor of Technology and Livelihood Education</option>
                      <option value="BSA">Bachelor of Science in Agriculture</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                    <label for="position" class="col-sm-3 control-label">Position</label>

                    <div class="col-sm-9">
                      <select class="form-control" id="position" name="position" required>
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
                <div class="form-group row">
                  <label for="year" class="col-sm-3 col-form-label">School year</label>
                  <div class="col-sm-4">
                    <input type="text" class="yearpicker form-control" name="year1" placeholder="From" value="" required autocomplete="off"> 
                  </div>
                  <div class="text-center">_</div>
                  <div class="col-sm-4">
                    <input type="text" class="yearpicker1 form-control" name="year2" placeholder="To" value="" required autocomplete="off">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="gender" class="col-sm-3 control-label">Gender</label>
                  <div class="col-sm-9">
                    <select class="form-control" id="gender" name="gender" required>
                      <option value="" selected>- Select -</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>
                </div>
                 <div class="form-group row">
                  <label for="birthdate" class="col-sm-3 control-label">Birth Date</label>
                  <div class="input-group col-sm-9">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" class="form-control" id="birthdate" name="birthdate" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" data-mask value="" onchange="getAge();">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="age" class="col-sm-3 col-form-label">Age</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" id="age" name="age" value="" placeholder="Click to calculate age" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="birth_address" class="col-sm-3 col-form-label">Birth Address</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="birth_address" name="birth_address" placeholder="Enter birth address" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="address" class="col-sm-3 col-form-label">Main Address</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="address" name="address" placeholder="Enter current address" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="contact" class="col-sm-3 col-form-label">Contact</label>
                  <div class="input-group col-sm-9">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    </div>
                    <input type="text" class="form-control" data-inputmask='"mask": "(+999) 999999999"' data-mask name="contact" required>
                  </div>
                  <!-- /.input group -->
                </div>
                <div class="form-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="photo" name="photo" required>
                    <label class="custom-file-label" for="photo">Choose photo</label>
                  </div>
                </div>
                <div class="form-group row">
                    <label for="platform" class="col-sm-3 control-label">Platform</label>

                    <div class="col-sm-12">
                      <textarea class="form-control" id="platform" name="platform" rows="7"></textarea>
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
              <h4 class="card-title"><b>Edit Candidate</b></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="<?php echo URLROOT; ?>/candidates/edit">
                <input type="hidden" class="id" name="id">
                <div class="form-group row">
                    <label for="edit_position" class="col-sm-3 control-label">Position</label>

                    <div class="col-sm-9">
                      <select class="form-control" id="edit_position" name="position" required>
                        <option value="" selected id="posselect"></option>
                        <?php
                          foreach ($data['getPositions'] as $row) {
                            echo "
                              <option value='".$row->id."'>".$row->description."</option>
                            ";
                          }
                        ?>
                      </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edit_platform" class="col-sm-3 control-label">Platform</label>

                    <div class="col-sm-12">
                      <textarea class="form-control" id="edit_platform" name="platform" rows="7"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i> Update</button>
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
              <form class="form-horizontal" method="POST" action="<?php echo URLROOT; ?>/candidates/delete">
                <input type="hidden" class="id" name="id">
                <div class="text-center">
                    <p>DELETE CANDIDATE</p>
                    <h2 class="bold fullname"></h2>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-default" name="delete"><i class="fa fa-trash"></i> Delete</button>
              </form>
            </div>
        </div>
    </div>
</div>

<!-- Update Photo -->
<div class="modal fade" id="edit_photo">
    <div class="modal-dialog">
        <div class="modal-content bg-primary">
            <div class="modal-header">
              <h4 class="modal-title"><b><span class="fullname"></span></b></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="<?php echo URLROOT; ?>/candidates/photo" enctype="multipart/form-data">
                <input type="hidden" class="id" name="id">
                <div class="form-group row" style="display: none">
                    <label for="edit_student_id" class="col-sm-3 col-form-label">Student ID</label>

                    <div class="col-sm-9">
                      <input type="number" class="form-control" id="edit_student_id" name="student_id">
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-file">
                      <input type="file" id="photo" name="photo" class="form-control custom-file-input" required>
                      <label for="photo" class="custom-file-label">Choose new photo</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-default" name="upload"><i class="fa fa-check-square-o"></i> Update</button>
              </form>
            </div>
        </div>
    </div>
</div>



     