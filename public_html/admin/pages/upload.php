<?php
/* Black Apple Inc.
 * http://black-apple.biz/
 * Dixie CMS
 * Created by Luthfie
 * luthfie@y7mail.com
 */

/* Configure directories */
$dirs = dixie_explore('dir','upload');

/* HTML View */
?>

<div class="content-form">
  <form action="<?php printf(WWW.'admin/a?data=upload-file'); ?>" method="post" class="form-content" enctype="multipart/form-data">
    <div class="input-parent">
      Directory
      <select class="form-select" name="directory" style="margin-left:10px;width:auto;" onchange="if(this.value=='new') document.getElementById('new_dir').style.display='block'; else document.getElementById('new_dir').style.display='none';">
        <option value="">--Directory--</option>
        <?php foreach($dirs as $dir) echo '<option value="'.$dir.'">'.$dir.'</option>'; ?>
        <option value="new">--Create New--</option>
      </select>
      <input type="text" name="new-directory" class="form-input" placeholder="Directory" style="display:none;" id="new_dir" />
    </div>
    <div class="input-parent">Upload<input type="file" name="file[]" class="form-input" title="click to choose the file" /></div>
    <div id="new_file"></div>
    <div>
      <div href="#" id="add_file" onclick="add_file('new_file')">Add File</div>
      <input type="submit" value="Upload" class="form-submit" />
    </div>
  </form>
  <input type="hidden" id="file_count" value="1" />
</div>
<script type="text/javascript">
function add_file(id){
  var nf = document.getElementById(id);
  var fc = document.getElementById('file_count');
  var count = fc.value;
  var pc = document.getElementById("page_content");
  var pcp = (count*40)+400;
  pc.style.height=pcp+"px";
  var newdiv = document.createElement('div');
  newdiv.setAttribute('class','input-parent');
  newdiv.innerHTML = '<input type="file" name="file[]" class="form-input" title="click to choose the file" />';
  if(count<20){
    count++;
    nf.appendChild(newdiv);
    fc.value=count;
  }else{
    document.getElementById('add_file').style.display="none";
  }
}
</script>