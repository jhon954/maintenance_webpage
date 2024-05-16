function login() {
    var nickname = document.getElementById("nickname").value;
    var password = document.getElementById("password").value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "php/login.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                window.location.href = response.redirectUrl;
            } else {
                document.getElementById("userError").innerHTML = response.errors.userError;
                document.getElementById("passwordError").innerHTML = response.errors.passwordError;
                document.getElementById("userError").style.display = response.errors.userError ? "block" : "none";
                document.getElementById("passwordError").style.display = response.errors.passwordError ? "block" : "none";
            }
        }
    };
    xhr.send("nickname=" + nickname + "&password=" + password);
}