<?php

namespace Greggilbert\Recaptcha;

use Greggilbert\Recaptcha\Service\RecaptchaInterface;
use Illuminate\View\View;

class Recaptcha
{
    /**
     * @var RecaptchaInterface
     */
    protected $service;

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var array
     */
    protected $dataParameterKeys = [
        'theme',
        'type',
        'callback',
        'tabindex',
        'expired-callback',
        'badge',
        'size',
    ];


    /**
     * @param $service
     * @param $config
     */
    public function __construct(
        RecaptchaInterface $service,
        array $config
    ) {
        $this->service = $service;
        $this->config = $config;
    }

    /**
     * Render the recaptcha
     *
     * @param array $options
     *
     * @return View
     */
    public function render(
        array $options = []
    ) {
        $mergedOptions = array_merge($this->config['options'], $options);

        $data = [
            'public_key' => value($this->config['public_key']),
            'options' => $mergedOptions,
            'dataParams' => $this->extractDataParams($mergedOptions),
        ];

        if (array_key_exists('lang', $mergedOptions) && "" !== trim($mergedOptions['lang'])) {
            $data['lang'] = $mergedOptions['lang'];
        }

        $view = $this->getView($options);

        return app('view')->make($view, $data);
    }

    /**
     * Generate the view path
     *
     * @param array $options
     *
     * @return string
     */
    protected function getView(
        array $options = []
    ): string {
        $view = 'recaptcha::' . $this->service->getTemplate();

        $configTemplate = $this->config['template'];

        if (array_key_exists('template', $options)) {
            $view = $options['template'];
        } elseif ("" !== trim($configTemplate)) {
            $view = $configTemplate;
        }

        return $view;
    }

    /**
     * Extract the parameters to be converted to data-* attributes
     * See the docs at https://developers.google.com/recaptcha/docs/display
     *
     * @param array $options
     *
     * @return array
     */
    protected function extractDataParams(
        array $options = []
    ): array {
        return array_only($options, $this->dataParameterKeys);
    }
}
