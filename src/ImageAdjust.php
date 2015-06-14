<?php

/**
 * @copyright 2015 Ethan Smith
 */

class ImageAdjust {

   public function load($path) {
      // TODO: add type loading
      return imagecreatefromjpeg($path);
   }

   public function save($image, $path) {
      imagejpeg($image, $path, 90);
   }

   public function destroy($image) {
      imagedestroy($image);
   }

   public function resize($image, $sourceWidth, $sourceHeight, $targetWidth, $targetHeight) {
      $altered = imagecreatetruecolor($targetWidth, $targetHeight);
      imagecopyresized($altered, $image, 0, 0, 0, 0, $targetWidth, $targetHeight, $sourceWidth, $sourceHeight);

      return $altered;
   }

   public function cropToRatio($image, $sourceWidth, $sourceHeight, $ratio) {
      list($targetWidth, $targetHeight) = $this->calculateSizeWithRatio($sourceWidth, $sourceHeight, $ratio);
      list($x, $y) = $this->offsetToCenter($sourceWidth, $sourceHeight, $targetWidth, $targetHeight);

      $altered = imagecreatetruecolor($targetWidth, $targetHeight);

      imagecopyresampled($altered, $image, 0, 0, $x, $y, $targetWidth, $targetHeight, $targetWidth, $targetHeight);

      return array($altered, $targetWidth, $targetHeight);
   }

   public function calculateRatio($width, $height) {
      return $width / $height;
   }

   public function calculateSizeWithRatio($width, $height, $ratio) {
      if ($ratio == 1) {
         return $width < $height ? array($width, $width) : array($height, $height);
      }

      if ($ratio > 1) {
         return array($width, $width / $ratio);
      }

      return array($height * $ratio, $height);
   }

   public function offsetToCenter($sourceWidth, $sourceHeight, $targetWidth, $targetHeight) {
      return array(
         floor(($sourceWidth - $targetWidth) / 2),
         floor(($sourceHeight - $targetHeight) / 2)
      );
   }
}
