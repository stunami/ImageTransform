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
 * @subpackage Resolve_Strategy
 * @version    SVN: $Id$
 */

/**
 *
 * Composite mime detection strategy
 *
 * @category   ImageTransform
 * @package    MimeType
 * @subpackage Resolve_Strategy
 * @author     Christian Schaefer <caefer@ical.ly>
 * @author     Jan Schumann <js@schumann-it.com>
 */
class ImageTransform_MimeType_Resolve_Strategy_Composite implements ImageTransform_MimeType_Resolve_Strategy_Interface
{
  /**
   * @var array $resolvingStrategies Array of instances ImageTransform_MimeType_Resolve_Strategy_Interface
   */
  private $resolvingStrategies = array();

  /**
   * @param ImageTransform_MimeType_Resolve_Strategy_Interface[]
   */
  public function __construct(array $resolvingStrategies = array())
  {
    foreach ($resolvingStrategies as $strategy)
    {
      $this->addStrategy($strategy);
    }
  }

  /**
   * Add a new strategy
   *
   * @param ImageTransform_MimeType_Resolve_Strategy_Interface $strategy
   */
  public function addStrategy(ImageTransform_MimeType_Resolve_Strategy_Interface $strategy)
  {
    if (!array_key_exists(get_class($strategy), $this->resolvingStrategies))
    {
      $this->resolvingStrategies[get_class($strategy)] = $strategy;
    }
  }

  /**
   * (non-PHPdoc)
   * @see ImageTransform/MimeType/Resolve/Strategy/Interface#resolve()
   */
  public function resolve($filepath)
  {
    $resolvedMimeType = false;

    do
    {
      $resolvedMimeType = current($this->resolvingStrategies)->resolve($filepath);
    }
    while (false === $resolvedMimeType && next($this->resolvingStrategies))
    ;

    return $resolvedMimeType;
  }
}
