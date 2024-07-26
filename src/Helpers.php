<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class Helpers
{
    public function __construct()
    {
    }


    function getFileMimeType($picture)
    {
        $mimeType = $picture->getClientMimeType();
        $parts = explode('/', $mimeType);
        return end($parts);
    }

    public static function extractIdFromApiUrl(string $url): ?int
    {
        $parts = explode('/', trim($url, '/'));

        return isset($parts[count($parts) - 1]) ? (int) $parts[count($parts) - 1] : null;
    }

    public static function slugify(string $text): string
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public static function createUploadedFile(string $path, string $copiedImagePath): UploadedFile
    {
        copy($path, $copiedImagePath);

        $defaultFile = new UploadedFile(
            $copiedImagePath,
            basename($copiedImagePath),
            mime_content_type($copiedImagePath),
            null,
            true
        );

        return $defaultFile;
    }

    public static function generateRandomString()
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $year = date('y');
        $month = date('n');
        $day = date('j');
        $hour = date('H');
        $second = date('s');
        $millisecond = round(microtime(true) * 1000);

        $randomCharacter1 = $characters[rand(0, strlen($characters) - 1)];
        $randomCharacter2 = $characters[rand(0, strlen($characters) - 1)];

        $randomString = substr("{$year}{$month}{$randomCharacter2}{$day}{$randomCharacter1}{$hour}{$second}{$millisecond}", 0, 8);

        return $randomString;
    }


    public static function genererCodeAlphanumerique($longueur)
    {
        $caracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $code = '';

        for ($i = 0; $i < $longueur; $i++) {
            $code .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }

        return $code;
    }


    public static function  getDistanceBetweenPoints($lat1, $lon1, $lat2, $lon2, $unit)
    {
        $theta = $lon1 - $lon2;
        $mile = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $mile = acos($mile);
        $mile = rad2deg($mile);
        $mile = $mile * 60 * 1.1515;
        $foot = $mile * 5280;
        $yarn = $foot / 3;
        $km = $mile * 1.609344;
        $m = $km * 1000;
        return compact($unit);
    }


    public function extractFormData($request)
    {
        $content = $request->getContent();

        $data = [];
        preg_match_all('/name=\"([^\"]+)\"[\s\S]*?\r\n\r\n([\s\S]*?)\r\n--/', $content, $matches);

        foreach ($matches[1] as $index => $name) {
            $data[$name] = $matches[2][$index];
        }

        return $data;
    }

    public static function parseMultipartFormData($request)
    {
        $content = $request->getContent();
        $boundary = substr($content, 0, strpos($content, "\r\n"));
        $parts = array_slice(explode($boundary, $content), 1);
        $data = [];

        foreach ($parts as $part) {
            if (strpos($part, '--' . $boundary . '--') !== false) break;

            $part = ltrim($part, "\r\n");

            $headerBody = explode("\r\n\r\n", $part, 2);
            if (count($headerBody) < 2) {
                continue;
            }

            list($headers, $body) = $headerBody;
            $headers = explode("\r\n", $headers);
            $contentDisposition = '';

            foreach ($headers as $header) {
                if (stripos($header, 'Content-Disposition:') !== false) {
                    $contentDisposition = $header;
                    break;
                }
            }

            if (preg_match('/name="([^"]+)"/i', $contentDisposition, $matches)) {
                $name = $matches[1];
                $keys = explode('[', str_replace(']', '', $name));
                $target = &$data;

                foreach ($keys as $key) {
                    if (!isset($target[$key])) {
                        $target[$key] = [];
                    }
                    $target = &$target[$key];
                }

                if (preg_match('/filename="([^"]+)"/i', $contentDisposition, $matches)) {
                    $filename = $matches[1];
                    $tmpFile = tempnam(sys_get_temp_dir(), 'php');
                    file_put_contents($tmpFile, rtrim($body, "\r\n"));

                    $uploadedFile = new UploadedFile(
                        $tmpFile,
                        $filename,
                        mime_content_type($tmpFile),
                        UPLOAD_ERR_OK,
                        true
                    );
                    $target = $uploadedFile;
                } else {
                    $target = stripslashes(rtrim($body, "\r\n"));
                }
            }
        }

        return $data;
    }
}
