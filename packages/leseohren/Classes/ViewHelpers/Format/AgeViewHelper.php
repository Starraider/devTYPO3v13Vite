<?php

/**
 * Age ViewHelper
 *
 * @package EXT:leseohren
 * @author Sven Kalbhenn <sven@skom.de>
 * @link https://www.skom.de
 */

namespace SKom\Leseohren\ViewHelpers\Format;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Exception;

/**
 * Renders the age of a DateTime object
 *
 * = Examples =
 *
 * <code>
 * <f:format.age>{birthday}</f:format.age>
 * </code>
 * <output>
 * 30
 * </output>
 *
 * <code title="inline syntax>
 * {person.birthday -> f:format.age()}
 * </code>
 * <output>
 * 23
 * </output>
 *
 * @api
 */
class AgeViewHelper extends AbstractViewHelper
{

    /**
     * Renders the output of this view helper
     *
     * @return string Identity
     * @api
     */
    public function render()
    {
        $date = $this->renderChildren();
        if (!$date instanceof \DateTime) {
            throw new Exception('f:format.age expects a DateTime object, ' . \gettype($date) . ' given.', 1286531071);
        }
        return $this->formatDateDifference($date);
    }

    /**
     * @param \DateTime $startDate
     * @return string
     */
    protected function formatDateDifference(\DateTime $startDate)
    {
        $endDate = new \DateTime();
        $dateInterval = $endDate->diff($startDate, true);
        return $dateInterval->y;
    }
}
