<?php
namespace Sample\Gridpart2\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class TemplatestatusActions extends Column
{
    /** Url path */
    const BLOG_URL_PATH_EDIT = 'gridpart2/template/edit';
    const BLOG_URL_PATH_DELETE = 'gridpart2/template/run';

    /** @var UrlInterface */
    protected $urlBuilder;

    /**
     * @var string
     */
    private $editUrl;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     * @param string $editUrl
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrl = self::BLOG_URL_PATH_EDIT
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->editUrl = $editUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
       
                if (isset($item['apisynchronization_id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl($this->editUrl, ['id' => $item['apisynchronization_id']]),
                        'label' => __('Edit')
                    ];
                    $item[$name]['run'] = [
                        'href' => $this->urlBuilder->getUrl(self::BLOG_URL_PATH_DELETE, ['id' => $item['apisynchronization_id']]),
                        'label' => __('Run'),
                        'confirm' => [
                            'title' => __('Run "${ $.$data.name }"'),
                            'message' => __('Are you sure you wan\'t to run a "${ $.$data.name }" record?')
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}
