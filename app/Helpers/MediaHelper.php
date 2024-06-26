<?PHP

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class MediaHelper
{

    const IMG_WIDTH = 370;
    const IMG_HIGHT = 244;

    public static function parseCurrency($amount, $type = 'INR')
    {
        $naivety = ($amount < 0) ? true : false;
        $amount = "₹ " . number_format(abs($amount), 2, ".", "");
        if ($naivety) {
            $amount = '- ' . $amount;
        }

        return $amount;
    }

    public static function removeImage($images)
    {
        $imageArray = $images;
        $imageData = gettype($images);
        if ($imageData != 'array') {
            $imageArray = explode(',', $images);
        }

        foreach ($imageArray as $key => $imageName) {
            if (file_exists($imageName)) {
                @unlink($imageName);
            }
        }
        return true;
    }

    /* check file directory path and create */
    private static function checkDir($dir)
    {
        if (!is_dir($dir)) {
            mkdir($dir);
        }
    }


    public static function makeThumbnail($fileName, $uploaded_image, $destinationThumbPath, $quality = 90)
    {
        try {
            if (!file_exists($destinationThumbPath)) {
                mkdir($destinationThumbPath, 0777, true);
            }

            $thumb_width = self::IMG_WIDTH;
            $thumb_height = self::IMG_HIGHT;
            $imgsize = getimagesize($uploaded_image);
            $width = $imgsize[0];
            $height = $imgsize[1];
            $mime = $imgsize['mime'];
            switch ($mime) {
                case 'image/gif':
                    $image_create = "imagecreatefromgif";
                    $image = "imagegif";
                    break;
                case 'image/png':
                    $image_create = "imagecreatefrompng";
                    $image = "imagepng";
                    $quality = 7;
                    break;
                case 'image/jpeg':
                    $image_create = "imagecreatefromjpeg";
                    $image = "imagejpeg";
                    break;
                default:
                    return false;
                    break;
            }
            $thumbnail = $destinationThumbPath . $fileName;
            list($width, $height) = getimagesize($uploaded_image);
            $thumb_create = imagecreatetruecolor($thumb_width, $thumb_height);
            $source = $image_create($uploaded_image);
            imagecopyresized($thumb_create, $source, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height);
            $image($thumb_create, $thumbnail, $quality);
            if ($thumb_create) {
                imagedestroy($thumb_create);
            }

            if ($source) {
                imagedestroy($source);
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function uploadImage($images = array(), $customPath = false, $createThumb = false, $type = 'image', $removeOld = false)
    {
        foreach ($images as $file) {
            $path = $file->getRealPath();
            $name = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $size = $file->getSize();
            // $Mime_Type  =  $file->getMimeType();
            switch ($type) {
                case $type == 'doc':
                    $imageArray = array("doc", "pdf", "docx");
                    break;
                case $type == 'video':
                    $imageArray = array("mp4", "avi", "ogg");
                    break;
                case $type == 'icon':
                    $imageArray = array("png", "jpg", "jpeg", "gif", "bmp", "ico", "icon");
                    break;
                default:
                    $imageArray = array("png", "jpg", "jpeg", "gif", "bmp");
                    break;
            }
            $checkFile = in_array($extension, $imageArray);
            if ($checkFile) {
                $destinationPath = public_path() . '/uploads/';
                if ($customPath) {
                    $destinationPath .= $customPath . "/";
                }

                if ($removeOld) {
                    if ($createThumb && $customPath) {
                        $oldFilePath = $destinationPath . "thumb/" . $removeOld;
                        $olfFileThumbPath = $destinationPath . $removeOld;
                        self::removeImage($oldFilePath);
                        self::removeImage($olfFileThumbPath);
                    } else {
                        self::removeImage($destinationPath . $removeOld);
                    }
                }
                $timeStamp = Carbon::now()->addDay('30')->timestamp;
                $fileName = $timeStamp . '_' . CustomHelper::generatePassword(8, 3) . "." . $extension;
                $file->move($destinationPath, $fileName);
                if ($createThumb) {
                    $destinationThumbPath = $destinationPath . "thumb/";
                    self::makeThumbnail($fileName, $destinationPath . $fileName, $destinationThumbPath);
                }
                $fileNameWithPath[] = $fileName; /* final file name */
            } else {
                return false;
            }
        }
        $fileNameWithPath = implode(',', $fileNameWithPath);
        return $fileNameWithPath;
    }

    /* upload image by base 64 bit */
    public static function uploadBase64Image($file, $name_prefix = false, $customPath = false, $createThumb = false, $removeOld = false)
    {
        $destinationPath = public_path() . '/uploads/';
        if ($customPath) {
            $destinationPath .= $customPath . "/";
        }

        $image_prefix = ($name_prefix) ?: Carbon::now()->addDay('30')->timestamp . '_' . CustomHelper::generatePassword(8, 3);
        if (preg_match('/^data:image\/(\w+);base64,/', $file, $img_type)) {
            $file = substr($file, strpos($file, ',') + 1);
            $file = str_replace(' ', '+', $file);
            $img_type = strtolower($img_type[1]);
            $fileName = $image_prefix . "." . $img_type;
            $file = base64_decode($file);
            if ($file === false) {
                return [
                    'status' => false,
                    'message' => 'Error invalid image source.',
                ];
            }
            $image_size = getImageSizeFromString($file)['bits'];
            $image_type = getImageSizeFromString($file)['mime'];


            switch ($img_type) {
                case $img_type == 'doc':
                    $imageArray = array("doc", "pdf", "docx");
                    break;
                case $img_type == 'video':
                    $imageArray = array("mp4", "avi", "ogg");
                    break;
                case $img_type == 'icon':
                    $imageArray = array("png", "jpg", "jpeg", "gif", "bmp", "ico", "icon");
                    break;
                default:
                    $imageArray = array("png", "jpg", "jpeg", "gif", "bmp");
                    break;
            }
            $checkFile = in_array($img_type, $imageArray);
            if ($checkFile) {
                $destinationPath = public_path() . '/uploads/';
                if ($customPath) {
                    $destinationPath .= $customPath . "/";
                }
                self::checkDir($destinationPath);

                \File::put($destinationPath . $fileName, $file);
                if ($createThumb) {
                    $destinationThumbPath = $destinationPath . "thumb/";
                    self::checkDir($destinationThumbPath);
                    self::makeThumbnail($fileName, $destinationPath . $fileName, $destinationThumbPath);
                }

                if ($removeOld) {
                    if ($createThumb && $customPath) {
                        $oldFilePath = $destinationPath . "thumb/" . $removeOld;
                        $olfFileThumbPath = $destinationPath . $removeOld;
                        self::removeImage($oldFilePath);
                        self::removeImage($olfFileThumbPath);
                    } else {
                        self::removeImage($destinationPath . $removeOld);
                    }
                }

                $aData['alt'] = $fileName;
                $aData['file_url'] = asset('uploads/' . $customPath . '/' . $fileName);
                $aData['file_path'] = $destinationPath . $fileName;
                $aData['file_name'] = $fileName;
                $aData['file_size'] = $image_size ?? 0;
                $aData['file_type'] = $image_type ?? $img_type;
                return [
                    'status' => true,
                    'image' => $aData,
                ];
            }
        }
        return [
            'status' => false,
            'message' => 'Error invalid image source.',
        ];
    }

    public static function uploadImageMedia($file, $customPath = false, $createThumb = false, $type = 'image', $removeOld = false)
    {
        try {
            $path = $file->getRealPath();
            $name = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $size = $file->getSize();
            $mime_Type = $file->getMimeType();
            switch ($type) {
                case $type == 'doc':
                    $imageArray = array("doc", "pdf", "docx");
                    break;
                case $type == 'video':
                    $imageArray = array("mp4", "avi", "ogg");
                    break;
                case $type == 'icon':
                    $imageArray = array("png", "jpg", "jpeg", "gif", "bmp", "ico", "icon");
                    break;
                default:
                    $imageArray = array("png", "jpg", "jpeg", "gif", "bmp");
                    break;
            }
            if (!in_array($extension, $imageArray)) {
                return false;
            } else {
                $destinationPath = public_path();
                if ($customPath) {
                    $destinationPath .= $customPath . "/";
                }

                if ($removeOld) {
                    if ($createThumb && $customPath) {
                        $oldFilePath = $destinationPath . "thumb/" . $removeOld;
                        $olfFileThumbPath = $destinationPath . $removeOld;
                        self::removeImage($oldFilePath);
                        self::removeImage($olfFileThumbPath);
                    } else {
                        self::removeImage($destinationPath . $removeOld);
                    }
                }
                $timeStamp = Carbon::now()->addDay('30')->timestamp;
                $fileName = $timeStamp . '_' . CustomHelper::generatePassword(8, 3) . "." . $extension;
                $file->move($destinationPath, $fileName);
                if ($createThumb) {
                    $destinationThumbPath = $destinationPath . "thumb/";
                    self::makeThumbnail($fileName, $destinationPath . $fileName, $destinationThumbPath);
                }
                return [
                    'file_name' => $fileName,
                    'alt' => $name,
                    'file_size' => $size,
                    'file_type' => $mime_Type,
                ];
            }
        } catch (\Throwable $th) {
            return false;
        }
    }

    public static function imageResize(Request $request)
    {
        try {
            $file_not_found = env('IMG_URL');
            $url = (isset($request->url) && $request->url && file_exists($request->url)) ? $request->url : $file_not_found;
            $width = (isset($request->width) && $request->width) ? $request->width : self::IMG_WIDTH;
            $height = (isset($request->height) && $request->height) ? $request->height : self::IMG_HIGHT;
            $imgsize = getimagesize($url);
            $width_orig = $imgsize[0];
            $height_orig = $imgsize[1];
            $mime = $imgsize['mime'];
            switch ($mime) {
                case 'image/gif':
                    header('Content-type: image/gif');
                    $image_create = "imagecreatefromgif";
                    $image = "imagegif";
                    break;
                case 'image/png':
                    header('Content-type: image/png');
                    $image_create = "imagecreatefrompng";
                    $image = "imagepng";
                    $quality = 9;
                    break;
                case 'image/jpeg':
                    header('Content-type: image/jpeg');
                    $image_create = "imagecreatefromjpeg";
                    $image = "imagejpeg";
                    $quality = 100;
                    break;
                default:
                    return false;
                    break;
            }

            $ratio_orig = $width_orig / $height_orig;
            if ($width / $height > $ratio_orig) {
                $width = $height * $ratio_orig;
            } else {
                $height = $width / $ratio_orig;
            }
            $image_p = imagecreatetruecolor($width, $height);
            $image_s = $image_create($url);
            imagecopyresampled($image_p, $image_s, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
            $image($image_p, null, $quality);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
