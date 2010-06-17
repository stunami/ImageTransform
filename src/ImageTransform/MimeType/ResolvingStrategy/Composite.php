<?php
/*
 * This file is part of the sfImageTransform package.
 * (c) 2007 Stuart Lowes <stuart.lowes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * MimeType_ResolvingStrategy_Composite
 *
 * ...
 *
 * @package    sfImageTransform
 * @subpackage MimeType_ResolvingStrategy
 * @author     Christian Schaefer <caefer@ical.ly>
 * @version    SVN: $Id$
 */
class MimeType_ResolvingStrategy_Composite implements MimeType_ResolvingStrategy_Interface
{
  /**
   * @var array $resolvingStrategies Array of instances implementing MimeType_ResolvingStrategy_Interface
   */
  private $resolvingStrategies = array();

  /**
   *
   */
  public function __construct(array $resolvingStrategies)
  {
    $this->resolvingStrategies = $resolvingStrategies;
  }

  /**
   * Resolve and return mime type of given filepath
   * 
   * @param  string $filepath Absolute path to the file of which to detect the mime type
   * @return string           The resolved mime type or boolean false
   */
  public function resolve($filepath)
  {
    $resolvedMimeType = false;

    do
    {
      $resolvedMimeType = current($this->resolvingStrategies)->resolve($filepath);
    }
    while(false === $resolvedMimeType && next($this->resolvingStrategies));

    return $resolvedMimeType;
  }
}
