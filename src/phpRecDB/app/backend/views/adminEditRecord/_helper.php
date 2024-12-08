<h1>phpRecDB Helper</h1>

<div class="row">
    <div class="col-sm-2"><label>Record URL: </label></div>
    <div class="col-sm-6"><?php echo CHtml::textField('phpRecDbHelperRecordId',$helperEndpointUrl,['readonly'=>'true','style'=>'width:100%']) ?></div>
    <div class="col-sm-3"><?php echo CHtml::button("copy ot clipboard",array('title'=>"copy ot clipboard",'id'=>'myButton')); ?></div>
</div>


<script>
    //copy to clipboard, taken from https://www.w3schools.com/howto/howto_js_copy_clipboard.asp
    window.onload = function() {
        document.getElementById("myButton").onclick = function() {
            var copyText = document.getElementById("phpRecDbHelperRecordId");
            console.log(copyText);
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */
            document.execCommand("copy");
        }
    }
</script>