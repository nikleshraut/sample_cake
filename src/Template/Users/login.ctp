<?php
$siteKey = "6LeI8AAVAAAAAFTR-g7tOYMy3AtfRRumXZbAmKKY";
$lang = "en";
?>
<h1>Login</h1>
<?php 
	echo $this->Html->image('loader.gif', [
			'alt' => 'Loader', 
			'border' => '0', 
			'data-src' => 'holder.js/100%x100',
			'class' => 'position-absolute d-none',
			'style' => 'margin: auto;left: 0;right: 0;',
			'id' => 'login_loader',
		]); 
?>

<?= $this->Form->create(null,['onsubmit'=>'return validateLogin()']) ?>
<?= $this->Form->control('email', ['default'=>'user1@g.com']) ?>
<?= $this->Form->control('password', ['default'=>'123456']) ?>
 <div class="g-recaptcha" data-sitekey="<?php echo $siteKey;?>"></div>
<?= $this->Form->button('Login') ?>
<?= $this->Form->end() ?>

<script type="text/javascript"
  src="https://www.google.com/recaptcha/api.js?hl=<?php echo $lang;?>">
</script>
<script type="text/javascript">
	function validateLogin(){
		$('#login_loader').removeClass('d-none');
		var _csrfToken = $('[name="_csrfToken"]').val();
		var email = $('#email').val();
		var password = $('#password').val();
		var g_recaptcha_response = $('[name="g-recaptcha-response"]').val();

		$.ajax({
			method: "POST",
			url: "/users/login",
			data: { _csrfToken, email, password, "g-recaptcha-response":g_recaptcha_response }
		}).done(function( response ) {
			$('#login_loader').removeClass('d-none');
			//console.log('response: ',response);
			if(response.success){
				location.href = response.return_url || '/';
			}
		});
		return false;
	}
</script>
