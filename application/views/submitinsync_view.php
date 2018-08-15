<? include 'insync_view.php'; ?>
<a id="submitInsync" href="insync://transfer?id=<?=$data["transferLinkId"]?>" style="display: none"></a>
<script type="text/javascript">
    document.getElementById('submitInsync').click();
</script>
