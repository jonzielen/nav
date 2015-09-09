var a = document.getElementsByTagName("A");

for (var i = 0; i < a.length; i++) {
    a[i].addEventListener("click", function(event, index){
        event.preventDefault();
        console.log(this.getAttribute('href'));
    });
}

$(function () {
    $('#mainNav ul').on('mouseenter mouseleave', function() {
        $(this).toggleClass('nav-active').delay(1000);
    });
});
