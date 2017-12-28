<?php

@session_start();
error_reporting(E_ERROR | E_PARSE);
ini_set("post_max_size", "1024M");
ini_set("upload_max_filesize", "1024M");
ini_set("max_input_time", "3600");
ini_set("output_buffering", "Off");
ini_set("max_execution_time", "1800");

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of upload
 *
 * @author HCCTH
 */
class upload {

    private $_path = "";
    private $_Filename = array();
    private $_FilenameResult = array();
    private $_FilenameCustom = array();
    private $_FilenameCustomResult = array();
    private $_minSizeImg = 1;
    private $_maxSizeImg = 102400000;
    private $_minSizeDoc = 1;
    private $_maxSizeDoc = 204800000;
    private $_imgType = array("png", "PNG", "jpg", "JPG", 'jpeg', 'JPEG');
    private $_docType = array("pdf", "PDF");
    private $_errorMessage = "";
    private $_reSize = FALSE;
    private $_defaultWidth = 1560;
    private $_defaultHeight = 1256;
    private $_flagPrefixName = FALSE;
    private $_prefixName = "";

    function Initial_and_Clear() {
        $this->_Filename = array();
        $this->_FilenameResult = array();
        $this->_FilenameCustom = array();
        $this->_FilenameCustomResult = array();
        $this->_errorMessage = "";
    }

    function get_errorMessage() {
        return $this->_errorMessage;
    }

    function set_errorMessage($_errorMessage) {
        $this->_errorMessage = $_errorMessage;
    }

    function add_FileName($fileAdd) {
        array_push($this->_Filename, $fileAdd);
    }

    function add_FileNameResult($fileAdd) {
        array_push($this->_FilenameResult, $fileAdd);
    }

    function add_FileNameCustom($fileAdd, $newFileName) {
        $tmpArr = array(
            "local" => $fileAdd,
            "newFilename" => "$newFileName"
        );
        array_push($this->_FilenameCustom, $tmpArr);
    }

    function add_FileNameCustomResult($fileAdd) {
        array_push($this->_FilenameCustomResult, $fileAdd);
    }

    function get_path() {
        return $this->_path;
    }

    function get_Filename() {
        return $this->_Filename;
    }

    function get_FilenameCustom() {
        return $this->_FilenameCustom;
    }

    function set_path($_path) {
        $this->_path = $_path;
    }

    function setPrefixName($_prefixName) {
        $this->_prefixName = $_prefixName;
    }

    function setFlagPrefixName($_flagPrefixName) {
        $this->_flagPrefixName = $_flagPrefixName;
    }

    function getResize() {
        return $this->_reSize;
    }

    function setResize($_reSize) {
        $this->_reSize = $_reSize;
    }

    function setDefaultWidth($_defaultWidth) {
        $this->_defaultWidth = $_defaultWidth;
    }

    function setDefaultHeight($_defaultHeight) {
        $this->_defaultHeight = $_defaultHeight;
    }

    function set_Filename($_Filename) {
        $this->_Filename = $_Filename;
    }

    function get_imgType() {
        return $this->_imgType;
    }

    function get_docType() {
        return $this->_docType;
    }

    function set_imgType($_imgType) {
        $this->_imgType = $_imgType;
    }

    function set_docType($_docType) {
        $this->_docType = $_docType;
    }

    function get_minSizeImg() {
        return $this->_minSizeImg;
    }

    function get_maxSizeImg() {
        return $this->_maxSizeImg;
    }

    function get_minSizeDoc() {
        return $this->_minSizeDoc;
    }

    function get_maxSizeDoc() {
        return $this->_maxSizeDoc;
    }

    function set_minSizeImg($_minSizeImg) {
        $this->_minSizeImg = $_minSizeImg;
    }

    function set_maxSizeImg($_maxSizeImg) {
        $this->_maxSizeImg = $_maxSizeImg;
    }

