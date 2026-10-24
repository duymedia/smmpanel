@extends('admin.layouts.app')
@section('title', 'Admin API v2')
@section('content')
<div class="content flex-row-fluid" id="kt_content">
  <style>
    .api-v2-hero {
      background: linear-gradient(135deg, #1b4dff 0%, #6038d8 100%);
    }

    .api-v2-hero .text-white-75 {
      color: rgba(255, 255, 255, .75);
    }

    .api-v2-sidebar {
      top: calc(var(--api-v2-header-height, 184px) + 16px);
      align-self: flex-start;
      max-height: calc(100vh - var(--api-v2-header-height, 184px) - 32px);
      overflow-y: auto;
    }

    .api-v2-sidebar .nav-link {
      color: var(--bs-gray-600);
      border-radius: .65rem;
    }

    .api-v2-sidebar .nav-link:hover,
    .api-v2-sidebar .nav-link.active {
      color: var(--bs-primary);
      background: var(--bs-primary-light);
    }

    .api-v2-sidebar .group-title {
      letter-spacing: .04em;
    }

    .api-v2-section,
    .api-v2-endpoint {
      scroll-margin-top: 120px;
    }

    .api-v2-endpoint summary {
      list-style: none;
      cursor: pointer;
    }

    .api-v2-endpoint summary::-webkit-details-marker {
      display: none;
    }

    .api-v2-endpoint summary .api-v2-chevron {
      transition: transform .2s ease;
    }

    .api-v2-endpoint[open] summary .api-v2-chevron {
      transform: rotate(180deg);
    }

    .api-v2-endpoint .table td,
    .api-v2-endpoint .table th {
      vertical-align: middle;
    }

    .api-v2-samples {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 1rem;
    }

    .api-v2-sample {
      min-width: 0;
      overflow: hidden;
      border: 1px solid var(--bs-gray-200);
      border-radius: .8rem;
      background: var(--bs-body-bg);
      box-shadow: 0 3px 10px rgba(16, 24, 40, .04);
    }

    .api-v2-sample--request {
      border-top: 3px solid var(--bs-primary);
    }

    .api-v2-sample--response {
      border-top: 3px solid var(--bs-success);
    }

    .api-v2-sample__header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: .75rem;
      padding: .75rem 1rem;
      border-bottom: 1px solid var(--bs-gray-200);
    }

    .api-v2-sample__title {
      display: flex;
      align-items: center;
      gap: .55rem;
      font-size: .75rem;
      font-weight: 800;
      letter-spacing: .06em;
      text-transform: uppercase;
    }

    .api-v2-sample--request .api-v2-sample__title {
      color: var(--bs-primary);
    }

    .api-v2-sample--response .api-v2-sample__title {
      color: var(--bs-success);
    }

    .api-v2-sample__type {
      padding: .2rem .45rem;
      border-radius: .35rem;
      background: var(--bs-gray-100);
      color: var(--bs-gray-600);
      font-size: .65rem;
      font-weight: 700;
    }

    .api-v2-code,
    .api-v2-code code {
      background: #0b1220 !important;
      color: #e6edf7 !important;
    }

    .api-v2-code {
      margin: 0;
      min-height: 118px;
      max-height: 260px;
      padding: 1.1rem 1.2rem;
      overflow: auto;
      border: 0 !important;
      border-radius: 0 0 .7rem .7rem;
      box-shadow: none !important;
      font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
      font-size: .82rem;
      font-weight: 500;
      line-height: 1.7;
      white-space: pre-wrap;
      overflow-wrap: anywhere;
      -webkit-font-smoothing: antialiased;
    }

    .api-v2-code code {
      display: block !important;
      margin: 0 !important;
      padding: 0 !important;
      border: 0 !important;
      box-shadow: none !important;
      font: inherit !important;
      line-height: inherit !important;
      text-shadow: none !important;
      white-space: inherit !important;
    }

    .api-v2-code .json-key {
      color: #93c5fd !important;
    }

    .api-v2-code .json-string {
      color: #a7f3d0 !important;
    }

    .api-v2-code .json-number {
      color: #fcd34d !important;
    }

    .api-v2-code .json-boolean {
      color: #c4b5fd !important;
    }

    .api-v2-code .json-null {
      color: #fda4af !important;
    }

    .api-v2-code::selection,
    .api-v2-code code::selection {
      background: #344054 !important;
      color: #ffffff !important;
    }

    .api-v2-code-label {
      font-size: .7rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .08em;
      color: var(--bs-gray-600);
      margin-bottom: .4rem;
    }

    .api-v2-samples+.api-v2-samples {
      margin-top: 1rem;
    }

    .api-v2-copy {
      white-space: nowrap;
    }

    .api-v2-empty {
      display: none;
    }

    .api-v2-search-wrap {
      position: relative;
    }

    .api-v2-search-wrap .fa-magnifying-glass {
      position: absolute;
      left: 1rem;
      top: 50%;
      transform: translateY(-50%);
      color: var(--bs-gray-500);
    }

    .api-v2-search-wrap input {
      padding-left: 2.6rem;
    }

    @media (max-width: 991.98px) {
      .api-v2-sidebar {
        position: static !important;
        max-height: none;
        overflow: visible;
      }

      .api-v2-sidebar .nav {
        flex-direction: row !important;
        overflow-x: auto;
        flex-wrap: nowrap;
      }

      .api-v2-sidebar .nav-link {
        white-space: nowrap;
      }
    }

    @media (max-width: 767.98px) {
      .api-v2-samples {
        grid-template-columns: 1fr;
      }
    }
  </style>

  <div class="row g-5 g-xl-8 mb-8">
    <div class="col-12">
      <div class="card api-v2-hero border-0 shadow-sm">
        <div class="card-body p-7 p-lg-10">
          <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-6">
            <div>
              <span class="badge badge-light-primary text-primary fw-bold mb-4">VERSION 2</span>
              <h2 class="text-white fw-bold mb-3">Admin API v2</h2>
              <p class="text-white-75 fs-5 mb-0 mw-700px">Centralized admin API integration documentation for orders, tasks, payments, users, and tickets.</p>
            </div>
            <div class="d-flex flex-wrap gap-3">
              <a href="#v2-overview" class="btn btn-light btn-sm px-4 api-v2-anchor">Get started</a>
              <a href="#v2-overview" class="btn btn-outline btn-outline-light btn-sm px-4 api-v2-anchor">View connection <i class="fa-solid fa-arrow-down ms-2"></i></a>
            </div>
          </div>
          <div class="row g-3 mt-5">
            <div class="col-6 col-lg-6">
              <div class="rounded bg-white bg-opacity-10 p-4 h-100">
                <div class="text-white-75 fs-8 text-uppercase fw-bold">Actions</div>
                <div class="text-white fs-2 fw-bold mt-1">20</div>
              </div>
            </div>
            <div class="col-6 col-lg-6">
              <div class="rounded bg-white bg-opacity-10 p-4 h-100">
                <div class="text-white-75 fs-8 text-uppercase fw-bold">Method</div>
                <div class="text-white fs-2 fw-bold mt-1">POST</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-5 g-xl-8">
    <div class="col-12" id="v2-overview">
      <div class="card shadow-sm">
        <div class="card-body p-6">
          <div class="d-flex flex-column flex-xl-row gap-5 align-items-xl-center">
            <div class="flex-grow-1">
              <div class="text-gray-600 fs-8 text-uppercase fw-bold mb-2">API endpoint</div>
              <div class="d-flex align-items-center gap-2 flex-wrap">
                <code id="api-v2-url" class="fs-5 fw-bold text-gray-900">https://naplike.com/api/adminv2</code>
                <button type="button" class="btn btn-icon btn-light-primary btn-sm api-v2-copy" data-copy-target="api-v2-url" title="Copy URL"><i class="fa-regular fa-copy"></i></button>
              </div>
            </div>
            <div class="vr d-none d-xl-block"></div>
            <div class="flex-grow-1">
              <div class="text-gray-600 fs-8 text-uppercase fw-bold mb-2">Current admin API key</div>
              <div class="d-flex align-items-center gap-2 flex-wrap">
                <code id="key" class="fs-5 fw-bold text-danger">37420********</code>
                <button type="button" class="btn btn-icon btn-light-primary btn-sm" onclick="_api.on.click.changeKey()" title="Generate new API key"><i class="fa-solid fa-rotate"></i></button>
              </div>
            </div>
            <div class="alert alert-warning d-flex align-items-center py-3 px-4 mb-0">
              <i class="fa-solid fa-shield-halved fs-3 me-3"></i>
              <span class="fs-8">Only share the API key with trusted systems and always use HTTPS.</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-4 col-xl-3">
      <div class="card shadow-sm api-v2-sidebar sticky-lg-top">
        <div class="card-body p-4">
          <div class="api-v2-search-wrap mb-4">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="search" class="form-control form-control-solid" id="api-v2-search" placeholder="Search actions..." autocomplete="off">
          </div>
          <div class="text-uppercase text-gray-500 fs-8 fw-bold group-title mb-2">Navigation</div>
          <nav class="nav flex-column gap-1" id="api-v2-nav">
            <a class="nav-link active px-3 py-2 fw-semibold api-v2-anchor" href="#v2-overview"><i class="fa-solid fa-book-open me-3 w-15px"></i>Overview</a>
            <div class="text-uppercase text-gray-500 fs-8 fw-bold group-title mt-4 mb-1 px-3">Orders</div>
            <a class="nav-link px-3 py-2 fw-semibold api-v2-anchor" href="#api-v2-orders">
              <i class="fa-solid fa-cart-shopping me-3 w-15px"></i>Orders <span class="badge badge-light-primary float-end">10</span>
            </a>
            <div class="text-uppercase text-gray-500 fs-8 fw-bold group-title mt-4 mb-1 px-3">Cancel tasks</div>
            <a class="nav-link px-3 py-2 fw-semibold api-v2-anchor" href="#api-v2-cancel">
              <i class="fa-solid fa-ban me-3 w-15px"></i>Cancel tasks <span class="badge badge-light-primary float-end">2</span>
            </a>
            <div class="text-uppercase text-gray-500 fs-8 fw-bold group-title mt-4 mb-1 px-3">Refill tasks</div>
            <a class="nav-link px-3 py-2 fw-semibold api-v2-anchor" href="#api-v2-refill">
              <i class="fa-solid fa-arrows-rotate me-3 w-15px"></i>Refill tasks <span class="badge badge-light-primary float-end">2</span>
            </a>
            <div class="text-uppercase text-gray-500 fs-8 fw-bold group-title mt-4 mb-1 px-3">Payments</div>
            <a class="nav-link px-3 py-2 fw-semibold api-v2-anchor" href="#api-v2-payments">
              <i class="fa-solid fa-wallet me-3 w-15px"></i>Payments <span class="badge badge-light-primary float-end">2</span>
            </a>
            <div class="text-uppercase text-gray-500 fs-8 fw-bold group-title mt-4 mb-1 px-3">Users</div>
            <a class="nav-link px-3 py-2 fw-semibold api-v2-anchor" href="#api-v2-users">
              <i class="fa-solid fa-users me-3 w-15px"></i>Users <span class="badge badge-light-primary float-end">2</span>
            </a>
            <div class="text-uppercase text-gray-500 fs-8 fw-bold group-title mt-4 mb-1 px-3">Tickets</div>
            <a class="nav-link px-3 py-2 fw-semibold api-v2-anchor" href="#api-v2-tickets">
              <i class="fa-solid fa-life-ring me-3 w-15px"></i>Tickets <span class="badge badge-light-primary float-end">2</span>
            </a>
          </nav>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-8 col-xl-9">
      <div class="card shadow-sm mb-6">
        <div class="card-body p-6">
          <div class="d-flex align-items-center gap-3 mb-4">
            <span class="symbol symbol-40px symbol-circle bg-light-primary"><i class="fa-solid fa-plug text-primary fs-4"></i></span>
            <div>
              <h3 class="fw-bold text-gray-900 mb-1">Quick start</h3>
              <p class="text-muted mb-0">Send a POST request to the endpoint below. Every request <strong>must</strong> include <code>action</code> and <code>key</code> in the body.</p>
            </div>
          </div>
          <div class="api-v2-samples mt-4">
            <div class="api-v2-sample api-v2-sample--request">
              <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-terminal"></i>cURL example</span><span class="api-v2-sample__type">shell</span></div>
              <pre class="api-v2-code"><code>curl -X POST 'https://naplike.com/api/adminv2' \
  -H 'Content-Type: application/json' \
  -d '{"action":"getOrders","key":"YOUR_API_KEY","limit":5}'</code></pre>
            </div>
            <div class="api-v2-sample api-v2-sample--response">
              <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-circle-exclamation"></i>Error response</span><span class="api-v2-sample__type">4xx/5xx</span></div>
              <pre class="api-v2-code"><code>{
  <span class="json-key">"data":</span> <span class="json-null">null</span>,
  <span class="json-key">"error_message":</span> <span class="json-string">"Missing ids"</span>,
  <span class="json-key">"error_code":</span> <span class="json-string">"BAD_REQUEST"</span>
}</code></pre>
            </div>
          </div>
          <div class="alert alert-info d-flex align-items-center py-3 px-4 mt-4 mb-0">
            <i class="fa-solid fa-lightbulb fs-3 me-3"></i>
            <span class="fs-8">The body accepts <strong>JSON</strong> (<code>Content-Type: application/json</code>) or regular <strong>form-urlencoded</strong> data. All <code>ids</code> fields are comma-separated strings (e.g. <code>"12,33,45"</code>). Non-existing IDs are reported in <code>skipped_ids</code> — they won't cause an error.</span>
          </div>
        </div>
      </div>

      <div id="api-v2-endpoints">
        <div id="api-v2-orders" class="api-v2-section mb-8">
          <div class="d-flex align-items-center gap-3 mb-4"><span class="symbol symbol-35px symbol-circle bg-light-primary"><i class="fa-solid fa-cart-shopping text-primary"></i></span>
            <h3 class="fw-bold mb-0">Orders</h3><span class="badge badge-light-primary">10 actions</span>
          </div>

          <details class="api-v2-endpoint card shadow-sm mb-4" data-search="getOrders orders list filters pagination">
            <summary class="card-header border-0 d-flex align-items-center justify-content-between p-5">
              <div><span class="badge badge-light-primary me-2">POST</span><code class="fs-5 fw-bold">getOrders</code>
                <div class="text-muted fs-8 mt-2">List orders with filters &amp; pagination. Returns matched order count + items.</div>
              </div><i class="fa-solid fa-chevron-down api-v2-chevron text-muted"></i>
            </summary>
            <div class="card-body pt-0 px-5 pb-5">
              <div class="table-responsive">
                <table class="table table-row-bordered table-rounded gy-3">
                  <thead>
                    <tr>
                      <th>Field</th>
                      <th>Required</th>
                      <th>Type</th>
                      <th>Description</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><code>ids</code></td>
                      <td>Optional</td>
                      <td>String</td>
                      <td>Comma-separated order IDs, e.g. <code>"123,124"</code>.</td>
                    </tr>
                    <tr>
                      <td><code>external_order_ids</code></td>
                      <td>Optional</td>
                      <td>String</td>
                      <td>Comma-separated provider order IDs.</td>
                    </tr>
                    <tr>
                      <td><code>created_from</code>, <code>created_to</code></td>
                      <td>Optional</td>
                      <td>Unix timestamp</td>
                      <td>Filter by creation date range (seconds).</td>
                    </tr>
                    <tr>
                      <td><code>order_status</code></td>
                      <td>Optional</td>
                      <td>String</td>
                      <td><code>in_progress</code>, <code>pending</code>, <code>processing</code>, <code>completed</code>, <code>partial</code>, <code>canceled</code>, <code>fail</code>.</td>
                    </tr>
                    <tr>
                      <td><code>mode</code></td>
                      <td>Optional</td>
                      <td>String</td>
                      <td><code>auto</code> (API orders) or <code>manual</code>.</td>
                    </tr>
                    <tr>
                      <td><code>service_ids</code></td>
                      <td>Optional</td>
                      <td>String</td>
                      <td>Comma-separated service IDs.</td>
                    </tr>
                    <tr>
                      <td><code>user</code></td>
                      <td>Optional</td>
                      <td>String</td>
                      <td>Username (exact match).</td>
                    </tr>
                    <tr>
                      <td><code>provider</code></td>
                      <td>Optional</td>
                      <td>String</td>
                      <td>Provider name.</td>
                    </tr>
                    <tr>
                      <td><code>link</code></td>
                      <td>Optional</td>
                      <td>String</td>
                      <td>Order link (URL).</td>
                    </tr>
                    <tr>
                      <td><code>limit</code></td>
                      <td>Optional</td>
                      <td>Integer</td>
                      <td>Max 1000 (default 100).</td>
                    </tr>
                    <tr>
                      <td><code>offset</code></td>
                      <td>Optional</td>
                      <td>Integer</td>
                      <td>Pagination offset (default 0).</td>
                    </tr>
                    <tr>
                      <td><code>sort</code></td>
                      <td>Optional</td>
                      <td>String</td>
                      <td><code>date-asc</code> or <code>date-desc</code> (default).</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="d-flex align-items-center gap-2 mt-3"><span class="badge badge-light-info">Response fields</span><span class="text-muted fs-8">Each item in <code>list[]</code> contains:</span></div>
              <div class="table-responsive mt-2">
                <table class="table table-row-bordered table-rounded gy-3">
                  <thead>
                    <tr>
                      <th>Field</th>
                      <th>Type</th>
                      <th>Description</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><code>id</code></td>
                      <td>Integer</td>
                      <td>Order ID.</td>
                    </tr>
                    <tr>
                      <td><code>external_id</code></td>
                      <td>String</td>
                      <td>Provider order ID (<code>0</code> when none).</td>
                    </tr>
                    <tr>
                      <td><code>user</code></td>
                      <td>String</td>
                      <td>Account username.</td>
                    </tr>
                    <tr>
                      <td><code>creation_type</code></td>
                      <td>String</td>
                      <td><code>api</code> or <code>new_order_form</code>.</td>
                    </tr>
                    <tr>
                      <td><code>charge</code></td>
                      <td>Object</td>
                      <td><code>{value, currency}</code> — charged amount (USD).</td>
                    </tr>
                    <tr>
                      <td><code>link</code></td>
                      <td>String</td>
                      <td>Order link.</td>
                    </tr>
                    <tr>
                      <td><code>start_count</code></td>
                      <td>Integer</td>
                      <td>Starting count.</td>
                    </tr>
                    <tr>
                      <td><code>quantity</code></td>
                      <td>Integer</td>
                      <td>Total ordered quantity.</td>
                    </tr>
                    <tr>
                      <td><code>service_id</code></td>
                      <td>Integer</td>
                      <td>Service ID.</td>
                    </tr>
                    <tr>
                      <td><code>service_type</code></td>
                      <td>String</td>
                      <td>Service type (e.g. <code>Package</code>).</td>
                    </tr>
                    <tr>
                      <td><code>service_name</code></td>
                      <td>String</td>
                      <td>Service name.</td>
                    </tr>
                    <tr>
                      <td><code>status</code></td>
                      <td>String</td>
                      <td>Current status (<code>pending</code>, <code>processing</code>, <code>completed</code>, etc.)</td>
                    </tr>
                    <tr>
                      <td><code>remains</code></td>
                      <td>Integer</td>
                      <td>Remaining quantity.</td>
                    </tr>
                    <tr>
                      <td><code>mode</code></td>
                      <td>String</td>
                      <td><code>auto</code> or <code>manual</code>.</td>
                    </tr>
                    <tr>
                      <td><code>provider</code></td>
                      <td>String</td>
                      <td>Provider name.</td>
                    </tr>
                    <tr>
                      <td><code>created</code></td>
                      <td>Datetime</td>
                      <td>Creation time + <code>created_timestamp</code>.</td>
                    </tr>
                    <tr>
                      <td><code>last_update</code></td>
                      <td>Datetime</td>
                      <td>Last update time + <code>last_update_timestamp</code>.</td>
                    </tr>
                    <tr>
                      <td><code>actions</code></td>
                      <td>Object</td>
                      <td>Available actions as booleans (<code>details</code>, <code>resend</code>, <code>edit</code>, <code>refill</code>, <code>set_partial</code>, <code>cancel_and_refund</code>, <code>request_cancel</code>, …).</td>
                    </tr>
                    <tr>
                      <td><code>provider_charge</code></td>
                      <td>Object</td>
                      <td><code>{value, currency}</code> — provider cost, only for <code>auto</code> orders.</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="api-v2-samples mt-4">
                <div class="api-v2-sample api-v2-sample--request">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-up-right-from-square"></i>Request sample</span><span class="api-v2-sample__type">JSON body</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"action":</span> <span class="json-string">"getOrders"</span>,
  <span class="json-key">"key":</span> <span class="json-string">"&lt;ADMIN_API_KEY&gt;"</span>,
  <span class="json-key">"order_status":</span> <span class="json-string">"completed"</span>,
  <span class="json-key">"user":</span> <span class="json-string">"john"</span>,
  <span class="json-key">"limit":</span> <span class="json-number">5</span>
}</code></pre>
                </div>
                <div class="api-v2-sample api-v2-sample--response">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-down-left"></i>Response sample</span><span class="api-v2-sample__type">200 application/json</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"data":</span> {
    <span class="json-key">"count":</span> <span class="json-number">1</span>,
    <span class="json-key">"list":</span> [
      {
        <span class="json-key">"id":</span> <span class="json-number">123</span>,
        <span class="json-key">"user":</span> <span class="json-string">"john"</span>,
        <span class="json-key">"status":</span> <span class="json-string">"completed"</span>,
        <span class="json-key">"link":</span> <span class="json-string">"https://example.com/post/1"</span>,
        <span class="json-key">"quantity":</span> <span class="json-number">1000</span>,
        <span class="json-key">"remains":</span> <span class="json-number">0</span>,
        <span class="json-key">"service_id":</span> <span class="json-number">10</span>,
        <span class="json-key">"mode":</span> <span class="json-string">"auto"</span>,
        <span class="json-key">"created":</span> <span class="json-string">"2026-07-29 10:00:00"</span>,
        <span class="json-key">"created_timestamp":</span> <span class="json-number">1722258000</span>,
        <span class="json-key">"last_update":</span> <span class="json-string">"2026-07-29 12:00:00"</span>,
        <span class="json-key">"last_update_timestamp":</span> <span class="json-number">1722268800</span>
      }
    ]
  },
  <span class="json-key">"error_message":</span> <span class="json-null">null</span>,
  <span class="json-key">"error_code":</span> <span class="json-null">null</span>
}</code></pre>
                </div>
              </div>
            </div>
          </details>

          <details class="api-v2-endpoint card shadow-sm mb-4" data-search="getOrder order detail id">
            <summary class="card-header border-0 d-flex align-items-center justify-content-between p-5">
              <div><span class="badge badge-light-primary me-2">POST</span><code class="fs-5 fw-bold">getOrder</code>
                <div class="text-muted fs-8 mt-2">Get an order by <code>id</code>.</div>
              </div><i class="fa-solid fa-chevron-down api-v2-chevron text-muted"></i>
            </summary>
            <div class="card-body pt-0 px-5 pb-5">
              <p class="text-muted fs-8">The request requires <code>id</code>. Response <code>data</code> is an order object using the same schema as a <code>getOrders</code> item. A missing order returns HTTP 404 / <code>NOT_FOUND</code>.</p>
              <div class="api-v2-samples">
                <div class="api-v2-sample api-v2-sample--request">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-up-right-from-square"></i>Request sample</span><span class="api-v2-sample__type">JSON body</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"action":</span> <span class="json-string">"getOrder"</span>,
  <span class="json-key">"key":</span> <span class="json-string">"&lt;ADMIN_API_KEY&gt;"</span>,
  <span class="json-key">"id":</span> <span class="json-number">123</span>
}</code></pre>
                </div>
                <div class="api-v2-sample api-v2-sample--response">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-down-left"></i>Response sample</span><span class="api-v2-sample__type">200 application/json</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"data":</span> {
    <span class="json-key">"id":</span> <span class="json-number">123</span>,
    <span class="json-key">"user":</span> <span class="json-string">"demo_user"</span>,
    <span class="json-key">"status":</span> <span class="json-string">"processing"</span>,
    <span class="json-key">"quantity":</span> <span class="json-number">1000</span>,
    <span class="json-key">"remains":</span> <span class="json-number">500</span>,
    <span class="json-key">"service_id":</span> <span class="json-number">10</span>
  },
  <span class="json-key">"error_message":</span> <span class="json-null">null</span>,
  <span class="json-key">"error_code":</span> <span class="json-null">null</span>
}</code></pre>
                </div>
              </div>
            </div>
          </details>

          <details class="api-v2-endpoint card shadow-sm mb-4" data-search="pullOrders pull order pending manual processing service_ids">
            <summary class="card-header border-0 d-flex align-items-center justify-content-between p-5">
              <div><span class="badge badge-light-warning me-2">POST</span><code class="fs-5 fw-bold">pullOrders</code>
                <div class="text-muted fs-8 mt-2">Pull manual Pending orders from the last 90 days.</div>
              </div><i class="fa-solid fa-chevron-down api-v2-chevron text-muted"></i>
            </summary>
            <div class="card-body pt-0 px-5 pb-5">
              <p class="text-muted fs-8">Fields: <code>service_ids</code> (optional), <code>limit</code> (default/max 100). Pulled orders are automatically moved to <code>Processing</code> and sorted by <code>order_id ASC</code>.</p>
              <div class="api-v2-samples">
                <div class="api-v2-sample api-v2-sample--request">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-up-right-from-square"></i>Request sample</span><span class="api-v2-sample__type">JSON body</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"action":</span> <span class="json-string">"pullOrders"</span>,
  <span class="json-key">"key":</span> <span class="json-string">"&lt;ADMIN_API_KEY&gt;"</span>,
  <span class="json-key">"service_ids":</span> <span class="json-string">"2,34,55"</span>,
  <span class="json-key">"limit":</span> <span class="json-number">10</span>
}</code></pre>
                </div>
                <div class="api-v2-sample api-v2-sample--response">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-down-left"></i>Response sample</span><span class="api-v2-sample__type">200 application/json</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"data":</span> {
    <span class="json-key">"count":</span> <span class="json-number">1</span>,
    <span class="json-key">"list":</span> [
      {
        <span class="json-key">"id":</span> <span class="json-number">123</span>,
        <span class="json-key">"user":</span> <span class="json-string">"demo_user"</span>,
        <span class="json-key">"creation_type":</span> <span class="json-string">"new_order_form"</span>,
        <span class="json-key">"charge":</span> {
          <span class="json-key">"value":</span> <span class="json-number">1.25</span>,
          <span class="json-key">"currency":</span> <span class="json-string">"USD"</span>
        },
        <span class="json-key">"link":</span> <span class="json-string">"https://example.com/post/1"</span>,
        <span class="json-key">"quantity":</span> <span class="json-number">1000</span>,
        <span class="json-key">"service_id":</span> <span class="json-number">10</span>,
        <span class="json-key">"service_name":</span> <span class="json-string">"Followers"</span>,
        <span class="json-key">"created":</span> <span class="json-string">"2026-07-29 10:00:00"</span>
      }
    ]
  },
  <span class="json-key">"error_message":</span> <span class="json-null">null</span>,
  <span class="json-key">"error_code":</span> <span class="json-null">null</span>
}</code></pre>
                </div>
              </div>
            </div>
          </details>

          <details class="api-v2-endpoint card shadow-sm mb-4" data-search="updateOrders update order status remains start_count cancel_reason batch">
            <summary class="card-header border-0 d-flex align-items-center justify-content-between p-5">
              <div><span class="badge badge-light-danger me-2">POST</span><code class="fs-5 fw-bold">updateOrders</code>
                <div class="text-muted fs-8 mt-2">Update up to 100 orders in one request — status, remains, charge recalculated automatically.</div>
              </div><i class="fa-solid fa-chevron-down api-v2-chevron text-muted"></i>
            </summary>
            <div class="card-body pt-0 px-5 pb-5">
              <div class="d-flex align-items-center gap-2 mb-3"><span class="badge badge-light-info">Request fields</span><span class="text-muted fs-8">Each item in the <code>orders[]</code> array:</span></div>
              <div class="table-responsive">
                <table class="table table-row-bordered table-rounded gy-3">
                  <thead>
                    <tr>
                      <th>Field</th>
                      <th>Required</th>
                      <th>Type</th>
                      <th>Description</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><code>id</code></td>
                      <td>Yes</td>
                      <td>Integer</td>
                      <td>Order ID to update.</td>
                    </tr>
                    <tr>
                      <td><code>status</code></td>
                      <td>Yes</td>
                      <td>String</td>
                      <td><code>pending</code>, <code>in_progress</code>, <code>processing</code>, <code>completed</code>, <code>partial</code>, <code>canceled</code>.</td>
                    </tr>
                    <tr>
                      <td><code>remains</code></td>
                      <td>For <code>partial</code></td>
                      <td>Integer</td>
                      <td>Remaining count (0 to quantity). <strong>Required</strong> when status is <code>partial</code>.</td>
                    </tr>
                    <tr>
                      <td><code>start_count</code></td>
                      <td>Optional</td>
                      <td>Integer</td>
                      <td>Set starting count value.</td>
                    </tr>
                    <tr>
                      <td><code>cancel_reason</code></td>
                      <td>Optional</td>
                      <td>String</td>
                      <td>Reason stored in <code>order_note</code>.</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <p class="text-muted fs-8 mt-3">⚠️ Charge and remains are <strong>recalculated automatically</strong> based on the new status, matching the admin panel behavior.</p>
              <div class="api-v2-samples">
                <div class="api-v2-sample api-v2-sample--request">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-up-right-from-square"></i>Request sample</span><span class="api-v2-sample__type">JSON body</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"action":</span> <span class="json-string">"updateOrders"</span>,
  <span class="json-key">"key":</span> <span class="json-string">"&lt;ADMIN_API_KEY&gt;"</span>,
  <span class="json-key">"orders":</span> [
    {
      <span class="json-key">"id":</span> <span class="json-number">123</span>,
      <span class="json-key">"status":</span> <span class="json-string">"processing"</span>,
      <span class="json-key">"start_count":</span> <span class="json-number">1000</span>
    },
    {
      <span class="json-key">"id":</span> <span class="json-number">124</span>,
      <span class="json-key">"status":</span> <span class="json-string">"partial"</span>,
      <span class="json-key">"remains":</span> <span class="json-number">250</span>
    }
  ]
}</code></pre>
                </div>
                <div class="api-v2-sample api-v2-sample--response">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-down-left"></i>Response sample</span><span class="api-v2-sample__type">200 application/json</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"data":</span> {
    <span class="json-key">"orders":</span> [
      {
        <span class="json-key">"id":</span> <span class="json-number">123</span>,
        <span class="json-key">"success":</span> <span class="json-boolean">true</span>,
        <span class="json-key">"error_message":</span> <span class="json-null">null</span>,
        <span class="json-key">"error_code":</span> <span class="json-null">null</span>
      },
      {
        <span class="json-key">"id":</span> <span class="json-number">124</span>,
        <span class="json-key">"success":</span> <span class="json-boolean">false</span>,
        <span class="json-key">"error_message":</span> <span class="json-string">"Invalid remains"</span>,
        <span class="json-key">"error_code":</span> <span class="json-string">"BAD_REQUEST"</span>
      }
    ]
  },
  <span class="json-key">"error_message":</span> <span class="json-null">null</span>,
  <span class="json-key">"error_code":</span> <span class="json-null">null</span>
}</code></pre>
                </div>
              </div>
            </div>
          </details>

          <details class="api-v2-endpoint card shadow-sm mb-4" data-search="resendOrders resend failed awaiting provider">
            <summary class="card-header border-0 d-flex align-items-center justify-content-between p-5">
              <div><span class="badge badge-light-danger me-2">POST</span><code class="fs-5 fw-bold">resendOrders</code>
                <div class="text-muted fs-8 mt-2">Resend Failed or Awaiting orders; up to 100 IDs.</div>
              </div><i class="fa-solid fa-chevron-down api-v2-chevron text-muted"></i>
            </summary>
            <div class="card-body pt-0 px-5 pb-5">
              <p class="text-muted fs-8">The request uses <code>ids</code> as a comma-separated string. Successfully resent orders are moved to <code>Pending</code> and receive a new provider order ID. Ineligible IDs are skipped.</p>
              <div class="api-v2-samples">
                <div class="api-v2-sample api-v2-sample--request">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-up-right-from-square"></i>Request sample</span><span class="api-v2-sample__type">JSON body</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"action":</span> <span class="json-string">"resendOrders"</span>,
  <span class="json-key">"key":</span> <span class="json-string">"&lt;ADMIN_API_KEY&gt;"</span>,
  <span class="json-key">"ids":</span> <span class="json-string">"123,124"</span>
}</code></pre>
                </div>
                <div class="api-v2-sample api-v2-sample--response">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-down-left"></i>Response sample</span><span class="api-v2-sample__type">200 application/json</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"data":</span> {
    <span class="json-key">"ids":</span> [
      <span class="json-number">123</span>
    ]
  },
  <span class="json-key">"error_message":</span> <span class="json-null">null</span>,
  <span class="json-key">"error_code":</span> <span class="json-null">null</span>
}</code></pre>
                </div>
              </div>
            </div>
          </details>

          <details class="api-v2-endpoint card shadow-sm mb-4" data-search="changeOrderStatus status order batch pending in_progress processing completed">
            <summary class="card-header border-0 d-flex align-items-center justify-content-between p-5">
              <div><span class="badge badge-light-danger me-2">POST</span><code class="fs-5 fw-bold">changeOrderStatus</code>
                <div class="text-muted fs-8 mt-2">Bulk update the status of up to 100 orders.</div>
              </div><i class="fa-solid fa-chevron-down api-v2-chevron text-muted"></i>
            </summary>
            <div class="card-body pt-0 px-5 pb-5">
              <p class="text-muted fs-8">Fields: <code>ids</code> as a string and <code>status</code>. Allowed statuses: <code>pending</code>, <code>in_progress</code>, <code>processing</code>, and <code>completed</code>. The API does not recalculate charge or remains.</p>
              <div class="api-v2-samples">
                <div class="api-v2-sample api-v2-sample--request">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-up-right-from-square"></i>Request sample</span><span class="api-v2-sample__type">JSON body</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"action":</span> <span class="json-string">"changeOrderStatus"</span>,
  <span class="json-key">"key":</span> <span class="json-string">"&lt;ADMIN_API_KEY&gt;"</span>,
  <span class="json-key">"ids":</span> <span class="json-string">"123,124"</span>,
  <span class="json-key">"status":</span> <span class="json-string">"completed"</span>
}</code></pre>
                </div>
                <div class="api-v2-sample api-v2-sample--response">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-down-left"></i>Response sample</span><span class="api-v2-sample__type">200 application/json</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"data":</span> {
    <span class="json-key">"ids":</span> [
      <span class="json-number">123</span>
    ],
    <span class="json-key">"status":</span> <span class="json-string">"completed"</span>,
    <span class="json-key">"skipped_ids":</span> [
      <span class="json-number">124</span>
    ]
  },
  <span class="json-key">"error_message":</span> <span class="json-null">null</span>,
  <span class="json-key">"error_code":</span> <span class="json-null">null</span>
}</code></pre>
                </div>
              </div>
            </div>
          </details>

          <details class="api-v2-endpoint card shadow-sm mb-4" data-search="requestCancelOrders request cancel order">
            <summary class="card-header border-0 d-flex align-items-center justify-content-between p-5">
              <div><span class="badge badge-light-warning me-2">POST</span><code class="fs-5 fw-bold">requestCancelOrders</code>
                <div class="text-muted fs-8 mt-2">Create cancellation requests using the client's cancellation rules.</div>
              </div><i class="fa-solid fa-chevron-down api-v2-chevron text-muted"></i>
            </summary>
            <div class="card-body pt-0 px-5 pb-5">
              <p class="text-muted fs-8">The request uses <code>ids</code> as a string, with up to 100 IDs. The result contains created request IDs and <code>skipped_ids</code>.</p>
              <div class="api-v2-samples">
                <div class="api-v2-sample api-v2-sample--request">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-up-right-from-square"></i>Request sample</span><span class="api-v2-sample__type">JSON body</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"action":</span> <span class="json-string">"requestCancelOrders"</span>,
  <span class="json-key">"key":</span> <span class="json-string">"&lt;ADMIN_API_KEY&gt;"</span>,
  <span class="json-key">"ids":</span> <span class="json-string">"123,124"</span>
}</code></pre>
                </div>
                <div class="api-v2-sample api-v2-sample--response">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-down-left"></i>Response sample</span><span class="api-v2-sample__type">200 application/json</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"data":</span> {
    <span class="json-key">"ids":</span> [
      <span class="json-number">123</span>
    ],
    <span class="json-key">"skipped_ids":</span> [
      <span class="json-number">124</span>
    ]
  },
  <span class="json-key">"error_message":</span> <span class="json-null">null</span>,
  <span class="json-key">"error_code":</span> <span class="json-null">null</span>
}</code></pre>
                </div>
              </div>
            </div>
          </details>

          <details class="api-v2-endpoint card shadow-sm mb-4" data-search="cancelOrders cancel refund order cancel_reason">
            <summary class="card-header border-0 d-flex align-items-center justify-content-between p-5">
              <div><span class="badge badge-light-danger me-2">POST</span><code class="fs-5 fw-bold">cancelOrders</code>
                <div class="text-muted fs-8 mt-2">Cancel and refund orders directly.</div>
              </div><i class="fa-solid fa-chevron-down api-v2-chevron text-muted"></i>
            </summary>
            <div class="card-body pt-0 px-5 pb-5">
              <p class="text-muted fs-8">Fields: <code>ids</code> as a string (up to 100), and optional <code>cancel_reason</code>. Orders are set to Canceled, charge and discount are set to 0, remains is reset to quantity, and coupons are released.</p>
              <div class="api-v2-samples">
                <div class="api-v2-sample api-v2-sample--request">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-up-right-from-square"></i>Request sample</span><span class="api-v2-sample__type">JSON body</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"action":</span> <span class="json-string">"cancelOrders"</span>,
  <span class="json-key">"key":</span> <span class="json-string">"&lt;ADMIN_API_KEY&gt;"</span>,
  <span class="json-key">"ids":</span> <span class="json-string">"123,124"</span>,
  <span class="json-key">"cancel_reason":</span> <span class="json-string">"Incorrect link"</span>
}</code></pre>
                </div>
                <div class="api-v2-sample api-v2-sample--response">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-down-left"></i>Response sample</span><span class="api-v2-sample__type">200 application/json</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"data":</span> {
    <span class="json-key">"ids":</span> [
      <span class="json-number">123</span>,
      <span class="json-number">124</span>
    ]
  },
  <span class="json-key">"error_message":</span> <span class="json-null">null</span>,
  <span class="json-key">"error_code":</span> <span class="json-null">null</span>
}</code></pre>
                </div>
              </div>
            </div>
          </details>

          <details class="api-v2-endpoint card shadow-sm mb-4" data-search="editOrderLink edit order link">
            <summary class="card-header border-0 d-flex align-items-center justify-content-between p-5">
              <div><span class="badge badge-light-danger me-2">POST</span><code class="fs-5 fw-bold">editOrderLink</code>
                <div class="text-muted fs-8 mt-2">Edit an order link.</div>
              </div><i class="fa-solid fa-chevron-down api-v2-chevron text-muted"></i>
            </summary>
            <div class="card-body pt-0 px-5 pb-5">
              <p class="text-muted fs-8">Required fields: <code>id</code>, <code>link</code>.</p>
              <div class="api-v2-samples">
                <div class="api-v2-sample api-v2-sample--request">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-up-right-from-square"></i>Request sample</span><span class="api-v2-sample__type">JSON body</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"action":</span> <span class="json-string">"editOrderLink"</span>,
  <span class="json-key">"key":</span> <span class="json-string">"&lt;ADMIN_API_KEY&gt;"</span>,
  <span class="json-key">"id":</span> <span class="json-number">123</span>,
  <span class="json-key">"link":</span> <span class="json-string">"https://example.com/new-link"</span>
}</code></pre>
                </div>
                <div class="api-v2-sample api-v2-sample--response">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-down-left"></i>Response sample</span><span class="api-v2-sample__type">200 application/json</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"data":</span> {
    <span class="json-key">"id":</span> <span class="json-number">123</span>,
    <span class="json-key">"link":</span> <span class="json-string">"https://example.com/new-link"</span>
  },
  <span class="json-key">"error_message":</span> <span class="json-null">null</span>,
  <span class="json-key">"error_code":</span> <span class="json-null">null</span>
}</code></pre>
                </div>
              </div>
            </div>
          </details>

          <details class="api-v2-endpoint card shadow-sm mb-4" data-search="setOrderPartial partial remains order">
            <summary class="card-header border-0 d-flex align-items-center justify-content-between p-5">
              <div><span class="badge badge-light-danger me-2">POST</span><code class="fs-5 fw-bold">setOrderPartial</code>
                <div class="text-muted fs-8 mt-2">Set an order to Partial and recalculate the charge.</div>
              </div><i class="fa-solid fa-chevron-down api-v2-chevron text-muted"></i>
            </summary>
            <div class="card-body pt-0 px-5 pb-5">
              <p class="text-muted fs-8">Required fields: <code>id</code>, <code>remains</code>. <code>remains</code> must be between 0 and quantity; Canceled orders cannot be changed to Partial.</p>
              <div class="api-v2-samples">
                <div class="api-v2-sample api-v2-sample--request">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-up-right-from-square"></i>Request sample</span><span class="api-v2-sample__type">JSON body</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"action":</span> <span class="json-string">"setOrderPartial"</span>,
  <span class="json-key">"key":</span> <span class="json-string">"&lt;ADMIN_API_KEY&gt;"</span>,
  <span class="json-key">"id":</span> <span class="json-number">123</span>,
  <span class="json-key">"remains":</span> <span class="json-number">250</span>
}</code></pre>
                </div>
                <div class="api-v2-sample api-v2-sample--response">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-down-left"></i>Response sample</span><span class="api-v2-sample__type">200 application/json</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"data":</span> {
    <span class="json-key">"id":</span> <span class="json-number">123</span>,
    <span class="json-key">"remains":</span> <span class="json-number">250</span>
  },
  <span class="json-key">"error_message":</span> <span class="json-null">null</span>,
  <span class="json-key">"error_code":</span> <span class="json-null">null</span>
}</code></pre>
                </div>
              </div>
            </div>
          </details>
        </div>

        <div id="api-v2-cancel" class="api-v2-section mb-8">
          <div class="d-flex align-items-center gap-3 mb-4"><span class="symbol symbol-35px symbol-circle bg-light-danger"><i class="fa-solid fa-ban text-danger"></i></span>
            <h3 class="fw-bold mb-0">Cancel tasks</h3><span class="badge badge-light-danger">2 actions</span>
          </div>
          <details class="api-v2-endpoint card shadow-sm mb-4" data-search="pullCancelTasks cancel pull pending manual task service_ids">
            <summary class="card-header border-0 d-flex align-items-center justify-content-between p-5">
              <div><span class="badge badge-light-warning me-2">POST</span><code class="fs-5 fw-bold">pullCancelTasks</code>
                <div class="text-muted fs-8 mt-2">Fetch pending cancel tasks for manual orders (last 90 days).</div>
              </div><i class="fa-solid fa-chevron-down api-v2-chevron text-muted"></i>
            </summary>
            <div class="card-body pt-0 px-5 pb-5">
              <p class="text-muted fs-8">Pulled tasks are <strong>automatically moved to <code>In progress</code></strong> to prevent duplicate pulls. Only <code>Pending</code> tasks from <code>Manual</code> orders within the last 90 days are returned.</p>
              <div class="table-responsive mt-3">
                <table class="table table-row-bordered table-rounded gy-3">
                  <thead>
                    <tr>
                      <th>Field</th>
                      <th>Required</th>
                      <th>Type</th>
                      <th>Description</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><code>service_ids</code></td>
                      <td>Optional</td>
                      <td>String</td>
                      <td>Comma-separated service IDs to filter by.</td>
                    </tr>
                    <tr>
                      <td><code>limit</code></td>
                      <td>Optional</td>
                      <td>Integer</td>
                      <td>Max 100 (default 100).</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="d-flex align-items-center gap-2 mt-3"><span class="badge badge-light-info">Response fields per task</span></div>
              <div class="table-responsive mt-2">
                <table class="table table-row-bordered table-rounded gy-3">
                  <thead>
                    <tr>
                      <th>Field</th>
                      <th>Type</th>
                      <th>Description</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><code>task_id</code></td>
                      <td>Integer</td>
                      <td>Cancel request ID.</td>
                    </tr>
                    <tr>
                      <td><code>order_id</code></td>
                      <td>Integer</td>
                      <td>Related order ID.</td>
                    </tr>
                    <tr>
                      <td><code>service_id</code></td>
                      <td>Integer</td>
                      <td>Service ID.</td>
                    </tr>
                    <tr>
                      <td><code>link</code></td>
                      <td>String</td>
                      <td>Order link.</td>
                    </tr>
                    <tr>
                      <td><code>created</code></td>
                      <td>Datetime</td>
                      <td>Creation time + <code>created_timestamp</code>.</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="api-v2-samples mt-4">
                <div class="api-v2-sample api-v2-sample--request">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-up-right-from-square"></i>Request sample</span><span class="api-v2-sample__type">JSON body</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"action":</span> <span class="json-string">"pullCancelTasks"</span>,
  <span class="json-key">"key":</span> <span class="json-string">"&lt;ADMIN_API_KEY&gt;"</span>,
  <span class="json-key">"service_ids":</span> <span class="json-string">"123,556,765"</span>,
  <span class="json-key">"limit":</span> <span class="json-number">10</span>
}</code></pre>
                </div>
                <div class="api-v2-sample api-v2-sample--response">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-down-left"></i>Response sample</span><span class="api-v2-sample__type">200 application/json</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"data":</span> {
    <span class="json-key">"count":</span> <span class="json-number">1</span>,
    <span class="json-key">"list":</span> [
      {
        <span class="json-key">"task_id":</span> <span class="json-number">501</span>,
        <span class="json-key">"order_id":</span> <span class="json-number">123</span>,
        <span class="json-key">"service_id":</span> <span class="json-number">10</span>,
        <span class="json-key">"link":</span> <span class="json-string">"https://example.com/post/1"</span>,
        <span class="json-key">"created":</span> <span class="json-string">"2026-07-29 10:00:00"</span>,
        <span class="json-key">"created_timestamp":</span> <span class="json-number">1722258000</span>
      }
    ]
  },
  <span class="json-key">"error_message":</span> <span class="json-null">null</span>,
  <span class="json-key">"error_code":</span> <span class="json-null">null</span>
}</code></pre>
                </div>
              </div>
            </div>
          </details>
          <details class="api-v2-endpoint card shadow-sm mb-4" data-search="rejectCancelTasks cancel reject task ids rejected">
            <summary class="card-header border-0 d-flex align-items-center justify-content-between p-5">
              <div><span class="badge badge-light-danger me-2">POST</span><code class="fs-5 fw-bold">rejectCancelTasks</code>
                <div class="text-muted fs-8 mt-2">Reject up to 100 cancellation tasks — only <code>Awaiting</code>/<code>Pending</code>/<code>In progress</code> tasks are affected.</div>
              </div><i class="fa-solid fa-chevron-down api-v2-chevron text-muted"></i>
            </summary>
            <div class="card-body pt-0 px-5 pb-5">
              <p class="text-muted fs-8">Tasks already <code>Completed</code> or <code>Rejected</code> are skipped. Provide <code>ids</code> as a comma-separated string.</p>
              <div class="table-responsive mt-3">
                <table class="table table-row-bordered table-rounded gy-3">
                  <thead>
                    <tr>
                      <th>Field</th>
                      <th>Required</th>
                      <th>Type</th>
                      <th>Description</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><code>ids</code></td>
                      <td>Yes</td>
                      <td>String</td>
                      <td>Comma-separated task IDs, max 100.</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="api-v2-samples mt-4">
                <div class="api-v2-sample api-v2-sample--request">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-up-right-from-square"></i>Request sample</span><span class="api-v2-sample__type">JSON body</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"action":</span> <span class="json-string">"rejectCancelTasks"</span>,
  <span class="json-key">"key":</span> <span class="json-string">"&lt;ADMIN_API_KEY&gt;"</span>,
  <span class="json-key">"ids":</span> <span class="json-string">"501,502,503"</span>
}</code></pre>
                </div>
                <div class="api-v2-sample api-v2-sample--response">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-down-left"></i>Response sample</span><span class="api-v2-sample__type">200 application/json</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"data":</span> {
    <span class="json-key">"ids":</span> [
      <span class="json-number">501</span>,
      <span class="json-number">502</span>
    ],
    <span class="json-key">"skipped_ids":</span> [
      <span class="json-number">503</span>
    ]
  },
  <span class="json-key">"error_message":</span> <span class="json-null">null</span>,
  <span class="json-key">"error_code":</span> <span class="json-null">null</span>
}</code></pre>
                </div>
              </div>
            </div>
          </details>
        </div>

        <div id="api-v2-refill" class="api-v2-section mb-8">
          <div class="d-flex align-items-center gap-3 mb-4"><span class="symbol symbol-35px symbol-circle bg-light-primary"><i class="fa-solid fa-arrows-rotate text-primary"></i></span>
            <h3 class="fw-bold mb-0">Refill tasks</h3><span class="badge badge-light-primary">2 actions</span>
          </div>
          <details class="api-v2-endpoint card shadow-sm mb-4" data-search="pullRefillTasks refill pull pending manual task service_ids">
            <summary class="card-header border-0 d-flex align-items-center justify-content-between p-5">
              <div><span class="badge badge-light-warning me-2">POST</span><code class="fs-5 fw-bold">pullRefillTasks</code>
                <div class="text-muted fs-8 mt-2">Pull Pending refill tasks for Manual orders from the last 90 days.</div>
              </div><i class="fa-solid fa-chevron-down api-v2-chevron text-muted"></i>
            </summary>
            <div class="card-body pt-0 px-5 pb-5">
              <p class="text-muted fs-8">Fields: optional <code>service_ids</code> and <code>limit</code> (max 100). Pulled tasks are automatically moved to <code>In progress</code>.</p>
              <div class="api-v2-samples">
                <div class="api-v2-sample api-v2-sample--request">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-up-right-from-square"></i>Request sample</span><span class="api-v2-sample__type">JSON body</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"action":</span> <span class="json-string">"pullRefillTasks"</span>,
  <span class="json-key">"key":</span> <span class="json-string">"&lt;ADMIN_API_KEY&gt;"</span>,
  <span class="json-key">"service_ids":</span> <span class="json-string">"123,556,765"</span>,
  <span class="json-key">"limit":</span> <span class="json-number">10</span>
}</code></pre>
                </div>
                <div class="api-v2-sample api-v2-sample--response">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-down-left"></i>Response sample</span><span class="api-v2-sample__type">200 application/json</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"data":</span> {
    <span class="json-key">"count":</span> <span class="json-number">1</span>,
    <span class="json-key">"list":</span> [
      {
        <span class="json-key">"task_id":</span> <span class="json-number">601</span>,
        <span class="json-key">"order_id":</span> <span class="json-number">123</span>,
        <span class="json-key">"start_count":</span> <span class="json-number">1000</span>,
        <span class="json-key">"quantity":</span> <span class="json-number">1000</span>,
        <span class="json-key">"current_count":</span> <span class="json-number">750</span>,
        <span class="json-key">"to_refill":</span> <span class="json-number">250</span>,
        <span class="json-key">"service_id":</span> <span class="json-number">10</span>,
        <span class="json-key">"link":</span> <span class="json-string">"https://example.com/post/1"</span>,
        <span class="json-key">"created":</span> <span class="json-string">"2026-07-29 10:00:00"</span>
      }
    ]
  },
  <span class="json-key">"error_message":</span> <span class="json-null">null</span>,
  <span class="json-key">"error_code":</span> <span class="json-null">null</span>
}</code></pre>
                </div>
              </div>
            </div>
          </details>
          <details class="api-v2-endpoint card shadow-sm mb-4" data-search="changeRefillTaskStatus refill status task completed rejected in progress">
            <summary class="card-header border-0 d-flex align-items-center justify-content-between p-5">
              <div><span class="badge badge-light-danger me-2">POST</span><code class="fs-5 fw-bold">changeRefillTaskStatus</code>
                <div class="text-muted fs-8 mt-2">Bulk update refill task statuses.</div>
              </div><i class="fa-solid fa-chevron-down api-v2-chevron text-muted"></i>
            </summary>
            <div class="card-body pt-0 px-5 pb-5">
              <p class="text-muted fs-8">Fields: <code>ids</code> as a string with up to 100 IDs, and case-sensitive <code>status</code>: <code>In progress</code>, <code>Completed</code>, or <code>Rejected</code>.</p>
              <div class="api-v2-samples">
                <div class="api-v2-sample api-v2-sample--request">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-up-right-from-square"></i>Request sample</span><span class="api-v2-sample__type">JSON body</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"action":</span> <span class="json-string">"changeRefillTaskStatus"</span>,
  <span class="json-key">"key":</span> <span class="json-string">"&lt;ADMIN_API_KEY&gt;"</span>,
  <span class="json-key">"ids":</span> <span class="json-string">"601"</span>,
  <span class="json-key">"status":</span> <span class="json-string">"Completed"</span>
}</code></pre>
                </div>
                <div class="api-v2-sample api-v2-sample--response">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-down-left"></i>Response sample</span><span class="api-v2-sample__type">200 application/json</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"data":</span> {
    <span class="json-key">"ids":</span> [
      <span class="json-number">601</span>
    ],
    <span class="json-key">"status":</span> <span class="json-string">"Completed"</span>,
    <span class="json-key">"skipped_ids":</span> [
      <span class="json-number">602</span>
    ]
  },
  <span class="json-key">"error_message":</span> <span class="json-null">null</span>,
  <span class="json-key">"error_code":</span> <span class="json-null">null</span>
}</code></pre>
                </div>
              </div>
            </div>
          </details>
        </div>

        <div id="api-v2-payments" class="api-v2-section mb-8">
          <div class="d-flex align-items-center gap-3 mb-4"><span class="symbol symbol-35px symbol-circle bg-light-success"><i class="fa-solid fa-wallet text-success"></i></span>
            <h3 class="fw-bold mb-0">Payments</h3><span class="badge badge-light-success">2 actions</span>
          </div>
          <details class="api-v2-endpoint card shadow-sm mb-4" data-search="getPayments payments list filters pagination method username email memo">
            <summary class="card-header border-0 d-flex align-items-center justify-content-between p-5">
              <div><span class="badge badge-light-primary me-2">POST</span><code class="fs-5 fw-bold">getPayments</code>
                <div class="text-muted fs-8 mt-2">List payments with filters and pagination.</div>
              </div><i class="fa-solid fa-chevron-down api-v2-chevron text-muted"></i>
            </summary>
            <div class="card-body pt-0 px-5 pb-5">
              <p class="text-muted fs-8">Filters: <code>ids</code>, <code>method</code>, <code>username</code>, <code>user_email</code>, <code>user_id</code>, <code>memo</code>, <code>created_from</code>, and <code>created_to</code>. Maximum pagination is 1000.</p>
              <div class="api-v2-samples">
                <div class="api-v2-sample api-v2-sample--request">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-up-right-from-square"></i>Request sample</span><span class="api-v2-sample__type">JSON body</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"action":</span> <span class="json-string">"getPayments"</span>,
  <span class="json-key">"key":</span> <span class="json-string">"&lt;ADMIN_API_KEY&gt;"</span>,
  <span class="json-key">"user_id":</span> <span class="json-number">12</span>,
  <span class="json-key">"created_from":</span> <span class="json-number">1447804800</span>,
  <span class="json-key">"limit":</span> <span class="json-number">10</span>,
  <span class="json-key">"offset":</span> <span class="json-number">0</span>,
  <span class="json-key">"sort":</span> <span class="json-string">"date-desc"</span>
}</code></pre>
                </div>
                <div class="api-v2-sample api-v2-sample--response">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-down-left"></i>Response sample</span><span class="api-v2-sample__type">200 application/json</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"data":</span> {
    <span class="json-key">"count":</span> <span class="json-number">1</span>,
    <span class="json-key">"list":</span> [
      {
        <span class="json-key">"payment_id":</span> <span class="json-number">701</span>,
        <span class="json-key">"user":</span> {
          <span class="json-key">"user_id":</span> <span class="json-number">12</span>,
          <span class="json-key">"username":</span> <span class="json-string">"demo_user"</span>,
          <span class="json-key">"user_email":</span> <span class="json-string">"demo@example.com"</span>,
          <span class="json-key">"balance":</span> <span class="json-number">25.5</span>
        },
        <span class="json-key">"amount":</span> {
          <span class="json-key">"value":</span> <span class="json-number">10</span>,
          <span class="json-key">"currency_code":</span> <span class="json-string">"USD"</span>,
          <span class="json-key">"formatted":</span> <span class="json-string">"$10.00"</span>
        },
        <span class="json-key">"method":</span> <span class="json-string">"Manual"</span>,
        <span class="json-key">"status":</span> <span class="json-string">"completed"</span>,
        <span class="json-key">"memo":</span> <span class="json-string">"Bonus"</span>,
        <span class="json-key">"created":</span> <span class="json-string">"2026-07-29 10:00:00"</span>
      }
    ]
  },
  <span class="json-key">"error_message":</span> <span class="json-null">null</span>,
  <span class="json-key">"error_code":</span> <span class="json-null">null</span>
}</code></pre>
                </div>
              </div>
            </div>
          </details>
          <details class="api-v2-endpoint card shadow-sm mb-4" data-search="addPayment payment add funds amount method user_id username email memo">
            <summary class="card-header border-0 d-flex align-items-center justify-content-between p-5">
              <div><span class="badge badge-light-danger me-2">POST</span><code class="fs-5 fw-bold">addPayment</code>
                <div class="text-muted fs-8 mt-2">Add funds to a user using a payment method name.</div>
              </div><i class="fa-solid fa-chevron-down api-v2-chevron text-muted"></i>
            </summary>
            <div class="card-body pt-0 px-5 pb-5">
              <p class="text-muted fs-8">Fields: <code>amount &gt; 0</code>, <code>method</code>, and one of <code>user_id</code> / <code>username</code> / <code>user_email</code>. You may also provide <code>memo</code>. The user is resolved in the order listed above.</p>
              <div class="api-v2-samples">
                <div class="api-v2-sample api-v2-sample--request">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-up-right-from-square"></i>Request sample</span><span class="api-v2-sample__type">JSON body</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"action":</span> <span class="json-string">"addPayment"</span>,
  <span class="json-key">"key":</span> <span class="json-string">"&lt;ADMIN_API_KEY&gt;"</span>,
  <span class="json-key">"amount":</span> <span class="json-number">10.5</span>,
  <span class="json-key">"method":</span> <span class="json-string">"Manual"</span>,
  <span class="json-key">"username":</span> <span class="json-string">"demo_user"</span>,
  <span class="json-key">"memo":</span> <span class="json-string">"added via Admin API"</span>
}</code></pre>
                </div>
                <div class="api-v2-sample api-v2-sample--response">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-down-left"></i>Response sample</span><span class="api-v2-sample__type">200 application/json</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"data":</span> {
    <span class="json-key">"payment_id":</span> <span class="json-number">701</span>,
    <span class="json-key">"user":</span> {
      <span class="json-key">"id":</span> <span class="json-number">12</span>,
      <span class="json-key">"username":</span> <span class="json-string">"demo_user"</span>,
      <span class="json-key">"email":</span> <span class="json-string">"demo@example.com"</span>,
      <span class="json-key">"balance":</span> <span class="json-string">"25.5"</span>
    },
    <span class="json-key">"amount":</span> {
      <span class="json-key">"value":</span> <span class="json-string">"10.5"</span>,
      <span class="json-key">"currency_code":</span> <span class="json-string">"USD"</span>,
      <span class="json-key">"formatted":</span> <span class="json-string">"$10.50"</span>
    }
  },
  <span class="json-key">"error_message":</span> <span class="json-null">null</span>,
  <span class="json-key">"error_code":</span> <span class="json-null">null</span>
}</code></pre>
                </div>
              </div>
            </div>
          </details>
        </div>

        <div id="api-v2-users" class="api-v2-section mb-8">
          <div class="d-flex align-items-center gap-3 mb-4"><span class="symbol symbol-35px symbol-circle bg-light-info"><i class="fa-solid fa-users text-info"></i></span>
            <h3 class="fw-bold mb-0">Users</h3><span class="badge badge-light-info">2 actions</span>
          </div>
          <details class="api-v2-endpoint card shadow-sm mb-4" data-search="getUsers users list filters pagination username email status">
            <summary class="card-header border-0 d-flex align-items-center justify-content-between p-5">
              <div><span class="badge badge-light-primary me-2">POST</span><code class="fs-5 fw-bold">getUsers</code>
                <div class="text-muted fs-8 mt-2">List users with filters and pagination.</div>
              </div><i class="fa-solid fa-chevron-down api-v2-chevron text-muted"></i>
            </summary>
            <div class="card-body pt-0 px-5 pb-5">
              <p class="text-muted fs-8">Filters: <code>ids</code>, <code>username</code>, <code>email</code>, and <code>status</code>. <code>status</code> accepts only <code>active</code> or <code>suspended</code> — any other value returns HTTP 400 <code>BAD_REQUEST</code>. Maximum pagination is 1000.</p>
              <div class="api-v2-samples">
                <div class="api-v2-sample api-v2-sample--request">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-up-right-from-square"></i>Request sample</span><span class="api-v2-sample__type">JSON body</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"action":</span> <span class="json-string">"getUsers"</span>,
  <span class="json-key">"key":</span> <span class="json-string">"&lt;ADMIN_API_KEY&gt;"</span>,
  <span class="json-key">"status":</span> <span class="json-string">"active"</span>,
  <span class="json-key">"limit":</span> <span class="json-number">10</span>,
  <span class="json-key">"offset":</span> <span class="json-number">0</span>,
  <span class="json-key">"sort":</span> <span class="json-string">"date-desc"</span>
}</code></pre>
                </div>
                <div class="api-v2-sample api-v2-sample--response">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-down-left"></i>Response sample</span><span class="api-v2-sample__type">200 application/json</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"data":</span> {
    <span class="json-key">"count":</span> <span class="json-number">1</span>,
    <span class="json-key">"list":</span> [
      {
        <span class="json-key">"id":</span> <span class="json-number">12</span>,
        <span class="json-key">"username":</span> <span class="json-string">"demo_user"</span>,
        <span class="json-key">"email":</span> <span class="json-string">"demo@example.com"</span>,
        <span class="json-key">"balance":</span> {
          <span class="json-key">"value":</span> <span class="json-number">25.5</span>,
          <span class="json-key">"currency":</span> <span class="json-string">"USD"</span>,
          <span class="json-key">"formatted":</span> <span class="json-string">"$25.50"</span>
        },
        <span class="json-key">"status":</span> <span class="json-string">"active"</span>,
        <span class="json-key">"created":</span> <span class="json-string">"2026-07-01 10:00:00"</span>,
        <span class="json-key">"last_auth":</span> <span class="json-string">"2026-07-29 10:00:00"</span>,
        <span class="json-key">"discount":</span> {
          <span class="json-key">"value":</span> <span class="json-number">0</span>
        },
        <span class="json-key">"custom_rates":</span> <span class="json-null">null</span>,
        <span class="json-key">"details":</span> {
          <span class="json-key">"full_name":</span> <span class="json-string">"Demo User"</span>,
          <span class="json-key">"phone":</span> <span class="json-string">"+84000000000"</span>
        }
      }
    ]
  },
  <span class="json-key">"error_message":</span> <span class="json-null">null</span>,
  <span class="json-key">"error_code":</span> <span class="json-null">null</span>
}</code></pre>
                </div>
              </div>
            </div>
          </details>
          <details class="api-v2-endpoint card shadow-sm mb-4" data-search="addUser user add username email password phone">
            <summary class="card-header border-0 d-flex align-items-center justify-content-between p-5">
              <div><span class="badge badge-light-danger me-2">POST</span><code class="fs-5 fw-bold">addUser</code>
                <div class="text-muted fs-8 mt-2">Create a new user.</div>
              </div><i class="fa-solid fa-chevron-down api-v2-chevron text-muted"></i>
            </summary>
            <div class="card-body pt-0 px-5 pb-5">
              <p class="text-muted fs-8">Required fields: <code>username</code>, <code>email</code>, and <code>password</code>. The username is lowercased and must be 6–20 characters; <code>phone</code> is optional.</p>
              <div class="api-v2-samples">
                <div class="api-v2-sample api-v2-sample--request">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-up-right-from-square"></i>Request sample</span><span class="api-v2-sample__type">JSON body</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"action":</span> <span class="json-string">"addUser"</span>,
  <span class="json-key">"key":</span> <span class="json-string">"&lt;ADMIN_API_KEY&gt;"</span>,
  <span class="json-key">"username":</span> <span class="json-string">"new_user"</span>,
  <span class="json-key">"email":</span> <span class="json-string">"new@example.com"</span>,
  <span class="json-key">"password":</span> <span class="json-string">"12qw34er5ty"</span>,
  <span class="json-key">"phone":</span> <span class="json-string">"+84000000000"</span>
}</code></pre>
                </div>
                <div class="api-v2-sample api-v2-sample--response">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-down-left"></i>Response sample</span><span class="api-v2-sample__type">200 application/json</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"data":</span> {
    <span class="json-key">"user_id":</span> <span class="json-number">13</span>
  },
  <span class="json-key">"error_message":</span> <span class="json-null">null</span>,
  <span class="json-key">"error_code":</span> <span class="json-null">null</span>
}</code></pre>
                </div>
              </div>
            </div>
          </details>
        </div>

        <div id="api-v2-tickets" class="api-v2-section mb-8">
          <div class="d-flex align-items-center gap-3 mb-4"><span class="symbol symbol-35px symbol-circle bg-light-warning"><i class="fa-solid fa-life-ring text-warning"></i></span>
            <h3 class="fw-bold mb-0">Tickets</h3><span class="badge badge-light-warning">2 actions</span>
          </div>
          <details class="api-v2-endpoint card shadow-sm mb-4" data-search="getTickets tickets list filters pagination status user">
            <summary class="card-header border-0 d-flex align-items-center justify-content-between p-5">
              <div><span class="badge badge-light-primary me-2">POST</span><code class="fs-5 fw-bold">getTickets</code>
                <div class="text-muted fs-8 mt-2">List tickets with filters and pagination.</div>
              </div><i class="fa-solid fa-chevron-down api-v2-chevron text-muted"></i>
            </summary>
            <div class="card-body pt-0 px-5 pb-5">
              <p class="text-muted fs-8">Filters: <code>ids</code>, <code>status</code> (<code>pending</code>/<code>processing</code>/<code>closed</code> or 0/1/2), and <code>user</code>. Request types: <code>1=cancel</code>, <code>2=refill</code>, and <code>3=speedup</code>.</p>
              <div class="api-v2-samples">
                <div class="api-v2-sample api-v2-sample--request">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-up-right-from-square"></i>Request sample</span><span class="api-v2-sample__type">JSON body</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"action":</span> <span class="json-string">"getTickets"</span>,
  <span class="json-key">"key":</span> <span class="json-string">"&lt;ADMIN_API_KEY&gt;"</span>,
  <span class="json-key">"status":</span> <span class="json-string">"pending"</span>,
  <span class="json-key">"user":</span> <span class="json-string">"demo_user"</span>,
  <span class="json-key">"limit":</span> <span class="json-number">10</span>,
  <span class="json-key">"offset":</span> <span class="json-number">0</span>,
  <span class="json-key">"sort":</span> <span class="json-string">"date-desc"</span>
}</code></pre>
                </div>
                <div class="api-v2-sample api-v2-sample--response">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-down-left"></i>Response sample</span><span class="api-v2-sample__type">200 application/json</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"data":</span> {
    <span class="json-key">"count":</span> <span class="json-number">1</span>,
    <span class="json-key">"list":</span> [
      {
        <span class="json-key">"id":</span> <span class="json-number">801</span>,
        <span class="json-key">"user":</span> {
          <span class="json-key">"id":</span> <span class="json-number">12</span>,
          <span class="json-key">"username":</span> <span class="json-string">"demo_user"</span>
        },
        <span class="json-key">"order_id":</span> <span class="json-number">123</span>,
        <span class="json-key">"service_id":</span> <span class="json-number">10</span>,
        <span class="json-key">"request":</span> <span class="json-string">"cancel"</span>,
        <span class="json-key">"status":</span> <span class="json-string">"pending"</span>,
        <span class="json-key">"created":</span> <span class="json-string">"2026-07-29 10:00:00"</span>,
        <span class="json-key">"updated":</span> <span class="json-string">"2026-07-29 10:01:00"</span>
      }
    ]
  },
  <span class="json-key">"error_message":</span> <span class="json-null">null</span>,
  <span class="json-key">"error_code":</span> <span class="json-null">null</span>
}</code></pre>
                </div>
              </div>
            </div>
          </details>
          <details class="api-v2-endpoint card shadow-sm mb-4" data-search="changeTicketStatus ticket status pending processing closed ids">
            <summary class="card-header border-0 d-flex align-items-center justify-content-between p-5">
              <div><span class="badge badge-light-danger me-2">POST</span><code class="fs-5 fw-bold">changeTicketStatus</code>
                <div class="text-muted fs-8 mt-2">Bulk update ticket statuses.</div>
              </div><i class="fa-solid fa-chevron-down api-v2-chevron text-muted"></i>
            </summary>
            <div class="card-body pt-0 px-5 pb-5">
              <p class="text-muted fs-8">Fields: <code>ids</code> as a string with up to 100 IDs, and lowercase <code>status</code>: <code>pending</code>, <code>processing</code>, or <code>closed</code>. Note: database status 2 is formatted as <code>closed</code> by <code>getTickets</code>.</p>
              <div class="api-v2-samples">
                <div class="api-v2-sample api-v2-sample--request">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-up-right-from-square"></i>Request sample</span><span class="api-v2-sample__type">JSON body</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"action":</span> <span class="json-string">"changeTicketStatus"</span>,
  <span class="json-key">"key":</span> <span class="json-string">"&lt;ADMIN_API_KEY&gt;"</span>,
  <span class="json-key">"ids":</span> <span class="json-string">"801"</span>,
  <span class="json-key">"status":</span> <span class="json-string">"closed"</span>
}</code></pre>
                </div>
                <div class="api-v2-sample api-v2-sample--response">
                  <div class="api-v2-sample__header"><span class="api-v2-sample__title"><i class="fa-solid fa-arrow-down-left"></i>Response sample</span><span class="api-v2-sample__type">200 application/json</span></div>
                  <pre class="api-v2-code"><code>{
  <span class="json-key">"data":</span> {
    <span class="json-key">"ids":</span> [
      <span class="json-number">801</span>
    ],
    <span class="json-key">"status":</span> <span class="json-string">"closed"</span>,
    <span class="json-key">"skipped_ids":</span> [
      <span class="json-number">999</span>
    ]
  },
  <span class="json-key">"error_message":</span> <span class="json-null">null</span>,
  <span class="json-key">"error_code":</span> <span class="json-null">null</span>
}</code></pre>
                </div>
              </div>
            </div>
          </details>
        </div>
      </div>

    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const adminHeader = document.getElementById('kt_header');

      function syncSidebarOffset() {
        if (!adminHeader || window.innerWidth < 992) return;
        document.documentElement.style.setProperty('--api-v2-header-height', Math.ceil(adminHeader.getBoundingClientRect().height) + 'px');
      }
      syncSidebarOffset();
      window.addEventListener('resize', syncSidebarOffset);

      function highlightJson(value) {
        const escaped = value.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        return escaped.replace(/("(?:\\.|[^"\\])*"\s*:|"(?:\\.|[^"\\])*")|\b(?:true|false)\b|\bnull\b|-?\d+(?:\.\d+)?(?:[eE][+-]?\d+)?/g, function(token) {
          let className = 'json-number';
          if (token.charAt(0) === '"') className = /:\s*$/.test(token) ? 'json-key' : 'json-string';
          else if (token === 'true' || token === 'false') className = 'json-boolean';
          else if (token === 'null') className = 'json-null';
          return '<span class="' + className + '">' + token + '</span>';
        });
      }

      document.querySelectorAll('.api-v2-code code').forEach(function(code) {
        const raw = code.textContent.trim();
        if (!raw) return;
        try {
          code.innerHTML = highlightJson(JSON.stringify(JSON.parse(raw), null, 2));
        } catch (e) {
          // Keep non-JSON code samples unchanged.
        }
      });

      const search = document.getElementById('api-v2-search');
      const endpointCards = Array.from(document.querySelectorAll('.api-v2-endpoint'));
      const sections = Array.from(document.querySelectorAll('.api-v2-section'));
      const navLinks = Array.from(document.querySelectorAll('#api-v2-nav .nav-link'));
      const anchors = Array.from(document.querySelectorAll('.api-v2-anchor'));
      const slugAliases = {
        overview: 'v2-overview',
        orders: 'api-v2-orders',
        cancel: 'api-v2-cancel',
        refill: 'api-v2-refill',
        payments: 'api-v2-payments',
        users: 'api-v2-users',
        tickets: 'api-v2-tickets'
      };

      function findSlugTarget(slug) {
        const aliasedSlug = slugAliases[slug] || slug;
        const directTarget = document.getElementById(aliasedSlug);
        if (directTarget) return directTarget;
        return endpointCards.find(function(card) {
          return (card.dataset.search || '').trim().split(/\s+/)[0] === slug;
        });
      }

      function scrollToSlug(slug) {
        const target = findSlugTarget(slug);
        if (!target) return false;
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
        return true;
      }

      function filterEndpoints() {
        const term = (search.value || '').trim().toLowerCase();
        endpointCards.forEach(function(card) {
          const matches = !term || (card.dataset.search || '').toLowerCase().includes(term);
          card.classList.toggle('d-none', !matches);
        });
        sections.forEach(function(section) {
          const visible = section.querySelectorAll('.api-v2-endpoint:not(.d-none)').length > 0;
          section.classList.toggle('d-none', !!term && !visible);
        });
      }

      if (search) search.addEventListener('input', filterEndpoints);

      anchors.forEach(function(link) {
        link.addEventListener('click', function(event) {
          const href = link.getAttribute('href') || '';
          const slug = href.charAt(0) === '#' ? href.slice(1) : '';
          if (!slug || !scrollToSlug(slug)) return;
          // Match the Bootstrap tabs on /admin/api: use href="#slug" for navigation
          // without changing the current URL.
          event.preventDefault();
          const activeLink = navLinks.find(function(item) {
            return item === link || item.getAttribute('href') === href;
          });
          if (activeLink) {
            navLinks.forEach(function(item) {
              item.classList.toggle('active', item === activeLink);
            });
          }
        });
      });

      const initialSlug = window.location.hash ? window.location.hash.slice(1) : '';
      if (initialSlug) {
        window.setTimeout(function() {
          scrollToSlug(initialSlug);
        }, 0);
      }

      document.querySelectorAll('[data-copy-target]').forEach(function(button) {
        button.addEventListener('click', async function() {
          const target = document.getElementById(button.dataset.copyTarget);
          if (!target) return;
          try {
            await navigator.clipboard.writeText(target.textContent.trim());
            const original = button.innerHTML;
            button.innerHTML = '<i class="fa-solid fa-check"></i>';
            setTimeout(function() {
              button.innerHTML = original;
            }, 1400);
          } catch (e) {
            if (typeof app !== 'undefined' && app.toastr) app.toastr('Unable to copy content', 'error');
          }
        });
      });

    });
  </script>
</div>
@endsection
@push('scripts')
<script>
  $(function() {
    if (window._api && typeof _api.init === 'function') _api.init();
  });
</script>
@endpush