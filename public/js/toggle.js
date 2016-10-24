
var togglebutton = document.getElementsByClassName('toggle');

for (var i = 0; i<togglebutton.length; i++) {
    togglebutton[i].addEventListener('click', function (e) {
        var button = e.target;

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: '/toggle',
            data: {user_id: button.id},
            success: function (data) {
                button.src = data;
            }
        })
    }, false);

}