    function set_minSizeDoc($_minSizeDoc) {
        $this->_minSizeDoc = $_minSizeDoc;
    }

    function set_maxSizeDoc($_maxSizeDoc) {
        $this->_maxSizeDoc = $_maxSizeDoc;
    }

    function get_FilenameResult() {
        return $this->_FilenameResult;
    }

    function get_FilenameCustomResult() {
        return $this->_FilenameCustomResult;
    }

    function set_FilenameResult($_FilenameResult) {
        $this->_FilenameResult = $_FilenameResult;
    }

    function deleteFile() {
        $resultStatus = FALSE;
        mkdir($this->_path . "temp/", 0777, true);
        $flgCopy = TRUE;
        $flgDelete = TRUE;
        foreach ($this->_Filename as $value) {
            if (copy($this->_path . $value, $this->_path . "temp/" . $value) != 1) {
                // $flgCopy = FALSE;
            }
        }

        foreach ($this->_Filename as $value) {
            if (!unlink($this->_path . $value)) {
                $flgDelete = FALSE;
            }
        }
        if (!$flgDelete) {
            foreach ($this->_Filename as $value) {
                copy($this->_path . "temp/" . $value, $this->_path . $value);
                unlink($this->_path . "temp/" . $value);
            }


            rmdir($this->_path . "temp/");
        } else {
            foreach ($this->_Filename as $value) {
                unlink($this->_path . "temp/" . $value);
            }
            rmdir($this->_path . "temp/");
            $resultStatus = TRUE;
        }




        return (bool) $resultStatus;
    }
    
    function deleteFileCustom() {
        $resultStatus = FALSE;
        mkdir($this->_path . "temp/", 0777, true);
        $flgCopy = TRUE;
        $flgDelete = TRUE;
        foreach ($this->_FilenameCustom as $value) {
            if (copy($this->_path . $value['local'], $this->_path . "temp/" . $value['local']) != 1) {
                // $flgCopy = FALSE;
            }
        }

        foreach ($this->_FilenameCustom as $value) {
            if (!unlink($this->_path . $value['local'])) {
                $flgDelete = FALSE;
            }
        }
        if (!$flgDelete) {
            foreach ($this->_FilenameCustom as $value) {
                copy($this->_path . "temp/" . $value['local'], $this->_path . $value['local']);
                unlink($this->_path . "temp/" . $value['local']);
            }


            rmdir($this->_path . "temp/");
        } else {
            foreach ($this->_FilenameCustom as $value) {
                unlink($this->_path . "temp/" . $value['local']);
            }
            rmdir($this->_path . "temp/");
            $resultStatus = TRUE;
        }




        return (bool) $resultStatus;
    }

    function deleteFileNoTemp() {
        $_tmpInfo = $this->getFileInDIR();
        foreach ($_tmpInfo as $key => $_valueTmpInfo) {
            $flgDelete = TRUE;
            foreach ($this->_Filename as $value) {
                if ($_tmpInfo[$key]['file'] == $value) {
                    $flgDelete = FALSE;
                }
            }
            if ($flgDelete) {
                unlink($this->_path . $_tmpInfo[$key]['file']);
            }
        }
    }

    function getFileInDIR() {
        $listFile = array();
        if (is_dir($this->_path)) {
            if ($dh = opendir($this->_path)) {
                while (($file = readdir($dh)) !== false) {
                    $tmp = array(
                        'file' => $file
                    );
                    $listFile[] = $tmp;
                }
                closedir($dh);
            }
        }
        return $listFile;
    }

