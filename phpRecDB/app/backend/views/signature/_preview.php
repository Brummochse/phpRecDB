<div style="background:#EEEEEE">

<br>
<b>Sample Signature:</b><br>
<?= CHtml::image($signatureStaticUrl)?>
<br>
<br>
</div>
<br>


<div style="border:solid 2px;padding:10px;">

<div style="font-size:0.6em;margin:20px;">
Use one of this two links as image-address in your forum-signature.
</div>
<br>
<br>
<label><b>Static Signature Image Path:</b></label>
<?= CHtml::textField('static',$signatureStaticUrl, array('readonly'=>true)); ?>
<?= CHtml::link('Test',$signatureStaticUrl, array('target'=>'_blank'));?>
<br>
<br>
<label><b>Dynamic Signature Creation Path:</b></label>
<?= CHtml::textField('static',$signatureDynamicUrl, array('readonly'=>true)); ?>
<?= CHtml::link('Test',$signatureDynamicUrl, array('target'=>'_blank'));?>

 <br>
<br>
<br>
<br>
<div style="font-size:0.6em;margin:20px;">
<u><b>Which of these links should i use?</b></u><br><br>
There is a slight difference between this 2 links.<br><br>


<dl>
    <dt><b>Static Signature Image Path:</b></dt>
    <dd>
    <ul>
        <li><font color="green">a real static image file</font></li>
        <li><font color="green">image will be recreated new every time when a new record was added</font></li>
        <li><font color="green">very fast, because image is already rendered</font></li>
        <li><font color="green">should be compatible with all forums which support images</font></li>
        <li><font color="red">maybe cache problem with some browsers</font></li>
    </ul>
    </dd>
    <dt><br><b>Dynamic Signature Creation Path:</b></dt>
    <dd>
    <ul>
        <li><font color="green">i think there should be no cache problem</font></li>
        <li><font color="red">no real image</font></li>
        <li><font color="red">image loading on the fly when calling this link</font></li>
        <li><font color="red">i don't know if all forums can handle this dynamic created image</font></li>
    </ul>
    </dd>
</dl>


</div>
</div>
