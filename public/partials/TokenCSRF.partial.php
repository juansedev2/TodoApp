<?php if(!empty($csrf_token)):?>
    <input type="text" value="<?=$csrf_token?>" name="csrf-token" readonly hidden>
<?php endif;?>