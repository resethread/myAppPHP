<p id="crypt">
	
</p>
<p id="decrypt">
	
</p>
<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/aes.js"></script>
<script>
	var encryptedAES = CryptoJS.AES.encrypt("Mezzssage", "Secret Passezezphrase");

    var decrypted = CryptoJS.AES.decrypt(encryptedAES, "Secret Passezezphrase");

    document.getElementById('decrypt').innerHTML = decrypted;
</script>