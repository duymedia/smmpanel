<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceApi;
use App\Models\ServiceSyncLog;
use App\Models\Category;
use App\Models\Platform;
use App\Models\Language;
use App\Models\ApiProvider;
use App\Models\Config;
use App\Smm\Smm;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function serviceOptions(array $data): array
    {
        $array = static function ($value, array $default = []): array {
            if (is_string($value)) $value = json_decode($value, true);
            return is_array($value) ? $value : $default;
        };
        $bool = static fn($value): int => filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;

        $check = $array($data['check_count_data'] ?? null, [
            'type' => 'youtube-view',
            'percent' => 0,
            'auto' => 0,
        ]);
        $check['type'] = trim((string) ($check['type'] ?? 'youtube-view'));
        $check['percent'] = max(0, min(100, (int) ($check['percent'] ?? 0)));
        $check['auto'] = $bool($check['auto'] ?? 0);

        $advanced = $array($data['advanced_settings_data'] ?? null, [
            'min_balance' => 0,
            'max_order' => 0,
        ]);
        $advanced['min_balance'] = max(0, (float) ($advanced['min_balance'] ?? 0));
        $advanced['max_order'] = max(0, (int) ($advanced['max_order'] ?? 0));

        return [
            'quantity_discount' => $bool($data['quantity_discount'] ?? 0),
            'quantity_discount_data' => $array($data['quantity_discount_data'] ?? null),
            'advanced_settings' => $bool($data['advanced_settings'] ?? 0),
            'advanced_settings_data' => $advanced,
            'check_count' => $bool($data['check_count'] ?? 0),
            'check_count_data' => $check,
            'hidden_api' => $bool($data['hidden_api'] ?? 0),
            'change_provider' => $bool($data['change_provider'] ?? 0),
            'summaries' => $array($data['summaries'] ?? null),
        ];
    }


    public function processNameField(array $nameData): array
    {

        $nameData = array_map(function ($name) {
            return trim(strip_tags($name));
        }, $nameData);

        if (empty($nameData['en'])) {
            throw new \InvalidArgumentException('T?n ti?ng Anh l? b?t bu?c');
        }


        $nameData = array_filter($nameData, function ($name) {
            return !empty($name);
        });

        return $nameData;
    }


    public function processAttributesField($attributesFromRequest): array
    {
        $attributes = [];

        if ($attributesFromRequest === null || $attributesFromRequest === '' || $attributesFromRequest === []) {
            return $attributes;
        }
        
        if (is_string($attributesFromRequest) && !empty($attributesFromRequest)) {
            try {
                $decoded = json_decode($attributesFromRequest, true);
                if (is_array($decoded)) {
                    $attributes = $decoded;
                }
            } catch (\Exception $e) {
                return [];
            }
        } elseif (is_array($attributesFromRequest)) {

            $attributes = $attributesFromRequest;
        }


        $attributes = array_filter($attributes, function ($item) {
            return !empty($item) && is_string($item);
        });


        $attributes = array_values($attributes);


        $attributes = array_map(function ($attr) {
            return trim($attr);
        }, $attributes);


        $attributes = array_unique($attributes);


        $attributes = array_values($attributes);




        return is_array($attributes) ? $attributes : [];
    }



    public function logServiceUpdate(Service $service, array $validated, array $originals = []): void
    {
        $map = [
            'rate_original' => ['rate',   'price_increase', 'price_decrease'],
            'min'           => ['min',    'min_max_change', 'min_max_change'],
            'max'           => ['max',    'min_max_change', 'min_max_change'],
            'refill'        => ['refill', 'enable',         'disable'],
            'cancel'        => ['cancel', 'enable',         'disable'],
        ];

        $domain = getDomain();
        $now    = now();
        $rows   = [];

        foreach ($map as $key => [$field, $typeUp, $typeDown]) {
            if (!array_key_exists($key, $validated)) continue;

            $newVal = $validated[$key];
            $oldVal = $originals[$key] ?? $service->getOriginal($key);

            if ((string) $newVal === (string) $oldVal) continue;

            $rows[] = [
                'service_id'    => $service->id,
                'provider_id'   => $service->provider_id,
                'provider_name' => $service->provider_name,
                'service_api'   => $service->service_api,
                'change_type'   => (float) $newVal > (float) $oldVal ? $typeUp : $typeDown,
                'old_value'     => $oldVal,
                'new_value'     => $newVal,
                'field_changed' => $field,
                'is_read'       => 0,
                'domain'        => $domain,
                'log_type'      => 'website',
                'created_at'    => $now,
                'updated_at'    => $now,
            ];
        }

        if (!empty($rows)) {
            DB::table('service_sync_logs')->insert($rows);
        }
    }

    public function processReactionField($reactionInput): ?string
    {

        if (is_null($reactionInput) || $reactionInput === '') {
            return null;
        }


        $reaction = trim($reactionInput);


        if (empty($reaction)) {
            return null;
        }


        $reaction = strtoupper($reaction);


        $reaction = preg_replace('/\s+/', ' ', $reaction);


        if (!preg_match('/^[A-Z0-9\s,\-]+$/', $reaction)) {
            throw new \InvalidArgumentException('Reaction ch? ???c ch?a ch? c?i, s?, d?u ph?y v? d?u g?ch ngang');
        }


        return $reaction;
    }
    public function index(Request $request)
    {

        if ($request->isMethod('PUT') && $request->input('action') === 'reorder') {
            return $this->reorder($request);
        }


        $query = Service::query()
            ->with(['category:id,name,platform_id,image', 'category.platform:id,name,image'])
            ->where('domain', getDomain());


        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                    ->orWhere('name->en', 'like', '%' . $search . '%')
                    ->orWhere('name->vi', 'like', '%' . $search . '%')
                    ->orWhere('title', 'like', '%' . $search . '%');
            });
        }


        $sortBy = $request->get('sort_by', 'position');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder)->orderBy('id', 'desc');


        $services = $query->paginate(50);


        if ($request->expectsJson() || $request->ajax()) {
            $html = view('admin.services.partials.services-list', compact('services'))->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'data' => $services
            ]);
        }


        $platforms = Platform::where('domain', getDomain())
            ->where('status', 1)
            ->orderBy('position', 'asc')
            ->get();


        $allCategories = Category::where('domain', getDomain())
            ->with(['platform:id,name,image', 'services' => function ($q) {
                $q->orderBy('position', 'asc');
            }])
            ->orderBy('position', 'asc')
            ->get();


        $plat_cat = [];
        foreach ($platforms as $platform) {
            $platformData = [
                'id' => $platform->id,
                'name' => $platform->name,
                'image' => $platform->image,
                'position' => $platform->position,
                'categories' => []
            ];


            $platformCategories = $allCategories->where('platform_id', $platform->id);

            foreach ($platformCategories as $category) {
                $categoryData = [
                    'id' => $category->id,
                    'name' => $category->getName('en'),
                    'image' => $category->image,
                    'position' => $category->position,
                    'services' => $category->services ?? collect()
                ];

                $platformData['categories'][] = $categoryData;
            }

            if (!empty($platformData['categories'])) {
                $plat_cat[] = $platformData;
            }
        }


        $languages = Language::where('status', true)
            ->where('domain', getDomain())
            ->select('id', 'name', 'code', 'flag')
            ->get();

        $providers = ApiProvider::where('domain', getDomain())
            ->where('status', true)
            ->select('id', 'name', 'link')
            ->orderBy('name')
            ->get();

        return view('admin.services.index', compact('services', 'plat_cat', 'languages', 'providers'));
    }


    public function reorder(Request $request)
    {
        try {
            $services = $request->input('services', []);

            foreach ($services as $item) {
                Service::where('id', $item['id'])->update(['position' => $item['position']]);
            }

            return response()->json([
                'success' => adminMessage('update')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'C? l?i x?y ra: ' . $e->getMessage()
            ], 500);
        }
    }


    public function add(Request $request)
    {
        $categories = Category::with('platform')->where('domain', getDomain())->get();
        $languages = Language::where('status', true)->where('code', '!=', 'en')->where('domain', getDomain())->orderBy('code')->get();
        $providers = ApiProvider::where('domain', getDomain())
            ->where('status', true)
            ->orderBy('name')
            ->get();
        $config = Config::first();
        $markupConfig = [
            'markup_retail' => ($config && $config->markup_retail > 0) ? $config->markup_retail : 110.0,
            'markup_agent' => ($config && $config->markup_agent > 0) ? $config->markup_agent : 108.0,
            'markup_distributor' => ($config && $config->markup_distributor > 0) ? $config->markup_distributor : 105.0
        ];

        return view('admin.services.add', compact('categories', 'languages', 'markupConfig', 'providers'));
    }


    public function create(Request $request)
    {
        $categories = Category::with('platform')->where('domain', getDomain())->get();
        $languages = Language::where('status', true)->where('code', '!=', 'en')->where('domain', getDomain())->orderBy('code')->get();

        $providers = ApiProvider::where('domain', getDomain())
            ->where('status', true)
            ->orderBy('name')
            ->get();



        $config = Config::first();


        $markupConfig = [
            'markup_retail' => ($config && $config->markup_retail > 0) ? $config->markup_retail : 110.0,
            'markup_agent' => ($config && $config->markup_agent > 0) ? $config->markup_agent : 108.0,
            'markup_distributor' => ($config && $config->markup_distributor > 0) ? $config->markup_distributor : 105.0
        ];



        return view('admin.services.create', compact('categories', 'languages', 'markupConfig', 'providers'));
    }


    public function import(Request $request)
    {
        $categories = Category::with('platform')->where('domain', getDomain())->get();
        $providers = ApiProvider::where('domain', getDomain())
            ->where('status', true)
            ->select('id', 'name', 'rate_api', 'fixed_decimal')
            ->orderBy('name')
            ->get();


        $config = Config::first();
        $markupConfig = [
            'markup_retail' => ($config && $config->markup_retail > 0) ? $config->markup_retail : 110.0,
            'markup_agent' => ($config && $config->markup_agent > 0) ? $config->markup_agent : 108.0,
            'markup_distributor' => ($config && $config->markup_distributor > 0) ? $config->markup_distributor : 105.0
        ];

        return view('admin.services.import', compact('categories', 'providers', 'markupConfig'));
    }


    public function storeImport(Request $request)
    {
        try {
            $payload = $this->normalizeImportPayload($request);

            $validated = validator($payload, [
                'category_id' => 'required|integer',
                'provider_id' => 'required|exists:api_providers,id',
                'services' => 'required|array|min:1',
                'services.*' => 'required|integer',
                'services_data' => 'required|array|min:1',
                'services_data.*.service_id' => 'required|integer',
                'services_data.*.rate_original' => 'sometimes|numeric|min:0',
                'services_data.*.rate_retail' => 'required|numeric|min:0',
                'services_data.*.rate_agent' => 'required|numeric|min:0',
                'services_data.*.rate_distributor' => 'required|numeric|min:0',
                'services_data.*.rate_retail_up' => 'required|numeric|min:0',
                'services_data.*.rate_agent_up' => 'required|numeric|min:0',
                'services_data.*.rate_distributor_up' => 'required|numeric|min:0',
                'services_data.*.sync_enabled' => 'sometimes|boolean',
                'markup_config' => 'required|array',
                'markup_config.markup_retail' => 'required|numeric|min:0',
                'markup_config.markup_agent' => 'required|numeric|min:0',
                'markup_config.markup_distributor' => 'required|numeric|min:0'
            ])->validate();

            $category = Category::where('domain', getDomain())
                ->whereKey($validated['category_id'])
                ->first();

            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Danh mục không tồn tại hoặc không thuộc tên miền hiện tại.',
                    'errors' => ['category_id' => ['Danh mục đã chọn không hợp lệ.']],
                ], 422);
            }



            $provider = ApiProvider::where('domain', getDomain())
                ->where('id', $validated['provider_id'])
                ->where('status', true)
                ->firstOrFail();


            $providerServices = $this->providerServices($provider);

            if (isset($providerServices['error'])) {
                return response()->json([
                    'success' => false,
                    'message' => is_array($providerServices)
                        ? ($providerServices['error'] ?? 'Kh?ng th? l?y danh s?ch d?ch v?')
                        : 'Kh?ng th? l?y danh s?ch d?ch v?'
                ], 400);
            }

            $providerServices = $this->normalizeProviderServicesForImport($providerServices);


            $psMap = [];
            foreach ($providerServices as $ps) {

                if (is_object($ps)) {
                    $ps = json_decode(json_encode($ps), true);
                }

                $serviceId = $ps['service'] ?? $ps['id'] ?? null;
                if ($serviceId) {
                    $psMap[$serviceId] = $ps;
                }
            }


            $categoryImage = $category->image;
            $errors = [];
            $imported = 0;
            $serviceRecords = [];
            $importedServices = [];


            foreach ($validated['services_data'] as $index => $serviceData) {
                $serviceId = $serviceData['service_id'];


                if (!isset($psMap[$serviceId])) {
                    $errors[] = "M? d?ch v? {$serviceId} kh?ng t?m th?y";
                    continue;
                }

                $ps = $psMap[$serviceId];
                $rate = floatval($ps['rate'] ?? 0);

                if ($rate <= 0 || empty($ps['name'])) {
                    $errors[] = "M? d?ch v? {$serviceId} c? d? li?u kh?ng h?p l?";
                    continue;
                }


                $rRetail = floatval($serviceData['rate_retail']);
                $rAgent = floatval($serviceData['rate_agent']);
                $rDist = floatval($serviceData['rate_distributor']);
                $rRetailUp = floatval($serviceData['rate_retail_up']);
                $rAgentUp = floatval($serviceData['rate_agent_up']);
                $rDistUp = floatval($serviceData['rate_distributor_up']);
                $sync = (bool)($serviceData['sync_enabled'] ?? true);
                $rateOriginal = array_key_exists('rate_original', $serviceData)
                    ? floatval($serviceData['rate_original'])
                    : $rate;


                $serviceRecords[] = [
                    'category_id' => $validated['category_id'],
                    'type' => 'api',
                    'type_service' => $ps['type'] ?? '0',
                    'name' => json_encode(['en' => $ps['name']]),
                    'title' => $ps['title'] ?? $ps['name'],
                    'description' => $ps['description'] ?? $ps['desc'] ?? '',
                    'image' => $categoryImage,
                    'rate_original' => $rateOriginal,
                    'rate_retail' => $rRetail,
                    'rate_agent' => $rAgent,
                    'rate_distributor' => $rDist,
                    'rate_retail_up' => $rRetailUp,
                    'rate_agent_up' => $rAgentUp,
                    'rate_distributor_up' => $rDistUp,
                    'min' => max(1, intval($ps['min'] ?? 1)),
                    'max' => max(1, intval($ps['max'] ?? 10000)),
                    'refill' => (bool)($ps['refill'] ?? false) ? 1 : 0,
                    'cancel' => (bool)($ps['cancel'] ?? false) ? 1 : 0,
                    'dripfeed' => (bool)($ps['dripfeed'] ?? false) ? 1 : 0,
                    'status' => 1,
                    'sync_rate' => $sync ? 1 : 0,
                    'sync_min_max' => $sync ? 1 : 0,
                    'sync_refill' => $sync ? 1 : 0,
                    'sync_cancel' => $sync ? 1 : 0,
                    'sync_status' => $sync ? 1 : 0,
                    'service_api' => $serviceId,
                    'provider_id' => $provider->id,
                    'provider_name' => $provider->name,
                    'domain' => getDomain(),
                    'position' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                $imported++;
                $importedServices[] = [
                    'service_id' => $serviceId,
                ];
            }



            if (!empty($serviceRecords)) {

                Service::query()->upsert(
                    $serviceRecords,
                    ['service_api', 'domain', 'provider_id'],
                    ['category_id', 'rate_original', 'rate_retail', 'rate_agent', 'rate_distributor', 'rate_retail_up', 'rate_agent_up', 'rate_distributor_up', 'sync_rate', 'sync_min_max', 'sync_refill', 'sync_cancel', 'sync_status', 'updated_at']
                );


                $persistedServices = Service::query()
                    ->where('domain', getDomain())
                    ->where('provider_id', $provider->id)
                    ->whereIn('service_api', array_column($serviceRecords, 'service_api'))
                    ->get(['id', 'service_api'])
                    ->keyBy('service_api');

                $importedServices = array_values(array_map(function ($item) use ($persistedServices) {
                    $persisted = $persistedServices->get($item['service_id']);

                    return [
                        'id' => $persisted?->id,
                        'service_id' => $item['service_id'],
                    ];
                }, $importedServices));
            }


            return response()->json([
                'success' => true,
                    'message' => 'Th?m d?ch v? th?nh c?ng.',
                'data' => [
                    'imported_count' => $imported,
                    'error_count' => count($errors),
                    'imported_services' => $importedServices,
                    'error_services' => $errors,
                ]
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu nhập chưa hợp lệ.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:api,manual',
            'type_service' => 'nullable|string',
            'name' => 'required|array',
            'name.en' => 'required|string|max:255',
            'name.*' => 'nullable|string|max:255',
            'rate_original' => 'nullable|numeric|min:0|required_if:type,manual',
            'rate_retail' => 'required|numeric|min:0',
            'rate_agent' => 'required|numeric|min:0',
            'rate_distributor' => 'required|numeric|min:0',
            'rate_retail_up' => 'nullable|numeric|min:0',
            'rate_agent_up' => 'nullable|numeric|min:0',
            'rate_distributor_up' => 'nullable|numeric|min:0',
            'provider_id' => 'nullable|string|required_if:type,api',
            'provider_service_id' => 'nullable|string|required_if:type,api',
            'provider_name' => 'nullable|string',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:500',
            'attributes' => 'nullable|array',
            'attributes.*' => 'nullable|string|max:255',
            'min' => 'nullable|integer|min:1',
            'max' => 'nullable|integer|min:1',
            'position' => 'nullable|integer|min:0',
            'average_time' => 'nullable|string|max:255',
            'note' => 'nullable|string',
            'reaction' => 'nullable|string|max:500',
            'sync_rate' => 'sometimes|nullable',
            'sync_min_max' => 'sometimes|nullable',
            'sync_refill' => 'sometimes|nullable',
            'sync_cancel' => 'sometimes|nullable',
            'sync_status' => 'sometimes|nullable',
            'service_api' => 'sometimes|nullable|string'
        ]);


        $validated['min'] = $validated['min'] ?? 1;
        $validated['max'] = $validated['max'] ?? 10000;


        $imageInput = $request->input('image');
        if ($imageInput && filter_var($imageInput, FILTER_VALIDATE_URL)) {
            $validated['image'] = $imageInput;
        } else {
            $category = Category::find($validated['category_id']);
            $validated['image'] = ($category && !empty($category->image)) ? $category->image : null;
        }


        if (isset($validated['name'])) {
            $validated['name'] = $this->processNameField($validated['name']);
        }


        $validated['status'] = $request->boolean('status', false);
        $validated['refill'] = $request->boolean('refill', false);
        $validated['cancel'] = $request->boolean('cancel', false);
        $validated['dripfeed'] = $request->boolean('dripfeed', false);
        $validated['sync_rate'] = $request->boolean('sync_rate', false);
        $validated['sync_min_max'] = $request->boolean('sync_min_max', false);
        $validated['sync_refill'] = $request->boolean('sync_refill', false);
        $validated['sync_cancel'] = $request->boolean('sync_cancel', false);
        $validated['sync_status'] = $request->boolean('sync_status', false);
        $validated['domain'] = getDomain();


        if ($validated['type'] === 'api') {
            if (isset($validated['provider_service_id']) && $validated['provider_service_id']) {
                $validated['service_api'] = $validated['provider_service_id'];
            } elseif ($request->has('service_api') && $request->input('service_api')) {
                $validated['service_api'] = $request->input('service_api');
            }
        } else {

            $validated['provider_id'] = null;
            $validated['provider_name'] = null;
            $validated['service_api'] = null;
        }


        $validated['attributes'] = $this->processAttributesField($request->input('attributes'));




        if ($request->has('reaction')) {
            try {
                $validated['reaction'] = $this->processReactionField($request->input('reaction'));
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'L?i x? l? reaction: ' . $e->getMessage()
                ], 500);
            }
        }

        $service = Service::create($validated);


        $message = "D?ch v? <strong>{$service->getName()}</strong> ?? ???c t?o th?nh c?ng!";

        return $request->expectsJson()
            ? response()->json(['success' => true, 'message' => $message, 'service' => $service])
            : redirect()->route('admin.services.index')->with('success', $message);
    }


    public function show(Request $request, Service $service)
    {
        $service->load(['category.platform', 'provider']);


        if ($service->type === 'api' && $service->provider_id && $service->service_api) {
            try {

                $provider = $service->provider;
                if ($provider && $provider->status) {
                    $smm = new \App\Smm\Smm();
                    $smm->api_url = $provider->link;
                    $smm->api_key = $provider->api_key;

                    $providerServices = $smm->services();


                    if (is_object($providerServices)) {
                        $providerServices = json_decode(json_encode($providerServices), true);
                    }

                    if (is_array($providerServices)) {

                        $matchingService = collect($providerServices)->first(function ($s) use ($service) {

                            if (is_object($s)) {
                                $s = json_decode(json_encode($s), true);
                            }
                            return ($s['service'] ?? $s['id'] ?? null) == $service->service_api;
                        });

                        if ($matchingService) {

                            if (is_object($matchingService)) {
                                $matchingService = json_decode(json_encode($matchingService), true);
                            }

                            $service->provider_service_name = $matchingService['name'] ?? null;
                            $service->provider_service_rate = $matchingService['rate'] ?? null;
                            $service->provider_service_min = $matchingService['min'] ?? null;
                            $service->provider_service_max = $matchingService['max'] ?? null;
                            $service->provider_service_type = $matchingService['type'] ?? null;
                        }
                    }
                }
            } catch (\Exception $e) {
            }
        }

        return $request->expectsJson() || $request->ajax()
            ? response()->json(['success' => true, 'service' => $service])
            : view('admin.services.show', compact('service'));
    }


    public function edit(Request $request)
    {

        $serviceId = $request->query('id');

        $service = $serviceId
            ? Service::where('domain', getDomain())->find($serviceId)
            : null;

        if (!$service) {
            return redirect()->route('admin.services.index')->with('error', 'Kh?ng t?m th?y d?ch v?');
        }

        $service->load(['category.platform']);


        $categories = Category::with('platform:id,name,image')
            ->where('domain', getDomain())
            ->select('id', 'name', 'platform_id', 'image')
            ->get()
            ->filter(function ($category) {
                return is_object($category) && $category->id && $category->platform;
            });


        $languages = Language::where('status', true)
            ->where('code', '!=', 'en')
            ->where('domain', getDomain())
            ->select('id', 'name', 'code')
            ->orderBy('code')
            ->get();


        $providers = ApiProvider::where('domain', getDomain())
            ->where('status', true)
            ->select('id', 'name', 'fixed_decimal', 'rate_api')
            ->orderBy('name')
            ->get();

        $config = Config::where('domain', getDomain())
            ->where('status', true)
            ->first();


        $markupConfig = [
            'markup_retail' => ($config && $config->markup_retail > 0) ? $config->markup_retail : 110.0,
            'markup_agent' => ($config && $config->markup_agent > 0) ? $config->markup_agent : 108.0,
            'markup_distributor' => ($config && $config->markup_distributor > 0) ? $config->markup_distributor : 105.0
        ];

        return view('admin.services.edit', compact('service', 'categories', 'languages', 'providers', 'markupConfig'));
    }


    public function update(Request $request)
    {
        $serviceId = $request->query('id');
        if (!$serviceId) {
            return response()->json(['success' => false, 'message' => 'Kh?ng t?m th?y d?ch v?'], 404);
        }

        $service = Service::findOrFail($serviceId);


        if ($request->has('toggle_status')) {
            $status = $request->boolean('status', false);
            $service->update(['status' => $status]);
            return response()->json(['success' => true, 'status' => $status, 'service' => $service->fresh()]);
        }


        try {
            $validated = $request->validate([
                'category_id'          => 'sometimes|required|exists:categories,id',
                'type'                 => 'sometimes|required|in:api,manual',
                'type_service'         => 'sometimes|nullable|string|in:Package,Default,Custom Comments,Mentions Hashtag,Special',
                'name'                 => 'sometimes|array',
                'name.en'              => 'sometimes|required|string|max:255',
                'name.*'               => 'nullable|string|max:255',
                'rate_original'        => 'sometimes|nullable|numeric|min:0',
                'rate_retail'          => 'sometimes|required|numeric|min:0',
                'rate_agent'           => 'sometimes|required|numeric|min:0',
                'rate_distributor'     => 'sometimes|required|numeric|min:0',
                'rate_retail_up'       => 'sometimes|nullable|numeric|min:0',
                'rate_agent_up'        => 'sometimes|nullable|numeric|min:0',
                'rate_distributor_up'  => 'sometimes|nullable|numeric|min:0',
                'provider_id'          => 'sometimes|nullable|string',
                'provider_service_id'  => 'sometimes|nullable|string',
                'provider_name'        => 'sometimes|nullable|string',
                'description'          => 'sometimes|nullable|string',
                'attributes'           => 'sometimes|nullable|array',
                'attributes.*'         => 'nullable|string|max:255',
                'min'                  => 'sometimes|nullable|integer|min:1',
                'max'                  => 'sometimes|nullable|integer|min:1',
                'average_time'         => 'sometimes|nullable|string|max:255',
                'note'                 => 'sometimes|nullable|string',
                'reaction'             => 'sometimes|nullable|string|max:500',
                'sync_rate'            => 'sometimes|nullable',
                'sync_min_max'         => 'sometimes|nullable',
                'sync_refill'          => 'sometimes|nullable',
                'sync_cancel'          => 'sometimes|nullable',
                'sync_status'          => 'sometimes|nullable',
                'service_api'          => 'sometimes|nullable|string',
                'total_limit'          => 'sometimes|nullable|integer|min:1',
                'limit'                => 'sometimes|nullable|integer|min:1',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => 'D? li?u kh?ng h?p l?', 'errors' => $e->errors()], 422);
        }


        $validated['min']      = $validated['min']  ?? 1;
        $validated['max']      = $validated['max']  ?? 10000;
        $validated['type']     = $validated['type'] ?? 'manual';


        if (isset($validated['name'])) {
            $validated['name'] = $this->processNameField($validated['name']);
        }


        $validated['status']      = $request->boolean('status', false);
        $validated['refill']      = $request->boolean('refill', false);
        $validated['cancel']      = $request->boolean('cancel', false);
        $validated['dripfeed']    = $request->boolean('dripfeed', false);
        $validated['sync_rate']   = $request->boolean('sync_rate', false);
        $validated['sync_min_max'] = $request->boolean('sync_min_max', false);
        $validated['sync_refill'] = $request->boolean('sync_refill', false);
        $validated['sync_cancel'] = $request->boolean('sync_cancel', false);
        $validated['sync_status'] = $request->boolean('sync_status', false);


        if ($validated['type'] === 'manual') {
            $validated['provider_id'] = $validated['provider_name'] = $validated['service_api'] = null;
            $service->forceFill(['provider_id' => null, 'provider_name' => null, 'service_api' => null]);
        } elseif (!empty($validated['provider_service_id'])) {
            $validated['service_api'] = $validated['provider_service_id'];
        }


        $validated['attributes'] = $this->processAttributesField($request->input('attributes'));
        if ($request->has('reaction')) {
            $validated['reaction'] = $this->processReactionField($request->input('reaction'));
        }


        try {
            $originals = $service->only(['rate_original', 'min', 'max', 'refill', 'cancel']);

            $attrs   = $service->getAttributes();
            $changed = array_filter($validated, function ($value, $key) use ($attrs) {
                if (is_array($value) || is_object($value)) return true;
                return (string) $value !== (string) ($attrs[$key] ?? '');
            }, ARRAY_FILTER_USE_BOTH);

            if (!empty($changed)) {
                $service->update($changed);
            }

            if ($request->boolean('notify', false) && $service->status) {
                $this->logServiceUpdate($service, $validated, $originals);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'L?i khi l?u d?ch v?: ' . $e->getMessage()], 500);
        }

        return response()->json([
            'success' => adminMessage('update'),
            'service' => $service->fresh(),
        ]);
    }


    public function destroy(Request $request, Service $service)
    {
        $serviceName = $service->getName();
        $service->delete();
        $message = "?? x?a d?ch v? {$serviceName} th?nh c?ng!";

        return $request->expectsJson()
            ? response()->json(['success' => true, 'message' => $message])
            : redirect()->route('admin.services.index')->with('success', $message);
    }


    public function getCategories(Request $request)
    {
        $categories = Category::with('platform:id,name,image')
            ->where('domain', getDomain())
            ->whereHas('platform')
            ->select('id', 'name', 'platform_id', 'image')
            ->get();

        return response()->json([
            'success' => true,
            'categories' => $categories->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->getName(),
                    'platform_name' => optional($category->platform)->name ?? 'N/A',
                    'platform_image' => optional($category->platform)->image,
                    'image' => $category->image,
                    'search_text' => strtolower((optional($category->platform)->name ?? 'N/A') . ' ' . $category->getName())
                ];
            })
        ]);
    }


    public function getLanguages(Request $request)
    {
        $languages = Language::where('status', true)
            ->where('code', '!=', 'en')
            ->where('domain', getDomain())
            ->orderBy('code')
            ->select('id', 'name', 'code', 'flag')
            ->get();

        return response()->json([
            'success' => true,
            'languages' => $languages
        ]);
    }


    public function getProviders(Request $request)
    {
        $providers = ApiProvider::where('domain', getDomain())
            ->where('status', true)
            ->orderBy('name')
            ->select('id', 'name', 'url')
            ->get();

        return response()->json([
            'success' => true,
            'providers' => $providers
        ]);
    }


    public function getProvidersByCategory(Request $request, $categoryId)
    {
        try {
            $category = Category::findOrFail($categoryId);


            $services = Service::where('cat_id', $categoryId)
                ->where('domain', getDomain())
                ->distinct()
                ->pluck('provider_id')
                ->filter()
                ->toArray();


            $providers = ApiProvider::whereIn('id', $services)
                ->where('domain', getDomain())
                ->where('status', true)
                ->orderBy('name')
                ->select('id', 'name', 'url')
                ->get();


            if ($providers->isEmpty()) {
                $providers = ApiProvider::where('domain', getDomain())
                    ->where('status', true)
                    ->orderBy('name')
                    ->select('id', 'name', 'url')
                    ->get();
            }

            return response()->json([
                'success' => true,
                'providers' => $providers,
                'category_id' => $categoryId
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }


    public function getProviderServices(Request $request, $providerId)
    {
        try {

            if (!$providerId || !is_numeric($providerId)) {
                return response()->json(['success' => false, 'message' => 'Mã nhà cung cấp không hợp lệ'], 400);
            }


            $provider = ApiProvider::where('domain', getDomain())
                ->where('id', $providerId)
                ->where('status', true)
                ->first();

            if (!$provider) {
                return response()->json(['success' => false, 'message' => 'Nhà cung cấp không tồn tại hoặc không hoạt động'], 404);
            }


            if (empty($provider->link) || empty($provider->api_key)) {
                return response()->json(['success' => false, 'message' => 'URL API hoặc API key của nhà cung cấp chưa được cấu hình'], 422);
            }


            $fixedDecimal = max(0, min(12, (int) ($provider->fixed_decimal ?? 10)));
            $providerRate = (float) ($provider->rate_api ?? 1) ?: 1;
            $cacheKey = 'provider_services_' . $providerId . '_' . md5($provider->link . '|' . $fixedDecimal . '|' . $providerRate);
            $cachedServices = Cache::get($cacheKey);

            if ($cachedServices !== null) {
                return response()->json([
                    'success' => true,
                    'services' => $cachedServices,
                    'count' => count($cachedServices),
                    'cached' => true
                ]);
            }


            $smm = new Smm();
            $smm->api_url = $provider->link;
            $smm->api_key = $provider->api_key;


            $services = $smm->services();


            if (is_object($services)) {
                $services = json_decode(json_encode($services), true);
            }


            if (!is_array($services)) {

                return response()->json([
                    'success' => false,
                    'message' => 'Kh?ng nh?n ???c ph?n h?i h?p l? t? nh? cung c?p'
                ], 500);
            }


            if (isset($services['error'])) {
                $errMsg = $services['error'];
                $curlErrno = $services['curl_errno'] ?? null;


                if ($curlErrno == 6) {
                    $errMsg = 'Kh?ng th? k?t n?i t?i nh? cung c?p (URL kh?ng t?n t?i ho?c DNS l?i)';
                } elseif ($curlErrno == 28) {
                    $errMsg = 'K?t n?i t?i nh? cung c?p b? qu? th?i gian ch?';
                } elseif ($curlErrno == 7) {
                    $errMsg = 'Kh?ng th? k?t n?i t?i nh? cung c?p (k?t n?i b? t? ch?i)';
                } elseif ($curlErrno == 35 || $curlErrno == 60) {
                    $errMsg = 'L?i SSL khi k?t n?i t?i nh? cung c?p';
                }


                return response()->json([
                    'success' => false,
                    'message' => $errMsg
                ], 502);
            }



            if (!isset($services[0]) && isset($services['error'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'L?i t? nh? cung c?p: ' . $services['error']
                ], 502);
            }


            $transformedServices = collect($services)->map(function ($s) use ($fixedDecimal, $providerRate) {

                if (is_object($s)) {
                    $s = json_decode(json_encode($s), true);
                }

                return [
                    'id' => $s['service'] ?? $s['id'] ?? null,
                    'name' => $s['name'] ?? 'Unknown',
                    'rate' => rtrim(rtrim(number_format((float) ($s['rate'] ?? 0) * $providerRate, $fixedDecimal, '.', ''), '0'), '.'),
                    'min' => intval($s['min'] ?? 1),
                    'max' => intval($s['max'] ?? 10000),
                    'type' => $s['type'] ?? 'Default',
                    'platform' => $s['platform'] ?? null,
                    'category' => $s['category'] ?? null,
                    'refill' => isset($s['refill']) ? (bool)$s['refill'] : false,
                    'cancel' => isset($s['cancel']) ? (bool)$s['cancel'] : false,
                    'dripfeed' => isset($s['dripfeed']) ? (bool)$s['dripfeed'] : false,
                    'title' => $s['title'] ?? null,
                    'description' => $s['description'] ?? null,
                ];
            })->filter(function ($s) {
                return !is_null($s['id']) && (float) $s['rate'] > 0;
            })->values()->toArray();


            Cache::put($cacheKey, $transformedServices, now()->addMinutes(5));

            return response()->json([
                'success' => true,
                'services' => $transformedServices,
                'count' => count($transformedServices),
                'cached' => false
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Kh?ng th? l?y danh s?ch d?ch v?: ' . $e->getMessage()
            ], 500);
        }
    }


    public function syncFromApi(Request $request, Service $service)
    {
        try {
            if (!$service->hasApiService()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dịch vụ chưa được liên kết với dịch vụ API',
                ]);
            }

            $synced = $service->syncFromApi();

            if ($synced) {
                return response()->json([
                    'success' => true,
                    'message' => 'Đồng bộ dịch vụ từ API thành công',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Không thể đồng bộ dịch vụ từ API',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi đồng bộ dịch vụ: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function toggleStatus(Request $request, Service $service)
    {
        try {
            $newStatus = $request->input('status', !$service->status);
            $newStatus = is_string($newStatus) ? filter_var($newStatus, FILTER_VALIDATE_BOOLEAN) : (bool) $newStatus;

            $service->update(['status' => $newStatus]);

            return response()->json([
                'success' => adminMessage('update')
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'C? l?i x?y ra khi c?p nh?t tr?ng th?i'
            ], 500);
        }
    }

    public function ajaxGet(Request $request): JsonResponse
    {
        $id = $request->input('data.id');

        if (!$id) {
            return response()->json(['error' => 'Thi?u m? d?ch v?']);
        }

        $service = Service::where('id', $id)
            ->where('domain', getDomain())
            ->first();

        if (!$service) {
            return response()->json(['error' => 'Kh?ng t?m th?y d?ch v?']);
        }

        $serviceName = $service->getName('en');
        $provider = $service->provider_id
            ? ApiProvider::where('domain', getDomain())->find($service->provider_id)
            : null;
        $decimals = max(0, min(12, (int) ($provider?->fixed_decimal ?? 10)));
        $rate = static fn ($value): string => rtrim(
            rtrim(number_format((float) $value, $decimals, '.', ''), '0'),
            '.'
        );
        $original = (float) ($service->rate_original ?? 0);
        $retail = $original * (float) ($service->rate_retail_up ?? 100) / 100;
        $agent = $original * (float) ($service->rate_agent_up ?? 100) / 100;
        $distributor = $original * (float) ($service->rate_distributor_up ?? 100) / 100;

        $addType = $service->provider_id ? 'Api' : 'Manual';

        return response()->json([
            'service_add_type'              => $addType,
            'provider_id'                   => $service->provider_id,
            'provider_sid'                  => $service->service_api,
            'service_sync_rate'             => $service->sync_rate   ? 1 : 0,
            'service_sync_minmax'           => $service->sync_min_max ? 1 : 0,
            'service_sync_refill'           => $service->sync_refill ? 1 : 0,
            'service_sync_cancel'           => $service->sync_cancel ? 1 : 0,
            'service_sync_status'           => $service->sync_status ? 1 : 0,
            'service_percent_inc'           => (float) ($service->rate_retail_up ?? 100),
            'service_percent_inc_1'         => (float) ($service->rate_agent_up ?? 100),
            'service_percent_inc_2'         => (float) ($service->rate_distributor_up ?? 100),
            'service_name'                  => $serviceName,
            'cat_id'                        => $service->category_id,
            'service_oprice'                => $rate($original),
            'service_price'                 => $rate($retail),
            'service_price_1'               => $rate($agent),
            'service_price_2'               => $rate($distributor),
            'service_type'                  => $service->type_service ?? 'Default',
            'service_status'                => $service->status ? 1 : 0,
            'service_sort'                  => $service->position ?? 0,
            'service_min'                   => $service->min ?? 1,
            'service_max'                   => $service->max ?? 10000,
            'service_tlimit'                => $service->total_limit ?? 100000,
            'service_limit'                 => $service->limit ?? 100000,
            'service_refill'                => $service->refill ? 1 : 0,
            'service_cancel'                => $service->cancel ? 1 : 0,
            'service_schedule'              => 0,
            'service_advanced_settings'     => $service->advanced_settings ? 1 : 0,
            'service_advanced_settings_data' => json_encode($service->advanced_settings_data ?? ['min_balance' => 0, 'max_order' => 0]),
            'service_overflow'              => (int) (($service->overflow ?? 0) !== 0),
            'service_overflow_data'         => (int) ($service->overflow ?? 0),
            'service_quantity_discount'     => $service->quantity_discount ? 1 : 0,
            'service_quantity_discount_data' => json_encode($service->quantity_discount_data ?? []),
            'service_check_count'           => $service->check_count ? 1 : 0,
            'service_check_count_data'      => json_encode($service->check_count_data ?? ['type' => 'youtube-view', 'percent' => 0, 'auto' => 0]),
            'service_average_time_custom'   => 0,
            'service_average_time'          => $service->average_time ?? '',
            'service_hidden_api'            => $service->hidden_api ? 1 : 0,
            'service_feature'               => json_encode($service->attributes ?? []),
            'service_summary'               => json_encode($service->summaries ?? []),
            'change_provider'               => $service->change_provider ? 1 : 0,
            'service_name_translated'       => json_encode(
                is_array($service->name) ? array_diff_key($service->name, ['en' => '']) : []
            ),
            'service_desc'                  => $service->description ?? '',
        ]);
    }


    public function ajaxAdd(Request $request): JsonResponse
    {
        try {
            $d = $request->input('data', []);

            $addType    = $d['add_type']    ?? 'Manual';
            $providerId = $d['provider_id'] ?? null;
            $providerSid = $d['provider_sid'] ?? null;
            $catId      = $d['cat_id']      ?? null;
            $name       = $d['name']        ?? '';
            $type       = $d['type']        ?? 'Default';
            $price      = floatval($d['price']  ?? 0);
            $price1     = floatval($d['price1'] ?? 0);
            $price2     = floatval($d['price2'] ?? 0);
            $oprice     = floatval($d['oprice'] ?? 0);
            $overflow   = (int) ($d['overflow_data'] ?? $d['overflow'] ?? 0);

            if (empty($name)) {
                return response()->json(['error' => 'T?n d?ch v? kh?ng ???c ?? tr?ng']);
            }
            if (!$catId) {
                return response()->json(['error' => 'Vui l?ng ch?n danh m?c']);
            }
            if ($overflow < -100 || $overflow > 100) {
                return response()->json(['error' => 'Gi? tr? overflow ph?i n?m trong kho?ng -100 ??n 100']);
            }

            $category = \App\Models\Category::find($catId);
            if (!$category || $category->domain !== getDomain()) {
                return response()->json(['error' => 'Danh m?c kh?ng t?n t?i']);
            }

            $providerName = null;
            if ($addType === 'Api' && $providerId) {
                $provider = ApiProvider::where('domain', getDomain())->find($providerId);
                $providerName = $provider?->name;
                $decimals = max(0, min(12, (int) ($provider?->fixed_decimal ?? 10)));
                $oprice = round($oprice, $decimals);
                $price = round($oprice * ((float) ($d['percent_inc'] ?? 100)) / 100, 8);
                $price1 = round($oprice * ((float) ($d['percent_inc_1'] ?? 100)) / 100, 8);
                $price2 = round($oprice * ((float) ($d['percent_inc_2'] ?? 100)) / 100, 8);
            }
            $upRetail = (float) ($d['percent_inc'] ?? 100);
            $upAgent = (float) ($d['percent_inc_1'] ?? 100);
            $upDist = (float) ($d['percent_inc_2'] ?? 100);

            $sync = $d['sync'] ?? $d['sync_rate'] ?? 0;
            $feature = $d['feature'] ?? [];
            if (is_string($feature)) {
                $feature = json_decode($feature, true) ?: [];
            }
            $options = $this->serviceOptions($d);

            $service = Service::create([
                'category_id'      => $catId,
                'type'             => strtolower($addType) === 'api' ? 'api' : 'manual',
                'type_service'     => $type,
                'name'             => ['en' => $name],
                'title'            => $name,
                'description'      => $d['description'] ?? '',
                'image'            => $category->image,
                'rate_original'    => $oprice,
                'rate_retail'      => $price,
                'rate_agent'       => $price1,
                'rate_distributor' => $price2,
                'rate_retail_up'   => $upRetail,
                'rate_agent_up'    => $upAgent,
                'rate_distributor_up' => $upDist,
                'min'              => max(1, intval($d['min'] ?? 1)),
                'max'              => max(1, intval($d['max'] ?? 10000)),
                'overflow'         => !empty($d['overflow']) ? $overflow : 0,
                'refill'           => ($d['refill'] ?? 0) ? 1 : 0,
                'cancel'           => ($d['cancel'] ?? 0) ? 1 : 0,
                'dripfeed'         => 0,
                'status'           => ($d['status'] ?? 0) ? 1 : 0,
                'sync_rate'        => $sync ? 1 : 0,
                'sync_min_max'     => ($d['sync_minmax'] ?? $sync) ? 1 : 0,
                'sync_refill'      => ($d['sync_refill'] ?? $sync) ? 1 : 0,
                'sync_cancel'      => ($d['sync_cancel'] ?? $sync) ? 1 : 0,
                'sync_status'      => ($d['sync_status'] ?? 0) ? 1 : 0,
                'service_api'      => $addType === 'Api' ? $providerSid : null,
                'provider_id'      => $addType === 'Api' ? $providerId  : null,
                'provider_name'    => $providerName,
                'attributes'       => $feature,
                'domain'           => getDomain(),
                'position'         => 0,
                ...$options,
            ]);

            return response()->json(['success' => adminMessage('add')]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'L?i: ' . $e->getMessage()]);
        }
    }


    public function ajaxUpdate(Request $request): JsonResponse
    {
        try {
            $d       = $request->input('data', []);
            $id      = $d['id'] ?? null;

            if (!$id) {
                return response()->json(['error' => 'Missing service ID']);
            }

            $service = Service::where('id', $id)->where('domain', getDomain())->first();
            if (!$service) {
                return response()->json(['error' => 'Service not found']);
            }

            $addType     = $d['add_type']    ?? ($service->provider_id ? 'Api' : 'Manual');
            $name        = $d['name']        ?? null;
            $price       = isset($d['price'])  ? floatval($d['price'])  : null;
            $price1      = isset($d['price1']) ? floatval($d['price1']) : null;
            $price2      = isset($d['price2']) ? floatval($d['price2']) : null;
            $oprice      = isset($d['oprice']) ? floatval($d['oprice']) : null;
            $overflow    = (int) ($d['overflow_data'] ?? $d['overflow'] ?? 0);
            if ($overflow < -100 || $overflow > 100) {
                return response()->json(['error' => 'Gi? tr? overflow ph?i n?m trong kho?ng -100 ??n 100']);
            }

            $updates = [];
            $updates = array_merge($updates, $this->serviceOptions($d));
            $provider = null;
            if ($addType === 'Api' && !empty($d['provider_id'])) {
                $provider = ApiProvider::where('domain', getDomain())->find($d['provider_id']);
                $decimals = max(0, min(12, (int) ($provider?->fixed_decimal ?? 10)));
                $upRetail = (float) ($d['percent_inc'] ?: $service->rate_retail_up ?: 100);
                $upAgent = (float) ($d['percent_inc_1'] ?: $service->rate_agent_up ?: 100);
                $upDist = (float) ($d['percent_inc_2'] ?: $service->rate_distributor_up ?: 100);
                if ($oprice !== null) {
                    $oprice = round($oprice, $decimals);
                    $price = round($oprice * $upRetail / 100, 8);
                    $price1 = round($oprice * $upAgent / 100, 8);
                    $price2 = round($oprice * $upDist / 100, 8);
                }
            }
            if ($name !== null) {
                $translated = $d['name_translated'] ?? [];
                if (is_string($translated)) {
                    $translated = json_decode($translated, true) ?: [];
                }
                $updates['name'] = array_filter(array_merge(['en' => $name], is_array($translated) ? $translated : []));
                $updates['title'] = $name;
            }
            if ($price  !== null) $updates['rate_retail']     = $price;
            if ($price1 !== null) $updates['rate_agent']      = $price1;
            if ($price2 !== null) $updates['rate_distributor'] = $price2;
            if ($oprice !== null) $updates['rate_original']   = $oprice;
            if (array_key_exists('percent_inc', $d)) $updates['rate_retail_up'] = (float) ($d['percent_inc'] ?: 100);
            if (array_key_exists('percent_inc_1', $d)) $updates['rate_agent_up'] = (float) ($d['percent_inc_1'] ?: 100);
            if (array_key_exists('percent_inc_2', $d)) $updates['rate_distributor_up'] = (float) ($d['percent_inc_2'] ?: 100);

            if (isset($d['cat_id'])) $updates['category_id'] = $d['cat_id'];
            if (isset($d['type'])) $updates['type_service'] = $d['type'];
            if (isset($d['min'])) $updates['min'] = max(1, intval($d['min']));
            if (isset($d['max'])) $updates['max'] = max(1, intval($d['max']));
            if (isset($d['overflow']) || isset($d['overflow_data'])) {
                $updates['overflow'] = !empty($d['overflow']) ? $overflow : 0;
            }
            if (isset($d['refill'])) $updates['refill'] = $d['refill'] ? 1 : 0;
            if (isset($d['cancel'])) $updates['cancel'] = $d['cancel'] ? 1 : 0;
            if (isset($d['status'])) $updates['status'] = $d['status'] ? 1 : 0;
            if (isset($d['sync_rate'])) $updates['sync_rate'] = $d['sync_rate'] ? 1 : 0;
            if (isset($d['sync_minmax'])) $updates['sync_min_max'] = $d['sync_minmax'] ? 1 : 0;
            if (isset($d['sync_refill'])) $updates['sync_refill'] = $d['sync_refill'] ? 1 : 0;
            if (isset($d['sync_cancel'])) $updates['sync_cancel'] = $d['sync_cancel'] ? 1 : 0;
            if (isset($d['sync_status'])) $updates['sync_status'] = $d['sync_status'] ? 1 : 0;
            if (isset($d['description'])) $updates['description'] = $d['description'];
            if (isset($d['avg_time'])) $updates['average_time'] = $d['avg_time'];
            $attributes = $this->processAttributesField($d['feature'] ?? null);
            $updates['attributes'] = $attributes ?: null;

            if ($addType === 'Manual') {
                $updates['type'] = 'manual';
                $updates['provider_id']   = null;
                $updates['provider_name'] = null;
                $updates['service_api']   = null;
            } elseif (isset($d['provider_id'])) {
                $updates['type'] = 'api';
                $updates['provider_id']  = $d['provider_id'];
                $updates['service_api']  = $d['provider_sid'] ?? $service->service_api;
                $provider ??= ApiProvider::where('domain', getDomain())->find($d['provider_id']);
                $updates['provider_name'] = $provider?->name ?? $service->provider_name;
            }

            if (!empty($updates)) {
                $service->update($updates);
            }

            return response()->json(['success' => adminMessage('update')]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'L?i: ' . $e->getMessage()]);
        }
    }


    public function ajaxDelete(Request $request): JsonResponse
    {
        $id = $request->input('data.id');

        $service = Service::where('id', $id)->where('domain', getDomain())->first();
        if (!$service) {
            return response()->json(['error' => 'Kh?ng t?m th?y d?ch v?']);
        }

        $service->delete();

        return response()->json(['success' => adminMessage('delete')]);
    }


    public function ajaxSort(Request $request): JsonResponse
    {
        $dataSort = $request->input('data.dataSort', []);

        if (empty($dataSort)) {
            return response()->json(['success' => true]);
        }

        foreach ($dataSort as $position => $id) {
            Service::where('id', $id)->where('domain', getDomain())
                ->update(['position' => $position]);
        }

        return response()->json(['success' => true]);
    }


    public function ajaxUpdateStatus(Request $request): JsonResponse
    {
        $id     = $request->input('data.id');
        $status = $request->input('data.status', 0);

        $service = Service::where('id', $id)->where('domain', getDomain())->first();
        if (!$service) {
            return response()->json(['error' => 'Kh?ng t?m th?y d?ch v?']);
        }

        $service->update(['status' => $status ? 1 : 0]);

        return response()->json(['success' => adminMessage('update')]);
    }


    public function ajaxSyncFor1dg(Request $request): JsonResponse
    {
        return response()->json(['success' => adminMessage('sync')]);
    }


    public function ajaxProviderServices(Request $request): JsonResponse
    {
        $id = $request->input('data.id', $request->input('id', $request->input('provider_id')));
        $provider = ApiProvider::where('domain', getDomain())->where('id', $id)->where('status', true)->first();
        if (!$provider) return response()->json(['error' => 'Nh? cung c?p kh?ng t?n t?i ho?c kh?ng ho?t ??ng']);
        if (!$provider->link || !$provider->api_key) return response()->json(['error' => 'Nh? cung c?p ch?a c?u h?nh URL API ho?c API key']);

        $decimals = max(0, min(12, (int) ($provider->fixed_decimal ?? 10)));
        $factor = (float) ($provider->rate_api ?? 1) ?: 1;
        $key = 'ajax_provider_services_v2_' . $id . '_' . md5($provider->link . '|' . $provider->api_key . '|' . $decimals . '|' . $factor);
        $services = Cache::remember($key, now()->addMinutes(5), function () use ($provider, $decimals, $factor) {
            return $this->normalizeProviderServicesForImport($this->providerServices($provider), $decimals, $factor);
        });

        return response()->json(['success' => $this->appendCurrentEditProviderService($request, $provider, $services)]);
    }

    public function ajaxProviderServicesForImport(Request $request): JsonResponse
    {
        $providerId = $request->input('data.id', $request->input('id', $request->input('provider_id')));

        if (!$providerId) {
            return response()->json(['error' => 'Vui l?ng ch?n nh? cung c?p']);
        }

        $provider = ApiProvider::where('domain', getDomain())
            ->where('id', $providerId)
            ->where('status', true)
            ->first();

        if (!$provider) {
            return response()->json(['error' => 'Nh? cung c?p kh?ng t?n t?i ho?c ?ang t?t']);
        }

        if (empty($provider->link) || empty($provider->api_key)) {
            return response()->json(['error' => 'Nh? cung c?p ch?a c?u h?nh URL API ho?c API key']);
        }

        $decimals = max(0, min(12, (int) ($provider->fixed_decimal ?? 10)));
        // The import view applies rate_api when displaying each provider price.
        $multiplier = 1.0;
        $cacheKey = 'ajax_provider_services_import_v3_' . $providerId . '_' . md5($provider->link . '|' . $provider->api_key . '|' . $decimals . '|' . $multiplier);
        $cache = Cache::store('file');
        $cached = $cache->get($cacheKey);

        if ($cached !== null) {
            return response()->json(['success' => $this->appendCurrentEditProviderService($request, $provider, $cached)]);
        }

        try {
            $raw = $this->providerServices($provider);

            if (isset($raw['error'])) {
                $message = is_array($raw) ? ($raw['error'] ?? 'Kh?ng th? l?y d?ch v? t? nh? cung c?p') : 'Kh?ng th? l?y d?ch v? t? nh? cung c?p';
                return response()->json(['error' => $message]);
            }

            $services = $this->normalizeProviderServicesForImport($raw, $decimals, $multiplier);

            if (empty($services)) {
                return response()->json(['error' => 'Nh? cung c?p kh?ng tr? v? d?ch v? h?p l?']);
            }

            // Provider data can contain emoji; the file cache avoids database-cache collation failures.
            $cache->put($cacheKey, $services, now()->addMinutes(5));

            return response()->json(['success' => $this->appendCurrentEditProviderService($request, $provider, $services)]);
        } catch (\Exception $e) {

            return response()->json(['error' => 'L?i k?t n?i: ' . $e->getMessage()]);
        }
    }

    public function providerServices(ApiProvider $provider): array
    {
        $smm = new Smm();
        $smm->api_url = $provider->link;
        $smm->api_key = $provider->api_key;
        $smm->timeout = 30;

        foreach (['json', 'form'] as $format) {
            $smm->format = $format;
            $raw = $smm->services();
            $raw = is_object($raw) ? json_decode(json_encode($raw), true) : $raw;
            if (!is_array($raw)) continue;
            if (isset($raw['error'])) continue;

            foreach (['success', 'data', 'services'] as $key) {
                if (isset($raw[$key])) {
                    $raw = is_array($raw[$key]) ? $raw[$key] : [];
                    break;
                }
            }

            if (is_array($raw) && $raw !== []) return $raw;
        }

        return ['error' => 'Kh?ng th? t?i d?ch v? t? nh? cung c?p'];
    }

    public function appendCurrentEditProviderService(Request $request, ApiProvider $provider, array $services): array
    {
        $referer = (string) $request->headers->get('referer', '');
        $serviceId = null;
        if ($referer !== '' && str_contains($referer, '/services/edit')) {
            parse_str((string) parse_url($referer, PHP_URL_QUERY), $query);
            $serviceId = is_numeric($query['id'] ?? null) ? (int) $query['id'] : null;
        }

        if (!$serviceId) {
            return $services;
        }

        $service = Service::where('domain', getDomain())
            ->where('id', $serviceId)
            ->where('provider_id', $provider->id)
            ->whereNotNull('service_api')
            ->first();

        if (!$service || !$service->service_api) {
            return $services;
        }

        $providerSid = (string) $service->service_api;
        foreach ($services as $item) {
            if ((string) ($item['service'] ?? '') === $providerSid) {
                // The provider option must show the current rate returned by SMM.
                return $services;
            }
        }

        $services[] = [
            'service' => $providerSid,
            'name' => $service->getName('en'),
            'rate' => (float) ($service->rate_original ?? 0),
            'min' => (int) ($service->min ?? 1),
            'max' => (int) ($service->max ?? 10000),
            'type' => (string) ($service->type_service ?? 'Default'),
            'category' => 'Current service',
            'refill' => (bool) $service->refill,
            'cancel' => (bool) $service->cancel,
            'dripfeed' => (bool) $service->dripfeed,
            'desc' => $service->getDescription('en'),
            'feature' => json_encode($service->attributes ?? []),
            'summary' => json_encode([]),
        ];

        return $services;
    }

    public function normalizeProviderServicesForImport(array $raw, ?int $decimals = null, float $multiplier = 1): array
    {
        $services = [];

        foreach ($raw as $key => $service) {
            if (is_object($service)) {
                $service = json_decode(json_encode($service), true);
            }

            if (!is_array($service)) {
                continue;
            }

            $serviceId = $service['service'] ?? $service['id'] ?? (is_numeric($key) ? null : $key);
            $name = trim((string) ($service['name'] ?? $service['title'] ?? ''));

            if (!$serviceId || $name === '') {
                continue;
            }

            $feature = $service['feature'] ?? $service['features'] ?? [];
            $summary = $service['summary'] ?? $service['summaries'] ?? [];
            $desc = $service['description'] ?? $service['desc'] ?? $service['details'] ?? '';
            $desc = is_scalar($desc) ? trim((string) $desc) : '';

            $rate = (float) ($service['rate'] ?? $service['price'] ?? 0) * $multiplier;
            $rate = $decimals === null
                ? $rate
                : rtrim(rtrim(number_format($rate, $decimals, '.', ''), '0'), '.');

            $services[] = [
                'service' => (string) $serviceId,
                'name' => $name,
                'rate' => $rate,
                'min' => (int) ($service['min'] ?? 1),
                'max' => (int) ($service['max'] ?? 10000),
                'type' => (string) ($service['type'] ?? 'Default'),
                'category' => (string) ($service['category'] ?? $service['category_name'] ?? 'Other'),
                'refill' => filter_var($service['refill'] ?? false, FILTER_VALIDATE_BOOLEAN),
                'cancel' => filter_var($service['cancel'] ?? false, FILTER_VALIDATE_BOOLEAN),
                'dripfeed' => filter_var($service['dripfeed'] ?? false, FILTER_VALIDATE_BOOLEAN),
                'desc' => $desc,
                'feature' => is_string($feature) ? $feature : json_encode($feature),
                'summary' => is_string($summary) ? $summary : json_encode($summary),
            ];
        }

        return $services;
    }

    public function normalizeImportPayload(Request $request): array
    {
        $payload = $request->input('data', null);

        if (is_string($payload)) {
            $decodedPayload = json_decode($payload, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decodedPayload)) {
                $payload = $decodedPayload;
            }
        }

        if (is_array($payload) && !empty($payload)) {
            return $this->transformLegacyImportPayload($payload);
        }

        $requestData = $request->all();

        if (isset($requestData['data'])) {
            $nestedPayload = $requestData['data'];

            if (is_string($nestedPayload)) {
                $decodedPayload = json_decode($nestedPayload, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decodedPayload)) {
                    $nestedPayload = $decodedPayload;
                }
            }

            if (is_array($nestedPayload) && !empty($nestedPayload)) {
                return $this->transformLegacyImportPayload($nestedPayload);
            }
        }

        $payload = [];
        foreach ($requestData as $key => $value) {
            if ($key === 'action' || $key === 'data') {
                continue;
            }

            if (str_starts_with($key, 'data.')) {
                data_set($payload, substr($key, 5), $value);
                continue;
            }

            if (preg_match('/^data\[(.+)\]$/', $key, $matches) === 1) {
                $normalizedKey = preg_replace('/\]\[/', '.', rtrim($matches[1], ']'));
                data_set($payload, $normalizedKey, $value);
                continue;
            }

            $payload[$key] = $value;
        }

        return is_array($payload) ? $this->transformLegacyImportPayload($payload) : [];
    }

    public function transformLegacyImportPayload(array $payload): array
    {
        if (empty($payload) || !array_is_list($payload) || !is_array($payload[0] ?? null)) {
            return $payload;
        }

        $firstItem = $payload[0];

        if (
            array_key_exists('category_id', $firstItem) ||
            array_key_exists('services_data', $firstItem) ||
            array_key_exists('markup_config', $firstItem)
        ) {
            return $payload;
        }

        $services = [];
        $servicesData = [];

        foreach ($payload as $item) {
            if (!is_array($item)) {
                continue;
            }

            $serviceId = isset($item['provider_sid']) ? (int) $item['provider_sid'] : 0;
            if ($serviceId <= 0) {
                continue;
            }

            $services[] = $serviceId;
            $servicesData[] = [
                'service_id' => $serviceId,
                'rate_original' => (float) ($item['oprice'] ?? 0),
                'rate_retail' => (float) ($item['price'] ?? 0),
                'rate_agent' => (float) ($item['price1'] ?? 0),
                'rate_distributor' => (float) ($item['price2'] ?? 0),
                'rate_retail_up' => (float) ($item['percent_inc'] ?? 0),
                'rate_agent_up' => (float) ($item['percent_inc_1'] ?? 0),
                'rate_distributor_up' => (float) ($item['percent_inc_2'] ?? 0),
                'sync_enabled' => !empty($item['sync']) ? 1 : 0,
            ];
        }

        return [
            'category_id' => isset($firstItem['cat_id']) ? (int) $firstItem['cat_id'] : 0,
            'provider_id' => isset($firstItem['provider_id']) ? (int) $firstItem['provider_id'] : 0,
            'services' => $services,
            'services_data' => $servicesData,
            'markup_config' => [
                'markup_retail' => (float) ($firstItem['percent_inc'] ?? 0),
                'markup_agent' => (float) ($firstItem['percent_inc_1'] ?? 0),
                'markup_distributor' => (float) ($firstItem['percent_inc_2'] ?? 0),
            ],
        ];
    }
}
