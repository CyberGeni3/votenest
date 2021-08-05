<?php
  $candidate = '';
  $sql = "SELECT * 
          FROM positions 
          ORDER BY priority 
          ASC";
  $query = $db->query($sql);
    while($row = $query->fetch_assoc()) {
      $sql = "SELECT * 
              FROM candidates 
              WHERE position_id='".$row['id']."'";
      $cquery = $db->query($sql);
      while($crow = $cquery->fetch_assoc()){
        $slug = slugify($row['description']);
        $checked = '';
        if(isset($_SESSION['post'][$slug])){
          $value = $_SESSION['post'][$slug];
          if(is_array($value)){
            foreach($value as $val){
              if($val == $crow['id']){
                $checked = 'checked';
              }
            }
          }
          else{
            if($value == $crow['id']){
              $checked = 'checked';
            }
          }
        }
        $input = ($row['max_vote'] > 1) ? '<input type="checkbox" class="flat-red '.$slug.'" name="'.$slug."[]".'" value="'.$crow['id'].'" '.$checked.'>' : '<input type="radio" class="flat-red '.$slug.'" name="'.slugify($row['description']).'" value="'.$crow['id'].'" '.$checked.'>';
        $image = (!empty($crow['photo'])) ? URLROOT . '/images/'.$crow['photo'] : URLROOT . '/images/profile.jpg';
        $candidate .= '
                        <li>
                        '.$input.'<button type="button" class="btn btn-primary btn-sm btn-flat clist platform" data-platform="'.$crow['platform'].'" data-fullname="'.$crow['firstname'].' '.$crow['lastname'].'"><i class="fa fa-search"></i> Platform</button><img src="'.$image.'" height="100px" width="100px" class="clist"><span class="cname clist">'.$crow['firstname'].' '.$crow['lastname'].'</span>
                        </li>
                      ';
      }

      $instruct = ($row['max_vote'] > 1) ? 'You may select up to '.$row['max_vote'].' candidates' : 'Select only one candidate';

      echo '
        <div class="row">
          <div class="col-md-12">
            <div class="box box-solid" id="'.$row['id'].'">
              <div class="box-header with-border">
                <h3 class="box-title"><b>'.$row['description'].'</b></h3>
              </div>
              <div class="box-body">
                <p>'.$instruct.'
                  <span class="pull-right">
                    <button type="button" class="btn btn-success btn-sm btn-flat reset float-right" data-desc="'.slugify($row['description']).'"><i class="fa fa-refresh"></i> Reset</button>
                  </span>
                </p>
                <div id="candidate_list">
                  <ul>
                    '.$candidate.'
                  </ul>
                  <hr>
                </div>
              </div>
            </div>
          </div>
        </div>
      ';
      $candidate = '';

    } 
?>