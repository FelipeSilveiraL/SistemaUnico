<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\unico\querys\QueryDepartamento;
use App\Http\Controllers\unico\querys\QueryEmpresa;

class LoadUserVariables
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (auth()->check()) {
            $idEmpresa = auth()->user()->empresa;
            $idDepartamento = auth()->user()->depto;

            $queryEmpresa = new QueryEmpresa();

            $empresaUser = $queryEmpresa->buscaEmpresaBpmgp($idEmpresa);
            $empresaAll = $queryEmpresa->buscaEmpresaBpmgp($idEmpresa = null);

            $queryDepartamento = new QueryDepartamento();
            $departUser = $queryDepartamento->listaDepartamentoUser($idDepartamento);
            $departamento = $queryDepartamento->listaDepartamento();

            // Passa as variáveis para todas as views
            view()->share(compact('empresaUser', 'empresaAll', 'departUser', 'departamento'));
        }

        return $next($request);
    }
}
