<?php
/**
 * This file is part of the ImageTransform package.
 * (c) 2007 Stuart Lowes <stuart.lowes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @category   ImageTransform
 * @package    MimeType
 * @subpackage Resolve
 * @version    SVN: $Id$
 */

/**
 * Implementation of ImageTransform_MimeType_Resolve_Aware.
 * Represents a file and its mime type
 *
 * @category   ImageTransform
 * @package    File
 * @author     Jan Schumann <js@schumann-it.com>
 */
class ImageTransform_File implements ImageTransform_MimeType_Resolve_Aware
{
  /**
   * @var string
   */
  private $filepath;
  /**
   * @var string
   */
  private $mime = '';
  /**
   * @var ImageTransform_MimeType_ResolveStrategy_Interface
   */
  private $mimeResolveStrategy;
  /**
   * @var ImageTransform_MimeType_ResolveStrategy_Pathinfo
   */
  private $pathinfoMimeResolveStrategy;

  /**
   * Constructs a new ImageTransform_File instance
   *
   * @see    ImageTransform_MimeType_Resolve_Aware::__construct()
   *
   * @throws ImageTransform_File_NotFoundException
   *
   * @param string $filepath The filepath (may be empty or non-existent for new files
   * @param string $mime     Set a mime type manually
   */
  public function __construct($filepath = '', $mime = '')
  {
    $this->setFilepath($filepath);
    $this->setMimeType($mime);
  }

  /**
   * Sets the filepath. If it is not readable and not emtpy the file directory has to be existend.
   * Otherwise an exeption will be thrown.
   *
   * @see    ImageTransform_MimeType_Resolve_Aware::setFilename()
   *
   * @throws ImageTransform_File_NotFoundException
   *
   * @param  string  $filepath The filepath including the filename (or empty for new files)
   * @param  boolean $isNew    If the file is a placeholder
   */
  public function setFilepath($filepath, $isNew = false)
  {
    $this->filepath = (string) $filepath;

    if (!$this->exists())
    {
      if ('' !== $this->filepath && !$isNew)
      {
        $this->ensureDirExists();
      }
    }
  }

  /**
   * Checke is the file exists and is readable
   *
   * @return boolean
   */
  public function exists()
  {
    return is_readable($this->filepath);
  }

  /**
   * Ensures that the directory for the file exists
   *
   * @throws ImageTransform_File_NotFoundException if dirname does not exist
   */
  private function ensureDirExists()
  {
    if (!is_dir(dirname($this->getFilepath())))
    {
      $message = 'The directory for the new file %s does not exist. Please create it before.';
      throw new ImageTransform_File_NotFoundException(sprintf($message, $this->getFilepath()));
    }
  }

  /**
   * Allows to set the mime-type manually.
   *
   * @see   ImageTransform_MimeType_Resolve_Aware::setMimeType()
   *
   * @param string $mime
   */
  public function setMimeType($mime)
  {
    $this->mime = (string) $mime;
  }

  /**
   * Returns the resolved mime type
   *
   * @see    ImageTransform_MimeType_Resolve_Aware::getMimeType()
   *
   * @throws ImageTransform_MimeType_Resolve_Strategy_Exception
   *
   * @param  boolean $forceDetection Force mime detection even if already detected
   *
   * @return string
   */
  public function getMimeType($forceDetection = false)
  {
    if (true === $forceDetection || '' === $this->mime)
    {
      $this->mime = $this->detectMimeType();
    }

    return $this->mime;
  }

  /**
   * Detects the mime type by the set strategy. Default strategy is pathinfo.
   *
   * @throws ImageTransform_MimeType_Resolve_Strategy_Exception
   *
   * @return string
   */
  private function detectMimeType()
  {
    if (!$this->exists() || is_null($this->mimeResolveStrategy))
    {
      $mime = $this->detectMimeTypeByExtension();
    }
    else
    {
      $mime = $this->mimeResolveStrategy->resolve($this->getFilepath());
    }

    if (!$mime)
    {
      $message = 'Mime type could not be detected by strategy %s for file %s';
      $message = sprintf($message, get_class($this->mimeResolveStrategy), $this->getFilepath());
      throw new ImageTransform_MimeType_Resolve_Strategy_Exception($message);
    }

    return $mime;
  }

  /**
   * Detects the mime type by extension (pathinfo)
   *
   * @throws ImageTransform_MimeType_Resolve_Strategy_Exception If mime type could not be detected#
   *
   * @return string
   */
  private function detectMimeTypeByExtension()
  {
    if (is_null($this->pathinfoMimeResolveStrategy))
    {
      $this->pathinfoMimeResolveStrategy = $this->createMimeResolveStrategy('pathinfo');
    }

    $mime = $this->pathinfoMimeResolveStrategy->resolve($this->getFilepath());

    if (!$mime)
    {
      $message = 'Mime type could not be detected by %s';
      $message .= !$this->exists() ? ' for the new file %s.' : '. Please set a detection strategy for file %s.';
      $message = sprintf($message, get_class($this->pathinfoMimeResolveStrategy), $this->getFilepath());
      throw new ImageTransform_MimeType_Resolve_Strategy_Exception($message);
    }

    return $mime;
  }

  /**
   * Gets the path of the file including the filename
   *
   * @see    ImageTransform_MimeType_Resolve_Aware::getFilename()
   *
   * @return string
   */
  public function getFilepath()
  {
    return $this->filepath;
  }

  /**
   * Set a mime detection strategy to be aware of mime detection methods
   *
   * @see   ImageTransform_MimeType_Resolve_Aware::setMimeResolveStrategy()
   *
   * @param ImageTransform_MimeType_Resolve_Strategy_Interface $strategy A mime detection strategy
   *
   * @return void
   */
  public function setMimeResolveStrategy(ImageTransform_MimeType_Resolve_Strategy_Interface $strategy)
  {
    $this->mimeResolveStrategy = $strategy;
  }

  /**
   * creates a mime detection strategy by name and uses it for this instance
   *
   * @param string $name
   */
  public function setMimeResolveStrategyByStrategyName($name)
  {
    $this->setMimeResolveStrategy($this->createMimeResolveStrategy($name));
  }

  /**
   * Mime detection strategy factory method
   *
   * @throws ImageTransform_MimeType_Resolve_Strategy_Exception
   *
   * @param string $strategy
   *
   * @return ImageTransform_MimeType_Resolve_Strategy_Interface
   */
  private function createMimeResolveStrategy($strategy)
  {
    $class = 'ImageTransform_MimeType_Resolve_Strategy_' . ucfirst($strategy);

    if (!class_exists($class))
    {
      $message = 'The strategy class %s could not be loaded. Please check autoloading works correct.';
      throw new ImageTransform_MimeType_Resolve_Strategy_Exception(sprintf($message, $class));
    }

    return new $class();
  }

  /**
   * Retrieves the file´s contents
   *
   * @throws ImageTransform_File_NotFoundException
   *
   * @return string
   */
  public function toString()
  {
    if (!$this->exists())
    {
      $message = 'Cannot get contents for non exsistent file %s.';
      throw new ImageTransform_File_NotFoundException(sprintf($message, $this->getFilepath()));
    }

    return file_get_contents($this->getFilepath());
  }

  /**
   * Retrieves the file´s contents
   *
   * @see ImageTransform_File::toString()
   *
   * @throws ImageTransform_File_NotFoundException
   *
   * @return string
   */
  public function __toString()
  {
    return $this->toString();
  }
}