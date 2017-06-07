<?php
namespace Sample\Gridpart2\Helper;

/**
 * Default review helper
 */
class Option extends \Magento\Framework\App\Helper\AbstractHelper
{
    
    /**
     * Filter manager
     *
     * @var \Magento\Framework\Filter\FilterManager
     */
    protected $filter;

    /**
     * Escaper
     *
     * @var \Magento\Framework\Escaper
     */
    protected $_escaper;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Escaper $escaper
     * @param \Magento\Framework\Filter\FilterManager $filter
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Escaper $escaper,
        \Magento\Framework\Filter\FilterManager $filter
    ) {
        $this->_escaper = $escaper;
        $this->filter = $filter;
        parent::__construct($context);
    }
    
    
    /**
     * Get review statuses with their codes
     *
     * @return array
     */
    public function getStatuses()
    {
        return [
            \Magento\Review\Model\Review::STATUS_APPROVED => __('Active'),
            \Magento\Review\Model\Review::STATUS_PENDING => __('Deactive')
        ];
    }
    
    /**
     * Get review statuses as option array
     *
     * @return array
     */
    public function getStatusesOptionArray()
    {
        $result = [];
        foreach ($this->getStatuses() as $value => $label) {
            $result[] = ['value' => $value, 'label' => $label];
        }

        return $result;
    }

}
