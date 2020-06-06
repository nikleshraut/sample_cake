<?php
$siteKey = "6LeI8AAVAAAAAFTR-g7tOYMy3AtfRRumXZbAmKKY";
$lang = "en";
?>
<h1>Login</h1>
<?= $this->Form->create() ?>
<?= $this->Form->control('email') ?>
<?= $this->Form->control('password') ?>
 <div class="g-recaptcha" data-sitekey="<?php echo $siteKey;?>"></div>
<?= $this->Form->button('Login') ?>
<?= $this->Form->end() ?>

<script type="text/javascript"
  src="https://www.google.com/recaptcha/api.js?hl=<?php echo $lang;?>">
</script>
