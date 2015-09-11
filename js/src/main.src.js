// var a = document.getElementsByTagName("A");
//
// for (var i = 0; i < a.length; i++) {
//     a[i].addEventListener("click", function(event, index) {
//         //event.preventDefault();
//         console.log(this.getAttribute('href'));
//     });
// }

$(function() {
    var toggles = document.querySelectorAll(".c-hamburger");

    for (var i = toggles.length - 1; i >= 0; i--) {
        var toggle = toggles[i];
        toggleHandler(toggle);
    };

    function toggleHandler(toggle) {
        toggle.addEventListener("click", function(e) {
            e.preventDefault();
            (this.classList.contains("is-active") === true) ? this.classList.remove("is-active"): this.classList.add("is-active");
        });
    }



    $('#mainNav ul').on('mouseenter mouseleave', function() {
        $(this).toggleClass('nav-active').delay(1000);
    });




});
