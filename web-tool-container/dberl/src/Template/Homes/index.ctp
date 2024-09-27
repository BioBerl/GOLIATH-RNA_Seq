<?php
echo $this->Form->create($form, ['type' => 'file']);
?>
<div class="bs-example">
    <?php echo $this->Form->input('email'); ?>
    <div class="btn-group" data-toggle="buttons">
        <label class="btn btn-primary">
            <input type="radio" name="tipo" id="tipo-1" value="1"> Transcriptomics
        </label>
        <label class="btn btn-primary">
            Genomics
        <!--    <input type="radio" name="tipo" id="tipo-0" value="0"> Genomics-->
        </label>
    </div>
</div>
<?php
echo "<div id=\"cont\">\n";
echo "</div>\n";
?>
<!--
<div class="form-group">
  <div class="col-sm-offset-2 col-sm-10">
    <label class="file-upload btn btn-primary">
    Browse for file #1... <?= $this->Form->input('file1', ['type' => 'file']); ?>
    </label>
    <label class="file-upload btn btn-primary">
    Browse for file #2... <?= $this->Form->input('file2', ['type' => 'file']); ?>
    </label>
  </div>
</div>
-->
<?php
echo $this->Form->button('Submit', ['class' => 'btn btn-primary']);
echo $this->Form->end();
?>

<div class="modal"><!-- Place at bottom of page --> </div>

<script>

    $body = $("body");
    $(document).ready(function () {
            $('input[name="tipo"]').on("change",
                    function (event) {
                        $.ajax({
                            async:true,
                            dataType:"html",
                            beforeSend: function (xhr) { // Add this line
                                xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                                $body.addClass("loading");
                            },  // Add this line
                            success:function (data, textStatus) {
                                $("#cont").html(data);
                                $body.removeClass("loading");
                            },
                            type:"post", url:"\/Homes\/form/" + $(this).attr('id')
                        });
                        return false;
                    });
            });

//    $('input[name="tipo"]').on('change', function(){
//            $("#cont").load('/Homes/form/', {type: $(this).attr('id')});
//            if ($(this).val()=='0') {                         
                //change to "show update"
//                $("#cont").load('/Homes/form/', {type: $(this).attr('id')});
//            } else  {
//                $("#cont").text("Transcriptomics");
//            }
//    });
</script>
