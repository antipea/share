<? include 'insync_view.php'; ?>

<form method="post" action="<?= $data["webpay_url"]?>" target="_self">

    <? foreach( $data["webpay"] as $key => $value ): ?>
        <input type="hidden" name="<?=$key?>" value="<?=$value;?>">
    <? endforeach; ?>
    <input id="submitWebpay" type="submit" class="hidden" value="Отправить">
</form>
<script type="text/javascript">
    document.getElementById('submitWebpay').click();
</script>
