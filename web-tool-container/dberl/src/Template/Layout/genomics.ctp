<div class="bs-example">
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">1. Aligner</a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in">
                <div class="panel-body">
                    <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-primary">
                                <input type="radio" name="genomics.aligner" id="tipo-0" value="0"> BWA-Align
                            </label>
                            <label class="btn btn-primary">
                                <input type="radio" name="genomics.aligner" id="tipo-1" value="1"> BWA-Mem
                            </label>
                    </div>

                    <?php #echo $this->Form->radio('genomics.aligner', ['BWA-Align','BWA-Mem']); ?>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">2. Processing</a>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse">
                <div class="panel-body">
                    <?php echo $this->Form->radio('genomics.processing', ['Struct...','SNVs', 'SNVs + Indel']); ?>
                </div>
            </div>
        </div>
    </div>
    <p><strong>Note:</strong> Click on the linked heading text to expand or collapse accordion panels.</p>
</div>
