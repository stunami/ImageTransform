<?php
/*
 * This file is part of the sfImageTransform package.
 * (c) 2007 Stuart <stuart.lowes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * sfImageTextGD class.
 *
 * Adds text to the image.
 *
 * <code>
 * <?php
 * $img = new sfImage('image1.jpg', 'image/png', 'GD');
 * $img->text('a symfony plugin', 20, 20, 10, 'Verdana', '#FF0000', 'left');
 * ?>
 * </code>
 *
 * @package sfImageTransform
 * @subpackage transforms
 * @author Stuart Lowes <stuart.lowes@gmail.com>
 * @version SVN: $Id$
 */
class sfImageTextGD extends sfImageTransformAbstract
{
  /**
   * Font face.
  */
  protected $font = 'Arial';

  /**
   * Font size.
  */
  protected $size = 10;

  /**
   * Text.
  */
  protected $text = '';

  /**
   * Angel of the text.
  */
  protected $angle = 0;

  /**
   * X coordinate.
  */
  protected $x = 0;

  /**
   * Y coordinate.
  */
  protected $y = 0;

  /**
   * Font Color.
  */
  protected $color = '#000000';

  /**
   * Path to font.
  */
  protected $font_dir = '';

  /**
   * Allowed alignments.
   * 
   * options are:
   *  top
   *  bottom
   *  left
   *  right
   *  middle
   *  center
   *  top-left
   *  top-right
   *  top-center
   *  middle-left
   *  middle-right
   *  middle-center
   *  bottom-left
   *  bottom-right
   *  bottom-center
   *
  */
  protected $alignments = array(
                               'top', 'bottom','left' ,'right', 'middle', 'center',
                               'top-left', 'top-right', 'top-center',
                               'middle-left', 'middle-right', 'middle-center',
                               'bottom-left', 'bottom-right', 'bottom-center',
                                );
  
  /**
   * Text alignment.
  */
  protected $alignment = 'left';

  /**
   * Construct an sfImageTextGD object.
   *
   * @param string text to be added to image
   * @param integer x-coordinate
   * @param integer y-coordinate
   * @param integer font size
   * @param string font face
   * @param string font color
   * @param string text alignment
   * @param integer text angle  
   */
  public function __construct($text, $x=0, $y=0, $size=10, $font='Arial', $color='#000000', $align='left', $angle=0)
  {
    $this->setFontDirectory(sfConfig::get('app_sfImageTransformPlugin_font_dir','/usr/share/fonts/truetype/msttcorefonts'));
    
    $this->setText($text);
    $this->setX($x);
    $this->setY($y);
    $this->setSize($size);
    $this->setFont($font);
    $this->setColor($color);
    $this->setAlignment($align);
    $this->setAngle($angle);
  }

  /**
   * Sets the text.
   *
   * @param string text to be displayed
   */
  public function setText($text)
  {
    $this->text = html_entity_decode($text, ENT_COMPAT, 'UTF-8');
  }

  /**
   * Gets the text.
   *
   * @return string
   */
  public function getText()
  {
    return $this->text;
  }

  /**
   * Sets X coordinate.
   *
   * @param integer
   */
  public function setX($x)
  {
    $this->x = $x;
  }

  /**
   * Gets X coordinate.
   *
   * @return integer
   */
  public function getX()
  {
    return $this->x;
  }

  /**
   * Sets Y coordinate.
   *
   * @param integer
   */
  public function setY($y)
  {
    $this->y = $y;
  }

  /**
   * Gets Y coordinate.
   *
   * @return integer
   */
  public function getY()
  {
    return $this->y;
  }

  /**
   * Sets text size.
   *
   * @param integer
   */
  public function setSize($size)
  {
    $this->size = $size;
  }

  /**
   * Gets text size.
   *
   * @return integer
   */
  public function getSize()
  {
    return $this->size;
  }
  
  /**
   * Sets text alignment.
   *
   * @param string
   * @return boolean
   */
  public function setAlignment($alignment)
  {
    if (in_array($alignment, $this->alignments))
    {
      $this->alignment = $alignment;
      
      return true;
    }
    
    return false;
  }

  /**
   * Gets text alignment.
   *
   * @return string
   */
  public function getAlignment()
  {
    return $this->alignment;
  }
  
  /**
   * Sets text font.
   *
   * @param string
   */
  public function setFont($font)
  {
    $this->font = str_replace(' ', '_', $font);
  }

  /**
   * Gets text font.
   *
   * @return string
   */
  public function getFont()
  {
    return $this->font;
  }
  
  /**
   * Sets font directory.
   *
   * @param string
   * @return boolean
   */
  public function setFontDirectory($dir)
  {
  
    if (file_exists($dir) && is_dir($dir))
    {
      $this->font_dir = $dir;
      
      return true;
    }
    
    return false;
  }

  /**
   * Gets font file.
   *
   * @return string
   */
  public function getFontFile()
  {
    return $this->font_dir . DIRECTORY_SEPARATOR . $this->font . '.ttf';
  }

  /**
   * Sets text color.
   *
   * @param string
   */
  public function setColor($color)
  {
    $this->color = $color;
  }

  /**
   * Gets text color.
   *
   * @return string
   */
  public function getColor()
  {
    return $this->color;
  }

  /**
   * Sets text angle.
   *
   * @param string
   */
  public function setAngle($angle)
  {
    $this->angle = $angle;
  }

  /**
   * Gets text angle.
   *
   * @return string
   */
  public function getAngle()
  {
    return $this->angle;
  }

  /**
   * Apply the transform to the sfImage object.
   *
   * @access protected
   * @param sfImage
   * @return sfImage
   */
  protected function transform(sfImage $image)
  {
    $resource = $image->getAdapter()->getHolder();
    
    $x = $this->getX();
    $y = $this->getY();
    
    list($x, $y, $width, $height) = $this->calculateBoxData($this->getText() ,$this->getFontFile(), $this->getSize(), $this->getAlignment(), $this->getX(), $this->getY(), $this->getAngle());
    
    // For now only horizontal text alignment is supported
    if($this->getAngle() == 0)
    {
      
    }

    $rgb = sscanf($this->color, '#%2x%2x%2x');

    $color = imagecolorallocate($resource, $rgb[0], $rgb[1], $rgb[2]);

    $lines = explode('\n', $this->getText());
    
    foreach($lines as $line)
    {
      imagettftext($resource, $this->getSize(), $this->getAngle(), $x, $y, $color, $this->getFontFile(), $line);
      $y += $height;
    }

    return $image;
  }
  
  protected function calculateBoxData($text, $font, $size, $alignment, $x, $y, $angle)
  {
      
    $box = imageTTFBbox($size,$angle,$font,$text);
    
    $width = abs($box[0] - $box[2]);
    $height = abs($box[7] - $box[1]);

    switch($alignment)
    {
      case 'top':
      case 'top-left':
        $x = $x;
        $y = $y + $height;
        break;
      case 'right':
      case 'bottom-right':
        $x = $x - $width;
        break;
      case 'top-right':
        $x = $x - $width;
        $y = $y + $height;
        break;
      case 'center':
      case 'bottom-center':
        $x = (int)($x - $width / 2);
        break;
      case 'middle-left':
        $y = (int)($y + $height / 2);
        break;
      case 'middle-right':
        $x = $x - $width;
        $y = (int)($y + $height / 2);
        break;
      case 'middle-center':
        $x = (int)($x - $width / 2);
        $y = (int)($y + $height / 2);
    }
    
    return array($x, $y, $width, $height);
  }
}
