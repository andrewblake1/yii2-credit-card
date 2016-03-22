<?php
/**
 * @copyright Copyright &copy; 2015 Andrew Blake
 * @package havryliv\yii2-credit-card
 * @license https://github.com/havryliv/yii2-credit-card/blob/master/LICENSE.md MIT License
 * @link https://github.com/havryliv/yii2-credit-card
 * @version 1.0.3
 */
namespace havryliv\creditcard;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Credit card expiry widget with client validation/masking for Yii2 framework configured to use client validation
 * courtesy of stripe as per https://github.com/stripe/jquery.payment and to work with yii.activeform.js.
 *
 * @author Andrew Blake <admin@newzealandfishing.com>
 */
class CreditCardExpiry extends \kartik\base\InputWidget
{
    /**
     * @var string/boolean the addon content
     */
    public $addon = false;

    /**
     * @var array HTML attributes for the addon container
     * the following special options are identified
     * - asButton: boolean if the addon is to be displayed as a button.
     * - buttonOptions: array HTML attributes if the addon is to be
     *   displayed like a button. If [[asButton]] is true, this will
     *   default to ['class' => 'btn btn-default']
     */
    public $addonOptions = [];

    /**
     * @var array HTML attributes for the input group container
     */
    public $containerOptions = [];

    public $type = 'tel';
    public $autocomplete = 'cc-expiry';
    public $placeholder = null;     // set to empty string if wish to be empty

    public function init()
    {
        parent::init();
        $this->_msgCat = 'creditcard';
        $this->initI18N(__DIR__);

        $this->options['type'] = $this->type;
        $this->options['autocomplete'] = $this->autocomplete;
        $this->options['placeholder'] = ($this->placeholder === null)
            ? Yii::t('creditcard', 'MM / YY')
            : $this->placeholder;

        $this->registerAssets();
        echo Html::tag('div', $this->renderInput(), $this->containerOptions);
    }

    /**
     * This is largely copied from kartik\time\TimePicker
     * @return string
     */
    protected function renderInput()
    {
        Html::addCssClass($this->options, 'form-control');
        if (!empty($this->options['disabled'])) {
            Html::addCssClass($this->addonOptions, 'disabled-addon');
        }
        if (ArrayHelper::getValue($this->pluginOptions, 'template', true) === false) {
            if (isset($this->size)) {
                Html::addCssClass($this->options, 'input-' . $this->size);
                Html::addCssClass($this->addonOptions, 'inline-addon inline-addon-' . $this->size);
            } else {
                Html::addCssClass($this->addonOptions, 'inline-addon');
            }
            return $this->getInput('textInput') . Html::tag('span', $this->addon, $this->addonOptions);
        }
        Html::addCssClass($this->containerOptions, 'input-group');
        $asButton = ArrayHelper::remove($this->addonOptions, 'asButton', false);
        $buttonOptions = ArrayHelper::remove($this->addonOptions, 'buttonOptions', []);
        if ($asButton) {
            Html::addCssClass($this->addonOptions, 'input-group-btn picker');
            $buttonOptions['type'] = 'button';
            if (empty($buttonOptions['class'])) {
                Html::addCssClass($buttonOptions, 'btn btn-default');
            }
            $content = Html::button($this->addon, $buttonOptions);
        } else {
            Html::addCssClass($this->addonOptions, 'input-group-addon picker');
            $content = $this->addon;
        }
        $addon = Html::tag('span', $content, $this->addonOptions);
        if (isset($this->size)) {
            Html::addCssClass($this->containerOptions, 'input-group-' . $this->size);
        }
        return $this->getInput('textInput') . $addon;
    }

    public function registerAssets()
    {
        $view = $this->getView();
        CreditCardAsset::register($view);
        $this->registerPlugin('ccExpiry');
    }

}