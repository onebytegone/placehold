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

   public function getPathForImage($width, $height) {
      $identifier = $this->generateIdentifier($width, $height, '0');
      $path = $this->pathForImage($this->storageDirectory, $identifier);

      if (!file_exists($path)) {
         ini_set('memory_limit', 512*1024*1024);

         $adjust = new ImageAdjust();
         $sourcePath = $this->findSourceImagePath($width, $height);
         list($srcWidth, $srcHeight) = getimagesize($sourcePath);
         $original = $adjust->load($sourcePath);
         list($cropped, $srcWidth, $srcHeight) = $adjust->cropToRatio($original, $srcWidth, $srcHeight, $adjust->calculateRatio($width, $height));
         $adjust->destroy($original);

         $resized = $adjust->resize($cropped, $srcWidth, $srcHeight, $width, $height);
         $adjust->destroy($cropped);

         $adjust->save($resized, $path);
         $adjust->destroy($resized);
      }

      return $path;
   }

   private function findSourceImagePath($width, $height) {
      return rtrim($this->sourceDirectory) . '/image.jpg';
   }

   public function pathForImage($directory, $ident, $type = 'jpg') {
      return rtrim($directory, '/') . '/' . $ident . '.' . $type;
   }
}
