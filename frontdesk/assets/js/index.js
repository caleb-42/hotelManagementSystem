
    var picObj;
    
    function initialize (){
        picObj = $('.productpic').croppie({
            viewport: {
                width: 200,
                height: 200,
                type: 'square'
            },
            boundary: {
                width: 100,
                height: 100
            }

        });
        picObj.croppie('bind', {
            url: './assets/img/4.png'
        });
        console.log("event");
    }

    function getpic(){
        var reader = new FileReader();
        reader.onload = function (event) {
            console.log(event);
            picObj.croppie("bind", {
                url: event.target.result
            }).then(function () {
                console.log(event.target.result);
            })
        }
        reader.readAsDataURL(this.files[0]);
    }

    function cropImg (){
        picObj.croppie('result', {
            type: 'canvas',
            size: 'viewport',
            format: 'png'
        }).then(function (response) {
            $.ajax({
                url: "./uploadImg.php",
                method: "POST",
                data: {
                    "image": response
                },
                success: function (data) {
                    $('.productpic').html(data);
                }
            });
            console.log(response);
        });
    }
