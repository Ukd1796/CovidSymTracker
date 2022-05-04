$(document).ready(function() {
    setTimeout(popup, 3000);
    function popup() {
    $("#popUp").css("display", "block");
    document.getElementById("container2").style.opacity = 0.4; 
    document.getElementById("popup").style.opacity = 1; 
}
});