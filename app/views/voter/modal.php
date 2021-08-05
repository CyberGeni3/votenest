<!-- Add -->
<form class="form-horizontal" id="newVoter" method="POST" action="<?php echo URLROOT; ?>/voter/add" enctype="multipart/form-data">
  <div class="modal fade" id="addnew">
      <div class="modal-dialog">
          <div class="modal-content card-info">
              <div class="card-header">
                <h4 class="card-title">Add New Voter</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <div class="card-body">
                  <input id="voterPic" type="hidden" name="voterPic" value=""/>
                    <div class="form-group row">
                      <label for="student_id" class="col-sm-3 col-form-label">Student ID</label>
                      <div class="col-sm-9">
                        <input type="number" class="form-control" id="student_id" name="student_id" placeholder="Enter student id" min="5170000" minlength="7" maxlength="8" required>
                      </div>
                    </div>
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
                          <option value="BSIT">Bachelor of Science in Information Technology</option>
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
                </div>
              </div>
                  
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <button type="button" class="btn btn-primary" id="takepic" onclick="enableSnap(); enableMC();"><i class="fa fa-camera"></i> Take Photo</button>
              </div>
          </div>
      </div>
  </div>
  <!-- WEBCAM MODAL -->
  <div class="modal fade" id="opencam" data-backdrop="static"  data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content card-info">
          <div id="overlay" class="overlay" style="display: none;">
            <i class="fas fa-2x fa-sync fa-spin"></i>
          </div>
            <div class="modal-header">
              <h4 class="modal-title"><b>Camera</b></h4>
            </div>
            <div class="modal-body">
                <div id="my_camera" style="margin: auto; width: 50%;">
                </div>
                <br>
                <div class="row">
                  <div class="col-md-8 mx-auto">
                    <div id="pre_take_buttons" style="display: ">
                <input class="btn btn-primary btn-block" id="snappy" type=button value="Take Snapshot" onClick="preview_snapshot(); enableVote(); disableMC();" disabled="false">
              </div>
              <div id="post_take_buttons" style="display:none">
                <input class="btn btn-primary btn-block" type=button value="&lt; Take Another" onClick="cancel_preview(); disableVote(); enableMC();">
              </div>
                  </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default btn-sm" id="modal_ender" onclick="$('#opencam').modal('hide');$('#addnew').modal('show');Webcam.reset();" disabled><i class="fa fa-times"></i> Close</button>
              <button type="submit" class="btn btn-primary btn-sm text-center" id="botar" onClick="disableSnap(); save_photo(); disableSelf(); document.getElementById('overlay').style.display='';" disabled><i class="fa fa-user-plus"></i>Add</button>
            </div>
        </div>
    </div>
  </div>
</form>

<!-- Edit -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success">
              <h4 class="modal-title"><b>Edit Voter</b></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="<?php echo URLROOT; ?>/voter/edit">
                <input type="hidden" class="id" name="id">
                <input type="number" name="student_id" id="edit_studentId" style="display: none;">
                <div class="form-group row">
                    <label for="edit_firstname" class="col-sm-3 col-form-label">First Name</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_firstname" name="firstname">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edit_middlename" class="col-sm-3 col-form-label">Middle Name</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_middlename" name="middlename">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="edit_lastname" class="col-sm-3 col-form-label">Last Name</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_lastname" name="lastname">
                    </div>
                </div>
                <div class="form-group row">
                  <label for="edit_program" class="col-sm-3 col-form-label">Program</label>
                    <div class="col-sm-9">
                      <select name="program" id="edit_program" class="form-control" style="width: 100%;" required>
                        <option value="BSIT">Bachelor of Science in Information Technology</option>
                        <option value="BSIT">Bachelor of Science in Industrial Technology</option>
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
                    <label for="new_email" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="new_email" name="email">
                    </div>
                </div>
              </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
              <button type="submit" class="btn btn-success" name="edit"><i class="fa fa-edit"></i> Update</button>
              </form>
            </div>
        </div>
    </div>
</div>


<!-- Delete -->
<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
              <h4 class="modal-title"><b>Deleting...</b></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="<?php echo URLROOT; ?>/voter/delete">
                <input type="hidden" class="id" name="id">
                <div class="text-center">
                    <p>DELETE VOTER</p>
                    <h2 class="bold fullname"></h2>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
              <button type="submit" class="btn btn-danger" name="delete"><i class="fa fa-trash"></i> Delete</button>
              </form>
            </div>
        </div>
    </div>
</div>

<!-- Update Photo -->
<div class="modal fade" id="edit_photo">
    <div class="modal-dialog">
        <div class="modal-content bg-info">
            <div class="modal-header">
              <h4 class="modal-title"><b><span class="fullname"></span></b></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="<?php echo URLROOT; ?>/voter/updatephoto" enctype="multipart/form-data">
                <input type="hidden" class="id" name="id">
                <div class="form-group">
                    <div class="custom-file">
                      <input type="file" id="photo" name="photo" class="form-control custom-file-input" required>
                      <label for="photo" class="custom-file-label">Choose new photo</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
              <button type="submit" class="btn btn-default" name="upload"><i class="fa fa-check"></i> Update</button>
              </form>
            </div>
        </div>
    </div>
</div>