    function AddFile() {
        $resultStatus = FALSE;
        $img = FALSE;
        $doc = FALSE;
        $seq = 1;
        foreach ($this->_Filename as $value) {
            if (!is_null($value) && $value != "") {

                $temp = explode(".", $value["name"]);
                $tmpFileName = date('YmdHis') . $seq++ . '.' . end($temp);
                $newfilename = $this->_path . $tmpFileName;
                $this->add_FileNameResult($tmpFileName);
                foreach ($this->_imgType as $typeImg) {
                    if ($typeImg == end($temp)) {
                        $img = TRUE;
                    }
                }
                foreach ($this->_docType as $typeDoc) {
                    if ($typeDoc == end($temp)) {
                        $doc = TRUE;
                    }
                }

                if ($img) {
                    $size = $value["size"];
                    if ($size < $this->_minSizeImg || $size > $this->_maxSizeImg) {
                        $this->_errorMessage = $_SESSION['cd_2211'];
                        $this->clearDataInFilenameResult($tmpFileName);
                        return (bool) $resultStatus = FALSE;
                    }
                }

                if ($doc) {
                    $size = $value["size"];
                    if ($size < $this->_minSizeDoc || $size > $this->_maxSizeDoc) {
                        $this->_errorMessage = $_SESSION['cd_2212'];
                        $this->clearDataInFilenameResult($tmpFileName);
                        return (bool) $resultStatus = FALSE;
                    }
                }

                if (!$img && !$doc) {
                    $this->_errorMessage = $_SESSION['cd_2210'];
                    $this->clearDataInFilenameResult($tmpFileName);
                    return (bool) $resultStatus = FALSE;
                }

                if (move_uploaded_file($value["tmp_name"], $newfilename)) {

                    if ($this->getResize()) {
                        $this->init($newfilename);
                        $this->resize($this->_defaultWidth, $this->_defaultHeight);
                        if ($this->save($newfilename) === false) {
                            $this->_errorMessage = "Error Resize";
                            $this->clearDataInFilenameResult($tmpFileName);
                            return (bool) $resultStatus = FALSE;
                        }
                    }
                    $this->_errorMessage = "";
                    $resultStatus = TRUE;
                } else {
                    $this->_errorMessage = $_SESSION['cd_2001'];
                    $this->clearDataInFilenameResult($tmpFileName);
                    return (bool) $resultStatus = FALSE;
                }
            }
        }
        return (bool) $resultStatus;
    }

    function AddFileCustom() {
        $resultStatus = FALSE;
        $img = FALSE;
        $doc = FALSE;
        $seq = 1;
        foreach ($this->_FilenameCustom as $value) {
            if (!is_null($value) && $value != "") {

                $temp = explode(".", $value['local']['name']);
                $tmpFileName = $value['newFilename'] . '.' . end($temp);


                $newfilename = $this->_path . $tmpFileName;
                $this->add_FileNameCustomResult($tmpFileName);
                foreach ($this->_imgType as $typeImg) {
                    if ($typeImg == end($temp)) {
                        $img = TRUE;
                    }
                }
                foreach ($this->_docType as $typeDoc) {
                    if ($typeDoc == end($temp)) {
                        $doc = TRUE;
                    }
                }

                if ($img) {
                    $size = $value['local']["size"];
                    if ($size < $this->_minSizeImg || $size > $this->_maxSizeImg) {
                        $this->_errorMessage = $_SESSION['cd_2211'];
                        $this->clearDataInFilenameCustomResult($tmpFileName);
                        return (bool) $resultStatus = FALSE;
                    }
                }

                if ($doc) {
                    $size = $value['local']["size"];
                    if ($size < $this->_minSizeDoc || $size > $this->_maxSizeDoc) {
                        $this->_errorMessage = $_SESSION['cd_2212'];
                        $this->clearDataInFilenameCustomResult($tmpFileName);
                        return (bool) $resultStatus = FALSE;
                    }
                }

                if (!$img && !$doc) {
                    $this->_errorMessage = $_SESSION['cd_2210'];
                    $this->clearDataInFilenameCustomResult($tmpFileName);
                    return (bool) $resultStatus = FALSE;
                }

                if (move_uploaded_file($value['local']["tmp_name"], $newfilename)) {

                    if ($this->getResize()) {
                        $this->init($newfilename);
                        $this->resize($this->_defaultWidth, $this->_defaultHeight);
                        if ($this->save($newfilename) === false) {
                            $this->_errorMessage = "Error Resize";
                            $this->clearDataInFilenameCustomResult($tmpFileName);
                            return (bool) $resultStatus = FALSE;
                        }
                    }
                    $this->_errorMessage = "";
                    $resultStatus = TRUE;
                } else {
                    $this->_errorMessage = $_SESSION['cd_2001'];
                    $this->clearDataInFilenameCustomResult($tmpFileName);
                    return (bool) $resultStatus = FALSE;
                }
            }
        }
        return (bool) $resultStatus;
    }

