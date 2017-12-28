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

        var inputElement = $("input[name=file]");
        readImage(inputElement).done(function (base64Data) {
            alert(base64Data);
        });


        function readImage(inputElement) {
            var deferred = $.Deferred();

            var files = inputElement.get(0).files;
            if (files && files[0]) {
                var fr = new FileReader();
                fr.onload = function (e) {
                    deferred.resolve(e.target.result);
                };
                fr.readAsDataURL(files[0]);
            } else {
                deferred.resolve(undefined);
            }

            return deferred.promise();
        }


//        var BlobBuilder = window.MozBlobBuilder || window.WebKitBlobBuilder;
//        var bb = new BlobBuilder();
//
//        var xhr = new XMLHttpRequest();
//        xhr.open('GET', file, true);
//
//        xhr.responseType = 'arraybuffer';
//
//        bb.append(this.response); // Note: not xhr.responseText
//
////at this point you have the equivalent of: new File()
//        var blob = bb.getBlob('image/png');
//
//        /* more setup code */
//        xhr.send(blob);
    });
</script>