<?php

if (isset($_SERVER['SCRIPT_FILENAME']) && realpath($_SERVER['SCRIPT_FILENAME']) === realpath(__FILE__)) {
    http_response_code(404);
    exit;
}

if (!function_exists('webqa_boot_laravel_context')) {
    function webqa_e($value)
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }

    function webqa_asset($path)
    {
        $relative = ltrim($path, '/');
        $full = dirname(__DIR__) . '/' . $relative;
        $version = is_file($full) ? filemtime($full) : time();

        return '/' . $relative . '?v=' . $version;
    }

    function webqa_csrf_token()
    {
        return isset($GLOBALS['webqa_csrf']) ? (string) $GLOBALS['webqa_csrf'] : '';
    }

    function webqa_authenticated()
    {
        return !empty($GLOBALS['webqa_authenticated']);
    }

    function webqa_include_shared($file)
    {
        include __DIR__ . '/' . ltrim($file, '/');
    }

    function webqa_send_symfony_cookies($response)
    {
        if (headers_sent() || !$response) {
            return false;
        }

        $cookies = $response->headers->getCookies();
        if (count($cookies) === 0) {
            return false;
        }

        foreach ($cookies as $cookie) {
            $options = array(
                'expires' => $cookie->getExpiresTime(),
                'path' => $cookie->getPath() !== '' ? $cookie->getPath() : '/',
                'secure' => $cookie->isSecure(),
                'httponly' => $cookie->isHttpOnly(),
            );

            if ($cookie->getDomain()) {
                $options['domain'] = $cookie->getDomain();
            }

            if ($cookie->getSameSite()) {
                $options['samesite'] = $cookie->getSameSite();
            }

            if (!setcookie($cookie->getName(), (string) $cookie->getValue(), $options)) {
                return false;
            }
        }

        return true;
    }

    function webqa_boot_laravel_context()
    {
        static $booted = false;
        if ($booted) {
            return;
        }
        $booted = true;

        $GLOBALS['webqa_csrf'] = '';
        $GLOBALS['webqa_authenticated'] = false;

        try {
            $root = dirname(__DIR__, 2);
            require_once $root . '/vendor/autoload.php';

            $app = require $root . '/bootstrap/app.php';
            $request = \Illuminate\Http\Request::capture();
            $app->instance('request', $request);
            \Illuminate\Support\Facades\Facade::clearResolvedInstance('request');

            $app->bootstrapWith(array(
                \Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables::class,
                \Illuminate\Foundation\Bootstrap\LoadConfiguration::class,
                \Illuminate\Foundation\Bootstrap\RegisterFacades::class,
                \Illuminate\Foundation\Bootstrap\RegisterProviders::class,
                \Illuminate\Foundation\Bootstrap\BootProviders::class,
            ));

            $hadSessionCookie = $request->cookies->has((string) config('session.cookie'));

            $encrypt = $app->make(\App\Http\Middleware\EncryptCookies::class);
            $response = $encrypt->handle($request, function ($request) use ($app) {
                $start = $app->make(\Illuminate\Session\Middleware\StartSession::class);

                return $start->handle($request, function () {
                    $GLOBALS['webqa_csrf'] = csrf_token();
                    $GLOBALS['webqa_authenticated'] = auth()->check();

                    return new \Illuminate\Http\Response('');
                });
            });

            $sent = webqa_send_symfony_cookies($response);
            if (!$sent && !$hadSessionCookie) {
                $GLOBALS['webqa_csrf'] = '';
                $GLOBALS['webqa_authenticated'] = false;
            }
        } catch (\Throwable $e) {
            $GLOBALS['webqa_csrf'] = '';
            $GLOBALS['webqa_authenticated'] = false;
            error_log('WebQA shared layout session bootstrap failed: ' . $e->getMessage());
        }
    }
}
