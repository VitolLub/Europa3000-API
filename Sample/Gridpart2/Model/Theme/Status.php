<?php
namespace Sample\Gridpart2\Model\Theme;



class Status implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var \Ashsmith\Blog\Model\Post
     */
    protected $_template;

    /**
     * Constructor
     *
     * @param \Sample\Gridpart2\Model\Template $template
     */
    public function __construct(\Sample\Gridpart2\Model\Template $template)
    {
        $this->_template =  $template;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $availableOptions = $this->_template->getAvailableStatuses();
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
