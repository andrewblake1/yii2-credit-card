<?php
/**
 * @copyright Copyright &copy; 2015 Andrew Blake
 * @package andrewblake1\yii2-credit-card
 * @license https://github.com/andrewblake1/yii2-credit-card/blob/master/LICENSE.md MIT License
 * @link https://github.com/andrewblake1/yii2-credit-card
 * @version 1.1.1
 */
namespace andrewblake1\creditcard;

use kartik\base\Config;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseHtml;
use yii\helpers\Html;
use yii\validators\StringValidator;

/**
 * Extends \kartik\base\InputWidget in order to add the ability to not add a name attribute to an input. This is
 * significant when you don't want the input to be submitted for security reasons. Stripe (and I think Braintree if I
 * recall correctly) provide javascript API the will take accept the values and return a token to be submitted instead.
 *
 * This helps for PCI compliance.
 *
 * @author Andrew Blake <admin@newzealandfishing.com>
 */
class InputWidget extends \kartik\base\InputWidget
{
    /**
     * @var string/boolean the addon content
     */
    public $addon;

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
     * @var string use [[right]] or [[left]] type of addon
     * position near to input
     */
    public $addonPosition = 'right';

    /**
     * @var array HTML attributes for the input group container
     */
    public $containerOptions = [];

    /**
     * @var string The value for the type attribute for the input
     */
    public $type = 'tel';

    /**
     * @var string The value of the auto complete attribute
     */
    public $autocomplete;

    /**
     * @var bool If true then name attribute will be added into the input. If false then it won't. This is significant
     * when you don't want the input to be submitted for security reasons. Stripe (and I think Braintree if I recall
     * correctly) provide javascript API the will take accept the values and return a token to be submitted instead.
     * This helps for PCI compliance.
     */
    public $submit = true;

    public function init()
    {
        parent::init();
        $this->_msgCat = 'creditcard';
        $this->initI18N(__DIR__);

        $this->options['type'] = $this->type;
        $this->options['autocomplete'] = $this->autocomplete;

        $this->registerAssets();
    }

    public function run()
    {
       return Html::tag('div', $this->renderInput(), $this->containerOptions);
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
        $addon = $this->addon
            ? Html::tag('span', $content, $this->addonOptions)
            : null;
        if (isset($this->size)) {
            Html::addCssClass($this->containerOptions, 'input-group-' . $this->size);
        }
        switch($this->addonPosition) {
            default:
            case 'left':
                return $addon . $this->getInput('textInput');
                break;

            case 'right':
                return $this->getInput('textInput') . $addon;
                break;
        }
    }

    /**
     * {@inheritDoc} Extends the parent to leave out code duplicated in getInput whereby name and value get set again.
     */
    protected function initInputWidget()
    {
        $this->initI18N(__DIR__, 'kvbase');
        if (!isset($this->language)) {
            $this->language = Yii::$app->language;
        }
        $this->_lang = Config::getLang($this->language);
        if ($this->pluginLoading) {
            $this->_loadIndicator = self::LOAD_PROGRESS;
        }
        $this->initDisability($this->options);
    }

    protected function getInput($type, $list = false)
    {
        if ($this->hasModel()) {
            if (isset($this->options['maxlength']) && $this->options['maxlength'] === true) {
                unset($this->options['maxlength']);
                foreach ($this->model->getActiveValidators($this->attribute) as $validator) {
                    if ($validator instanceof StringValidator && $validator->max !== null) {
                        $this->options['maxlength'] = $validator->max;
                        break;
                    }
                }
            }
            if ($this->submit) {
                $this->name = isset($this->options['name']) ? $this->options['name'] : BaseHtml::getInputName($this->model, $this->attribute);
            }
            $this->value = isset($this->options['value']) ? $this->options['value'] : BaseHtml::getAttributeValue($this->model, $this->attribute);
            if (!array_key_exists('id', $this->options)) {
                $this->options['id'] = BaseHtml::getInputId($this->model, $this->attribute);
            }
        }

        return Html::textInput($this->name, $this->value, $this->options);
    }

    public function registerAssets()
    {
        $view = $this->getView();
        CreditCardAsset::register($view);
    }

}