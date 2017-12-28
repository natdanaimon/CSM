<?php
//$a = "i_repair_item_1";
//$b = "file_1";
//$c = "2018";
//echo substr($a, 0,14);
//echo '<br/>';
//echo substr($b, 0,5);
//echo '<br/>';
//echo substr($c,2);
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<input type="file" id="f1" name="f1" value="C:\xampp\htdocs\CSM\csm\upload\step_checkrepair\1712005_1.JPG">
<img id="m1" src="1712005_1.JPG" width="50px" height="50px">
<script>
    $(document).ready(function () {
        // $('#f1').val($('#m1')[0].currentSrc);
        debugger;
        var file = "http://localhost/CSM/csm/upload/1712005_1.JPG";
        var preview = document.querySelector('#preview');
        var files = document.querySelector('input[type=file]').files;

        function readAndPreview(file) {

            // Make sure `file.name` matches our extensions criteria
            if (/\.(jpe?g|png|gif)$/i.test(file.name)) {
                var reader = new FileReader();

                reader.addEventListener("load", function () {
                    var image = new Image();
                    image.height = 100;
                    image.title = file.name;
                    image.src = this.result;
                    preview.appendChild(image);
                }, false);

                reader.readAsDataURL(file);
            }

        }

        if (files) {
            [].forEach.call(files, readAndPreview);
        }
    });
</script>