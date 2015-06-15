<?php

/**
 * @copyright 2015 Ethan Smith
 */

class ImageFetch {
   private $sourceDirectory = "";
   private $storageDirectory = "";

   function __construct($source, $storage) {
      $this->sourceDirectory = $source;
      $this->storageDirectory = $storage;
   }

   public function generateIdentifier($width, $height, $index) {
      return "{$width}x{$height}_$index";
   }

   public function findPossibleFiles($width, $height) {
      $allFiles = scandir($this->storageDirectory);

      $pattern = "/".$this->generateIdentifier($width, $height, ".*")."/";
      return array_filter($allFiles, function ($item) use ($pattern) {
         return preg_match($pattern, $item) == 1;
      });
   }

   public function getPathForImage($width, $height) {
      $files = $this->findPossibleFiles($width, $height);

      $path = "";
      if (count($files) < 3) {
         ini_set('memory_limit', 512*1024*1024);

         $adjust = new ImageAdjust();
         $sourcePath = $this->findSourceImagePath($width, $height);
         list($srcWidth, $srcHeight) = getimagesize($sourcePath);
         $original = $adjust->load($sourcePath);
         list($cropped, $srcWidth, $srcHeight) = $adjust->cropToRatio($original, $srcWidth, $srcHeight, $adjust->calculateRatio($width, $height));
         $adjust->destroy($original);

         $resized = $adjust->resize($cropped, $srcWidth, $srcHeight, $width, $height);
         $adjust->destroy($cropped);

         $identifier = $this->generateIdentifier($width, $height, strval(count($files)));
         $path = $this->pathForImage($this->storageDirectory, $identifier);

         $adjust->save($resized, $path);
         $adjust->destroy($resized);
      } else {
         $path = $this->pathForImage($this->storageDirectory, $files[array_rand($files)], '');
      }

      return $path;
   }

   private function findSourceImagePath($width, $height) {
      return rtrim($this->sourceDirectory) . '/image.jpg';
   }

   public function pathForImage($directory, $ident, $type = 'jpg') {
      return rtrim($directory, '/') . '/' . $ident . ($type !== '' ? '.' . $type : '');
   }
}