    function clearDataInFilenameResult($tmp) {
        foreach ($this->_FilenameResult as $key => $value) {
            if ($tmp == $value) {
                unset($this->_FilenameResult[$key]);
            }
        }
    }

    function clearDataInFilenameCustomResult($tmp) {
        foreach ($this->_FilenameResult as $key => $value) {
            if ($tmp == $value) {
                unset($this->_FilenameResult[$key]);
            }
        }
    }

    function clearFileAddFail() {
        $flgDelete = TRUE;
        if ($this->_FilenameResult != NULL) {
            foreach ($this->_FilenameResult as $value) {
                if (!unlink($this->_path . $value)) {
                    $flgDelete = FALSE;
                }
            }
        }
        return (bool) $flgDelete;
    }
    
    function clearFileAddFailCustom() {
        $flgDelete = TRUE;
        if ($this->_FilenameCustomResult != NULL) {
            foreach ($this->_FilenameCustomResult as $value) {
                if (!unlink($this->_path . $value)) {
                    $flgDelete = FALSE;
                }
            }
        }
        return (bool) $flgDelete;
    }

    //ResizeFile
    private $image;
    private $image_type;

    public function init($filename) {
        $image_info = getimagesize($filename);
        $this->image_type = $image_info[2];

        switch ($this->image_type) {
            case IMAGETYPE_JPEG:
                $this->image = imagecreatefromjpeg($filename);
                break;
            case IMAGETYPE_GIF:
                $this->image = imagecreatefromgif($filename);
                break;
            case IMAGETYPE_PNG:
                $this->image = imagecreatefrompng($filename);
                break;
        }
    }

    public function save($filename, $image_type = IMAGETYPE_JPEG, $compression = 75, $permissions = null) {
        switch ($image_type) {
            case IMAGETYPE_JPEG:
                imagejpeg($this->image, $filename, $compression);
                break;
            case IMAGETYPE_GIF:
                imagegif($this->image, $filename);
                break;
            case IMAGETYPE_PNG:
                imagepng($this->image, $filename);
                break;
            default:
                return false;
                break;
        }

        if ($permissions != null) {
            chmod($filename, $permissions);
        }

        return true;
    }

    public function output($image_type = IMAGETYPE_JPEG) {
        switch ($image_type) {
            case IMAGETYPE_JPEG:
                imagejpeg($this->image);
                break;
            case IMAGETYPE_GIF:
                imagegif($this->image);
                break;
            case IMAGETYPE_PNG:
                imagepng($this->image);
                break;
        }
    }

    public function get_width() {
        return imagesx($this->image);
    }

    public function get_height() {
        return imagesy($this->image);
    }

    public function resize_to_height($height) {
        $ratio = $height / $this->get_height();
        $width = $this->get_width() * $ratio;
        $this->resize($width, $height);
    }

    public function resize_to_width($width) {
        $ratio = $width / $this->get_width();
        $height = $this->get_height() * $ratio;
        $this->resize($width, $height);
    }

    public function scale($scale) {
        $width = $this->get_width() * $scale / 100;
        $height = $this->get_height() * $scale / 100;
        $this->resize($width, $height);
    }

    public function resize($width, $height) {
        $new_image = imagecreatetruecolor($width, $height);
        imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->get_width(), $this->get_height());
        $this->image = $new_image;
    }

}
