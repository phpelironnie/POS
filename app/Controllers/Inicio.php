<?php

namespace App\Controllers;

use App\Models\ProductosModel;
use App\Models\VentasModel;

class Inicio extends BaseController
{
    protected $productoModel, $ventasModel;

    public function __construct()
    {
        $this->ventasModel      = new VentasModel();
        $this->productoModel    = new ProductosModel();
    }

    public function index()
    {
        $totalProductos     = $this->productoModel->totalProductos();
        $totalVentas        = $this->ventasModel->totalDia(date('Y-m-d'));
        $NumeroVentas       = $this->ventasModel->VentaDia(date('Y-m-d')); //año-mes-dia
        $minimos            = $this->productoModel->productosMinimo();

        $productosnombre = $this->productoModel->where('activo',1)->findAll();

        $datos = ['totalProductos' => $totalProductos, 'productosnombre' => $productosnombre, 'NumeroVentas' => $NumeroVentas, 'totalVentas' => $totalVentas, 'minimos' => $minimos];

        echo view('header');
        echo view('dashboard', $datos);
        echo view('footer');
    }
}
