<?php

/**
 * @copyright 2015 Ethan Smith
 */
class ImageAdjustTest extends BaseTest {
   public function testCalculateSizeWithRatio() {
      $adjust = new ImageAdjust();

      $this->assertEquals(array(1000, 1000), $adjust->calculateSizeWithRatio(1000, 1000, 1));
      $this->assertEquals(array(1000, 1000), $adjust->calculateSizeWithRatio(1000, 2000, 1));
      $this->assertEquals(array(1600, 900), $adjust->calculateSizeWithRatio(1600, 1000, 16/9));
      $this->assertEquals(array(900, 1600), $adjust->calculateSizeWithRatio(1000, 1600, 9/16));

   }

   public function testOffsetToCenter() {
      $adjust = new ImageAdjust();

      $this->assertEquals(array(0, 0), $adjust->offsetToCenter(1000, 1000, 1000, 1000));
      $this->assertEquals(array(0, -250), $adjust->offsetToCenter(1000, 1000, 1000, 500));
      $this->assertEquals(array(-500, 0), $adjust->offsetToCenter(2000, 1000, 1000, 1000));
   }
}
