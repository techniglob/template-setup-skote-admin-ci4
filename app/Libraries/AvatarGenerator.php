<?php

namespace App\Libraries;

class AvatarGenerator
{
    protected $width = 200;
    protected $height = 200;
    protected $backgroundColor = [85, 46, 145]; // Purple
    protected $textColor = [255, 255, 255]; // White
    protected $fontSize = 50;
    protected $fontPath;

    public function __construct()
    {
        // Default font path
        $this->fontPath = WRITEPATH . 'fonts/OpenSans-Bold.ttf';

        if (!file_exists($this->fontPath)) {
            throw new \Exception("Font file not found at: " . $this->fontPath);
        }
    }

    public function generate(string $initials = 'PK')
    {
        // Create image canvas
        $image = imagecreatetruecolor($this->width, $this->height);

        // Colors
        $bgColor = imagecolorallocate($image, ...$this->backgroundColor);
        $textColor = imagecolorallocate($image, ...$this->textColor);

        // Fill background
        imagefilledrectangle($image, 0, 0, $this->width, $this->height, $bgColor);

        // Text positioning
        $bbox = imagettfbbox($this->fontSize, 0, $this->fontPath, $initials);
        $x = ($this->width - ($bbox[2] - $bbox[0])) / 2;
        $y = ($this->height - ($bbox[7] - $bbox[1])) / 2;
        $y -= $bbox[7];

        // Write text
        imagettftext($image, $this->fontSize, 0, $x, $y, $textColor, $this->fontPath, $initials);

        // Output image
        header('Content-Type: image/png');
        imagepng($image);
        imagedestroy($image);
    }
}