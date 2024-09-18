<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function handle(Request $request, int $type = HttpKernelInterface::MAIN_REQUEST, bool $catch = true): Response
    {
        $start = microtime(true);
        $response = parent::handle($request, $type, $catch);

        $executionTime = round((microtime(true) - $start) * 1000);
        $peakMemoryUsage = round(memory_get_peak_usage()/1024);

        $response->headers->set('X-Debug-Time', $executionTime.' ms');
        $response->headers->set('X-Debug-Memory', $peakMemoryUsage . ' KB');
        
        return $response;
    }
}
