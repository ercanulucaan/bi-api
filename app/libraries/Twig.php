<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Twig
{
    private $config = [];

    private $functions_asis = [
        'base_url',
        'site_url',
        'current_url',
        'uri_string',
        'json_encode',
        'json_decode',
        'base64_encode',
        'option',
        'is_logged_in',
        'is_admin',
        'is_dealer',
        'account',
        'route',
        'theme',
        'x_time',
        'row',
        'rows',
        'order',
        'all',
        'insert',
        'update',
        'delete'
    ];
    private $functions_safe = [
        'form_open',
        'form_close',
        'form_error',
        'set_value',
        'form_hidden'
    ];

    private $libraries = [
        'session'
    ];

    private $functions_added = FALSE;

    private $twig;

    private $loader;

    protected $ci;

    public function __construct($params = [])
    {
        $this->ci =& get_instance();
        $currentClass = $this->ci->router->fetch_class();

        $this->config = [
            'paths' => [
                APPPATH . 'modules/' . $currentClass . '/views', VIEWPATH
            ],
            'cache' => APPPATH . 'cache/twig',
        ];

        $this->config = array_merge($this->config, $params);

        if (isset($params['functions'])) {
            $this->functions_asis = array_unique(
                array_merge($this->functions_asis, $params['functions'])
            );
        }
        if (isset($params['functions_safe'])) {
            $this->functions_safe = array_unique(
                array_merge($this->functions_safe, $params['functions_safe'])
            );
        }

        foreach($this->libraries as $value)
        {
            $this->ci->load->library($value);
            $this->addGlobal($value, $this->ci->{$value});
        }

        $this->addGlobal('security', $this->ci->security);
    }

    protected function resetTwig()
    {
        $this->twig = null;
        $this->createTwig();
    }

    protected function createTwig()
    {
        if ($this->twig !== null)
        {
            return;
        }

        if (ENVIRONMENT === 'production')
        {
            $debug = FALSE;
        }
        else
        {
            $debug = TRUE;
        }

        if ($this->loader === null)
        {
            $this->loader = new \Twig_Loader_Filesystem($this->config['paths']);
        }

        $twig = new \Twig_Environment($this->loader, [
            'cache' => $this->config['cache'],
            'debug' => $debug,
            'autoescape' => TRUE,
        ]);

        if ($debug) {
            $twig->addExtension(new \Twig_Extension_Debug());
        }

        $this->twig = $twig;
    }

    protected function setLoader($loader)
    {
        $this->loader = $loader;
    }

    public function addGlobal($name, $value)
    {
        $this->createTwig();
        $this->twig->addGlobal($name, $value);
    }

    public function display($view, $params = [])
    {
        $CI =& get_instance();
        $CI->output->set_output($this->render($view, $params));
    }

    public function render($view, $params = [])
    {
        $this->createTwig();
        $this->addFunctions();

        $view = $view . '.twig';
        return $this->twig->render($view, $params);
    }

    protected function addFunctions()
    {
        if ($this->functions_added)
        {
            return;
        }

        foreach ($this->functions_asis as $function) {
            if (function_exists($function)) {
                $this->twig->addFunction(
                    new \Twig_SimpleFunction(
                        $function,
                        $function
                    )
                );
            }
        }

        foreach ($this->functions_safe as $function) {
            if (function_exists($function)) {
                $this->twig->addFunction(
                    new \Twig_SimpleFunction(
                        $function,
                        $function,
                        ['is_safe' => ['html']]
                    )
                );
            }
        }

        if (function_exists('anchor')) {
            $this->twig->addFunction(
                new \Twig_SimpleFunction(
                    'anchor',
                    [$this, 'safe_anchor'],
                    ['is_safe' => ['html']]
                )
            );
        }

        $this->functions_added = TRUE;
    }

    public function safe_anchor($uri = '', $title = '', $attributes = [])
    {
        $uri = html_escape($uri);
        $title = html_escape($title);

        $new_attr = [];
        foreach ($attributes as $key => $val) {
            $new_attr[html_escape($key)] = html_escape($val);
        }

        return anchor($uri, $title, $new_attr);
    }

    public function getTwig()
    {
        $this->createTwig();
        return $this->twig;
    }

}