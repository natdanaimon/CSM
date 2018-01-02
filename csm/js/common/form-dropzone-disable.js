
var maxImageWidth = 800;
var maxImageHeight = 800;


var FormDropzone = function () {


    return {
        //main function to initiate the module
        init3: function () {

            Dropzone.options.myDropzoneS3 = {
                dictDefaultMessage: "",
                addRemoveLinks: false,
                maxFiles: 0,
                thumbnailWidth: "120",
                thumbnailHeight: "120",
                acceptedFiles: "image/jpeg,image/png,image/gif",
                init: function () {
                    thisDropzone3 = this;
                    var dupplicate = false;
                    $.get('controller/repair/processController.php?func=iniDismantling&ref_no=' + ref_no, function (data) {
                        $.each(data, function (key, value) {
                            var mockFile = {name: value.name, size: value.size};
                            thisDropzone3.options.addedfile.call(thisDropzone3, mockFile);
                            thisDropzone3.options.thumbnail.call(thisDropzone3, mockFile, "upload/step_dismantling/" + ref_no + "/" + value.name);
                            thisDropzone3.options.complete(thisDropzone3, mockFile);
                        });
                        setImageCount(ref_no);
                    });
                    this.on("success", function (file, response) {
                        var res = JSON.parse(response);
                        var resp = res.error.split(",");
                        if (res.code != '0') {
                            dupplicate = true;
                            thisDropzone3.removeFile(file);
                            var errCode = "Code (" + resp[0] + ") : " + resp[1];
                            $.notify(errCode, "error");
                            return;
                        } else {
                            var errCode = "Code (" + resp[0] + ") : " + resp[1];
                            $.notify(errCode, "success");
                        }
                        $(file.previewElement).find('[data-dz-name]').html(res.name);
                        $(file.previewElement).find('[data-dz-size]').html(res.size);
                        setImageCount(ref_no);
                    });
                    this.on("removedfile", function (file) {
                        if (!dupplicate) {
                            $.get('controller/repair/processController.php?func=delDismantling&filename=' + file.name + '&ref_no=' + ref_no, function (data) {
                                dupplicate = false;
                                var res = data.split(",");
                                if (res[0] == "0000") {
                                    var errCode = "Code (" + res[0] + ") : " + res[1];
                                    $.notify(errCode, "success");
                                } else {
                                    var errCode = "Code (" + res[0] + ") : " + res[1];
                                    $.notify(errCode, "error");
                                    $('#se-pre-con').delay(100).fadeOut();
                                    return;
                                }
                                setImageCount(ref_no);
                            });

                        }
                        dupplicate = false;

                    });
                }
            }

        }

        , init4: function () {


            Dropzone.options.myDropzoneS4 = {
                dictDefaultMessage: "",
                addRemoveLinks: false,
                maxFiles: 0,
                thumbnailWidth: "120",
                thumbnailHeight: "120",
                acceptedFiles: "image/jpeg,image/png,image/gif",
                init: function () {
                    thisDropzone4 = this;
                    var dupplicate = false;
                    $.get('controller/repair/processController.php?func=iniTapping&ref_no=' + ref_no, function (data) {
                        $.each(data, function (key, value) {
                            var mockFile = {name: value.name, size: value.size};
                            thisDropzone4.options.addedfile.call(thisDropzone4, mockFile);
                            thisDropzone4.options.thumbnail.call(thisDropzone4, mockFile, "upload/step_tapping/" + ref_no + "/" + value.name);
                            thisDropzone4.options.complete(thisDropzone4, mockFile);
                        });
                        setImageCount(ref_no);
                    });
                    this.on("success", function (file, response) {
                        var res = JSON.parse(response);
                        var resp = res.error.split(",");
                        if (res.code != '0') {
                            dupplicate = true;
                            thisDropzone4.removeFile(file);
                            var errCode = "Code (" + resp[0] + ") : " + resp[1];
                            $.notify(errCode, "error");
                            return;
                        } else {
                            var errCode = "Code (" + resp[0] + ") : " + resp[1];
                            $.notify(errCode, "success");
                        }
                        $(file.previewElement).find('[data-dz-name]').html(res.name);
                        $(file.previewElement).find('[data-dz-size]').html(res.size);
                        setImageCount(ref_no);
                    });
                    this.on("removedfile", function (file) {
                        if (!dupplicate) {
                            $.get('controller/repair/processController.php?func=delTapping&filename=' + file.name + '&ref_no=' + ref_no, function (data) {
                                dupplicate = false;
                                var res = data.split(",");
                                if (res[0] == "0000") {
                                    var errCode = "Code (" + res[0] + ") : " + res[1];
                                    $.notify(errCode, "success");
                                } else {
                                    var errCode = "Code (" + res[0] + ") : " + res[1];
                                    $.notify(errCode, "error");
                                    $('#se-pre-con').delay(100).fadeOut();
                                    return;
                                }
                                setImageCount(ref_no);
                            });

                        }
                        dupplicate = false;

                    });
                }
            }
        }
        , init5: function () {


            Dropzone.options.myDropzoneS5 = {
                dictDefaultMessage: "",
                addRemoveLinks: false,
                maxFiles: 0,
                thumbnailWidth: "120",
                thumbnailHeight: "120",
                acceptedFiles: "image/jpeg,image/png,image/gif",
                init: function () {
                    thisDropzone5 = this;
                    var dupplicate = false;
                    $.get('controller/repair/processController.php?func=iniFilling&ref_no=' + ref_no, function (data) {
                        $.each(data, function (key, value) {
                            var mockFile = {name: value.name, size: value.size};
                            thisDropzone5.options.addedfile.call(thisDropzone5, mockFile);
                            thisDropzone5.options.thumbnail.call(thisDropzone5, mockFile, "upload/step_filling/" + ref_no + "/" + value.name);
                            thisDropzone5.options.complete(thisDropzone5, mockFile);
                        });
                        setImageCount(ref_no);
                    });
                    this.on("success", function (file, response) {
                        var res = JSON.parse(response);
                        var resp = res.error.split(",");
                        if (res.code != '0') {
                            dupplicate = true;
                            thisDropzone5.removeFile(file);
                            var errCode = "Code (" + resp[0] + ") : " + resp[1];
                            $.notify(errCode, "error");
                            return;
                        } else {
                            var errCode = "Code (" + resp[0] + ") : " + resp[1];
                            $.notify(errCode, "success");
                        }
                        $(file.previewElement).find('[data-dz-name]').html(res.name);
                        $(file.previewElement).find('[data-dz-size]').html(res.size);
                        setImageCount(ref_no);
                    });
                    this.on("removedfile", function (file) {
                        if (!dupplicate) {
                            $.get('controller/repair/processController.php?func=delFilling&filename=' + file.name + '&ref_no=' + ref_no, function (data) {
                                dupplicate = false;
                                var res = data.split(",");
                                if (res[0] == "0000") {
                                    var errCode = "Code (" + res[0] + ") : " + res[1];
                                    $.notify(errCode, "success");
                                } else {
                                    var errCode = "Code (" + res[0] + ") : " + res[1];
                                    $.notify(errCode, "error");
                                    $('#se-pre-con').delay(100).fadeOut();
                                    return;
                                }
                                setImageCount(ref_no);
                            });

                        }
                        dupplicate = false;

                    });
                }
            }
        }
        , init6: function () {


            Dropzone.options.myDropzoneS6 = {
                dictDefaultMessage: "",
                addRemoveLinks: false,
                maxFiles: 0,
                thumbnailWidth: "120",
                thumbnailHeight: "120",
                acceptedFiles: "image/jpeg,image/png,image/gif",
                init: function () {
                    thisDropzone6 = this;
                    var dupplicate = false;
                    $.get('controller/repair/processController.php?func=iniSpraying&ref_no=' + ref_no, function (data) {
                        $.each(data, function (key, value) {
                            var mockFile = {name: value.name, size: value.size};
                            thisDropzone6.options.addedfile.call(thisDropzone6, mockFile);
                            thisDropzone6.options.thumbnail.call(thisDropzone6, mockFile, "upload/step_spraying/" + ref_no + "/" + value.name);
                            thisDropzone6.options.complete(thisDropzone6, mockFile);
                        });
                        setImageCount(ref_no);
                    });
                    this.on("success", function (file, response) {
                        var res = JSON.parse(response);
                        var resp = res.error.split(",");
                        if (res.code != '0') {
                            dupplicate = true;
                            thisDropzone6.removeFile(file);
                            var errCode = "Code (" + resp[0] + ") : " + resp[1];
                            $.notify(errCode, "error");
                            return;
                        } else {
                            var errCode = "Code (" + resp[0] + ") : " + resp[1];
                            $.notify(errCode, "success");
                        }
                        $(file.previewElement).find('[data-dz-name]').html(res.name);
                        $(file.previewElement).find('[data-dz-size]').html(res.size);
                        setImageCount(ref_no);
                    });
                    this.on("removedfile", function (file) {
                        if (!dupplicate) {
                            $.get('controller/repair/processController.php?func=delSpraying&filename=' + file.name + '&ref_no=' + ref_no, function (data) {
                                dupplicate = false;
                                var res = data.split(",");
                                if (res[0] == "0000") {
                                    var errCode = "Code (" + res[0] + ") : " + res[1];
                                    $.notify(errCode, "success");
                                } else {
                                    var errCode = "Code (" + res[0] + ") : " + res[1];
                                    $.notify(errCode, "error");
                                    $('#se-pre-con').delay(100).fadeOut();
                                    return;
                                }
                                setImageCount(ref_no);
                            });

                        }
                        dupplicate = false;

                    });
                }
            }
        }
        , init7: function () {


            Dropzone.options.myDropzoneS7 = {
                dictDefaultMessage: "",
                addRemoveLinks: false,
                maxFiles: 0,
                thumbnailWidth: "120",
                thumbnailHeight: "120",
                acceptedFiles: "image/jpeg,image/png,image/gif",
                init: function () {
                    thisDropzone7 = this;
                    var dupplicate = false;
                    $.get('controller/repair/processController.php?func=iniPrepare&ref_no=' + ref_no, function (data) {
                        $.each(data, function (key, value) {
                            var mockFile = {name: value.name, size: value.size};
                            thisDropzone7.options.addedfile.call(thisDropzone7, mockFile);
                            thisDropzone7.options.thumbnail.call(thisDropzone7, mockFile, "upload/step_prepare/" + ref_no + "/" + value.name);
                            thisDropzone7.options.complete(thisDropzone7, mockFile);
                        });
                        setImageCount(ref_no);
                    });
                    this.on("success", function (file, response) {
                        var res = JSON.parse(response);
                        var resp = res.error.split(",");
                        if (res.code != '0') {
                            dupplicate = true;
                            thisDropzone7.removeFile(file);
                            var errCode = "Code (" + resp[0] + ") : " + resp[1];
                            $.notify(errCode, "error");
                            return;
                        } else {
                            var errCode = "Code (" + resp[0] + ") : " + resp[1];
                            $.notify(errCode, "success");
                        }
                        $(file.previewElement).find('[data-dz-name]').html(res.name);
                        $(file.previewElement).find('[data-dz-size]').html(res.size);
                        setImageCount(ref_no);
                    });
                    this.on("removedfile", function (file) {
                        if (!dupplicate) {
                            $.get('controller/repair/processController.php?func=delPrepare&filename=' + file.name + '&ref_no=' + ref_no, function (data) {
                                dupplicate = false;
                                var res = data.split(",");
                                if (res[0] == "0000") {
                                    var errCode = "Code (" + res[0] + ") : " + res[1];
                                    $.notify(errCode, "success");
                                } else {
                                    var errCode = "Code (" + res[0] + ") : " + res[1];
                                    $.notify(errCode, "error");
                                    $('#se-pre-con').delay(100).fadeOut();
                                    return;
                                }
                                setImageCount(ref_no);
                            });
                        }
                        dupplicate = false;

                    });
                }
            }
        }
        , init8: function () {


            Dropzone.options.myDropzoneS8 = {
                dictDefaultMessage: "",
                addRemoveLinks: false,
                maxFiles: 0,
                thumbnailWidth: "120",
                thumbnailHeight: "120",
                acceptedFiles: "image/jpeg,image/png,image/gif",
                init: function () {
                    thisDropzone8 = this;
                    var dupplicate = false;
                    $.get('controller/repair/processController.php?func=iniPolishing&ref_no=' + ref_no, function (data) {
                        $.each(data, function (key, value) {
                            var mockFile = {name: value.name, size: value.size};
                            thisDropzone8.options.addedfile.call(thisDropzone8, mockFile);
                            thisDropzone8.options.thumbnail.call(thisDropzone8, mockFile, "upload/step_polishing/" + ref_no + "/" + value.name);
                            thisDropzone8.options.complete(thisDropzone8, mockFile);
                        });
                        setImageCount(ref_no);
                    });
                    this.on("success", function (file, response) {
                        var res = JSON.parse(response);
                        var resp = res.error.split(",");
                        if (res.code != '0') {
                            dupplicate = true;
                            thisDropzone8.removeFile(file);
                            var errCode = "Code (" + resp[0] + ") : " + resp[1];
                            $.notify(errCode, "error");
                            return;
                        } else {
                            var errCode = "Code (" + resp[0] + ") : " + resp[1];
                            $.notify(errCode, "success");
                        }
                        $(file.previewElement).find('[data-dz-name]').html(res.name);
                        $(file.previewElement).find('[data-dz-size]').html(res.size);
                        setImageCount(ref_no);
                    });
                    this.on("removedfile", function (file) {
                        if (!dupplicate) {
                            $.get('controller/repair/processController.php?func=delPolishing&filename=' + file.name + '&ref_no=' + ref_no, function (data) {
                                dupplicate = false;
                                var res = data.split(",");
                                if (res[0] == "0000") {
                                    var errCode = "Code (" + res[0] + ") : " + res[1];
                                    $.notify(errCode, "success");
                                } else {
                                    var errCode = "Code (" + res[0] + ") : " + res[1];
                                    $.notify(errCode, "error");
                                    $('#se-pre-con').delay(100).fadeOut();
                                    return;
                                }
                                setImageCount(ref_no);
                            });
                        }
                        dupplicate = false;

                    });
                }
            }
        }
        , init9: function () {


            Dropzone.options.myDropzoneS9 = {
                dictDefaultMessage: "",
                addRemoveLinks: false,
                maxFiles: 0,
                thumbnailWidth: "120",
                thumbnailHeight: "120",
                acceptedFiles: "image/jpeg,image/png,image/gif",
                init: function () {
                    thisDropzone9 = this;
                    var dupplicate = false;
                    $.get('controller/repair/processController.php?func=iniCheck&ref_no=' + ref_no, function (data) {
                        $.each(data, function (key, value) {
                            var mockFile = {name: value.name, size: value.size};
                            thisDropzone9.options.addedfile.call(thisDropzone9, mockFile);
                            thisDropzone9.options.thumbnail.call(thisDropzone9, mockFile, "upload/step_check/" + ref_no + "/" + value.name);
                            thisDropzone9.options.complete(thisDropzone9, mockFile);
                        });
                        setImageCount(ref_no);
                    });
                    this.on("success", function (file, response) {
                        var res = JSON.parse(response);
                        var resp = res.error.split(",");
                        if (res.code != '0') {
                            dupplicate = true;
                            thisDropzone9.removeFile(file);
                            var errCode = "Code (" + resp[0] + ") : " + resp[1];
                            $.notify(errCode, "error");
                            return;
                        } else {
                            var errCode = "Code (" + resp[0] + ") : " + resp[1];
                            $.notify(errCode, "success");
                        }
                        $(file.previewElement).find('[data-dz-name]').html(res.name);
                        $(file.previewElement).find('[data-dz-size]').html(res.size);
                        setImageCount(ref_no);
                    });
                    this.on("removedfile", function (file) {
                        if (!dupplicate) {
                            $.get('controller/repair/processController.php?func=delCheck&filename=' + file.name + '&ref_no=' + ref_no, function (data) {
                                dupplicate = false;
                                var res = data.split(",");
                                if (res[0] == "0000") {
                                    var errCode = "Code (" + res[0] + ") : " + res[1];
                                    $.notify(errCode, "success");
                                } else {
                                    var errCode = "Code (" + res[0] + ") : " + res[1];
                                    $.notify(errCode, "error");
                                    $('#se-pre-con').delay(100).fadeOut();
                                    return;
                                }
                                setImageCount(ref_no);
                            });
                        }
                        dupplicate = false;

                    });
                }
            }
        }







    };
}();

jQuery(document).ready(function () {
    FormDropzone.init3();
    FormDropzone.init4();
    FormDropzone.init5();
    FormDropzone.init6();
    FormDropzone.init7();
    FormDropzone.init8();
    FormDropzone.init9();


});