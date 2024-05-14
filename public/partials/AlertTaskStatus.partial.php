<div class="container text-center">
    <?php if(!(empty($message) || (empty($color)))):?>
        <div class="alert <?=$color?>" role="alert"><?=$message?></div>
    <?php endif;?>
</div>