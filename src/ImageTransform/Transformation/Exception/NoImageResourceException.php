<?php
/**
 * This file is part of the ImageTransform package.
 * (c) Christian Schaefer <caefer@ical.ly>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ImageTransform\Transformation\Exception;

/**
 * Exception for calls to methods not defined in a registered delegate
 *
 * @author Christian Schaefer <caefer@ical.ly>
 */
class NoImageResourceException extends \BadMethodCallException
{
}
