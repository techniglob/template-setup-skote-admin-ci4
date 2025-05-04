<?php

namespace App\Libraries;

class AvatarGenerator
{
    protected $width = 100;
    protected $height = 100;
    protected $backgroundColor = [52, 143, 235];
    protected $textColor = [255, 255, 255]; // White
    protected $fontSize = 40;
    protected $fontPath;

    public function __construct()
    {
        $this->fontPath = FCPATH . '/common/fonts/OpenSans-Bold.ttf';
        if (!file_exists($this->fontPath)) {
            throw new \Exception("Font file not found at: " . $this->fontPath);
        }
    }

    public function getInitials(string $fullName): string
    {
        $words = explode(' ', strtoupper(trim($fullName)));
        $initials = '';
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= $word[0];
            }
        }
        return substr($initials, 0, 2); // Max 2 chars
    }

    public function generate(string $initials = 'PK')
    {
        // Create image canvas
        $image = imagecreatetruecolor($this->width, $this->height);

        // Allocate colors
        $bgColor = imagecolorallocate($image, ...$this->backgroundColor);
        $textColor = imagecolorallocate($image, ...$this->textColor);
        imagefilledrectangle($image, 0, 0, $this->width, $this->height, $bgColor);

        // Get bounding box
        $bbox = imagettfbbox($this->fontSize, 0, $this->fontPath, $initials);

        $textWidth  = abs($bbox[4] - $bbox[0]);
        $textHeight = abs($bbox[5] - $bbox[1]);

        $x = ($this->width - $textWidth) / 2;
        $y = ($this->height + $textHeight) / 2;

        // Draw text
        imagettftext($image, $this->fontSize, 0, $x, $y, $textColor, $this->fontPath, $initials);

        // Output
        header('Content-Type: image/png');
        imagepng($image);
        imagedestroy($image);
    }

    public function generateFromName(string $fullName = 'Pritam Khan')
    {
        $initials = $this->getInitials($fullName);
        $this->generate($initials);
    }
}
