<?= $this->Html->script('jquery') ?>

<!--
<style>
.myDiv{
        display:none;
}
</style>
-->
<div class="bs-example">
    <div class="btn-group" data-toggle="buttons">
        <label class="btn btn-primary">
            <input type="radio" name="seq" id="seq-single" class='sequence' value="0"> Single
        </label>
        <label class="btn btn-primary">
            <input type="radio" name="seq" id="seq-paired" class='sequence' value="1"> Paired
        </label>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
    <!--
      <div id='show0' class='myDiv'>
      <label class="file-upload btn btn-primary">
          Browse for file #1... <?= $this->Form->input('file1', ['type' => 'file']); ?>
      </label>
      </div>
      -->
      <div id='show1' class='myDiv'>
      <label class="file-upload btn btn-primary">
          Browse for file #1... <?= $this->Form->input('file1', ['type' => 'file']); ?>
      </label>
      <label class="file-upload btn btn-primary">
          Browse for file #2... <?= $this->Form->input('file2', ['type' => 'file', 'required' => false]); ?>
      </label>
      </div>
    </div>
</div>

<!--
<script>
$(document).ready(function(){
        $('.sequence').on('click', function(){
                var demovalue = $(this).val(); 
                $("div.myDiv").hide();
                $("#show"+demovalue).show();
        });
});
</script>
-->
