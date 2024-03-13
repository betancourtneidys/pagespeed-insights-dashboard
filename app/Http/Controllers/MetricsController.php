<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Strategy;
use App\Models\MetricHistoryRun;
use Illuminate\Support\Facades\Log;

class MetricsController extends Controller
{
    // Método para mostrar el formulario
    public function showForm()
    {
        // Recupera todas las categorías y estrategias de la base de datos
        $categories = Category::all();
        $strategies = Strategy::all();

        // Retorna la vista pasando las categorías y estrategias
        return view('metrics_form', compact('categories', 'strategies'));
    }

    // Método para hacer la solicitud a la API de Google PageSpeed Insights
    public function getPageSpeedMetrics(Request $request)
    {
        $client = new Client();

        // Recolecta los datos del formulario
        $url = $request->url;
        $categories = $request->categories;
        $strategy = $request->strategy;
        $apiKey = env('GOOGLE_PAGESPEED_API_KEY');

        // Construye la query string para la solicitud a la API
        $queryParams = http_build_query(['url' => $url, 'key' => $apiKey, 'strategy' => $strategy]);
        foreach ($categories as $category) {
            $queryParams .= "&category=$category";
        }

        $urlWithParams = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?$queryParams";
        Log::debug("Request URL:", ['url' => $urlWithParams]);

        // Realiza la solicitud a la API de Google PageSpeed Insights
        $response = $client->request('GET', $urlWithParams);

        // Decodifica y retorna la respuesta JSON
        return json_decode($response->getBody(), true);
    }

    // Muestra el historial de métricas guardadas.
    public function showHistory()
    {
        // Recupera el historial incluyendo la estrategia relacionada
        $metricRun = MetricHistoryRun::with('strategy')->get();

        Log::info('Metric history retrieved.', ['metrics' => $metricRun]);

        // Retorna la vista del historial pasando los resultados
        return view('metric-history', compact('metricRun'));
    }

    // Almacena un registro de métricas en la base de datos.
    public function store(Request $request)
    {
        // Valida los campos requeridos y asegura que las métricas sean numéricas entre 0 y 1
        $request->validate([
            'url' => 'required|url',
            'strategy' => 'required|string',
            'performance_metric' => 'nullable|numeric|between:0,1',
            'accessibility_metric' => 'nullable|numeric|between:0,1',
            'best_practices_metric' => 'nullable|numeric|between:0,1',
            'seo_metric' => 'nullable|numeric|between:0,1',
            'pwa_metric' => 'nullable|numeric|between:0,1',
        ]);

        // Encuentra el ID de la estrategia basado en el nombre
        $strategy = Strategy::where('name', $request->strategy)->first();

        // Crea el registro de métricas en la base de datos
        $metricRun = MetricHistoryRun::create([
            'url' => $request->url,
            'strategy_id' => $strategy->id, // Use the found strategy_id
            'performance_metric' => $request->performance_metric,
            'accessibility_metric' => $request->accessibility_metric,
            'best_practices_metric' => $request->best_practices_metric,
            'seo_metric' => $request->seo_metric,
            'pwa_metric' => $request->pwa_metric,
        ]);

        // Retorna una respuesta JSON indicando el éxito de la operación
        return response()->json([
            'message' => 'Metric Run saved successfully!',
            'data' => $metricRun
        ]);
    }
}
