<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Opengento\CatalogSortOrder\Block\Adminhtml\Config\Form\Field;

use Magento\Backend\Block\Template\Context;
use Magento\Catalog\Model\Config\Source\ListSort;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Config\Model\Config\Source\Yesno;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Phrase;
use Magento\Framework\View\Element\Html\Select;

class SortOrder extends AbstractFieldArray
{
    public function __construct(
        Context $context,
        private ListSort $listSort,
        private Yesno $yesno,
        array $data = [],
    ) {
        parent::__construct($context, $data);
    }

    /**
     * @throws LocalizedException
     */
    public function getAttributesSelectRenderer(): Select
    {
        if (!$this->hasData('attributes_select_renderer')) {
            $this->setData(
                'attributes_select_renderer',
                $this->createSelectRenderer('attribute_code', $this->listSort)
            );
        }

        return $this->_getData('attributes_select_renderer');
    }

    /**
     * @throws LocalizedException
     */
    public function getYesNoSelectRenderer(): Select
    {
        if (!$this->hasData('yesno_select_renderer')) {
            $this->setData(
                'yesno_select_renderer',
                $this->createSelectRenderer('include_direction', $this->yesno)
            );
        }

        return $this->_getData('yesno_select_renderer');
    }

    /**
     * @throws LocalizedException
     */
    protected function _prepareToRender(): void
    {
        $this->addColumn('attribute_code', [
            'label' => new Phrase('Attribute'),
            'renderer' => $this->getAttributesSelectRenderer(),
        ]);
        $this->addColumn('attribute_label', [
            'label' => new Phrase('Label'),
            'comment' => new Phrase('Leave blank to use default label.'),
        ]);
        $this->addColumn('include_direction', [
            'label' => new Phrase('Include Direction'),
            'renderer' => $this->getYesNoSelectRenderer(),
        ]);
    }

    /**
     * @throws LocalizedException
     */
    protected function _prepareArrayRow(DataObject $row): void
    {
        $row->setData(
            'option_extra_attrs',
            [
                'option_' . $this->getAttributesSelectRenderer()->calcOptionHash($row->getData('attribute_code')) => 'selected="selected"',
                'option_' . $this->getYesNoSelectRenderer()->calcOptionHash($row->getData('include_direction')) => 'selected="selected"'
            ]
        );
    }

    /**
     * @throws LocalizedException
     */
    private function createSelectRenderer(string $name, OptionSourceInterface $optionSource): Select
    {
        /** @var Select $select */
        $select = $this->getLayout()->createBlock(Select::class, '', ['data' => ['is_render_to_js_template' => true]]);
        $select->setData('name', $this->_getCellInputElementName($name));
        $select->setOptions($optionSource->toOptionArray());

        return $select;
    }
}
