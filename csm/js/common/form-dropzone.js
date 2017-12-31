var FormDropzone = function () {


    return {
        //main function to initiate the module
        init: function () {

            Dropzone.options.myDropzoneS3 = {
                dictDefaultMessage: "",
                acceptedFiles: "image/jpeg,image/png,image/gif",
                init: function () {
                    this.on("addedfile", function (file) {
                        // Create the remove button
                        var removeButton = Dropzone.createElement("<a href='javascript:;'' class='btn red btn-sm btn-block'>Remove</a>");

                        // Capture the Dropzone instance as closure.
                        var _this = this;

                        // Listen to the click event
                        removeButton.addEventListener("click", function (e) {
                            alert(file);
                            // Make sure the button click doesn't submit the form:
                            e.preventDefault();
                            e.stopPropagation();

                            // Remove the file preview.
                            _this.removeFile(file);
                            // If you want to the delete the file on the server as well,
                            // you can do the AJAX request here.
                        });

                        // Add the button to the file preview element.
                        file.previewElement.appendChild(removeButton);
                    });
                    var file_image = "http://someserver.com/myimage.jpg";

                    var mockFile = {name: "myimage.jpg", size: 12345};
                    this.addFile.call(this, mockFile);

                }
            }
        }
    };
}();

jQuery(document).ready(function () {
    FormDropzone.init();
});