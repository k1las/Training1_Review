<?php
namespace Custom\Training1_Review\Model;

/**
 * Class Review
 *
 * @package Custom\Training1_Review\Model
 */
class Review extends \Magento\Review\Model\Review
{
    /**
     * Validate review summary fields
     *
     * @return bool|string[]
     */
    public function validate()
    {
        $errors = [];

        if (!\Zend_Validate::is($this->getTitle(), 'NotEmpty')) {
            $errors[] = __('Please enter a review summary.');
        }

        if (!\Zend_Validate::is($this->getNickname(), 'NotEmpty')) {
            $errors[] = __('Please enter a nickname.');
        }

        if (strpos($this->getNickname(), '-')) {
            $errors[] = __('Please enter a nickname without dashes.');
        }

        if (!\Zend_Validate::is($this->getDetail(), 'NotEmpty')) {
            $errors[] = __('Please enter a review.');
        }

        if (empty($errors)) {
            return true;
        }
        return $errors;
    }
}
