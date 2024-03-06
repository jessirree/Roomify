function validate(){
    var username = document.getElementById("username").value;
    var pass = document.getElementById("pass").value;
    if(username == "admin" && pass == "admin123"){
        alert("Login Successful");
        window.open("admin.html")
        return false;
    }
    else{
        alert("Login Failed")
    }
}